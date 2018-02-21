<div class="col-md-3 col-sm-6">
    <div class="card card-profile card-plain">
        <div class="card-avatar">
            <img src="{{asset('img/supervisor.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
        </div>
        <div class="card-content text-center">
            <h4 class="card-title text-truncate" title="Ver información de {{$supervisor->nombre}} ">
                {{$supervisor->nombre}}
            </h4>
            <h6 class="category text-muted text-truncate">{{$supervisor->user}}</h6>
        </div>
        <div class="text-center">
            <a href="/supervisores/{{$supervisor->id}}"  class="btn btn-info btn-round btn-just-icon ">
                <i class="fa fa-info" aria-hidden="true"></i>
            </a>
            <a href="/supervisores/{{$supervisor->id}}/metricas" class="btn btn-success btn-round btn-just-icon">
                <i class="fa fa-line-chart" aria-hidden="true"></i>

            </a>
        </div>
    </div>
</div>