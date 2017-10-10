@extends('layouts.master')

@section('title','Información del agente')

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/agentes" title="Todos los agentes">
                <i class="material-icons">reply</i>
                <p class="hidden-lg hidden-md">Regresar</p>
            </a>
        </li>
        <li>
            <a href="/agentes/{{ $agente->id }}/editar" title="Editar">
                <i class="material-icons">edit</i>
                <p class="hidden-lg hidden-md">Editar</p>
            </a>
        </li>
        <li>
            <a href="#" class="delete-agente" title="Eliminar">
                <i class="material-icons">delete</i>
                <p class="hidden-lg hidden-md">Eliminar</p>
            </a>
        </li>
    
        <li>
            <a href="/agentes/nuevo" title="Agregar nuevo">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Nuevo</p>
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
            <form class="form-horizontal">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Datos del agente</h4>
                    <div class="row">
                        <label class="col-md-2 label-on-left">Nombre</label>
                        <div class="col-md-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ $agente->nombre }}" disabled="">
                                <span class="material-input"></span>
                            </div>
                           
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Nombre corto</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="nombre_corto" value="{{ ( $agente->nombre_corto !== 'null' ) ? $agente->nombre_corto : '' }}" disabled>
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-2 label-on-left">RFC</label>
                                <div class="col-md-10">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="rfc" value="{{ ( $agente->rfc !== 'null' ) ? $agente->rfc : '' }}" disabled>
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
                                        <input type="text" class="form-control" value="{{ ( $agente->email !== 'null' ) ? $agente->email : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>
                                   
                                </div>
                                <div class="col-md-5"> 
                                    <div class="row">     
                                        <label class="col-md-3 label-on-left">Teléfono</label>
                                        <div class="col-md-9 ">                     
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" value="{{ ( $agente->telefono !== 'null' ) ? $agente->telefono : '' }}" disabled="">
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
                                                <input type="text" class="form-control" value="{{ ( $agente->celular !== 'null' ) ? $agente->celular : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $agente->ciudad !== 'null' ) ? $agente->ciudad : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $agente->codigo_postal !== 'null' ) ? $agente->codigo_postal : '' }}" disabled="">
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
                                <textarea class="form-control"  disabled="">{{ ( $agente->direccion !== 'null' ? $agente->direccion : '' ) }}</textarea>
                                <span class="material-input"></span>
                            </div>
                            
                        </div>
                    </div>
                </div><!-- ./card-content -->
                <div class="card-footer">
                    <hr>
                    <nav class="navs pull-right">
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn btn-danger btn-simple delete-agente">
                                    <i class="material-icons">delete</i>
                                    Eliminar
                                </a>
                            </li>
                            <li>
                                <a href="/agentes/{{ $agente->id }}/editar" class="btn btn-primary btn-round">
                                    <i class="material-icons">edit</i>
                                    Editar
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>  <!-- ./card-footer -->
            </form>
        </div>  <!-- ./card -->         
   
    </div>
</div>
@endsection

@push('scripts')
  
  @include('layouts.partials.notify')

  @include("layouts.partials.confirmDelete", ["url" => "/agentes/$agente->id/destroy", "class" => "delete-agente", "redirect" => "/agentes" ])

@endpush