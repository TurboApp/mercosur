<template>
    <a :href="data.url">
        <div class="card" style="border-radius:6px;">
            <div :class="'card-content content-'+data.type">
                <h6 class="category-social" v-html="tipo(data)"></h6>
                <h4 class="card-title" v-text="data.titulo"></h4>
                <p v-text="data.mensaje"></p>
                <div class="footer">
                    <div class="author">
                            <img v-if="data.emisor.url_avatar" :src="data.emisor.url_avatar"  class="avatar img-raised">
                            <img v-else :src="'/img/'+data.emisor.perfil.perfil+'.png'"  class="avatar img-raised">
                            <span class="text-truncate" v-text="data.emisor.nombre+' '+data.emisor.apellido"></span>
                    </div>
                    <div class="stats">
                         <span v-html="momento(data.created_at)"></span>.
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>
<script>
var moment = require('moment');
import 'moment/locale/es';
export default {
    props:{
        data:{
            type:[Object, Array],
            required:true,
        },
        index:{
            type:Number
        }
    },
    mounted(){
        console.log(this.data);
        this.readed();
    },
    methods:{
        tipo(noti)
        {
            switch (noti.type) 
            {
                case 'info':
                   return '<i class="fa fa-info-circle" aria-hidden="true"></i> <span>INFORMACIÓN</span>';

                case 'success':
                   return '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span>MUY BIEN</span>';
                          
                case 'rose':
                   return '<i class="fa fa-bell-o" aria-hidden="true"></i> <span>AVISO</span>';
       
                case 'warning':
                   return '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span>¡ATENCIÓN!</span>';
       
                case 'danger':
                   return '<i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span>ALERTA</span>';
       
                default:
                   return '<i class="fa fa-info-circle" aria-hidden="true"></i> <span>INFORMACIÓN</span>';
            }
        },
        momento(hour){
            return '<i class="fa fa-clock-o" aria-hidden="true"></i> ' + moment(hour).fromNow();
        },
        readed(){
            let self = this;
            if(this.data.status === 'no-read')
            {
                axios.get('/notificaciones/readed/', {
                    params: {
                        id: this.data.id,
                    },
                }).then(({ data }) => {
                    //console.log(data);
                });
            }
        }
    }
}
</script>

