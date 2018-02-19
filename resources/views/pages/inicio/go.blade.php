@extends('layouts.master')

@section('title','Inicio')

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio'],
    ])
    @endcomponent()
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-muted">Hoy <small><a href="/servicios/">ver servicios</a></small></h2>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header descarga" data-background-color="orange">
                        <i class="material-icons">arrow_downward</i>
                </div>
                <div class="card-content">
                    <p class="category">Descargas</p>
                    <h3 class="card-title">{{ $resumen->descargasToday }}</h3>
                </div>
                
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header carga" data-background-color="orange">
                    <i class="material-icons">arrow_upward</i>
                </div>
                <div class="card-content">
                    <p class="category">Cargas</p>
                    <h3 class="card-title">{{ $resumen->cargasToday }}</h3>
                </div>
                
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header trasbordo" data-background-color="orange">
                    <i class="material-icons">compare_arrows</i>
                </div>
                <div class="card-content">
                    <p class="category">Trasbordos</p>
                    <h3 class="card-title">{{ $resumen->trasbordosToday }}</h3>
                </div>
                
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="rose">
                    <i class="material-icons">done</i>
                </div>
                <div class="card-content">
                    <p class="category">Total</p>
                    <h3 class="card-title">{{  $resumen->totalToday }}</h3>
                </div>
                
            </div>
        </div>   
            
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-muted">Esta semana</h2>
        </div>
        <div class="col-md-4">
                <div class="card card-chart" >
                    <div class="card-header descarga" data-background-color="rose" style="border-radius:6px;">
                        <div id="semanaDescargaChart" class="ct-chart">
                            
                        </div>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Descargas</h4>
                        <p class="category">{{$resumen->totalSemanaDescarga}} durante la semana.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header carga" data-background-color="orange" style="border-radius:6px;">
                        <div id="semanaCargaChart" class="ct-chart">
                            
                        </div>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Cargas</h4>
                        <p class="category">{{$resumen->totalSemanaCarga}} durante la semana.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header trasbordo" data-background-color="blue" style="border-radius:6px;">
                        <div id="semanaTrasbordoChart" class="ct-chart">
                            
                        </div>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Trasbordos</h4>
                        <p class="category">{{$resumen->totalSemanaTrasbordo}} durante la semana.</p>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-muted">Tops</h2>
        </div>
        <div class="col-md-4">
            <div class="card" style="border-radius:6px;">
                <div class="card-content content-warning" style="border-radius:6px;">
                    <h6 class="category-social"><i class="fa fa-user-o" aria-hidden="true"></i> Clientes</h6>
                    <p class="card-description">
                            <table class="table">
                                    <tbody>
                                        @foreach ($resumen->topClientes as $index => $cliente)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$cliente->nombre_corto}}</td>
                                                <td class="text-right">{{count($cliente->servicio)}}</td>
                                            </tr>                                            
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                    </p>
                    <div class="card-stats justify-content-center text-center">
                        <a href="/clientes/" class="btn btn-white btn-round">
                            Clientes
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="border-radius:6px;">
                <div class="card-content content-warning" style="border-radius:6px;">
                    <h6 class="category-social"><i class="fa fa-truck" aria-hidden="true"></i> Transportes</h6>
                    <p class="card-description">
                            <table class="table">
                                    <tbody>
                                        @foreach ($resumen->topTransportes as $index => $transporte)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$transporte->nombre_corto}}</td>
                                                <td class="text-right">{{count($transporte->ordenservicios)}}</td>
                                            </tr>                                            
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                    </p>
                    <div class="card-stats justify-content-center text-center">
                        <a href="/transportes/" class="btn btn-white btn-round">
                            Transportes
                        </a>
                    </div>
                        
                        
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="border-radius:6px;">
                <div class="card-content content-warning" style="border-radius:6px;">
                    <h6 class="category-social"><i class="fa fa-id-card-o" aria-hidden="true"></i> Agentes</h6>
                    <p class="card-description">
                            <table class="table">
                                    <tbody>
                                        @foreach ($resumen->topAgentes as $agente)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$agente->nombre_corto}}</td>
                                                <td class="text-right">{{count($agente->servicio)}}</td>
                                            </tr>                                            
                                        @endforeach
                                    </tbody>
                            </table>
                    </p>
                    <div class="card-stats justify-content-center text-center">
                        <a href="/agentes/" class="btn btn-white btn-round">
                            Agentes
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card card-profile">
                <div class="card-avatar">
                    <a href="/operarios-produccion/{{$resumen->topMontacarguista->first()->id}}" title="Ver información">
                        <img src="{{asset('img/fuerza-montacarguista.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    </a>
                </div>
                <div class="card-content text-center">
                    <h4 class="card-title text-truncate" title="Ver información de {{$resumen->topMontacarguista->first()->nombre}} ">
                        <a href="/operarios-producion/{{$resumen->topMontacarguista->first()->id}}" class="">
                            {{$resumen->topMontacarguista->first()->nombre}}
                        </a>
                    </h4>
                    <h6 class="category text-muted text-truncate">{{$resumen->topMontacarguista->first()->categoria}}</h6>
                    <p class="lead">
                        {{ count($resumen->topMontacarguista->first()->produccion) }} 
                        @if (count($resumen->topMontacarguista->first()->produccion) == 1)
                            Maniobra
                        @else
                            Maniobras                            
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-profile">
                <div class="card-avatar">
                    <a href="/operarios-produccion/{{$resumen->topMontacarga->first()->id}}" title="Ver información">
                        <img src="{{asset('img/fuerza-montacarga.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    </a>
                </div>
                <div class="card-content text-center">
                    <h4 class="card-title text-truncate" title="Ver información de {{$resumen->topMontacarga->first()->nombre}} ">
                        <a href="/operarios-producion/{{$resumen->topMontacarga->first()->id}}" class="">
                            {{$resumen->topMontacarga->first()->nombre}}
                        </a>
                    </h4>
                    <h6 class="category text-muted text-truncate">{{$resumen->topMontacarga->first()->categoria}}</h6>
                    <p class="lead">
                        {{ count($resumen->topMontacarga->first()->produccion) }} 
                        @if (count($resumen->topMontacarga->first()->produccion) == 1)
                            Maniobra
                        @else
                            Maniobras                            
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-profile ">
                <div class="card-avatar">
                    <a href="/operarios-produccion/{{$resumen->topAuxiliar->first()->id}}" title="Ver información">
                        <img src="{{asset('img/fuerza-Auxiliar-de-Patio.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    </a>
                </div>
                <div class="card-content text-center">
                    <h4 class="card-title text-truncate" title="Ver información de {{$resumen->topAuxiliar->first()->nombre}} ">
                        <a href="/operarios-producion/{{$resumen->topAuxiliar->first()->id}}" class="">
                            {{$resumen->topAuxiliar->first()->nombre}}
                        </a>
                    </h4>
                    <h6 class="category text-muted text-truncate">{{$resumen->topAuxiliar->first()->categoria}}</h6>
                    <p class="lead">
                        {{ count($resumen->topAuxiliar->first()->produccion) }} 
                        @if (count($resumen->topAuxiliar->first()->produccion) == 1)
                            Maniobra
                        @else
                            Maniobras                            
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <!-- SUPERVISOR -->
        <div class="col-md-3 col-sm-6">
            <div class="card card-profile ">
                <div class="card-avatar">
                    <a href="/supervisores/{{$resumen->topSupervisor->first()->id}}" title="Ver información">
                        <img src="{{asset('img/supervisor.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                    </a>
                </div>
                <div class="card-content text-center">
                    <h4 class="card-title text-truncate" title="Ver información de {{$resumen->topSupervisor->first()->nombre}} ">
                        <a href="/supervisores/{{$resumen->topSupervisor->first()->id}}" class="">
                            {{$resumen->topSupervisor->first()->nombre}}
                        </a>
                    </h4>
                    <h6 class="category text-muted text-truncate">{{$resumen->topSupervisor->first()->user}}</h6>
                    <p class="lead">
                        {{ count($resumen->topSupervisor->first()->supervisor) }} 
                        @if (count($resumen->topSupervisor->first()->supervisor) == 1)
                            Maniobra
                        @else
                            Maniobras                            
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
            {{--  Metricas por semana --}}
            //Descargas
            new Chartist.Line('#semanaDescargaChart', {
                labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                series: [
                    [
                        {{ $resumen->semana[0]['descargas'] }}, 
                        {{ $resumen->semana[1]['descargas'] }}, 
                        {{ $resumen->semana[2]['descargas'] }}, 
                        {{ $resumen->semana[3]['descargas'] }}, 
                        {{ $resumen->semana[4]['descargas'] }}, 
                        {{ $resumen->semana[5]['descargas'] }}
                    ]
                ]
              }, {
                fullWidth: true,
                chartPadding: {
                  right: 40
                }
              });
    
            new Chartist.Line('#semanaCargaChart', {
                labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                series: [
                    [
                        {{ $resumen->semana[0]['cargas'] }}, 
                        {{ $resumen->semana[1]['cargas'] }}, 
                        {{ $resumen->semana[2]['cargas'] }}, 
                        {{ $resumen->semana[3]['cargas'] }}, 
                        {{ $resumen->semana[4]['cargas'] }}, 
                        {{ $resumen->semana[5]['cargas'] }}
                    ]
                ]
              }, {
                fullWidth: true,
                chartPadding: {
                  right: 40
                }
              });
            new Chartist.Line('#semanaTrasbordoChart', {
                labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                series: [
                    [
                        {{ $resumen->semana[0]['trasbordos'] }}, 
                        {{ $resumen->semana[1]['trasbordos'] }}, 
                        {{ $resumen->semana[2]['trasbordos'] }}, 
                        {{ $resumen->semana[3]['trasbordos'] }}, 
                        {{ $resumen->semana[4]['trasbordos'] }}, 
                        {{ $resumen->semana[5]['trasbordos'] }}
                    ]
                ]
              }, {
                fullWidth: true,
                chartPadding: {
                  right: 40
                }
              });
    </script>
@endpush