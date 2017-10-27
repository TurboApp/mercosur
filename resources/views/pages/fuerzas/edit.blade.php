@extends('layouts.master')
@section('title','Editar Operario')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
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
            <div class="card-header card-header-icon" data-background-color="">
              <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
            </div>
            <div class="card-content">
              <h4 class="card-title">Editar Operario</h4>
              <div class="row">
                <div class="col-md-4">
                  <div class="card-profile text-center" style="margin-top:100px;">
                    <div class="card-avatar" style="max-width:170px; max-height:170px;">
                      <img src="{{asset('img/fuerza-'.str_replace(" ","-",$fuerza->categoria).'.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    </div>
                    <div class="row form-horizontal">
                      <div class="col-md-6 col-md-offset-3">
                        <div class="btn-group bootstrap-select show-tick">
                          <select class="selectpicker" name="categoria"  data-style="select-with-transition" title="{{$fuerza->categoria}}" required>
                            <option value="Montacarguista">Montacarguista</option>
                            <option value="Montacarga">Montacarga</option>
                            <option value="Auxiliar Patio">Auxililar de Patio</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="row form-horizontal">
                    <div class="col-md-6">
                      <label class="col-md-2 label-on-left">Nombre</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" name="nombre" value="{{$fuerza->nombre}}" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-md-2 label-on-left">Apellido</label>
                        <div class="col-md-10">
                          <div class="form-group label-floating is-empty">
                            <input type="text" name="apellido" value="{{$fuerza->apellido}}" class="form-control" required>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="row form-horizontal">
                    <div class="col-md-12">
                      <label class="col-md-1 label-on-left">Dirección</label>
                      <div class="col-md-11">
                        <input type="text" name="direccion" value="{{$fuerza->direccion}}" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row form-horizontal">
                    <div class="col-md-6">
                      <label class="col-md-2 label-on-left">Telefono</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" name="telefono" value="{{$fuerza->telefono}}" class="form-control" maxlength="20">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-md-2 label-on-left">Celular</label>
                        <div class="col-md-10">
                          <div class="form-group label-floating is-empty">
                            <input type="text" name="celular" value="{{$fuerza->celular}}" class="form-control" maxlength="20">
                          </div>
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
