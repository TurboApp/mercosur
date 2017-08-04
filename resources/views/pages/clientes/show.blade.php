@extends('layouts.master')

@section('title','Información del cliente')

@section('nav-top')
<ul class="nav navbar-nav navbar-right">
    <li>
        <a href="/clientes" rel="tooltip" data-placement="bottom" title="Ir a clientes">
            <i class="material-icons">reply</i>
            <p class="hidden-lg hidden-md">Ir a clientes</p>
        </a>
    </li>
    <li>
        <a href="/clientes/{{ $cliente->id }}/editar" rel="tooltip" data-placement="bottom" title="Editar">
            <i class="material-icons">edit</i>
            <p class="hidden-lg hidden-md">Editar</p>
        </a>
    </li>
    <li>
        <a href="#" rel="tooltip" class=" delete-cliente" data-placement="bottom" title="Eliminar">
            <i class="material-icons">delete</i>
            <p class="hidden-lg hidden-md">Eliminar</p>
        </a>
    </li>
    <li>
        <a href="/clientes/nuevo" rel="tooltip" data-placement="bottom" title="Agregar nuevo">
            <i class="material-icons">person_add</i>
            <p class="hidden-lg hidden-md">Agregar</p>
        </a>
    </li>
    
    
    <li class="separator hidden-lg hidden-md"></li>
</ul>

<form class="navbar-form navbar-right" method="GET" action="/clientes/busqueda/" role="search">
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
            <form class="form-horizontal">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">person</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Datos del cliente</h4>
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Nombre</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ $cliente->nombre }}" disabled="">
                                <span class="material-input"></span>
                            </div>
                           
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">RFC</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $cliente->rfc !== 'null' ) ? $cliente->rfc : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $cliente->email !== 'null' ) ? $cliente->email : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>
                                   
                                </div>
                                <div class="col-md-5"> 
                                    <div class="row">     
                                        <label class="col-sm-3 label-on-left">Teléfono</label>
                                        <div class="col-sm-9 ">                     
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" value="{{ ( $cliente->telefono !== 'null' ) ? $cliente->telefono : '' }}" disabled="">
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
                                                <input type="text" class="form-control" value="{{ ( $cliente->celular !== 'null' ) ? $cliente->celular : '' }}" disabled="">
                                                <span class="material-input"></span>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Direcciòn</label>
                        <div class="col-sm-6">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $cliente->direccion !== 'null' ? $cliente->direccion : '' ) }}" disabled="">
                                <span class="material-input"></span>
                            </div>
                           
                        </div><!-- ./col-md-10 -->
                        <label class="col-sm-2 label-on-left">Codigo postal</label>
                        <div class="col-sm-2">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $cliente->codigo_postal !== 'null' ) ? $cliente->codigo_postal : '' }}" disabled="">
                                <span class="material-input"></span>
                            </div>
                        
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Ciudad</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $cliente->ciudad !== 'null' ) ? $cliente->ciudad : '' }}" disabled="">
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
                                <a href="#" class="btn btn-danger btn-simple delete-cliente">
                                    <i class="material-icons">delete</i>
                                    Eliminar
                                </a>
                            </li>
                            <li>
                                <a href="/clientes/{{ $cliente->id }}/editar" class="btn btn-primary btn-round">
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

  @include("layouts.partials.confirmDelete", ["url" => "/clientes/$cliente->id/destroy", "class" => "delete-cliente", "redirect" => "/clientes" ])
  
@endpush