@extends('layouts.master')
@section('title','Editar Datos de Usuario')
@section('nav-top')
  @component('components.navbarsearch',[
      'action'    =>  'UserController@search',
  ])
  @endcomponent()
@endsection
@section('content')
  <div class="row">
    <div class="col-md-10 col-sm-12  col-md-offset-1">
      <div class="card">
        <div class="card-header card-header-icon" data-background-color="">
          <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
        </div>
        <div class="card-content">
          <h4 class="card-title">Editar Usuario</h4>
          <form id="editUsuario" method="POST" action="/usuarios/{{$usuario->id}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="col-md-4">
              <div class="text-center">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                  <div class="fileinput-new thumbnail img-circle" style="max-width:170px;">
                    @if ($usuario->url_avatar)
                      <img class="img img-responsive img-circle z-depth-3"  src="{{Storage::url($usuario->url_avatar)}}" alt=""  onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    @else
                      <img src="{{asset('img/'.str_replace(" ","-",$usuario->perfil->perfil).'.png')}}" alt="..." class="img img-responsive img-circle z-depth-3" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    @endif
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail img-circle" style="max-width:170px;"></div>
                    <div>
                      <span class="btn btn-simple btn-primary btn-file btn-xs" style="cursor:pointer">
                        <span class="fileinput-new"><i class="fa fa-camera" aria-hidden="true"></i> Agregar Imagen</span>
                        <span class="fileinput-exists"><i class="fa fa-picture-o" aria-hidden="true"></i> Cambiar imagen</span>
                        <input type="file" name="url_avatar" accept="image/x-png,image/gif,image/jpeg"/></span>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label class="col-md-3 label-on-left">Puesto</label>
                  <div class="col-md-9">
                    {!!Form::select('id_puesto[]',$puestos,$usuario->puestos->pluck('id')->toArray(),['multiple'=>'multiple','value'=>'id_puesto','class'=>'selectpicker','data-style'=>'select-with-transition','required'=>'required'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label class="col-md-3 label-on-left">Perfil</label>
                  <div class="col-md-9">
                    {!!Form::select('id_perfil',$perfiles,$usuario->perfil->id,['class'=>'selectpicker','data-style'=>'select-with-transition','required'=>'required'])!!}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-horizontal">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="col-md-4 label-on-left">Nombre</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="nombre" value="{{$usuario->nombre}}" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="col-md-4 label-on-left">Apellido</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="apellido" value="{{$usuario->apellido}}" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label class="col-md-2 label-on-left">Dirección</label>
                        <div class="col-md-10">
                          <input type="text" class="form-control" name="direccion" value="{{$usuario->direccion}}" required>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <label class="col-md-2 label-on-left">Email</label>
                      <div class="col-md-10">
                        <input type="email" class="form-control" name="email" value="{{$usuario->email}}">
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-md-2 label-on-left">Telefono</label>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="telefono" value="{{$usuario->telefono}}" maxlength="20">
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-md-2 label-on-left">Celular</label>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="celular" value="{{$usuario->celular}}" maxlength="20" required>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-md-2 label-on-left">User</label>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="user" value="{{$usuario->user}}" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-primary">
                <i class="material-icons">save</i>
                 Guardar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  @include('layouts.partials.errors')
  <script type="text/javascript">
  $(function(){
      $('#editUsuario').validate({
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
