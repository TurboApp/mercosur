@extends('layouts.master')
@section('title','Información de Transportes')
@section('nav-top')
  <ul class="nav navbar-nav navbar-right">
     <li>
        <a href="/transportes" rel="tooltip" data-placement="bottom" title="Todos los Transportes">
            <i class="material-icons">reply</i>
            <p class="hidden-lg hidden-md">Regresar</p>
        </a>
    </li>
    <li>
        <a href="/transportes/{{ $transporte->id }}/editar" rel="tooltip" data-placement="bottom" title="Editar">
            <i class="material-icons">edit</i>
            <p class="hidden-lg hidden-md">Editar</p>
        </a>
    </li>
    <li>
        <a href="#" rel="tooltip" class=" delete-transporte" data-placement="bottom" title="Eliminar">
            <i class="material-icons">delete</i>
            <p class="hidden-lg hidden-md">Eliminar</p>
        </a>
    </li>

    <li>
        <a href="/transportes/nuevo" rel="tooltip"  data-placement="bottom" title="Agregar nuevo">
            <i class="material-icons">add</i>
            <p class="hidden-lg hidden-md">Nuevo</p>
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
            <form class="form-horizontal">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="fa fa-truck fa-2x" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Datos del Transporte</h4>
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Nombre</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ $transporte->nombre }}" disabled="">
                                <span class="material-input"></span>
                            </div>

                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">RFC</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $transporte->rfc !== 'null' ) ? $transporte->rfc : '' }}" disabled="">
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
                                        <input type="text" class="form-control" value="{{ ( $transporte->email !== 'null' ) ? $transporte->email : '' }}" disabled="">
                                        <span class="material-input"></span>
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <label class="col-sm-3 label-on-left">Teléfono</label>
                                        <div class="col-sm-9 ">
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
                                        <label class="col-sm-3 label-on-left">Celular</label>
                                        <div class="col-sm-9">
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
                      <label class="col-sm-2 label-on-left">Dirección</label>
                      <div class="col-sm-10">
                          <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group label-floating is-empty">
                                      <label class="control-label"></label>
                                      <input type="text" class="form-control" value="{{ ( $transporte->direccion !== 'null' ) ? $transporte->direccion : '' }}" disabled="">
                                      <span class="material-input"></span>
                                  </div>

                              </div>
                              <div class="col-md-5">
                                  <div class="row">
                                      <label class="col-sm-3 label-on-left">Codigo Postal</label>
                                      <div class="col-sm-9 ">
                                          <div class="form-group label-floating is-empty">
                                              <label class="control-label"></label>
                                              <input type="text" class="form-control" value="{{ ( $transporte->codigo_postal !== 'null' ) ? $transporte->codigo_postal : '' }}" disabled="">
                                              <span class="material-input"></span>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="row">
                                      <label class="col-sm-3 label-on-left">Tipo</label>
                                      <div class="col-sm-9">
                                          <div class="form-group label-floating is-empty">
                                              <label class="control-label"></label>
                                              <input type="text" class="form-control" value="{{ ( $transporte->tipo !== 'null' ) ? $transporte->tipo : '' }}" disabled="">
                                              <span class="material-input"></span>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">País</label>
                        <div class="col-sm-5">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $transporte->pais !== 'null' ) ? $transporte->pais : '' }}" disabled="">
                                <span class="material-input"></span>
                            </div>

                        </div>
                        <label class="col-sm-2 label-on-left">Ciudad</label>
                        <div class="col-sm-3">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="text" class="form-control" value="{{ ( $transporte->ciudad !== 'null' ) ? $transporte->ciudad : '' }}" disabled="">
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
