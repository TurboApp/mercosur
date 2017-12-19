<template>
    <div class="row">
        <div class="col-xs-12">
            <h4 v-text="title"></h4>    
        </div>
        <div class="col-xs-12">
            <p>
                <textarea  class="form-control input-lg" disabled v-text="value"></textarea>
            </p>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        title:{
            type:String,
            required:true
            },
        text:{
            type:String,
            required:true
            },
        id:{
            type:[Number]
        },
        value:{
            type:[String, Number]
        }
    },
    data(){
        return{
            
        }
    },
    mounted(){
        
    },
    methods:{
        
    }
}
</script>

