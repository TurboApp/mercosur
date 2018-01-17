@extends('layouts.master')
@section('title','Notificaciones')
  @section('nav-top')

  @endsection
  @section('content')
    @foreach ($usuarios as $usuario)
      <div class="row">
        <div class="col-md-7">
          <h3>{{$usuario->nombre}}</h3>
          <h3>{{$usuario->email}}</h3>
        </div>
        <div class="col-md-3">
          <a href="/pdf/{{$usuario->id}}/1" target="_blank"><button type="button" rel="tooltip" class="btn btn-warning">PDF</button></a>
          <a href="/pdf/{{$usuario->id}}/2"><button type="button" rel="tooltip" class="btn btn-primary">Decargar PDF</button></a>
          <a href="/pdf/{{$usuario->id}}/3" target="_blank"><button type="button" rel="tooltip" class="btn btn-warning">Imprimir</button></a>
        </div>
      </div>
    @endforeach
  @endsection
