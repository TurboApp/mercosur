@extends('layouts.master')
@section('title','Fuerza de tarea')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
        'value'     =>  $request->s
    ])
    @endcomponent()
@endsection
@section('breadcrump')
  @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Fuerza de tarea' => 'fuerza-tarea', 'Resultados de la Busqueda' => '' ],
    ])
  @endcomponent()
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
          <p class="lead text-muted"><i class="fa fa-search" aria-hidden="true"></i> Resultados de la busqueda. ({{$request->s}})</p>
        </div>
    </div>
    @if (!count($fuerzas))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
    @else
      <div class="row">
        @foreach ($fuerzas as $fuerza)
          <div class="col-md-3 col-sm-6">
            <div class="card card-profile card-plain">
              <div class="card-avatar">
                <img src="{{asset('img/fuerza-'.str_replace(" ","-",$fuerza->categoria).'.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
              </div>
              <div class="card-content text-center">
                <h4 class="card-title text-truncate">{{$fuerza->nombre}} </h4>
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
