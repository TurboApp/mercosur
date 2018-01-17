@extends('layouts.master')

@section('title','Edición operario: '.$fuerza->nombre)
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
  @component('components.breadcrump',[
       'navigation'    =>  [ 'Inicio' => 'inicio', 'Fuerza de tarea' => 'fuerza-tarea', 'Edicion operario: '.$fuerza->nombre => '' ],
   ])
   @endcomponent()
@endsection

@section('content')
    <form id="editOperario" class="form-horizontal" action="/fuerzas/{{$fuerza->id}}" method="post">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="card">
            
          
            <div class="card-content">
              <h4 class="card-title">Editar Operario</h4>
              <div class="row">
                <div class="col-md-4">
                  <div class="card-profile text-center" style="margin-top:100px;">
                    <div class="card-avatar" style="max-width:170px; max-height:170px;">
                      <img src="{{asset('img/fuerza-'.str_replace(" ","-",$fuerza->categoria).'.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-2 control-label">Nombre</label>
                      <div class="col-md-10">
                        <input type="text" name="nombre" value="{{$fuerza->nombre}}" class="form-control" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">Categoria</label>
                      <div class="col-md-10">
                        <select class="selectpicker" name="categoria"  data-style="select-with-transition" required>
                          
                            <option value="Montacarguista" @if($fuerza->categoria == "Montacarguista")  selected @endif > Montacarguista</option>
                          
                            <option value="Montacarga" @if($fuerza->categoria == 'Montacarga') selected @endif >Montacarga</option>
                          
                            <option value="Auxiliar de patio" @if($fuerza->categoria == 'Auxiliar de patio') selected @endif >Auxililar de Patio</option>
                          
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">Contacto</label>
                      <div class="col-md-10">
                        <input type="text" name="direccion" value="{{$fuerza->contacto}}" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">Descripcion</label>
                      <div class="col-md-10">
                        <textarea name="descripcion" class="form-control">{{$fuerza->descripcion}}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i>
                 Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  @endsection

  @push('scripts')
    @include('layouts.partials.errors')
    <script type="text/javascript">
    $(function(){
        $('#editOperario').validate({
          errorPlacement: function(error, element) {
            $(element).closest('div.form-group').addClass('has-error');
            $(element).siblings( ".select-with-transition" ).addClass('error_selectpicker');
          }
        });
        $('.selectpicker').on('change', function () {
            $(this).valid();
            $(this).siblings( ".select-with-transition" ).removeClass('error_selectpicker');
        });
    });
    </script>
  @endpush
