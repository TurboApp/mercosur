<template>
    <div>
        <div class="row" v-if="inputType == 'check'">
            <div class="col-xs-8">
                <h3 v-text="title"></h3>    
                <p class="list-group-item-text text-muted" v-text="helpText"></p>
            </div>
            <div class="col-xs-4 text-right">
                <p class="form-group">
                    <toggle-button :value="false" :color="'#2ECC40'" :sync="true" :height="25"
                    :labels="{checked: '<i class=\'fa fa-check\' ></i>', unchecked: ''}" 
                    @change="alerta"/>
                </p>
            </div>
        </div>
        <div class="row" v-else-if="inputType == 'text'">
            <div class="col-xs-12">
                <h3 v-text="title"></h3>    
                <span class="list-group-item-text text-muted" v-text=""></span>
            </div>
            <div class="col-xs-12">
                <p class="form-group">
                    <input type="text" class="form-control input-lg" :placeholder="helpText">
                </p>
            </div>
        </div>
        <div class="row" v-else-if="inputType == 'photo'">
            <div class="col-xs-12">
                <h3 v-text="title"></h3>    
                
            </div>
            <div class="col-xs-12">
                <div class="grey lighten-4" 
                    style="
                        width:100%; 
                        height:350px; 
                        position:relative;
                    ">
                    <a href="#" @click.prevent="open" 
                        
                        style="
                            position:absolute; 
                            width:100%; 
                            height:350px; 
                            display: flex;
                            flex-direction: column;
                            flex-wrap: nowrap;
                            justify-content: center;
                            align-items: stretch;
                            align-content: stretch;
                            color:#bdbdbd;
                            text-align:center;
                            ">
                         <i class="fa fa-camera fa-4x" aria-hidden="true"></i>                                               
                         <span class="list-group-item-text text-muted" v-text="helpText"></span>
                    </a>
                </div>
                <div id="results"></div>
            </div>
        </div>
           
    </div>
</template>
<script>
import ToggleButton from '../components/toogleButton.vue';
//import VueWebcam from 'vue-webcam';

export default {
    components:{
        'toggle-button':ToggleButton,
       //VueWebcam,
    },
    props:{
        inputType:{
            type: String,
            required:true,
        },
        id:{
            type:[Number, String],
            required:true
        },
        title:{
            type:String,
            required:true
        },
        helpText:{
            type:String
        }
    },
    data(){
        return{
            photo: null
        }
    },
    methods:{
        alerta(){
            console.log("Se ejecuta el evento");
        },
         take_photo () {
            this.photo = this.$refs.webcam.getPhoto();
        },
        open() {
            let sm = $.sweetModal({
               title:'CAPTURAR FOTO',
                content: `
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div id="my_camera" style="margin:0 auto;" ></div>
                        </div>
                    </div>
                    <div class="row" id="pre_take_buttons">
                        <div class="col-xs-4 col-xs-offset-4 text-center">
                            <button id="capturarFoto" class="btn btn-primary btn-round btn-just-icon">
                             <i class="fa fa-picture-o " aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row" id="post_take_buttons" style="display:none;">
                        <div class="col-xs-6 text-center">
                            <button id="cancelarFoto" class="btn btn-danger btn-round btn-just-icon">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-xs-6 text-center">
                            <button id="guardarFoto" class="btn btn-success btn-round btn-just-icon">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    
                    `,
               
                showCloseButton:false,
                blocking:true,
                theme: $.sweetModal.THEME_DARK,
                onOpen: function(){
                    Webcam.set({
                        width: 500,
                        height: 390,
                        dest_width: 640,
                        dest_height: 480,
                        image_format: 'jpeg',
                        jpeg_quality: 90,
                        force_flash: false,
                        flip_horiz: true,
                        fps: 45
                    });
                   
                    Webcam.attach( '#my_camera' );

                    $('#capturarFoto').on('click',function(){
                            Webcam.freeze();
                            document.getElementById('pre_take_buttons').style.display = 'none';
			                document.getElementById('post_take_buttons').style.display = '';
                    });
                    $('#cancelarFoto').on('click',function(){
                            Webcam.unfreeze();
                            document.getElementById('pre_take_buttons').style.display = '';
			                document.getElementById('post_take_buttons').style.display = 'none';
                    });
                    $('#guardarFoto').on('click',function(){
                           Webcam.snap( function(data_uri) {
                                // display results in page
                                document.getElementById('results').innerHTML = 
                                    '<h2>Here is your image:</h2>' + 
                                    '<img src="'+data_uri+'"/>';
                            } );
                           sm.close(); 
                    });



                },
                onClose(){
                    Webcam.reset();
                }


            });
        },
        
    },
  
}
</script>
