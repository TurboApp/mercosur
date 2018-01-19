<template>
    <li class="dropdown">
        <a href="#" @click="open" class="dropdown-toggle" data-toggle="dropdown" title="Notificaciones">
            <i class="material-icons">notifications</i>
            <span v-if="count>0" class="notification" v-text="count"></span>
            <p class="hidden-lg hidden-md">
                Notifications
                <b class="caret"></b>
            </p>
        </a>
        <ul class="dropdown-menu">
            <li v-for="(data, index) in list" :key="index">
                <a :href="data.url">
                    {{data.titulo}}
                    <br/>
                    <small v-text="data.mensaje"></small>
                </a>
            </li>
            <li v-if="list.length==0">
                <p class="text-muted" style="padding: 0 7px; margin:0;">
                    Ha leido todas las notificaciones <br>
                    <a href="/notificaciones/"><small>Ver notificaciones</small></a>
                </p>
            </li>
        </ul>
    </li>
</template>
<script>
import EventBus from './../../event-bus.js';
export default {
    data(){
        return{
            unread:[],
            list:[],
            count:0
        }
    },
    created(){
        EventBus.$on('notificaciones', () => {
            this.init();
        });
    },
    mounted(){
        this.init();
    },
    methods:{
        init(){
            let self = this;
            axios.get('/notificaciones/unread/').then(({ data }) => {
                if(data.length > 6){
                    self.count = '+6';
                }else{
                    self.count = data.length;
                }
                self.unread = data;
            });
        },
        open(){
            if(this.count>6){
                window.location.href = "/notificaciones/";
            }
            let self = this;
            self.list=[];
            for (let index = 0; index < 7; index++) {
                if(self.unread[index]){
                    if(self.unread[index].mensaje.length>45){
                        self.unread[index].mensaje = self.unread[index].mensaje.substring(0, 42) + ' ...';
                    }
                    self.list.unshift(self.unread[index]);    
                }else{
                    break;
                }
            }
            axios.get('/notificaciones/readedAll/').then(({ data }) => {
                setTimeout(function(){
                    self.count=0;
                }, 3000);
            });
        }
    }
}
</script>

