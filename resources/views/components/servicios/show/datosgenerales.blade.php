<card type="header-icon" icon="fa-info">
    <template>
        <template slot="title">Datos generales</template>
        <div class="row ">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="form-group">                       
                        <div class="col-md-6">
                            <select class="selectpicker" data-style="btn btn-primary btn-round" disabled>
                                <option selected>{{$data->agente->nombre_corto}}</option>
                            </select>
                        </div>
                    </div>
                            
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" title="Fecha">
                                <i class="fa fa-calendar "></i> Fecha
                            </span>
                            <input type="text" value="{{$data->fecha_recepcion}}" class="form-control" disabled>
                            <span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i> Hora
                            </span>
                            <input type="text" value="{{$data->hora_recepcion}}" class="form-control" disabled>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div><!-- ./form-horizontal  -->
            </div><!-- ./col -->
            
        </div><!-- ./row -->
        <hr style="border:0;">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="form-group">
                        <label for="cliente" class="col-md-2 control-label">Cliente</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $data->cliente->nombre_corto }} - {{$data->cliente->nombre}}" disabled>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">RFC</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $data->cliente->rfc }}" disabled>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- cliente input hidden -->
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $data->destino }}" disabled>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">País</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{$data->destino_pais}}" disabled>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /row-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group label-floating">
                    <label for="observaciones" class="control-label">Observaciones</label>
                    <textarea class="form-control" disabled>{{ $data->observaciones }}</textarea>
                </div>
            </div>
        </div>
    </template>
</card>