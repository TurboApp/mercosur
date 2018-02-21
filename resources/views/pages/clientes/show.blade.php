@extends('layouts.master')


@section('title','Cliente: '.str_limit($cliente->nombre, 24))

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Clientes' => 'clientes',  $cliente->nombre => '' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        @if(auth()->user()->perfil->perfil == 'admin')
        <li>
            <a href="/clientes/{{ $cliente->id }}/editar" title="Editar">
                <i class="material-icons">edit</i>
                <p class="hidden-lg hidden-md">Editar</p>
            </a>
        </li>
        <li>
            <a href="#" class=" delete-cliente" title="Eliminar">
                <i class="material-icons">delete</i>
                <p class="hidden-lg hidden-md">Eliminar</p>
            </a>
        </li>
        <li>
            <a href="/clientes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">person_add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        @endif
        <li>
            <a href="/clientes" title="Ir a clientes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a clientes</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>

    @component('components.navbarsearch',[
        'action'    => 'ClienteController@search',
    ])
    @endcomponent()
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
                    <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Nombre corto</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" value="{{ ( $cliente->nombre_corto !== 'null' ) ? $cliente->nombre_corto : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $cliente->rfc !== 'null' ) ? $cliente->rfc : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
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
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Ciudad</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="ciudad" value="{{ ( $cliente->ciudad !== 'null' ) ? $cliente->ciudad : '' }}" maxlength="60">
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
                                        <input type="text" class="form-control" name="codigo_postal" value="{{ ( $cliente->codigo_postal !== 'null' ) ? $cliente->codigo_postal : '' }}" maxlength="10">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    
                    
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Dirección</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <textarea class="form-control" disabled="">{{ ( $cliente->direccion !== 'null' ? $cliente->direccion : '' ) }}</textarea>
                                <span class="material-input"></span>
                            </div>
                            
                        </div>
                    </div>
                </div><!-- ./card-content -->
                @if (auth()->user()->perfil->perfil == 'admin')
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
                @endif
            </form>
        </div>  <!-- ./card -->         
   
    </div>
</div>
@endsection

@push('scripts')
  
  @include('layouts.partials.notify')

  @include("layouts.partials.confirmDelete", ["url" => "/clientes/$cliente->id/destroy", "class" => "delete-cliente", "redirect" => "/clientes" ])
  
@endpush