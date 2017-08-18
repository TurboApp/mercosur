<template>
    <card  class="todolist" bgColor="blue" > 
        <template slot="title">Este es un titulo</template>  
        <fg-input size="lg" v-on:keyup.enter.native="createItem"  v-model="newItem" class="todolis-input" :placeholder='placeholder'></fg-input>
        <ul class="list-group todolist-group">
           <li @dblclick.prevent="edit(doc)" :class="['list-group-item',{'is-editting': editting===doc.id}]" v-for="(doc, index) in docs">
                <div class="row" >
                     <template v-if="editting!==doc.id">
                        <div class="col-xs-9">
                            <div class="form-group">
                            <h4>
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                <span v-text="doc.titulo"></span>
                            </h4>
                            </div>
                        </div>
                        <div class="col-xs-3 text-right">
                            <button v-on:click.prevent="edit(doc)" class="btn btn-primary btn-just-icon btn-round">
                                <i class="material-icons">mode_edit</i>
                            </button>
                            <button v-on:click.prevent="remove(doc,index)" class="btn btn-danger btn-just-icon btn-round ">
                                <i class="material-icons">delete</i>
                            </button>
                        </div>
                     </template>
                     <template v-else>
                         <div class="col-xs-9">
                             <fg-input @keyup.enter.native="update(doc)"  @keyup.esc.native="discard" size="lg" v-model="draft" icon="fa-file-text-o fa-lg" autofocus="true"></fg-input>       
                             
                         </div>
                         <div class="col-xs-3 text-right">
                             <button v-on:click="update(doc)" class="btn btn-success btn-just-icon btn-round">
                                 <i class="material-icons">check</i>
                             </button>
                             <button v-on:click="discard" class="btn btn-warning btn-just-icon btn-round ">
                                 <i class="material-icons">close</i>
                             </button>
                         </div>
                     </template>
                 </div>
             </li>
            
        </ul>
        
            
    
        <ul class="pagination">
            <li v-for="(p, index) in paginas" :class="p.active">
                <a href="javascript:void(0);" @click="changePage(index)">
                    <span  v-html="p.pagina"></span>
                </a>
            </li> 
        </ul>

        
    </card>
</template>
<script>
import fgInput from '../form/formGroupInput.vue';
import card from '../cards/Card.vue';

