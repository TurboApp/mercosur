@extends('layouts.master')
@section('title','Operarios')
  @section('nav-top')
    <form class="navbar-form navbar-right" method="GET" action="/fuerzas/busqueda/" role="search">
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
    @if (!count($fuerzas))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
      @else
        <div class="row">
          @foreach ($fuerzas as $fuerza)
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <img src="{{asset('img/user-head.png')}}" alt="...">
                </div>
                <div class="card-content">
                  <div class="row">
                    <h3 class="card-title">{{$fuerza->nombre}}</h3>
                    <h4 class="category text-gray">{{$fuerza->categoria}}</h4>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-6 text-center">
                      <i class="fa fa-mobile fa-2x text-muted" aria-hidden="true"></i>
                      <h4 class="category text-gray">{{$fuerza->celular}}</h4>
                    </div>
                    <div class="col-md-6 text-center">
                      <i class="fa fa-phone fa-2x text-muted" aria-hidden="true"></i>
                      <h4 class="category text-gray">{{$fuerza->telefono}}</h4>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <a href="/fuerzas/{{$fuerza->id}}"><button type="button" class="btn btn-primary btn-block btn-round">Ver Detalles</button></a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
    @endif

  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
