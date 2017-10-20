@extends('layouts.master')
@section('title','Editar Perfil')
@section('nav-top')

@endsection
@section('content')
  <form id="MyPerfil" action="/perfil/{{$user->id}}" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="card">
      <div class="card-content">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4 text-center">
              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                <div class="fileinput-new thumbnail img-circle" style="max-width:170px;">
                  @if ($user->url_avatar)
                    <img src="{{url($user->url_avatar)}}" alt="...">
                  @else
                    <img src="{{asset('img/user-default.jpg')}}" alt="...">
                  @endif
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail img-circle" style="max-width:170px;"></div>
                <div>
                  <span class="btn btn-simple btn-primary btn-file btn-xs" style="cursor:pointer">
                    <span class="fileinput-new"><i class="fa fa-camera" aria-hidden="true"></i> Agregar Imagen</span>
                    <span class="fileinput-exists"><i class="fa fa-picture-o" aria-hidden="true"></i> Cambiar imagen</span>
                    <input type="file" name="url_avatar" accept="image/x-png,image/gif,image/jpeg"/></span>
                  </div>
                </div><hr class="hr">
                <div class="row">
                  <span class="label light-blue darken-4"><i class="fa fa-key" aria-hidden="true"></i> {{$user->user}}</span>
                  <span class="label light-blue darken-4"><i class="fa fa-user" aria-hidden="true"></i> {{$user->perfil->descripcion}}</span>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-horizontal">
                  <div class="row">
                    <label class="col-md-2 label-on-left">Nombre</label>
                    <div class="col-md-10">
                      <input type="text" name="nombre" class="form-control" value="{{$user->nombre}}">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 label-on-left">Apellido</label>
                    <div class="col-md-10">
                      <input type="text" name="apellido" class="form-control" value="{{$user->apellido}}">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 label-on-left">Dirección</label>
                    <div class="col-md-10">
                      <input type="text" name="direccion" class="form-control" value="{{$user->direccion}}">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 label-on-left">Telefono</label>
                    <div class="col-md-10">
                      <input type="text" name="telefono" class="form-control" value="{{$user->telefono}}">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 label-on-left">Email</label>
                    <div class="col-md-10">
                      <input type="email" name="email" class="form-control" value="{{$user->email}}">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 label-on-left">Celular</label>
                    <div class="col-md-10">
                      <input type="text" name="celular" class="form-control" value="{{$user->celular}}">
                    </div>
                  </div>
                  <hr class="hr" style="width:90%">
                  <div class="row">
                    <label class="col-md-3 label-on-left">Contraseña Actual</label>
                    <div class="col-md-9">
                      <input type="password" name="password_actual" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-3 label-on-left">Nueva Contraseña</label>
                    <div class="col-md-9">
                      <input id="pass" type="password" name="password" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-3 label-on-left">Confirmar Constraseña</label>
                    <div class="col-md-9">
                      <input type="password" class="form-control" equalto="#pass">
                    </div>
                  </div>
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
@endsection
@push('scripts')
  @include('layouts.partials.errors')
  <script type="text/javascript">
  $(function(){
      $('#MyPerfil').validate({
        errorPlacement: function(error, element) {
          $(element).closest('div.form-group').addClass('has-error');
          $(element).siblings( ".select-with-transition" ).addClass('error_selectpicker');
        }
      });
  });
  </script>
@endpush
