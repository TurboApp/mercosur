<template>
<div class="form-horizontal">
    <legend>{{legend}}</legend>
    <div class="row">
        <label class="col-md-1 col-sm-12 label-on-left">Operador</label>
        <div class="col-md-11 col-sm-12">
            <div class="form-group ">
                <input type="text" class="form-control" ref="operador" :value="value.operador"  @input="update" >
                <span class="help-block">Ingrese el nombre completo del operador del vehiculo</span>
            </div>
        </div>
    </div><!-- ./row -->
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <label class="col-md-2 label-on-left">Transporte</label>
                <div class="col-md-10">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label"></label>
                        <input type="text" class="form-control" ref="lineatrasporte" :value="value.lineaTrasporte" @input="update" required>
                        <span class="help-block">Ingrese el nombre de la linea de Transporte</span>
                        <span class="material-input"></span>
                    </div>
                </div><!-- ./col-md-7 -->
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <label class="col-md-4 label-on-left">N° de Talón</label>
                <div class="col-md-8">
                    <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" ref="talon" :value="value.talon" @input="update" required>
                        <span class="help-block">Numero de talón</span>
                    </div>
                </div><!-- ./col-md-8 -->
            </div><!-- ./row -->
        </div><!-- ./col-md-4 --> 
        <div class="col-md-2 col-sm-12">
            <div class="row">
                <label class="col-md-4 label-on-left">Cantidad</label>
                <div class="col-md-8">
                    <div class="form-group label-floating is-empty">
                        <input type="number" class="form-control"  min="1" ref="cantidad" :value="value.cantidad" @input="update" required>
                    </div>
                </div><!-- ./col-md-8 -->
            </div><!-- ./row -->
        </div><!-- ./col-md-3 -->
    </div><!-- ./row -->
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <label class="col-md-3 label-on-left">Marca</label>
                <div class="col-md-9">
                    <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control get-marca-vehiculo" ref="marca" :value="value.marca" @input="update">
                        <span class="help-block">Marca del vehiculo</span>
                    </div>
                </div><!-- ./col-md-7 -->
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <label class="col-md-4 label-on-left">Placas Tractor</label>
                <div class="col-md-8">
                    <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" ref="placastractor" :value="value.placasTractor" @input="update" required>
                        <span class="help-block">Ingrese Placas Tractor</span>
                    </div>
                </div><!-- ./col-md-8 -->
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <label class="col-md-4 label-on-left">Placas Caja</label>
                <div class="col-md-8">
                    <div class="form-group label-floating is-empty">
                        <input type="text" class="form-control" ref="placascaja" :value="value.placasCaja" @input="update" required>
                        <span class="help-block">Ingrese Placas de Caja</span>
                    </div>
                </div><!-- ./col-md-8 -->
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
    </div><!-- ./row -->
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <label class="col-md-2 label-on-left">Unidad</label>
                <div class="col-md-10 col-sm-4">
                    <div class="form-group label-floating is-empty">
                        <select class="selectpicker" data-style="select-with-transition" title="Seleccione tipo de unidad" ref="tipounidad" :value="value.tipoUnidad" @input="update" required>
                            <option value="RABON">RABON</option> <option value="TORTON">TORTON</option> 
                            <option value="CAJA CERRADA">CAJA CERRADA</option> 
                            <option value="FULL / DOBLE SEMIREMOLQUE">FULL / DOBLE SEMIREMOLQUE</option> 
                            <option value="PLATAFORMA">PLATAFORMA</option>
                            <option value="JAULA ENLONADA / CORTINA">JAULA ENLONADA / CORTINA</option>
                            <option value="TOLVA">TOLVA</option>
                        </select>
                    </div>
                </div><!-- ./col-md-9 -->    
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <label class="col-md-3 label-on-left">Medida</label>
                <div class="col-md-9 col-sm-4">
                    <div class="form-group label-floating is-empty">
                        <select class="selectpicker" data-style="select-with-transition" title="Seleccione medida" ref="medidaunidad" :value="value.medidaUnidad" @input="update" required>
                            <option value="26 PIES">26 PIES</option> 
                            <option value="35 PIES">35 PIES</option> 
                            <option value="40 PIES">40 PIES</option> 
                            <option value="45 PIES">45 PIES</option> 
                            <option value="48 PIES">48 PIES</option> 
                            <option value="53 PIES">53 PIES</option>
                        </select>
                    </div>
                </div><!-- ./col-md-9 -->    
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
        <div class="col-md-2 col-sm-12">
            <div class="row">
                <label class="col-md-3 label-on-left">Ejes</label>
                <div class="col-md-9 col-sm-4">
                    <div class="form-group label-floating is-empty">
                        <input type="number" class="form-control" nim="1" max="8" value="2" ref="ejes" :value="value.ejes" @input="update" required>
                    </div>
                </div><!-- ./col-md-9 -->    
            </div><!-- ./row -->
        </div><!-- ./col-md-4 -->
    </div>
</div>

</template>
<script>
export default {
    name:'form-transporte',
    props:['value','legend'],
    
    methods:{
        update(){
            this.$emit('input',{
                operador:       this.$refs.operador.value,
                lineaTrasporte: this.$refs.lineatrasporte.value,
                talon:          this.$refs.talon.value,
                cantidad:       this.$refs.cantidad.value,
                marca:          this.$refs.marca.value,
                placasTractor:  this.$refs.placastractor.value,
                placasCaja:     this.$refs.placascaja.value,
                tipoUnidad:     this.$refs.tipounidad.value,
                medidaUnidad:   this.$refs.medidaunidad.value,
                ejes:           this.$refs.ejes.value

            });
        }
    }

}
</script>

