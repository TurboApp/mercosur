<div class="col-md-4 col-sm-6">
    <div class="info text-center">
        <div class="icon">
            @if ($usuario->url_avatar)
                <img class="img img-responsive img-circle z-depth-3"  src="{{Storage::url($usuario->url_avatar)}}" alt=""  onerror='this.onerror = null; this.src="/img/user-default.jpg"' style="max-width:128px;margin:0 auto;">
            @else
                <img src="{{asset('img/'.str_replace(" ","-",$usuario->perfil->perfil).'.png')}}" alt="..." class="img img-responsive img-circle z-depth-3" onerror='this.onerror = null; this.src="/img/user-default.jpg"' style="max-width:128px;margin:0 auto;">
            @endif
        </div>
        <h4 class="info-title text-truncate" title="{{$usuario->nombre .' '.$usuario->apellido}}">
            {{$usuario->nombre}} {{$usuario->apellido}}
        </h4>
        <p class="text-muted text-uppercase">
            @if (count($usuario->puestos))
                @foreach ($usuario->puestos as $puesto)
                    {{$puesto->puesto}}
                @endforeach
            @else
                <span class="text-danger">Sin puesto</span>
            @endif
        </p>
        <h6 class="category text-muted text-truncate" title="Usuario: {{$usuario->user}}">
            <i class="fa fa-user-circle-o fa-1 text-muted" aria-hidden="true"></i> {{$usuario->user}}
        </h6>
        @if(!isset($edit))
            <a href="/usuarios/{{$usuario->id}}">
                <button type="button" class="btn btn-primary btn-round btn-sm">
                <i class="fa fa-info-circle" aria-hidden="true"></i> Información</button>
            </a>
        @else
            <a href="/usuarios/{{$usuario->id}}"><button type="button" class="btn btn-primary btn-simple btn-just-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></button> </a>
            <a href="/usuarios/{{$usuario->id}}/editar"><button type="button" class="btn btn-success btn-simple btn-just-icon"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
        @endif
    </div>
</div>