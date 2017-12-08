<template>
<div>
    <div>
        <ul :class="addClass" role="tablist">
            <li v-for="tab in tabs" :class="{'active':tab.isActive}">
                <a :href="tab.href" @click="activeTab(tab)">
                    <template v-if="tab.icon">
                        <i class="material-icons">{{tab.icon}}</i>
                    </template>
                    {{tab.name}}
                </a>
            </li>
        </ul>
    </div>
        
    <div class="tab-content">
        <slot></slot>
    </div>
        
</div>
</template>
<script>
export default {
  name:'tabs',
  props:{
      orientation:{
          type:String,
          default:'vertical',
      },
      icons:{
          type:Boolean,
          default:false
      }
      
  },
  computed:{
       addClass(){
           var c='nav nav-pills nav-pills-primary';
           if(this.icons){
               c +=' nav-pills-icons';
           }
           if(this.orientation=='horizontal'){
               c += " nav-stacked"
           }
           return c;
       } 
  },
  created(){
      this.tabs=this.$children;
      
  },
  
  methods:{
      activeTab(activeTab){
          this.tabs.forEach(tab=>{
              tab.isActive = (tab.name==activeTab.name)
          });
      }
  }
}
</script>

