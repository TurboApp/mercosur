@extends('layouts.master')
@section('title','Añadir nuevo servicio')
@section('nav-top')

@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Nuevo Servicio</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p class="lead text-muted">
                Seleccione el servicio que desee realizar
            </p>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-3 col-xs-6">
            <a href="/trafico/nuevo/servicio/Descarga" class="btn btn-bg btn-block btn-default Descarga tbn-service">
                <img src="/img/servicios-iconos/descarga-icon.png" class="img img-responsive" alt="" style="margin:0 auto;">
                <h4>Descarga</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="/trafico/almacen/" class="btn btn-bg btn-block btn-defult Carga tbn-service">
                <img src="/img/servicios-iconos/carga-icon.png" class="img img-responsive" alt="" style="margin:0 auto;">
                <h4>Carga</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="/trafico/nuevo/servicio/Trasbordo" class="btn btn-bg btn-block btn-defult Trasbordo tbn-service">
            <img src="/img/servicios-iconos/trasbordo-icon.png" class="img img-responsive" alt="" style="margin:0 auto;">
                <h4>Trasbordo</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="#" class="btn btn-bg btn-block btn-default deep-purple deep-purple tbn-service">
            <img src="/img/servicios-iconos/otros-servicios-icon.png" class="img img-responsive" alt="" style="margin:0 auto;">
                <h4>Otros servicios</h4>
            </a>
        </div>
    </div>
    
    
   
    
</div><!-- ./container-fluid -->


@endsection
@push('scripts')
<script>
    (function(){
        let btnService = document.getElementsByClassName('tbn-service');
        let pathImage='';
        for (var i = 0; i < btnService.length; i++) {
            btnService[i].addEventListener("mouseover",function(){
                pathImage=this.querySelector('img').getAttribute('src');
                pathImage=pathImage.replace('icon.png','icon-on.png');
                this.querySelector('img').setAttribute('src', pathImage);
            });
            btnService[i].addEventListener("mouseout",function(){
                pathImage=this.querySelector('img').getAttribute('src');
                pathImage=pathImage.replace('icon-on.png','icon.png');
                this.querySelector('img').setAttribute('src', pathImage);
            });
        }
       


    })();
</script>
@endpush
