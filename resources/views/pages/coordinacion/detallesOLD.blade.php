@extends('pages.coordinacion.master')

@section('content-page')
   

   @if($servicio->supervisor_id == null)
{{--      
    @component( 'components.coordinacion.search_supervisor' , [ 'servicio' => $servicio ] )
    @endcomponent()  --}}

   @else

    
    {{--  Supervisor encargado  --}}
    <div class="row">
        
        <div class="col-md-12">
            <div class="media" >
                <div class="media-left" >
                    
                    @if ($servicio->supervisor->url_avatar)
                        <img class="img img-responsive img-circle "  src="{{Storage::url($servicio->supervisor->url_avatar)}}"   onerror='this.onerror = null; this.src="/img/user-default.jpg"' style="max-width:100px;">
                    @else
                        <img src="{{asset('img/supervisor.png')}}"  class="img img-responsive img-circle " onerror='this.onerror = null; this.src="/img/user-default.jpg"' style="max-width:100px;">
                    @endif
                </div>
                <div class="media-body">
                    <h3 class="media-heading title" style="margin-top:.8em;">{{$servicio->supervisor->nombre}}</h3>
                    <span class="text-uppercase text-muted">{{ $servicio->supervisor->user }}</span>
                </div>
            </div>
        </div>
    </div>
    
    
    {{--  Avance de tareas  --}}
    <div div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title">Actividad</h2>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            @for($i=0; $i<10; $i++)
                <div class="panel panel-default">
                    <div class="panel-header">
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                
                                
                                <button class="btn btn-primary btn-just-icon btn-round">
                                    {{--  <i class="fa fa-plus" aria-hidden="true"></i>  --}}
                                    <i class="material-icons">build</i>
                                </button>
                            </div>
                            <div class="col-xs-10 col-md-11">
                                <div class="row">
                                    <div class="col-xs-10">
                                        <h4>  {{$i+1}} tarea   </h4>
                                    </div>
                                    <div class="col-xs-2 text-right">
                                        <h4>60%</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="progress progress-line-primary">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            @endfor
            
        </div>
    </div>

   @endif 
        



   


        
@endsection


  