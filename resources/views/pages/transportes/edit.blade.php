@extends('layouts.master')

@section('title','Linea de transporte: '.str_limit($transporte->nombre, 24))

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Lineas de transportes' => 'transportes',  $transporte->nombre => '' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/transportes/{{$transporte->id}}" title="Cancelar">
                <i class="material-icons">cancel</i>
                <p class="hidden-lg hidden-md">Cancelar</p>
            </a>
        </li>
        <li>
            <a href="/transportes" title="Ir a clientes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a clientes</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @component('components.navbarsearch',[
                'action'  =>  'LineasTransporteController@search',
            ])
    @endcomponent()
@endsection

@section('content')
    <div class="row">
    <div class="col-md-12">

        <div class="card">
            <form id="editTransporte" method="POST" action="/transportes/{{ $transporte->id }}" class="form-horizontal" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">edit</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Edición</h4>
                    <div class="row">
                        <div class="form-group label-floating is-empty">
                            <label class="col-md-2 label-on-left" for="transporte"><span class="text-danger">*</span> Nombre</label>
                            <div class="col-md-10">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" name="nombre" value="{{ $transporte->nombre }}" maxlength="90" required>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left"><span class="text-danger">*</span> Nombre corto</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="nombre_corto" value="{{ $transporte->nombre_corto }}" maxlength="30" required>
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-2 label-on-left"><span class="text-danger">*</span> RFC</label>
                                <div class="col-md-10">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="rfc" value="{{ $transporte->rfc }}" maxlength="15" required>
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    
                    <div class="row">
                        <label class="col-md-2 label-on-left">Email</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="email" value="{{ $transporte->email }}" email="true" maxlength="60">
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <label class="col-md-3 label-on-left">Teléfono</label>
                                        <div class="col-md-9 ">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="telefono" value="{{ $transporte->telefono }}"  maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-md-3 label-on-left">Celular</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="celular" value="{{ $transporte->celular }}"  maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Ciudad</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="ciudad" value="{{ $transporte->ciudad }}" maxlength="60">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-3 label-on-left">Codigo Postal</label>
                                <div class="col-md-9">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="codigo_postal" value="{{ $transporte->codigo_postal }}"  maxlength="10">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Tipo</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <select class="selectpicker" name="tipo" value="{{ $transporte->tipo }}" data-style="select-with-transition" title="{{ $transporte->tipo }}"  data-size="7" tabindex="-98">
                                            <option value="Nacional">Nacional</option>
                                            <option value="Extranjero">Extranjero</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./col-md-10 -->
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-3 label-on-left">País</label>
                                <div class="col-md-9">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control typeahead" name="pais" value="{{ $transporte->pais }}" maxlength="20">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <label class="col-md-2 label-on-left">Dirección</label>
                        <div class="col-md-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <textarea class="form-control" name="direccion" maxlength="191">{{ $transporte->direccion }}</textarea>
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                </div><!-- ./card-content -->
                <div class="card-footer text-right">
                    <hr>
                    <nav class="navs pull-right">
                        <ul class="list-inline">
                            <li>
                                <a href="/transportes/{{$transporte->id}}" class="btn btn-danger btn-simple delete-agente">
                                    <i class="material-icons">cancel</i>
                                    Cancelar
                                </a>
                            </li>
                            <li>
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="material-icons">save</i>
                                    Guardar cambios
                                </button>
                            </li>
                        </ul>
                    </nav>

                </div><!-- ./card-footer -->
            </form>
        </div>  <!-- ./card -->

    </div>
</div>
  @endsection
@push('scripts')
  @include('layouts.partials.errors')
     <script>
      $('#editTransporte').validate({
            errorPlacement: function(error, element) {
                $(element).parent('div').addClass('has-error');
            }
        });

    </script>
@endpush
@push('scripts')
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
