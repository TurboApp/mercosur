@extends('layouts.master')
@section('title','Lineas de transportes')
@section('nav-top')
    @if(auth()->user()->perfil->perfil == 'admin')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/transportes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @endif
    @component('components.navbarsearch',[
                'action'  =>  'LineasTransporteController@search',
            ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Lineas de transportes' => '' ],
    ])
    @endcomponent()
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
          
            @component('components.displaydatatable',[
                'datos' => $transportes,
                'name'  => 'Transporte',
                'urlTo'   => 'transportes',
                'ajax'  => '/API/transportes/',
                'icon'  => 'fa-truck',
                'title' => 'Todos los transportes'
            ])
            @endcomponent()

        </div><!-- ./col-md-12 -->

    </div><!-- ./row -->
@endsection
