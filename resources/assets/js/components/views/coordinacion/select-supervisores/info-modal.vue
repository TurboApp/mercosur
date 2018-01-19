<template>
    <div>
        <bootstrap-modal ref="theModal" :need-header="false" :need-footer="false" :size="'large'" :opened="myOpenFunc">
            <div slot="title">
                Your title here
            </div>
            <div slot="body">
                Your body here
            </div>
            <div slot="footer">
                Your footer here
            </div>
        </bootstrap-modal>
    </div>
</template>   
<script>
import modal from './modal.vue';
export default {
    components:{
       "bootstrap-modal":modal 
    },
    methods:{
        myOpenFunc(){
            console.log('Hola');
        }
    }
}
</script>  