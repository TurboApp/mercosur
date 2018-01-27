@extends('layouts.master')
@section('title','Puestos')
@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Herramientas' => 'inicio', 'Puestos' => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="card grey lighten-5">
          <div class="card-content">
            <form id="createPuesto" action="/herramientas/puestos/nuevo" method="POST" autocomplete="off">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group label-floating">
                    <label class="control-label">Nombre Puesto</label>
                    <input type="text" class="form-control" id="puesto" name="puesto" value="{{ old('puesto') }}" required>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group label-floating">
                    <label class="control-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
                  </div>
                </div>
                <div class="col-md-2 text-right">
                  <button type="submit" id="submitPuesto" class="btn btn-primary">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Agregar
                  </button>
                </div>
              </div>
            </form>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                <table class="table table-condensed" id="puestos" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">N°</th>
                      <th>Puesto</th>
                      <th>Descripcion</th>
                      <th>Editar</th>
                    </tr>
                  </thead>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- modal --}}
      <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form id="editFormPuesto" >
          {{ csrf_field() }}
          {{ method_field('PATCH') }}
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
              <h4 class="modal-title" id="myModalLabel">Modificar Puesto</h4>
            </div>
            <div class="modal-body">
              <div class="card-content">
                  <div class="form-group">
                    <input type="hidden" name="id" id="editId" class="form-control">
                  </div>
                  <div class="form-group">
                    <label class="control-label">Puesto</label>
                    <input type="text" id="editPuesto" name="puesto" value=""  class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Descripción</label>
                    <textarea type="text" id="editDescripcion" name="descripcion" class="form-control" required></textarea>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-simple btn-primary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </form>
      </div>
  @endsection
@push('scripts')
  @include('layouts.partials.notify')
  <script>
  $().ready(function() {
      var oTable = $('#puestos').DataTable({
        order: [],
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/herramientas/getPuestos",
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
              sFirst: "Primero",
              sLast: "Último",
              sNext: "Siguiente",
              sPrevious: "Anterior"
          },
          oAria: {
              sSortAscending: ": Activar para ordenar la columna de manera ascendente",
              sSortDescending: ": Activar para ordenar la columna de manera descendente"
          }
        },
        columns: [
              {
                "data": "id",
                "render":function(data, type, row)
                {
                  return '<h5 class="category">'+data+'<h5>'
                }
              },
              {
                "data": "puesto",
                "render":function(data, type, row)
                {
                  return '<h4 class="text-primary text-left">'+data+'<h4>'
                }
              },
              {
                "data": "descripcion",
                "render":function(data, type, row)
                {
                  return '<h4 class="text-left text-muted">'+data+'<h4>'
                }
              },

              {
                "data": null,
                "render" : function(data, type, row)
                {
                  return '<button type="button" rel="tooltip" class="puesto btn btn-success btn-simple btn-just-icon" data-target="#update" data-toggle="modal" data-id="'+data.id+'"><i class="fa fa-pencil fa-1x" aria-hidden="true"></i>'
                },
              }
          ]
      });
      $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
          console.log(message);
      };
      
      $('#createPuesto').validate({
        errorPlacement: function(error, element) {
          $(element).closest('div.form-group').addClass('has-error');
        },
        
      });
      $('#createPuesto').submit(function(e){
          e.preventDefault();
          let inputPuesto = $('#createPuesto #puesto').val();
          let inputDescripcion = $('#createPuesto #descripcion').val();
          axios.post('/herramientas/puestos/nuevo',{
            puesto: inputPuesto,
            descripcion: inputDescripcion
          }).then(function(response){
              oTable.ajax.reload();
              $('#createPuesto #puesto').val('');
              $('#createPuesto #descripcion').val('');
              $.notify({
                  icon: "check",
                  message: "<h6>En hora buena</h6>Se agrego un puesto satisfacctoriamente"
              },{
                  type: 'success',
                  timer: 4000,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
              });
          });
      });

      $('#editFormPuesto').validate({
        errorPlacement: function(error, element) {
          $(element).closest('div.form-group').addClass('has-error');
        },
        
      });
      $('#editFormPuesto').submit(function(e){
          e.preventDefault();
          let id = $('#editId').val();
          let puesto = $('#editPuesto').val();
          let descripcion = $('#editDescripcion').val();
          let token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          if(puesto =='' || descripcion==''){
            return
          }
          axios.post('/herramientas/puestos/edit',{
            id : id,
            puesto : puesto,
            descripcion : descripcion,
            _token : token
          }).then(function(response){
              console.log(response.data);
              oTable.ajax.reload();
              $('#editId').val();
              $('#editPuesto').val('');
              $('#editDescripcion').val('');
              $('#update').removeClass('in');
              $('#update').css({'display':'none'});
              $('.modal-backdrop').remove();
              $('body').removeClass( "modal-open" );
              $.notify({
                  icon: "check",
                  message: "<h6>En hora buena</h6>Los cambios se realizarón satisfacctoriamente"
              },{
                  type: 'info',
                  timer: 4000,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
              });
          });
      });

      $(document).on("click",".puesto", function(){
          let id = $(this).data('id');
          $('#editPuesto').val('');
          $('#editDescripcion').val('');
          $('#id').attr('value','');
          axios.get('/herramientas/info-puesto/'+id)
          .then(function(response){
              let data=response.data;
              $('#editPuesto').val(data.puesto);
              $('#editDescripcion').val(data.descripcion);
              $('#editId').val(data.id);
          });
      });
});
  </script>

@endpush
