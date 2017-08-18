<template>
  
    
<ul>
    <li v-for="(p, index) in paginas" :class="p.active">
        <a href="javascript:void(0);" @click="activePage(index)">
            <span  v-html="p.pagina"></span>
        </a>
    </li> 
</ul>

    
</template>
<script>
export default {
    name:'app-pagination',
    data(){
        return{
            paginas:[]
        }
    },
    props:{
        totalItems: {
            type: Number,
            //required: true,
            //default:10    
        },
        itemsPerPage:{
            type:Number,
            //required:true,
            default:3
        },
        
        firstText:{
            type:String,
            //default:'&laquo;'
            //default:undefined
        }, 
        lastText:{
            type:String,
            //default:'&raquo;'
            //default:undefined
        },
        
    },
    mounted: function(){
        this.createPaginator();
    },
    methods:{
        createPaginator()
        {
            var self=this;
            var a, p;
            var totalPaginas=Math.ceil(this.totalItems / this.itemsPerPage);
            console.log('total Items: '+this.totalItems);
            console.log('item x papagina: '+this.itemsPerPage);
            console.log('total paginas: '+totalPaginas);
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
        activePage(index){
            this.$emit('change');
            let lastIndex = this.paginas.length-1;
            if(this.firstText && this.lastText )
            {
                this.paginas.forEach(function(p,i)
                {
                    if(index==0){
                        index=1;
                    }
                    if(index==lastIndex){
                        index = lastIndex - 1;
                    }
                    if(i==0 && index > 1){
                        p.active='';
                    }
                    else if(i==0 && index < 2){
                        p.active='disabled';
                    }
                    if(i==lastIndex && index < lastIndex-1 ){
                        p.active='';
                    }
                    else if(i==lastIndex  && index >= lastIndex-1  ){
                        p.active='disabled';
                    }

                    if(i==index && index!=lastIndex){
                        p.active='active';
                    }
                    if(p.active==='active' && i!==index){
                        p.active=''
                    }
                });
            }
            else
            {
                this.paginas.forEach(function(p,i)
                {
                    
                    

                    if(i==index ){
                        p.active='active';
                    }
                    if(p.active==='active' && i!==index){
                        p.active=''
                    }
                });
            }
            
        }
        
        
        
    }

}
</script>
<style lang="scss">

</style>


