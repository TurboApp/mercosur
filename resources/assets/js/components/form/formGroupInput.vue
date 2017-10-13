<template>
  <div :class="[addClass,{'is-empty':isFocused}]" >
    <template v-if="label">
      <label class="control-label" >
        {{label}}
      </label>
    </template>
    <template v-if="icon" >
      <span class="input-group-addon">
        <template v-if="typeIcon(icon)">
          <i class="fa fa-lg" :class="icon"></i>
        </template>
        <template v-else>
          <i class="material-icons">{{icon}}</i>
        </template>
      </span>
    </template>  
    <div class="form-group " :class="(size) ? 'form-group-'+size : '' ">

      <input class="form-control " :class="[(size) ? 'input-'+size : '', classInput]"  v-bind="$props" :value="value" 
        @input="$emit('input', $event.target.value )" @focus="inFocus" @blur="outFocus">
        <span  class="help-block" v-text="help"></span>
      
    </div>
    <template v-if="status">
      <span class="form-control-feedback">
        <i v-if="status=='has-error'" class="material-icons" v-text="'clear'"></i>
        <i v-else-if="status=='has-success'" class="material-icons" v-text="'done'"></i>
        <i v-else-if="status=='has-info'" class="material-icons" v-text="'info'"></i> 
        <i v-else-if="status=='has-warning'" class="material-icons" v-text="'warning'"></i> 
      </span>
      
    </template>
        
  </div>
</template>
<script>
  export default {
    data(){
      return{
        isFocused:true
      }
    },
    props: {
      type: {
        type: String,
        default: 'text'
      },
      size:String,
      help:String,
      icon:String,
      status:String,
      label: String,
      labelFloating:Boolean,
      name: String,
      disabled: Boolean,
      required: Boolean,
      autofocus: Boolean,
      placeholder: String,
      value: [String, Number],
      classInput:''
    },
    computed:{
      addClass(){
        let classes = ' ';
        if(typeof(this.icon)!="undefined"){
          classes='input-group ';
          if(typeof(this.size)!="undefined"){
            //classes +='input-group-'+this.size;
          }
        }else{
          classes='form-group ';
          if(typeof(this.size)!="undefined"){
            classes +='form-group-'+this.size;
          }
        }
        if(this.labelFloating == true)
        {
          classes +=  'label-floating'
        }
        if(this.status)
        {
          classes +=  ' '+this.status;
        }
        console.log(classes);
        return  classes;
      }
    },
    methods:{
      typeIcon(icon){
        return (icon.substring(0,3) === 'fa-');
      },
      inFocus(){
        this.isFocused=false;
      },
      outFocus(){
        if(!this.value){
          this.isFocused=true;
        }
      }

    }
  }

</script>
<style>

</style>
