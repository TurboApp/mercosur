@extends('layouts.master')
@section('title','Agregar nuevas herramientas')
@section('nav-top')
  <ul class="nav navbar-nav navbar-right">
      <li>
          <a href="{{ URL::previous() }}" rel="tooltip" data-placement="bottom" title="Ir atras">
              <i class="material-icons">arrow_back</i>
              <p class="hidden-lg hidden-md">Regresar</p>
          </a>
      </li>
      <li class="separator hidden-lg hidden-md"></li>
  </ul>
  <form class="navbar-form navbar-right" method="GET" action="/herramientas/busqueda/" role="search">
      <div class="form-group form-search is-empty">
          <input type="text" class="form-control" name="s" placeholder="Buscar">
          <span class="material-input"></span>
      </div>
      <button type="submit" class="btn btn-white btn-round btn-just-icon">
          <i class="material-icons">search</i>
          <div class="ripple-container"></div>
      </button>
  </form>
@endsection
  @section('content')
    <div class="row">
      <div class="col-md-6">
        <form id="createPuesto" action="/herramientas" method="POST" autocomplete="off">
          {{ csrf_field() }}
          <div class="card">
            <div class="card-header card-header-icon" data-background-color="blue">
              <i class="fa fa-cog fa-lg" aria-hidden="true"></i>
            </div>
            <div class="card-content">
              <h4 class="card-title">Agregar nuevo Puesto</h4>
              <div class="form-horizontal">
                <div class="row">
                  <label class="col-xs-2 label-on-left">Nombre Puesto</label>
                  <div class="col-xs-10">
                    <div class="form-group label-floating is-empty">
                      <input type="text" class="form-control" name="puesto" value="{{ old('puesto') }}" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="form-group label-floating is-empty">
                      <label class="control-label">Una breve descripción de el puesto</label>
                      <textarea class="form-control" rows="3" name="descripcion" value="{{old('descripcion')}}"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary btn-round">
                <i class="material-icons">save</i>
                 Guardar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-content table-responsive">
            <table class="table">
              <thead class="text-primary">
                <th>N°</th>
                <th>Puesto</th>
                <th>Descripción</th>
                <th>Editar</th>
              </thead>
              <tfoot>
                <th>N°</th>
                <th>Puesto</th>
                <th>Descripción</th>
                <th>Editar</th>
              </tfoot>
              <tbody>
                @foreach ($puestos as $key => $puesto)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$puesto->puesto}}</td>
                    <td>{{$puesto->descripcion}}</td>
                    <td><button type="button" rel="tooltip" class="puesto btn btn-success btn-simple btn-just-icon" data-target="#update" data-toggle="modal"  data-id={{$puesto->id}}><i class="fa fa-pencil fa-1x" aria-hidden="true"></i></a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    {{-- modal --}}
      <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form class="" action="/herramientas/actualizar" method="post">
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
                <div class="form-horizontal">
                  <div class="row">
                    <label class="col-md-3">Puesto</label>
                    <input type="hidden" name="id" value="" id="id" class="form-control">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <input type="text" name="puesto" value="" id="info-puesto" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-3">Descripción</label>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <input type="text" name="descripcion" value="" id="info-descripcion" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </form>
      </div>
  @endsection
@push('scripts')
  @include('layouts.partials.notify')
  <script type="text/javascript">
  $(function(){
      $('#createPuesto').validate({
        errorPlacement: function(error, element) {
          $(element).closest('div.form-group').addClass('has-error');
        }
      });

      $(document).on("click",".puesto", function(){
        // console.log($(this).data('id'));
          let id = $(this).data('id');
          $('#info-puesto').attr('value','');
          $('#info-descripcion').attr('value','');
          $('#id').attr('value','');

          axios.get('/herramientas/info-puesto/'+id)
          .then(function(response){
              let data=response.data;
              console.log(data);
              $('#info-puesto').attr('value',data.puesto);
              $('#info-descripcion').attr('value',data.descripcion);
              $('#id').attr('value',data.id);
          });
      });
});

  </script>
@endpush
