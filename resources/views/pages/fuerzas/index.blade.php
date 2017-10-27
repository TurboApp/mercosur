@extends('layouts.master')
@section('title','Operarios')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
    ])
    @endcomponent()
  @endsection
  @section('content')
    @if (!count($fuerzas))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
      @else
        <div class="row">
          @foreach ($fuerzas as $fuerza)
            <div class="col-md-3 col-sm-6">
              <div class="card card-profile card-plain">
                <div class="card-avatar">
                  <img src="{{asset('img/fuerza-'.str_replace(" ","-",$fuerza->categoria).'.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                </div>
                <div class="card-content text-center">
                  <h4 class="card-title text-truncate-ln2">{{$fuerza->nombre}} {{$fuerza->apellido}}</h4>
                  <h6 class="category text-muted">{{$fuerza->categoria}}</h6>
                  <div class="footer">
                    <a href="/fuerzas/{{$fuerza->id}}"><button type="button" class="btn btn-primary btn-simple btn-just-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                    <a href="/fuerzas/{{$fuerza->id}}/editar"><button type="button" class="btn btn-success btn-simple btn-just-icon"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="card-footer text-center">
            {{ $fuerzas->links() }}
        </div>
    @endif

  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
  @endpush
