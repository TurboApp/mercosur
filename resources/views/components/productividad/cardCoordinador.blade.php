<div class="col-md-3 col-sm-6">
    <div class="card card-profile card-plain">
        <div class="card-avatar">
            <img src="{{asset('img/coordinador.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
        </div>
        <div class="card-content text-center">
            <h4 class="card-title text-truncate" title="Ver información de {{$coordinador->nombre}} ">
                {{$coordinador->nombre}}
            </h4>
            <h6 class="category text-muted text-truncate">{{$coordinador->user}}</h6>
        </div>
        <div class="text-center">
            <a href="/coordinadores/{{$coordinador->id}}"  class="btn btn-info btn-round btn-just-icon ">
                <i class="fa fa-info" aria-hidden="true"></i>
            </a>
            <a href="/coordinadores/{{$coordinador->id}}/metricas" class="btn btn-success btn-round btn-just-icon">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>