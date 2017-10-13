@extends('layouts.master')
@section('title','Vista de Usuario')
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
    <form class="navbar-form navbar-right" method="GET" action="/usuarios/busqueda/" role="search">
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
      <div class="col-md-10 col-sm-12  col-md-offset-1">
        <div class="card">
          <div class="card-header card-header-icon" data-background-color="blue">
            <i class="fa fa-user fa-lg" aria-hidden="true"></i>
          </div>
          <div class="card-content">
            <h4 class="card-title">Datos del Usuario</h4>
            <div class="col-md-4">
              <div class="card-profile text-center" style="margin-top:100px;">
                <div class="card-avatar"  style="max-width:170px; max-height:170px;">
                  @if ($usuario->url_avatar)
                    <img class="img" src="{{Storage::url($usuario->url_avatar)}}" alt="">
                  @else
                    <img src="{{asset('img/user-default.jpg')}}" alt="...">
                  @endif
                </div>
              </div>
              <div class="row text-center">
                <h6 class="category text-gray">{{$usuario->perfil->perfil}}</h6>
              </div>
              <div class="row text-center">
                <h4 class="card-title">
                  @foreach ($usuario->puestos as $puesto)
                    {{$puesto->puesto}}
                  @endforeach
                </h4>
              </div>
            </div>{{--card imagen--}}
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-9">
                  <h3 class="card-title">{{$usuario->nombre}} {{$usuario->apellido}}</h3>
                  <h4 class="category text-gray">{{$usuario->direccion}}</h4>
                </div>
                <div class="col-md-3 text-right">
                  <a href="/usuarios/{{$usuario->id}}/editar"><button type="button" rel="tooltip" class="btn btn-success btn-round btn-just-icon"><i class="fa fa-pencil fa-1x" aria-hidden="true"></i></button></a>
                  <a href="#" class="delete-usuario">
                    <button type="button" class="btn btn-danger btn-round btn-just-icon"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button>
                  </a>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="form-horizontal">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-2 label-on-left">Email</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" value="{{$usuario->email}}" disabled="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-2 label-on-left">Telefono</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" value="{{$usuario->telefono}}" disabled="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-2 label-on-left">Celular</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" value="{{$usuario->celular}}" disabled="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-2 label-on-left">Usuario</label>
                      <div class="col-md-10">
                        <div class="form-group label-floating is-empty">
                          <input type="text" class="form-control" value="{{$usuario->user}}" disabled="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>{{--datos usuario--}}
          </div>
        </div>
      </div>
    </div>
  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
    @include("layouts.partials.confirmDelete", ["url" => "/usuarios/$usuario->id/destroy", "class" => "delete-usuario", "redirect" => "/usuarios" ])
  @endpush
