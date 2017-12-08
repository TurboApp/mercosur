<template>
    <div>
        <input type="file" :name="name"  :id="id" :class="classInput" :accept="accept" :multiple="multiple" ref="fileInput" @change="change" />
        <label :for="id">
            <template v-if="styleInput=='button'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>
                <span>{{captionLabel}}</span>
            </template>
            <template v-else-if="styleInput=='outline'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                <span>{{captionLabel}}</span>
            </template>
            <template v-else-if="styleInput=='link'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                <span>{{captionLabel}}</span>
            </template>
            <template v-else-if="styleInput=='simple'">
                 <span>{{captionLabel}}</span>
            </template>
            <template v-else-if="styleInput=='circle'">
                <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>
                </figure> 
                <span>{{captionLabel}}</span>
            </template>
            <template v-else-if="styleInput=='file'">
                <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>
                </figure> 
                <span>{{captionLabel}}</span>
            </template>
            
            <template v-else-if="styleInput=='inputgroup'">
                <span>{{inputgroupLabel}}</span> 
                <strong>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                    {{label}}
                </strong>
            </template>
            <template v-else>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>
                <span>{{captionLabel}}</span>
            </template>
        </label>

    </div>

</template>
<script>
import EventBus from '../event-bus.js';
export default {
    props:{
        label:{
            type:String,
            default:'Elige un archivo'
        },
        value:[FileList,String],
       
        name:{
            type:String,
            default:'file'
        },
        styleInput:{
            type:String,
            default:'button'
        },
        
        multiple:{
            type:Boolean,
            default:false
        },
        accept:{
            type:String,
        },
        id:{
            type: [String, Number],
            default:this._uid
        },
        caption:{
            type:String,
            default:'archivos seleccionados'
        }
    },
    data(){
        return{
            captionLabel:'',
            inputgroupLabel:'',
            files:[],
        }
    },
    computed:{
        classInput(){
            switch(this.styleInput){
                case 'button':
                    return 'inputfile inputfile-1';
                break;
                case 'outline':
                    return 'inputfile inputfile-2';
                break;
                case 'link':
                case 'simple':
                    return 'inputfile inputfile-3';
                break;
                case 'circle':
                    return 'inputfile inputfile-4';
                break;
                case 'file':
                    return 'inputfile inputfile-5';
                break;
                case 'inputgroup':
                    return 'inputfile inputfile-6';
                break;
                default:
                    return 'inputfile inputfile-1';

            }
        },
    },
    mounted(){
        this.captionLabel=this.label+'...';
    },
    created() {
        EventBus.$on('reset', this.nuevo);
    },
    methods:{
        change(e){
            this.$destroy;
            this.captionLabel=this.label;
            this.$emit('input', e.target.files)
            var files= e.target.files;
            this.files=[];
            if(!files.length) return;
            if( files && files.length > 1 ){
                this.captionLabel=files.length +' '+ this.caption;
                if(this.styleInput=='inputgroup'){
                    this.inputgroupLabel  = this.captionLabel; 

                }
                for (var i = 0,file; i < files.length; i++) {
                    file = files[i];
                    this.files.push({
                        'name':file.name
                    })   
                    
                }
            }
            else{
                this.captionLabel= files[0].name;
                if(this.styleInput=='inputgroup'){
                    this.inputgroupLabel  = this.captionLabel; 

                }
            }
            
        },
        nuevo(){
            this.captionLabel=this.label+'...';
            this.inputgroupLabel='';
            this.files=[]; 
        }
    }
}
</script>

