@extends('layouts.master')
@section('title','Cards de Usuarios')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'UserController@search',
    ])
    @endcomponent()
  @endsection
  @section('content')
    @if (!count($usuarios))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
    @else
      <div class="row no-gutter">
        @foreach ($usuarios as $index => $usuario)
          <div class="col-md-4 col-sm-6">
            <div class="card card-profile card-plain">
              <div class="col-md-5">
                <div class="">
                  @if ($usuario->url_avatar)
                    <img class="img img-responsive img-circle z-depth-3"  src="{{Storage::url($usuario->url_avatar)}}" alt=""  onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                  @else
                    <img src="{{asset('img/'.str_replace(" ","-",$usuario->perfil->perfil).'.png')}}" alt="..." class="img img-responsive img-circle z-depth-3" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                  @endif
                </div>
              </div>
              <div class="col-md-7">
                <div class="card-content">
                    <h4 class="card-title text-truncate-ln2">{{$usuario->nombre}} {{$usuario->apellido}}</h4>
                  <p class="category text-muted text-uppercase">
                    @if (count($usuario->puestos))
                      @foreach ($usuario->puestos as $puesto)
                          {{$puesto->puesto}}
                      @endforeach
                    @else
                      <span class="text-danger">No asignado</span>
                    @endif
                  </p>
                  <p class="category text-muted"><i class="fa fa-user-circle-o fa-1 text-muted" aria-hidden="true"></i> {{$usuario->user}}</p>
                  <div class="footer">
                    <a href="/usuarios/{{$usuario->id}}"><button type="button" class="btn btn-primary btn-simple btn-just-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                    <a href="/usuarios/{{$usuario->id}}/editar"><button type="button" class="btn btn-success btn-simple btn-just-icon"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="card-footer text-center">
          {{ $usuarios->links() }}
      </div>
    @endif
  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
