@extends('layouts.master')
@section('title','Clientes')
@section('nav-top')
    @if(auth()->user()->perfil->perfil == 'admin')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/clientes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">person_add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @endif
    @component('components.navbarsearch',[
        'action'    => 'ClienteController@search',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Clientes' => 'clientes' ],
    ])
    @endcomponent()
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        @component('components.displaydatatable',[
                'datos' => $clientes,
                'name'  => 'Cliente',
                'urlTo' => 'clientes',
                'ajax'  => '/API/clientes/',
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
