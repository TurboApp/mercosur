<template>
    <li :class="['list-group-item', {'is-editting': editting}]" >
        <div class="row" >
            <template v-if="!doc.editting">
            <div class="col-xs-9">
                <div class="form-group">
                <h4>
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    <span><slot name="item"></slot></span>
                </h4>
                </div>
            </div>
            <div class="col-xs-3 text-right">
                <button @:click="edit(doc)" class="btn btn-primary btn-just-icon btn-round">
                    <i class="material-icons">mode_edit</i>
                </button>
                <button @click="discard" class="btn btn-danger btn-just-icon btn-round ">
                    <i class="material-icons">delete</i>
                </button>
            </div>
            </template>
            <template v-else>
                <div class="col-xs-9">
                    <fg-input size="lg" v-model="doc.titulo" icon="fa-file-text-o fa-lg" autofocus></fg-input>       
                    
                </div>
                <div class="col-xs-3 text-right">
                    <button v-on:click="" class="btn btn-success btn-just-icon btn-round">
                        <i class="material-icons">check</i>
                    </button>
                    <button v-on:click="" class="btn btn-warning btn-just-icon btn-round ">
                        <i class="material-icons">close</i>
                    </button>
                </div>
            </template>
        </div>
    </li>

</template>
<script>
import evenbus from '../event-bus.js';
import fgInput from '../form/formGroupInput.vue';

export default{
    elements:{
       'fg-input':fgInput
    },
    data(){
        return{
            editting:false,
            draf:'',
        }
    },
   props:['model','index','key'],
    methods:{
        edit(){
            EventBus.$emit('editting',this.index);

            this.draft=this.task.description;

            this.editting=true;
        },
        // edit(doc){
        //     this.docs.forEach(function(doc){
        //         doc.editting=false;
        //     });
        //     return doc.editting=true;  
        // },
        discard(){
            this.editting=false;
        }
        // delete: function(){

        // },
        // update:function(){

        // },
    }
}
</script>     
<style lang="scss">
.card.todolist  .card-content{
       padding:0;
    
    .todolis-input{
        padding:0 15px;
        margin-bottom:25px;
    }
    .list-group.todolist-group{
        .list-group-item{
            border-left-style:none;
            border-right-style:none;
            padding-top:0;
            padding-bottom:0;
            
            &.is-editting{
                box-shadow: inset 0px 0px 15px 1px rgba(0,0,0,0.15);
                
                input[type="text"]{
                    border:none;
                    box-shadow: 0 0 0;
                    background: transparent;
                }
                .col-xs-9{
                    padding-left:0;
                }
            }

        }
        .list-group-item:first-child{
            border-top-right-radius: 0px;
            border-top-left-radius: 0px;
            border-top-style:none;
        }
        .list-group-item:last-child
         {
            border-bottom-right-radius: 0px;
            border-bottom-left-radius: 0px;
            border-bottom-style:none;
        }
    }
}
</style>