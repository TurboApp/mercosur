@extends('layouts.master')
@section('title','Lista de Transportes')
@section('nav-top')
    @component('components.navbarsearch',[
                'action'  =>  'LineasTransporteController@search',
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
