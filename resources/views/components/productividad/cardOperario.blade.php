<div class="col-md-3 col-sm-6">
    <div class="card card-profile card-plain">
        <div class="card-avatar">
            <a href="/operarios-produccion/{{$operario->id}}" title="Ver información">
                <img 
                    src="{{asset('img/fuerza-'.str_replace(" ","-",$operario->categoria).'.png')}}" alt="..." 
                class="img img-responsive {{ !$operario->status ? 'img-gray' : '' }}" 
                    onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
            </a>
        </div>
        <div class="card-content text-center">
            <h4 class="card-title text-truncate" title="Ver información de {{$operario->nombre}} ">
                <a href="/operarios-produccion/{{$operario->id}}" class="">
                    {{$operario->nombre}}
                </a>
            </h4>
            <h6 class="category text-muted text-truncate">{{$operario->categoria}}</h6>
            @if($operario->status)
                <small>
                    <span class="label-success " style="width:10px; height:10px; border-radius:50%; display:inline-block;"></span>
                    ACTIVO
                </small>
            @else
                <small>
                    <span class="label-default para-asignar" style="width:10px; height:10px; border-radius:50%; display:inline-block;"></span>
                    INACTIVO
                </small>
            @endif
        </div>
    </div>
</div>