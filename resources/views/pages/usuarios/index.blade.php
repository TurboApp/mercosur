@extends('layouts.master')

@section('title','Usuarios')

@section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'UserController@search',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Usuarios'=>'miPerfil' ],
    ])
    @endcomponent()
@endsection


@section('content')
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
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
