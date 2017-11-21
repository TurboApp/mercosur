<card>
<template>
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-2 control-label">Recepción</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="{{ $data->fecha_recepcion->format('d/m/Y') }} - {{$data->hora_recepcion}}" disabled>
            </div>
        </div>

        <div class="form-group">                       
            <label class="col-md-2 control-label">Agente</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="{{$data->agente->nombre}}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-md-2 control-label">Cliente</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="{{ $data->cliente->nombre_corto }} - {{$data->cliente->nombre}} {{ $data->cliente->rfc }}" disabled>
            </div>
        </div>    
                

        <div class="form-group">
            <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="{{ $data->destino }} - {{$data->destino_pais}}" disabled>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 control-label">Observaciones</label>
            <div class="col-md-10">
                <textarea class="form-control" disabled>{{ $data->observaciones }}</textarea>
            </div>
        </div>
    </div>
</template>
</card>
