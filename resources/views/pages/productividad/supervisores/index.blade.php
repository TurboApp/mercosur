@extends('layouts.master')

@section('title','Supervisores')

@section('nav-top')
  @component('components.navbarsearch',[
      'action'    =>  'FuerzaTareaController@searchSupervisoresProduccion',
  ])
  @endcomponent()
@endsection
@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Supervisores' => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
    @if (!count($supervisores))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
      @else
        <div class="row">
            @foreach ($supervisores as $supervisor)
                @component('components.productividad.cardSupervisor', ['supervisor'=>$supervisor] )
                @endcomponent()
            @endforeach
        </div>
        <div class="card-footer text-center">
            {{ $supervisores->links() }}
        </div>
    @endif

  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
