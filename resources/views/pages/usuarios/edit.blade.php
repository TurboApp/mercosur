@extends('layouts.master')

@section('title','Edición usuario: ' . $usuario->nombre )

@section('nav-top')
  @component('components.navbarsearch',[
      'action'    =>  'UserController@search',
  ])
  @endcomponent()
@endsection

@section('breadcrump')
  @component('components.breadcrump',[
      'navigation'    =>  [ 'Inicio' => 'inicio', 'Usuarios'=>'usuarios' , 'Edición usuario: ' . $usuario->nombre  => '' ],
  ])
  @endcomponent()
@endsection

@section('content')
  <div class="row">
    <form id="editUsuario" method="POST" action="/usuarios/{{$usuario->id}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
      <div class="col-md-10 col-sm-12  col-md-offset-1">
        <div class="card">
          <div class="card-content">
            <h4 class="card-title">Datos Generales</h4>
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-md-2 control-label">Nombre</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="nombre" value="{{$usuario->nombre}}" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Apellido</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="apellido" value="{{$usuario->apellido}}" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Dirección</label>
                <div class="col-md-10">
                  <textarea class="form-control" name="direccion">{{ $usuario->direccion }}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Email</label>
                <div class="col-md-10">
                  <input type="email" class="form-control" name="email" value="{{$usuario->email}}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Telefono</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="telefono" value="{{$usuario->telefono}}" maxlength="20">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Celular</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" name="celular" value="{{$usuario->celular}}" maxlength="20" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Puesto</label>
                <div class="col-md-10">
                  {!!Form::select('id_puesto[]',$puestos,$usuario->puestos->pluck('id')->toArray(),['multiple'=>'multiple','value'=>'id_puesto','class'=>'selectpicker','data-style'=>'select-with-transition','required'=>'required'])!!}
                </div>
              </div>  
              <div class="form-group">
                <label class="col-md-2 control-label">Equipo</label>
                <div class="col-md-10">
                  {!!Form::select('equipo_id',$equipos,$usuario->equipo->id,['value'=>'equipo_id','class'=>'selectpicker','data-style'=>'select-with-transition','required'=>'required'])!!}
                </div>
              </div>  
            </div><!-- ./form-horizontal -->
          </div><!-- ./card-content -->    
        </div><!-- ./card -->      
        <div class="card">
          <div class="card-content">
            <h4 class="card-title">Datos de la cuenta</h4>
                {{--  <div class="text-center">
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
                </div>  --}}
            <div class="form-group">
              <label class="col-md-2 control-label">User</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name="user" value="{{$usuario->user}}" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Perfil</label>
              <div class="col-md-10">
                {!!Form::select('id_perfil',$perfiles,$usuario->perfil->id,['class'=>'selectpicker','data-style'=>'select-with-transition','required'=>'required'])!!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Contraseña Nueva</label>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="password" name="password" id="password" class="form-control">
                  <span class="input-group-addon" style="padding:0;">
                    <button type="button" class="btn-view btn-sm btn btn-just-icon btn-round btn-success" style="margin:0;">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                  </span>  
                </div>
              </div>
            </div>
          </div><!-- ./card-content -->
        </div><!-- ./card -->
      </div>  <!-- ./col-md -->
      <div class="col-md-10 col-sm-12  col-md-offset-1 text-right">
          <button type="submit" class="btn btn-primary">
            <i class="material-icons">save</i>
            Guardar
          </button>
      </div><!-- ./col-md -->
    </form>
  </div><!-- ./row -->
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

      $('.btn-view').click(function(){
        if($('#password').attr('type') == 'password'){
          $(this).find('i').removeClass('fa-eye');
          $(this).find('i').addClass('fa-eye-slash');
          $('#password').attr('type','text');
        }else{
          $(this).find('i').removeClass('fa-eye-slash');
          $(this).find('i').addClass('fa-eye');
          $('#password').attr('type','password');
        }
      });

  });
  </script>
@endpush
