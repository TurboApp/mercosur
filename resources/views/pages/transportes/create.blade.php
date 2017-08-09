
@extends('layouts.master')
@section('title','Añadir nueva linea de transporte')
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
<form class="navbar-form navbar-right" method="GET" action="/transportes/busqueda/" role="search">
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
    <div class="col-md-12">

        <div class="card">
            <form id="createTransporte" method="POST" action="/transportes" class="form-horizontal" autocomplete="off">
                {{ csrf_field() }}
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="fa fa-truck fa-2x" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Ingrese los datos</h4>
                    <div class="row">
                        <div class="form-group label-floating is-empty">
                            <label class="col-sm-2 label-on-left" for="destino">* Nombre</label>
                            <div class="col-sm-10">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" maxlength="90" required>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">RFC</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" name="rfc" value="{{ old('rfc') }}" maxlength="15" required>
                                <span class="material-input"></span>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Email</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="60" email="true" >
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <label class="col-sm-3 label-on-left">Teléfono</label>
                                        <div class="col-sm-9 ">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 label-on-left">Celular</label>
                                        <div class="col-sm-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="celular" value="{{old('celular') }}" maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                      <form class="form-inline">
                        <label class="col-sm-2 label-on-left">Dirección</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="direccion" value="{{ old('direccion') }}" maxlength="60" >
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <label class="col-sm-3 label-on-left">Codigo Postal</label>
                                        <div class="col-sm-9 ">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="codigo_postal" value="{{ old('codigo_postal') }}" maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                      <div class="form-group">
                                        <label class="col-sm-3 label-on-left">Tipo</label>
                                          <div class="col-md-8 btn-group bootstrap-select show-tick">
                                            <select class="selectpicker" name="tipo" value="{{old('tipo')}}" data-style="select-with-transition" title="Seleccione" data-size="7" tabindex="-98">
                                              <option value="Nacional">Nacional</option>
                                              <option value="Extranjero">Extranjero</option>
                                            </select>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./col-md-10 -->
                      </form>
                    </div><!-- ./row -->
                    <div class="row">
                      {{-- <div class="col-md-6 col-sm-6"> --}}
                        <label class="col-sm-2 label-on-left">País</label>
                        <div class="col-sm-3">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control typeahead" name="pais" value="{{ old('pais') }}" maxlength="191">
                                <span class="material-input"></span>
                            </div>
                        </div><!-- ./col-md-10 -->
                      {{-- </div> --}}
                      {{-- <div class="col-md-6 col-sm-6"> --}}
                        <label class="col-sm-2 label-on-left">Ciudad</label>
                        <div class="col-sm-5">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" name="ciudad" value="{{ old('ciudad') }}" maxlength="60">
                                <span class="material-input"></span>
                            </div>
                        </div><!-- ./col-md-10 -->
                      {{-- </div> --}}
                    </div>
                </div><!-- ./card-content -->
                <div class="card-footer text-right">
                    <hr>
                    <button type="submit" class="btn btn-primary btn-round">
                        <i class="material-icons">save</i>
                        Guardar
                    </button>
                </div><!-- ./card-footer -->
            </form>
        </div>  <!-- ./card -->

    </div>
</div>
@endsection
@push('scripts')
  @include('layouts.partials.errors')

      <script>
        $('#createDestino').validate({
              errorPlacement: function(error, element) {
                  $(element).parent('div').addClass('has-error');
              }
          });

      </script>

      <script>

          demo.getCountry('.typeahead');

      </script>
      <script>
          let mv = new Vue({
              data:{

              },
              computed:{

              },
              methods:{

              }
          });
      </script>
@endpush
