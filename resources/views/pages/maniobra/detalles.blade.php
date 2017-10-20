@extends('pages.maniobra.master')

@section('content-page')
   
   @if($servicio->supervisor_id == null)

    @component( 'components.maniobra.search_supervisor' , [ 'servicio' => $servicio ] )
    @endcomponent()

   @else

    
    {{--  Supervisor encargado  --}}
    <div class="row">
        <div class="col-sm-2">
            <img class="img img-response" src="{{$servicio->supervisor->url_avatar}}" onerror='this.onerror = null; this.src="/img/user-default.jpg"' style="max-width:120px;margin:0 auto;">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="title" style="margin-bottom:0;padding-bottom:0;">{{$servicio->supervisor->nombre}}</h3>
                </div>
                <div class="col-xs-12">
                    <span>{{ $servicio->supervisor->user }}</span>
                </div>
            </div>
            
        </div>
    </div>

    {{--  Fuerza de tarea  --}}
    <div div class="row">
        <div class="col-md-12">
            <h3>Fuerza de tarea</h3>
        </div>
        <div class="col-md-12">
            <p>Lista de fuerza de traea</p>
        </div>
    </div>
   
    {{--  Avance de tareas  --}}
    <div div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-6">
                    <h3>Tareas</h3>
                </div>
                <div class="col-xs-6 text-right">
                    <h3>40%</h3>
                </div>

            </div>
        </div>
        <hr>
        <div class="col-md-12">
            @for($i=0; $i<10; $i++)
                <div class="row">
                    <div class="col-xs-6">
                        <h4>
                            <button class="btn btn-just-icon btn-simple btn-sm btn-default">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button> 
                            {{$i+1}} tarea 
                        </h4>
                    </div>
                    <div class="col-xs-6 text-right">
                        <h4>60%</h4>
                    </div>
                    <div class="col-xs-12">
                        <div class="progress progress-line-primary">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
            
        </div>
    </div>

   @endif 
        
@endsection