export default{
    elements:{
        'card' : card,
        'fg-input' : fgInput
    },
    data(){
        return{
            newItem:'',
            draft:'',
            editting:0,
            docs: [],

            elementos:'',
            currentPage:'',
            totalItems : 0,
            currentPage : 1,
            itemsPerPage : 1,
            allItem:0,
            paginas:[]
        }
    },
    props:{
        getData:{
            type:String
        },
        setData:{
            type:String
        },
        placeholder:{
            type:String
        },
        titulo:{
            type:String
        },
        firstText:{
            type:String,
            
        }, 
        lastText:{
            type:String,
        },
        
    },
    mounted:function(){
        this.fetchItems();
        
    },
    computed:{
        
    },
    methods:{
        fetchItems(){
            let self = this;
            var a, p;
            axios.get(this.getData)
            .then(function (response) {
                self.allItem = response.data.todolist;
                self.totalItems = response.data.todolist.length;
                self.docs = response.data.todolist.slice(0,  self.itemsPerPage );
                var totalPaginas=Math.ceil(self.totalItems / self.itemsPerPage);
                for (var i = 0; i < totalPaginas; i++) 
                {
                    a='';
                    p=i+1;
                    if(i==0){
                        a='active';
                    }
                    self.paginas.push({
                        active:a,
                        pagina:p
                    });
                
                }
               
                
                    
            });
        },
        edit(doc){
            this.draft='';
            this.editting=doc.id;
            this.draft=doc.titulo;
            console.log(this.draft);
            this.docs.forEach(function(doc){
                doc.editting=false;
            });
            return doc.editting=true;  
        },
        discard(){
            console.log('Entra a discard');
            this.editting=0;
            this.draft='';
        },
        update(doc){
            doc.titulo=this.draft;
            this.editting=0;
        },
        remove(doc,index){
             
            this.draft='';
            this.editting=0;
            var self=this;
            swal({
                
                showCancelButton: true,
                title: '¿Esta seguro?',
                text: "Se eliminara el registro <strong>"+ doc.titulo +"</strong><br/> ¡No podrás revertir esto!",
                type: 'warning',
                allowOutsideClick: false,
                allowEscapeKey:false,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, ¡Eliminar!',
                cancelButtonText: 'No, Cancelar',
                buttonsStyling: false
                }).then(function () {
                    
                    // axios({
                    //     method:'delete',
                    //     url:'{{$url}}',
                    // });
                    self.docs.splice(index, 1);
            
                }, function (dismiss) {
               
                })
            
        },
        createItem(item){

            this.docs.push({
                id:'',
                titulo:this.newItem
            });
            this.docs.forEach((doc, index) => {
                this.$set(doc,'id',index + 1);
            });
            this.newItem='';
            console.log(this.docs);
        },
        createPaginator(){
            var self=this;
            var a, p;
            var totalPaginas=Math.ceil(this.totalItems / this.itemsPerPage);
            for (var i = 0; i < totalPaginas; i++) 
            {
                a='';
                p=i+1;
                if(i==0){
                    a='active';
                }
                this.paginas.push({
                    active:a,
                    pagina:p
                });
            
            }
            if(this.firstText  && this.lastText ){
                console.log('Entra y agrega dirs and last');
                this.paginas.unshift({
                    active:'disabled',
                    pagina:this.firstText
                });
                this.paginas.push({
                    active:'',
                    pagina:this.lastText
                });
            }
            console.log(this.paginas);
           
        },
        changePage(index){
            this.itemsPerPage=index+1;
            let obj={};
            // let limit=this.itemsPerPage * this.itemsPerPage;
            // let init=limit-this.itemsPerPage;
            //let lastIndex = this.paginas.length-1;
            console.log('metodo loco');
            obj = this.docs=this.reloadList();
            this.docs=obj.docs;
            
            // axios.get(this.getData).then(function (response) {
            //     self.allItem = response.data.todolist;
            //     self.totalItems = response.data.todolist.length;
            //     self.docs = response.data.todolist.slice(init,  limit );
            //     console.log(self.docs);
            // });
            
            
            this.paginas.forEach(function(p,i)
            {
                
                if(i==index ){
                    p.active='active';
                }
                if(p.active==='active' && i!==index){
                    p.active=''
                }
            });
            
        },
        reloadList:function(){
            let list=[];
            let self=this;
            let limit=this.currentPage * this.itemsPerPage;
            console.log('limit '+limit);
            let init=limit-this.itemsPerPage;
            axios.get(this.getData).then(function (response) {
                list.allItem = response.data.todolist;
                list.totalItems = response.data.todolist.length;
                list.docs = response.data.todolist.slice(init,  limit );
            });
            console.log(list);
            return list;
        }
    }   
    //if(this.firstText && this.lastText )
            // {
            //     this.paginas.forEach(function(p,i)
            //     {
            //         if(index==0){
            //             index=1;
            //         }
            //         if(index==lastIndex){
            //             index = lastIndex - 1;
            //         }
            //         if(i==0 && index > 1){
            //             p.active='';
            //         }
            //         else if(i==0 && index < 2){
            //             p.active='disabled';
            //         }
            //         if(i==lastIndex && index < lastIndex-1 ){
            //             p.active='';
            //         }
            //         else if(i==lastIndex  && index >= lastIndex-1  ){
            //             p.active='disabled';
            //         }

            //         if(i==index && index!=lastIndex){
            //             p.active='active';
            //         }
            //         if(p.active==='active' && i!==index){
            //             p.active=''
            //         }
            //     });
            // }
        
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

