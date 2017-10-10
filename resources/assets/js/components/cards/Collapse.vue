<template>
	<div class="card card-collapse">
		<div  class="card-header">
			<h4 class="card-title" :class="{'active':isActive}">
				<a href @click.prevent="isOpen">
					{{title}}
					<span class="pull-right">
						<i class="fa fa-chevron-down" :class="{'fa-flip-vertical' : isActive }" aria-hidden="true"></i>
					</span>	
				</a>
			</h4>
		</div>
		
		<div class="card-content" v-show="isActive">
			<slot></slot>
		</div>
	</div>
</template>
<script>

export default{
	data(){
		return{
			isActive:true,
		}
	},
	props:{
		title:{
			type:String,
			required:true
		}
		
	},
	methods:{
		isOpen(){
			
			this.isActive=!this.isActive;
			
		}
	}
	
}
</script>
<style lang="scss">

</style>
