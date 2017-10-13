@extends('layouts.master')
@section('title','Agentes')
@section('nav-top')
    @component('components.navbarsearch',[
        'action' => 'AgenteController@search'
    ])
    @endcomponent()
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        
        @component('components.displaydatatable',[
            'datos' =>  $agentes,
            'name'  =>  'Agente',
            'url'   =>  'agentes',
            'icon'  =>  'fa-id-card-o',
            'title' =>  'Todos los agentes'
        ])
        @endcomponent()   
        
       

    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')
    @include('layouts.partials.errors')
@endpush
