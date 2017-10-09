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
    <div class="col-xs-6">
      <form id="createPerfil" action="/herramientas" method="POST" autocomplete="off">
        {{ csrf_field() }}
        <div class="card">
          <div class="card-header card-header-icon" data-background-color="blue">
            <i class="fa fa-cog fa-lg" aria-hidden="true"></i>
          </div>
          <div class="card-content">
            <h4 class="card-title">Agregar nuevo Perfil</h4>
            <div class="form-horizontal">
              <div class="row">
                <label class="col-xs-2 label-on-left">Nombre Perfil</label>
                <div class="col-xs-10">
                  <div class="form-group label-floating is-empty">
                    <input type="text" class="form-control" name="perfil" value="{{ old('perfil') }}" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="form-group label-floating is-empty">
                    <label class="control-label">Una breve descripción de el perfil</label>
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
    <div class="col-xs-6">
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
  @endsection
@push('scripts')
  @include('layouts.partials.notify')
  <script type="text/javascript">
  $(function(){
      $('#createPerfil').validate({
        errorPlacement: function(error, element) {
          $(element).closest('div.form-group').addClass('has-error');
        }
      });
      $('#createPuesto').validate({
        errorPlacement: function(error, element) {
          $(element).closest('div.form-group').addClass('has-error');
        }
      });
  });
  </script>
@endpush
