

   
   @if($servicio->supervisor_id == null)

    @component( 'components.maniobra.search_supervisor' , [ 'servicio' => $servicio ] )
    @endcomponent()

   @else

    
    {{--  Supervisor encargado  --}}
    <div class="row">
        
        <div class="col-md-8">
            <div class="media" >
                <div class="media-left" >
                    <img class="media-object img" src="{{Storage::url($servicio->supervisor->url_avatar)}}"  style="max-width:100px;">
                </div>
                <div class="media-body">
                    <h3 class="media-heading title" style="margin-top:.8em;">{{$servicio->supervisor->nombre}}</h3>
                    <span class="text-uppercase text-muted">{{ $servicio->supervisor->user }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-right">
            <h1 style="margin-bottom:0;padding-bottom:0;">00:00</h1>
            <span >Tiempo</span>
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
        

