@extends('layouts.master')
@section('title','Clientes')
@section('nav-top')
    @component('components.navbarsearch',[
        'action'    => 'ClienteController@search',
    ])
    @endcomponent()
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        @component('components.displaydatatable',[
                'datos' => $clientes,
                'name'  => 'Cliente',
                'url'   => 'clientes',
                'icon'  => 'group',
                'title' => 'Todos los clientes'
            ])
        @endcomponent()
        
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')
    @include('layouts.partials.notify')
@endpush