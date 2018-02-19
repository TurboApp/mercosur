@extends('layouts.master')

@section('title','Operarios')

@section('nav-top')
  @component('components.navbarsearch',[
      'action'    =>  'FuerzaTareaController@searchOperariosProduccion',
  ])
  @endcomponent()
@endsection
@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Operarios' => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
    @if (!count($fuerzas))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
      @else
        <div class="row">
            @foreach ($fuerzas as $fuerza)
                @component('components.productividad.cardOperario', ['operario'=>$fuerza] )
                @endcomponent()
            @endforeach
        </div>
        <div class="card-footer text-center">
            {{ $fuerzas->links() }}
        </div>
    @endif

  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
