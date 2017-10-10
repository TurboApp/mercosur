@extends('layouts.master')
@section('title','Busqueda de clientes')
@section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'ClienteController@search',
        'value'     =>  $request->s
    ])
    @endcomponent()
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        
        <p class="lead text-muted">
            <i class="fa fa-search" aria-hidden="true"></i> Resultados de la búsqueda ( 
                @if($request->s)
                    {{ $request->s }} 
                @else
                    ...    
                @endif
            )
        </p>
        
        @component('components.displaydatatable',[
            'datos' =>  $clientes,
            'name'  => 'Cliente',
            'url'   => 'clientes'
        ])
        @endcomponent()
       
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')

@endpush