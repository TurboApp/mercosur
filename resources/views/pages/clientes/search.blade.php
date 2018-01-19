@extends('layouts.master')

@section('title','Resultados de la busqueda: '.str_limit($request->s, 24))

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/clientes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">person_add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        <li>
            <a href="/clientes" title="Ir a clientes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a clientes</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @component('components.navbarsearch',[
        'action'    =>  'ClienteController@search',
        'value'     =>  $request->s
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Clientes' => 'clientes', 'Busqueda: '.$request->s => ''],
    ])
    @endcomponent()
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        
        {{--  <p class="lead text-muted">
            <i class="fa fa-search" aria-hidden="true"></i> Resultados de la búsqueda ( 
                @if($request->s)
                    {{ $request->s }} 
                @else
                    ...    
                @endif
            )
        </p>  --}}
        
        @component('components.displaydatatable',[
            'datos' => $clientes,
            'name'  => 'Cliente',
            'urlTo' => 'clientes',
            'ajax'  => '/API/clientes/'.$request->s,
            'filter' => false
        ])
        @endcomponent()
       
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')

@endpush