@extends('layouts.master')

@section('title','Coordinadores')

@section('nav-top')
  @component('components.navbarsearch',[
      'action'    =>  'FuerzaTareaController@searchCoordinadoresProduccion',
      'value'     =>  $request->s
  ])
  @endcomponent()
@endsection
@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Coordinadores' => 'coordinadores','Resultados de la Busqueda' => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
    @if (!count($coordinadores))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
      @else
        <div class="row">
            @foreach ($coordinadores as $coordinador)
                @component('components.productividad.cardCoordinador', ['coordinador'=>$coordinador] )
                @endcomponent()
            @endforeach
        </div>
        <div class="card-footer text-center">
            {{ $coordinadores->links() }}
        </div>
    @endif

  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
