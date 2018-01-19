@extends('layouts.master')
@section('title','Agentes')
@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/agentes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @component('components.navbarsearch',[
        'action' => 'AgenteController@search'
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Agentes' => '' ],
    ])
    @endcomponent()
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        @component('components.displaydatatable',[
            'datos' =>  $agentes,
            'name'  =>  'Agente',
            'urlTo'   =>  'agentes',
            'ajax'  => '/API/agentes/',
            'icon'  =>  'fa-id-card-o',
            'title' =>  'Todos los agentes'

        ])
        @endcomponent()



    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')
    @include('layouts.partials.notify')
@endpush
