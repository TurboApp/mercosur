@extends('layouts.master')
@section('title','Detalles de maniobra')
@section('nav-top')

@endsection
@section('content')

     {{--  Error si no esta asignado un supervisor  --}}
    @if($servicio->supervisor_id == null)
        @component('components.maniobra.if_supervisor')
        @endcomponent()
    @endif;    
                    
    
    <div class="row">
        <div class="col-md-6">
            <h3>{{$servicio->servicio->tipo}}</h3>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <span class="lead">
                    Fecha del servicio 
                    {{ ucfirst(Date::instance( $servicio->fecha_servicio)->format('j \\d\\e F \\d\\e Y') ) }}
                </span>
            </div>
        </div>
    </div>



    {{--  NAV  --}}
    @component('components.maniobra.nav', ['id' => $servicio->id ])
    @endcomponent()
    
   
    <div class="row">
        <div  class="col-md-12">
            {{--  <card class="grey lighten-4">  --}}
            <card class=" light-green accent-3">
            
                <template>
                    {{--  <span class="text-muted">Cliente</span>  --}}
                    <h1 class="title white-text">{{$servicio->servicio->cliente->nombre}}</h1>
                </template>
            </card>
        </div>
    </div>



    @yield('content-page')
    
    {{--  @component('components.maniobra.search_supervisor')
    @endcomponent()  --}}

        
@endsection
@push('scripts')

    @include('layouts.partials.errors')
    
@endpush