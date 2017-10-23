@extends('layouts.master')
@section('title','Busqueda de Usuarios')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
        'value'     =>  $request->s
    ])
    @endcomponent()
  @endsection
  @section('content')
    <div class="row">
         <p class="lead text-muted"><i class="fa fa-search" aria-hidden="true"></i> Resultados de la busqueda. ({{$request->s}})</p>
    </div>
    @if (!count($fuerzas))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
    @else
      <div class="row">
        @foreach ($fuerzas as $fuerza)
          <div class="col-md-3 col-sm-6">
            <div class="card card-profile card-plain">
              <div class="card-avatar">
                <img src="{{asset('img/user-head.png')}}" alt="..." class="img img-responsive">
              </div>
              <div class="card-content text-center">
                <h4 class="card-title text-truncate-ln2">{{$fuerza->nombre}} {{$fuerza->apellido}}</h4>
                <h6 class="category text-muted">{{$fuerza->categoria}}</h6>
                <div class="footer">
                  <a href="/fuerzas/{{$fuerza->id}}"><button type="button" class="btn btn-primary btn-simple btn-just-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                  <a href="/fuerzas/{{$fuerza->id}}/editar"><button type="button" class="btn btn-success btn-simple btn-just-icon"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="card-footer text-center">
          {{ $fuerzas->links() }}
      </div>
    @endif
  @endsection
