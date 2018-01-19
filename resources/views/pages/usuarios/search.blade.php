@extends('layouts.master')

@section('title','Usuarios: Resultados de la busqueda')

@section('nav-top')
  @component('components.navbarsearch',[
      'action'    =>  'UserController@search',
      'value'     =>  $request->s
  ])
  @endcomponent()
@endsection

@section('breadcrump')
  @component('components.breadcrump',[
      'navigation'    =>  [ 'Inicio' => 'inicio', 'Usuarios'=>'usuarios' , 'Resultados de la busqueda' => '' ],
  ])
  @endcomponent()
@endsection

@section('content')
    <div class="row">
      <div class="col-md-12">
        <p class="lead text-muted">
          <i class="fa fa-search" aria-hidden="true"></i> Resultados de la busqueda. ({{$request->s}})
        </p>
      </div>
    </div>
    @if (!count($usuarios))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
    @else
      <div class="row no-gutter">
        @foreach ($usuarios as $index => $usuario)
          @component('components.card-usuario', ['usuario'=>$usuario, 'edit'=>'true'] )
          @endcomponent()
        @endforeach
      </div>
      <div class="card-footer text-center">
          {{ $usuarios->links() }}
      </div>
    @endif
  @endsection
