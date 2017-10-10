<template>
<div>
    <form-documento v-for="(form, index) in forms" :key="index" :index="index" @remove="deleteForm"></form-documento> 
    <p class="text-right">
    <button type="button" class="btn btn-primary btn-simple" @click.prevent="addForm"><i class="material-icons">add_box</i> Agregar Documento</button>
    </p>
</div>
</template>
<script>
import formDocumento from './forms/documento.vue';
export default {
    components:{
        'form-documento':formDocumento
    },
    data(){
        return{
            forms:[]
        }
    },
    methods:{
        addForm(){
            var x=this.forms.lenght;
            this.forms.push({'form':x});
            console.log(this.forms);

        },
        deleteForm(i){
            console.log('pasa algo');
            console.log(i);
            this.forms.splice(i,1);
            
            console.log(this.forms);
        }
    }
}
</script>

