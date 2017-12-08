<template>
<transition name="fade" mode="in-out" >
    <div v-show="isActive">
        <div class="tab-pane" :class="{'active':isActive}">
            <slot ></slot>
        </div>
    </div>
</transition>

</template>
<script>
export default {
    name:'tab',
    props:{
        name:{required:true},
        active:{default:false},
        icon:{type:String}
    },
    data(){
        return{
            isActive:false
        }
    },
    mounted(){
      this.isActive=this.active;
    },
    computed:{
        href(){
            return '#'+this.name.toLowerCase().replace(/ /g, '-');
        },
        fadeClass(){

        }
    }
}
</script>
