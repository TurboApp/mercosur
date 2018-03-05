<template>
    <div>
        <card >
            <template>
            	<div class="row">
            		<div class="col-sm-12">
            			<h2>Ubicación de la mercancia</h2>		
            		</div>
            	</div>
            	
            	<div v-if="images.length > 0" class="clearfix">
                    <div v-for="(image, index) in images" :key="index" class="col-sm-3" >
                        <a :href="'/'+image" data-lightbox="Mercancia" class="thumbnail" style="display:block; width:100%; height:100%;">
                            <img class="img img-responsive img-thumbnail" 
                                :src="'/'+image" 
                                onerror='this.onerror = null; this.src="/img/no-image.jpg"'
                            >
                        </a>
                    </div>
                </div>
            </template>
        </card>

        
       
    </div>
</template>
<script>

import card from '../../cards/Card.vue';

export default {
    components: {
        'card':card,
        
    },
    props:{
        images:{
            type:[Object, Array],
            required:true,
        },
    },
    data(){
        return {
        }
    },
    mounted(){
  
    },
    methods:{
        
    }
}
</script>

