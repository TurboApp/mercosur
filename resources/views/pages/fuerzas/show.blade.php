@extends('layouts.master')

@section('title', 'Operario: '.$fuerza->nombre)

@section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@search',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Fuerza de tarea' => 'fuerza-tarea', $fuerza->nombre => '' ],
    ])
    @endcomponent()
@endsection

@section('content')
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col-xs-4">
                <div class="text-center">
                  <div  style="max-width:170px; max-height:170px;">
                    <img src="{{asset('img/fuerza-'.str_replace(" ","-",$fuerza->categoria).'.png')}}" alt="..." class="img img-responsive" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                  </div>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="card-title" style="margin-bottom:0px;padding-bottom:0;">{{$fuerza->nombre}}</h3>
                    <h4 class=" text-gray" style="margin:0;">{{$fuerza->categoria}}</h4>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <label class="control-label">Contacto</label>
                    <p class="category text-muted">{{$fuerza->contacto}}</p>
                    <label class="control-label">Descripcion</label>
                    <p class="category text-muted">{{$fuerza->descripcion}}</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-2">
                <a href="/fuerzas/{{$fuerza->id}}/editar"><button type="button" rel="tooltip" class="btn btn-success btn-round btn-just-icon"><i class="fa fa-pencil fa-1x" aria-hidden="true"></i></button></a>
                <a href="#" class="delete-fuerza">
                  <button type="button" class="btn btn-danger btn-round btn-just-icon"><i class="fa fa-trash-o fa-1x" aria-hidden="true"></i></button>
                </a>
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
