@extends('layouts.master')

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => 'servicios',  $servicio->tipo => '' ],
    ])
    @endcomponent()
@endsection

@section('title', $servicio->tipo )


@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/servicios/nuevo"  title="Nuevo servicio">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Nuevo servicio</p>
            </a>
        </li>
        <li>
            <a href="/servicios" title="Ir a servicios">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a servicios</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <card class="{{$servicio->tipo}}">
            <template>
                <h1 class="title white-text">{{$servicio->tipo}}</h1>
                <p>
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{$servicio->autor->nombre .' '.$servicio->autor->apellido}} -
                    <i class="fa fa-calendar" aria-hidden="true"></i> {{Date::instance($servicio->created_at)->format('l j \\d\\e F Y ')}} -
                    <i class="fa fa-clock-o" aria-hidden="true"></i> {{Date::instance($servicio->created_at)->format('h:i:s A')}}
                </p>
                
                
                @if($servicio->parent)
                    <a href="/servicios/{{$servicio->parent->id}}" class="btn {{$servicio->parent->tipo}}">
                        {{$servicio->parent->tipo}} (Servicio N. {{$servicio->parent->numero_servicio}}) &nbsp;
                        <i class="material-icons">call_made</i>
                    </a>
                @elseif($servicio->children)
                    @foreach($servicio->children as $child)
                        <a href="/servicios/{{$child->id}}" class="btn {{$child->tipo}}">
                            {{$child->tipo}} (Servicio N. {{$child->numero_servicio}}) &nbsp;
                            <i class="material-icons">call_made</i>
                        </a>
                    @endforeach
                @endif
               
            </template>
        </card>
    </div> 

    <div class="row">   
    
        <h3 class="title">Datos Generales</h3>
        
        @component('components.servicios.show.datosgenerales',[
            'data'  =>  $servicio
        ])
        @endcomponent()
        

        <h3 class="title">Transportes</h3>
        
        @foreach($servicio->transportes as $transporte)
            @component('components.servicios.show.transportes',[
                'data' => $transporte
            ])
            @endcomponent() 
        @endforeach()

        <h3 class="title">Documentos</h3>
        
        @component('components.servicios.show.documentos',
            ['data' => $servicio->documentos ])
        @endcomponent 

        <h3 class="title">Archivos</h3>

        @component('components.servicios.show.archivos',
            ['data'  =>  $servicio->archivos])
        @endcomponent
        
    </div>
    <div class="row">
        @if($servicio->parent)
            <h3 class="title">Servicios relacionados</h3>
            <div class="col-md-4">
                <a href="/servicios/{{$servicio->parent->id}}">
                    <card class="{{$servicio->parent->tipo}}">
                    <template>
                        <div style="
                            width:100%;
                            height:100px;
                            background:url('/img/servicios-iconos/descarga-icon.png');
                            background-size:cover;
                            background-position:bottom center;
                            display:block;
                        "></div>
                       
                        <h2 class="white-text">{{$servicio->parent->tipo}}</h2>
                        <h5>Servicio N. {{$servicio->parent->numero_servicio}}</h5>
                        <ul class="list-unstyled">
                            <li>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{$servicio->parent->autor->nombre .' '.$servicio->parent->autor->apellido}}     
                            </li>
                            <li>
                                <i class="fa fa-calendar" aria-hidden="true"></i> {{Date::instance($servicio->parent->created_at)->format('d/m/Y')}} 
                            </li>
                        </ul>
                    </template>
                    </card>
                </a>
            </div>
        @elseif( count($servicio->children) )
            <h3 class="title">Servicios relacionados</h3>
            @foreach($servicio->children as $child)
                <div class="col-md-4">
                <a href="/servicios/{{$child->id}}">
                    <card class="{{$child->tipo}}">
                    <template>
                        <div style="
                            width:100%;
                            height:100px;
                            background:url('/img/servicios-iconos/carga-icon.png');
                            background-size:cover;
                            background-position:bottom center;
                            display:block;
                        "></div>
                       
                        <h2 class="white-text">{{$child->tipo}}</h2>
                        <h5>Servicio N. {{$child->numero_servicio}}</h5>
                        <ul class="list-unstyled">
                            <li>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{$child->autor->nombre .' '.$child->autor->apellido}}     
                            </li>
                            <li>
                                <i class="fa fa-calendar" aria-hidden="true"></i> {{Date::instance($child->created_at)->format('d/m/Y')}} 
                            </li>
                        </ul>
                    </template>
                    </card>
                </a>
            </div>
            @endforeach
        @endif

    </div>
</div>

@endsection
@push('scripts')

    @include('layouts.partials.notify')

    @include('layouts.partials.errors')
@endpush
