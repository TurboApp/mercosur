@extends('layouts.master')

@section('title','Agregar operario')

@section('nav-top')
  <ul class="nav navbar-nav navbar-right">
    <li>
        <a href="/fuerzas" title="Ir a operarios">
            <i class="material-icons">arrow_upward</i>
            <p class="hidden-lg hidden-md">Ir a clientes</p>
        </a>
    </li>
  </ul>
  @component('components.navbarsearch',[
      'action'    =>  'FuerzaTareaController@search',
  ])
  @endcomponent()
@endsection
@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Fuerza de tarea' => 'fuerza-tarea', 'Agregar operarario' => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
  <form id="createOperario" class="" action="/fuerzas" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="row">
    <div class="col-md-10 col-sm-12  col-md-offset-1">
      <div class="card">
        <div class="card-content">
          <h4 class="card-title">Ingrese los datos</h4>
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-md-2 control-label"><span class="text-danger">*</span> Nombre</label>
              <div class="col-md-10">
                <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label"> Contacto</label>
              <div class="col-md-10">
                  <input type="text" name="contacto" value="{{old('contacto')}}" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Descripcion</label>
              <div class="col-md-10">
                <textarea name="descripcion" class="form-control">{{old('descripcion')}}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label"><span class="text-danger">*</span> Categoria</label>
              <div class="col-md-10">
                <div class="btn-group bootstrap-select show-tick">
                  <select class="selectpicker" name="categoria"  data-style="select-with-transition" title="Selecione una opcion" required>
                    <option value="Montacarguista" @if(old('categoria') == "Montacarguista") select  @endif>Montacarguista</option>
                    <option value="Montacarga" @if(old('categoria') == "Montacarga") select  @endif>Montacarga</option>
                    <option value="Auxiliar de patio" @if(old('categoria') == "Auxiliar de patio") select  @endif>Auxililar de Patio</option>
                  </select>
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
      $('#createOperario').validate({
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
