@extends('layouts.master')
@section('title','Agregar Nuevo Usuario')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'UserController@search',
    ])
    @endcomponent()
  @endsection
  @section('content')
    <div class="row">
      <form id="createUsuario" action="/usuarios" method="POST" autocomplete="off" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-icon" data-background-color="blue">
              <i class="fa fa-address-book-o fa-lg" aria-hidden="true"></i>
            </div>
            <div class="card-content">
              <h4 class="card-title">Datos Generales</h4>
              <div class="form-horizontal">
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Nombre</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Apellido</label>
                    <div class="col-md-10">
                      <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" name="apellido" value="{{ old('apellido') }}" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Dirección</label>
                    <div class="col-md-10">
                      <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" name="direccion" value="{{ old('direccion') }}" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Email</label>
                    <div class="col-md-10">
                      <div class="form-group label-floating is-empty">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label class="col-md-4 label-on-left">Telefono</label>
                      <div class="col-md-8">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" maxlength="10">
                        </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <label class="col-md-2 label-on-left">Celular</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" name="celular" value="{{ old('celular') }}" maxlength="10" required>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Puesto</label>
                    <div class="col-md-10">
                      <div class="btn-group bootstrap-select show-tick">
                        {{-- {{$datos['puestos']}} --}}
                        <select class="selectpicker" name="id_puesto[]" multiple  data-style="select-with-transition" title="Selecione el Puesto"  required>
                          @foreach ($puestos as $puesto )
                              <option value="{{$puesto->id}}">{{$puesto->puesto}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> {{--fin col insertar--}}
        <div class="col-md-4">
          <div class="card">
            <div class="card-header card-header-icon" data-background-color="blue">
              <i class="fa fa-key fa-lg" aria-hidden="true"></i>
            </div>
            <div class="card-content">
              <h4 class="card-title">Datos de la Cuenta</h4>
              <div class="text-center">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                  <div class="fileinput-new thumbnail img-circle">
                    <img src="{{asset('img/user-default.jpg')}}" alt="...">
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                    <div>
                      <span class="btn btn-simple btn-primary btn-file btn-xs" style="cursor:pointer">
                        <span class="fileinput-new"><i class="fa fa-camera" aria-hidden="true"></i> Agregar Imagen</span>
                        <span class="fileinput-exists"><i class="fa fa-picture-o" aria-hidden="true"></i> Cambiar imagen</span>
                        <input type="file" name="url_avatar" accept="image/x-png,image/gif,image/jpeg"/></span>
                    </div>
                  </div>
                </div>
                <div class="form-horizontal">
                  <div class="row">
                    <label class="col-md-4 label-on-left">Perfil de Usuario</label>
                    <div class="col-md-8">
                      <div class="btn-group bootstrap-select show-tick">
                        <select class="selectpicker" name="perfil_id"  data-style="select-with-transition" title="Selecione el Perfil" required>
                          @foreach ($perfiles as $index => $perfil)
                            <option value={{$perfil->id}}>{{$perfil->perfil}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-4 label-on-left">Nombre de Usuario</label>
                    <div class="col-md-8">
                      <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" name="user" value="{{ old('user') }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-4 label-on-left">Contraseña</label>
                    <div class="col-md-8">
                      <div class="form-group label-floating is-empty">
                        <input id="pass" type="password" class="form-control" name="password" value="{{ old('password') }}"  required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-4 label-on-left">Confirmar Contraseña</label>
                    <div class="col-md-8">
                      <input type="password" class="form-control" equalto="#pass" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary btn-round">
              <i class="material-icons">save</i>
               Guardar
            </button>
        </div>
      </form>
    </div>
  @endsection
  @push('scripts')
    @include('layouts.partials.errors')
    <script type="text/javascript">
    $(function(){
        $('#createUsuario').validate({
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
