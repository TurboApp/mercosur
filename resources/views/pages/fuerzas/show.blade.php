@extends('layouts.master')
@section('title','Operario')
  @section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
    ])
    @endcomponent()
  @endsection
  @section('content')
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="card">
          <div class="card-header card-header-icon" data-background-color="">
            <i class="fa fa-user fa-lg" aria-hidden="true"></i>
          </div>
          <div class="card-content">
            <h4 class="card-title">Datos del Operario</h4>
            <div class="row">
              <div class="col-md-4">
                <div class="card-profile text-center" style="margin-top:100px;">
                  <div class="card-avatar" style="max-width:170px; max-height:170px;">
                    <img src="{{asset('img/fuerza-'.str_replace(" ","-",$fuerza->categoria).'.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                  </div>
                </div><br>
                <div class="row text-center">
                  <h3 class="card-title text-gray">{{$fuerza->categoria}}</h3>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-9">
                    <h3 class="card-title" style="margin-bottom:0px">{{$fuerza->nombre}} {{$fuerza->apellido}}</h3>
                    <small class="category">{{$fuerza->direccion}}</small>
                  </div>
                  <div class="col-md-3">
                    <a href="/fuerzas/{{$fuerza->id}}/editar"><button type="button" rel="tooltip" class="btn btn-success btn-round btn-just-icon"><i class="fa fa-pencil fa-1x" aria-hidden="true"></i></button></a>
                    <a href="#" class="delete-fuerza">
                      <button type="button" class="btn btn-danger btn-round btn-just-icon"><i class="fa fa-trash-o fa-1x" aria-hidden="true"></i></button>
                    </a>
                  </div>
                </div>
                <hr>
                <div class="form-horizontal">
                  <div class="row">
                    <label class="col-md-2 label-on-left">Telefono</label>
                    <div class="col-md-9">
                      <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" value="{{$fuerza->telefono}}" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-md-2 label-on-left">Celular</label>
                    <div class="col-md-9">
                      <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" value="{{$fuerza->celular}}" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
    @include("layouts.partials.confirmDelete", ["url" => "/fuerzas/$fuerza->id/destroy", "class" => "delete-fuerza", "redirect" => "/fuerzas" ])
  @endpush
