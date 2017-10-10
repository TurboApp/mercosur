@extends('layouts.master')
@section('title','Información de Transportes')
@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/transportes" title="Todos los Transportes">
                <i class="material-icons">reply</i>
                <p class="hidden-lg hidden-md">Regresar</p>
            </a>
        </li>
        <li>
            <a href="/transportes/{{ $transporte->id }}/editar" title="Editar">
                <i class="material-icons">edit</i>
                <p class="hidden-lg hidden-md">Editar</p>
            </a>
        </li>
        <li>
            <a href="#" class=" delete-transporte" title="Eliminar">
                <i class="material-icons">delete</i>
                <p class="hidden-lg hidden-md">Eliminar</p>
            </a>
        </li>
        <li>
            <a href="/transportes/nuevo" title="Agregar nuevo">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Nuevo</p>
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
            <form class="form-horizontal">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="fa fa-truck fa-2x" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Datos del Transporte</h4>
                    <div class="row">
                        <label class="col-md-2 label-on-left">Nombre</label>
                        <div class="col-md-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ $transporte->nombre }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $transporte->nombre_corto !== 'null' ) ? $transporte->nombre_corto : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $transporte->rfc !== 'null' ) ? $transporte->rfc : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $transporte->email !== 'null' ) ? $transporte->email : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <label class="col-md-3 label-on-left">Teléfono</label>
                                        <div class="col-md-9 ">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" value="{{ ( $transporte->telefono !== 'null' ) ? $transporte->telefono : '' }}" disabled="">
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
                                                <input type="text" class="form-control" value="{{ ( $transporte->celular !== 'null' ) ? $transporte->celular : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $transporte->ciudad !== 'null' ) ? $transporte->ciudad : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $transporte->codigo_postal !== 'null' ) ? $transporte->codigo_postal : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Tipo</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" value="{{ ( $transporte->tipo !== 'null' ) ? $transporte->tipo : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-3 label-on-left">País</label>
                                <div class="col-md-9">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" value="{{ ( $transporte->pais !== 'null' ) ? $transporte->pais : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-md-2 label-on-left">Dirección</label>
                        <div class="col-md-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <textarea class="form-control" disabled="">{{ ( $transporte->direccion !== 'null' ) ? $transporte->direccion : '' }}</textarea>
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
                                <a href="#" class="btn btn-danger btn-simple delete-transporte">
                                    <i class="material-icons">delete</i>
                                    Eliminar
                                </a>
                            </li>
                            <li>
                                <a href="/transportes/{{ $transporte->id }}/editar" class="btn btn-primary btn-round">
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

  @include("layouts.partials.confirmDelete", ["url" => "/transportes/$transporte->id/destroy", "class" => "delete-transporte", "redirect" => "/transportes" ])

@endpush
