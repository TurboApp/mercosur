@extends('layouts.master')

@section('title','Resultados de la busqueda: '.str_limit($request->s, 24))

@section('nav-top')
     <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/agentes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        <li>
            <a href="/agentes" title="Ir a clientes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a agentes</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @component('components.navbarsearch',[
        'action'=>'AgenteController@search',
        'value' =>$request->s
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Agentes' => 'agentes', 'Busqueda: '.$request->s => ''],
    ])
    @endcomponent()
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
       
        @component('components.displaydatatable',[
            'datos' => $agentes,
            'name' => 'Agente',
            'urlTo'   => 'agentes',
            'ajax'  => '/API/agentes/'.$request->s,
            'filter' => false
        ])
        @endcomponent()
        
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')

@endpush