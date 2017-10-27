@extends('layouts.master')

@section('title','Agente: '.str_limit($agente->nombre, 24))

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Agentes' => 'agentes',  $agente->nombre => '' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/agentes/{{$agente->id}}" title="Cancelar">
                <i class="material-icons">cancel</i>
                <p class="hidden-lg hidden-md">cancelar</p>
            </a>
        </li>
        <li>
            <a href="/agentes" title="Ir a agentes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a agentes</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @component('components.navbarsearch',[
        'action' => 'AgenteController@search'
    ])
    @endcomponent()
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
   
        <div class="card">
            <form id="editAgente" method="POST" action="/agentes/{{ $agente->id }}" class="form-horizontal" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">edit</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Edición</h4>
                    <div class="row">
                        <div class="form-group label-floating is-empty">
                            <label class="col-md-2 label-on-left" for="agente"><span class="text-danger">*</span> Nombre</label>
                            <div class="col-md-10">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" name="nombre" value="{{ $agente->nombre }}" maxlength="90" required>
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
                                        <input type="text" class="form-control" name="nombre_corto" value="{{ $agente->nombre_corto  }}" required>
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
                                        <input type="text" class="form-control" name="rfc" value="{{ $agente->rfc }}" required>
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
                                        <input type="text" class="form-control" name="email" value="{{ $agente->email }}" email="true" maxlength="60">
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5"> 
                                    <div class="row">     
                                        <label class="col-md-3 label-on-left">Teléfono</label>
                                        <div class="col-md-9 ">                     
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="telefono" value="{{ $agente->telefono }}"  maxlength="20">
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
                                                <input type="text" class="form-control" name="celular" value="{{ $agente->celular }}"  maxlength="20">
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
                                        <input type="text" class="form-control" name="ciudad" value="{{ $agente->ciudad }}" maxlength="60">
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
                                        <input type="text" class="form-control" name="codigo_postal" value="{{ $agente->codigo_postal }}" maxlength="10">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-md-2 label-on-left">Direcciòn</label>
                        <div class="col-md-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <textarea class="form-control" name="direccion" maxlength="191">{{ $agente->direccion }}</textarea>
                                <span class="material-input"></span>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div>
                </div><!-- ./card-content -->
                <div class="card-footer text-right">
                    <hr>
                    <nav class="navs pull-right">
                        <ul class="list-inline">
                            <li>
                                <a href="/agentes/{{$agente->id}}" class="btn btn-danger btn-simple delete-agente">
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
      $('#editAgente').validate({
            errorPlacement: function(error, element) {
                $(element).parent('div').addClass('has-error');
            }
        });

    </script>
@endpush



