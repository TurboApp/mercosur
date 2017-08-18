<template>
	<div class="card">
		<template v-if="type=='header-icon'">
			<div  class="card-header card-header-icon" :data-background-color="bgColor">
				<template v-if="typeIcon(icon)">
            		<i class="fa fa-2x" :class="icon"></i>
				</template>
				<template v-else>
					<i class="material-icons" v-text="icon"></i>
				</template>
				
			</div>
			<div class="card-content">
				<h4 class="card-title">
					<slot name="title"></slot>
				</h4>
				<slot></slot>
			</div>
		</template>
		<template v-else>
			<div  class="card-header" :class=" (type=='header-text') ? 'card-header-text' :''" :data-background-color="bgColor">
				<h4 class="card-title">
					<slot name="title"></slot>
				</h4>
				<p class="category"><slot name="subtitle"></slot></p>
			</div>
			<div class="card-content">
				<slot></slot>
			</div>
			
		</template>
		

		<div v-if="$slots['footer']" class="card-footer" >
			<slot name="footer"></slot>	
		</div>
	</div>
</template>
<script>

export default{
	props:['type','bgColor','icon'],
	methods:{
		typeIcon(icon){
			return (icon.substring(0,3) === 'fa-');
		}
	}
	
}
</script>
<style lang="scss">

</style>
