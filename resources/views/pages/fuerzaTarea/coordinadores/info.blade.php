@extends('layouts.master')

@section('title', 'Usuario: '.str_limit($usuario->nombre, 24) )

@section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@searchCoordinadoresProduccion',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
  @component('components.breadcrump',[
      'navigation'    =>  [ 'Inicio' => 'inicio', 'Coordinadores'=>'coordinadores' , $usuario->nombre  => '' ],
  ])
  @endcomponent()
@endsection

@section('content')
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-content">
            <div class="col-md-12 visible-sm-* visible-xs-* hidden-md hidden-lg ">
                <h3 class="card-title" style="margin:0;padding:0;">{{$usuario->nombre}} {{$usuario->apellido}}</h3>
                <h4 class="category text-gray" style="margin:0;padding:0;">{{$usuario->user}}</h4>
                <hr style="margin:0;">
            </div>
            <div class="col-md-4">
              <div class="card-profile text-center" style="margin-top:100px;">
                <div class="card-avatar"  style="max-width:170px; max-height:170px;">
                  @if ($usuario->url_avatar)
                    <img class="img img-responsive img-circle z-depth-3"  src="{{Storage::url($usuario->url_avatar)}}" alt=""  onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                  @else
                    <img src="{{asset('img/'.str_replace(" ","-",$usuario->perfil->perfil).'.png')}}" alt="..." class="img img-responsive img-circle z-depth-3" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                  @endif
                </div>
              </div>
              <div class="row text-center">
                <h6 class="category text-gray">{{$usuario->perfil->descripcion}}</h6>
              </div>
              <div class="row text-center">
                <h4 class="card-title">
                  @foreach ($usuario->puestos as $puesto)
                    {{$puesto->puesto}}
                  @endforeach
                </h4>
              </div>
            </div>{{--card imagen--}}
            <div class="col-md-6">
              <div class="hidden-sm hidden-xs ">
                <h3 class="card-title" style="margin:0;padding:0;">{{$usuario->nombre}} {{$usuario->apellido}}</h3>
                <h4 class="category text-gray" style="margin:0;padding:0;">{{$usuario->user}}</h4>
                <hr style="margin:0;">
              </div>
              <div class="form-group" style="margin:0;">
                  <label class="control-label">Equipo</label>
                  <p class="text-muted" style="font-weight:500;">
                    {{$usuario->equipo->nombre}}
                  </p>
                </div>
              <div class="form-group" style="margin:0;">
                <label class="control-label">Email</label>
                <p class="text-muted" style="font-weight:500;">
                  {{$usuario->email}}
                </p>
              </div>
              <div class="form-group" style="margin:0;">
                <label class="control-label">Telefono</label>
                <p class="text-muted" style="font-weight:500;">
                  {{$usuario->telefono}}
                </p>
              </div>
              <div class="form-group" style="margin:0;">
                <label class="control-label">Celular</label>
                  <p class="text-muted" style="font-weight:500;">
                    {{$usuario->celular}}
                  </p>
              </div>
              <div class="form-group" style="margin:0;">
                <label class="control-label">Dirección</label>
                <p class="text-muted" style="font-weight:500;"> 
                  {{$usuario->direccion}}
                </p>
              </div>
            </div>{{--datos usuario--}}
          </div>
        </div>
      </div>
    </div>
  @endsection
  @push('scripts')
    @include('layouts.partials.notify')
    @include("layouts.partials.confirmDelete", ["url" => "/usuarios/$usuario->id/destroy", "class" => "delete-usuario", "redirect" => "/usuarios" ])
  @endpush
