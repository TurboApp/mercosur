@extends('layouts.master')

@section('title','Agregar agente')

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/agentes" title="Ir a agentes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a clientes</p>
            </a>
        </li>
      
    </ul>
    @component('components.navbarsearch',[
        'action' => 'AgenteController@search'
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Agentes' => 'agentes', 'Agregar agente' => '' ],
    ])
    @endcomponent()
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
   
        <div class="card">
            <form id="createAgente" method="POST" action="/agentes" class="form-horizontal" autocomplete="off">
                {{ csrf_field() }}
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Ingrese los datos</h4>
                    <div class="row">
                        <div class="form-group label-floating is-empty">
                            <label class="col-md-2 label-on-left" for="agente"><span class="text-danger">*</span> Nombre</label>
                            <div class="col-md-10">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" maxlength="90" required>
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
                                        <input type="text" class="form-control" name="nombre_corto" value="{{ old('nombre_corto') }}" maxlength="15" required>
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
                                        <input type="text" class="form-control" name="rfc" value="{{ old('rfc') }}" maxlength="15" required>
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
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="60" email="true" >
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5"> 
                                    <div class="row">     
                                        <label class="col-md-3 label-on-left">Teléfono</label>
                                        <div class="col-md-9 ">                     
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
                                        <label class="col-md-3 label-on-left">Celular</label>
                                        <div class="col-md-9">                     
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
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Ciudad</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="ciudad" value="{{ old('ciudad') }}" maxlength="60">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-3 label-on-left">Codigo postal</label>
                                <div class="col-md-9">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="codigo_postal" value="{{ old('codigo_postal') }}" maxlength="10">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    
                    
                    <div class="row">
                        <label class="col-md-2 label-on-left">Dirección</label>
                        <div class="col-md-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <textarea class="form-control" name="direccion" maxlength="191">{{ old('direccion') }}</textarea>
                                <span class="material-input"></span>
                            </div>
                        </div><!-- ./col-md-10 -->
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
      $('#createAgente').validate({
            errorPlacement: function(error, element) {
                $(element).parent('div').addClass('has-error');
            }
        });

    </script>

@endpush