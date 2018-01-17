@extends('layouts.master')
@section('title','Agregar usuario')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'UserController@search',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
  @component('components.breadcrump',[
      'navigation'    =>  [ 'Inicio' => 'inicio', 'Usuarios'=>'usuarios' , 'Agregar usuario' => '' ],
  ])
  @endcomponent()
@endsection

@section('content')
    <div class="row">
      <form id="createUsuario" action="/usuarios" method="POST" autocomplete="off" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-10 col-sm-12  col-md-offset-1">
          <div class="card">
            <div class="card-content">
              <h4 class="card-title">Datos Generales</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Nombre</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Apellido</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="apellido" value="{{ old('apellido') }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Dirección</label>
                  <div class="col-md-10">
                    <textarea class="form-control" name="direccion" required>{{ old('direccion') }}</textarea> 
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Email</label>
                  <div class="col-md-10">
                      <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Telefono</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" maxlength="10">
                    </div>
                  
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><span class="text-danger">*</span> Celular</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" name="celular" value="{{ old('celular') }}" maxlength="10" required>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Puesto</label>
                  <div class="col-md-10">
                    <select class="selectpicker" name="id_puesto[]" multiple  data-style="select-with-transition" title="Selecione el Puesto"  required>
                        @foreach ($puestos as $puesto )
                            <option value="{{$puesto->id}}" >{{$puesto->puesto}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Equipo</label>
                  <div class="col-md-10">
                    <select class="selectpicker" name="equipo_id" data-style="select-with-transition" title="Seleccione un equipo" required>
                      @foreach ($equipos as $equipo)
                        <option value="{{$equipo->id}}" @if($equipo->id == old('equipo_id')) selected  @endif > {{ $equipo->nombre }} </option>
                      @endforeach
                    </select>  
                  </div>
                </div>
              </div><!-- ./form-horizontal -->
            </div><!-- ./card-content -->
          </div> <!--  ./card  -->
        </div> {{-- ./col-md --}}
        <div class="col-md-10 col-sm-12  col-md-offset-1">
          <div class="card">
            <div class="card-content">
              <h4 class="card-title">Datos de la Cuenta</h4>
              {{--  <div class="text-center">
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
                </div>  --}}
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Perfil de Usuario</label>
                  <div class="col-md-10">
                    <div class="btn-group bootstrap-select show-tick">
                      <select class="selectpicker" name="perfil_id"  data-style="select-with-transition" title="Selecione el Perfil" required>
                        @foreach ($perfiles as $index => $perfil)
                          <option value={{$perfil->id}} @if($perfil->id == old('perfil_id')) selected @endif >{{$perfil->descripcion}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Nombre de Usuario</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="user" value="{{ old('user') }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Contraseña</label>
                  <div class="col-md-10">
                    <input id="pass" type="password" class="form-control" name="password"  required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"><span class="text-danger">*</span> Confirmar Contraseña</label>
                  <div class="col-md-10">
                    <input type="password" class="form-control" equalto="#pass" required>
                  </div>
                </div>
              </div><!-- ./form-horizontal -->
            </div><!-- ./card-content -->
          </div><!-- ./card -->
        </div><!-- ./col-md -->
        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary">
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
