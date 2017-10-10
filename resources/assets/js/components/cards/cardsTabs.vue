<template>
<div class="card">
	<div class="card-header card-header-tabs" :data-background-color="bgColor">
		<div class="nav-tabs-navigation">
			<div class="nav-tabs-wrapper">
				<span class="nav-tabs-title">{{title}}</span>
				<ul class="nav nav-tabs">
					<li v-for="cardtab in cardstabs" :class="{'active':cardtab.isActive}">
						<a :href="cardtab.href" @click="activeCardTab(cardtab)">
							<template v-if="cardtab.icon">
							<i class="material-icons" v-text="cardtab.icon"></i>
							</template>
							{{cardtab.tabTitle}}
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="card-content">
		<div class="tab-content">
			<slot></slot>
		</div>
	</div>

</div>

</template>
<script>
export default {
    props:{
		title:{
			type:String,

		},
		bgColor:{
			type:String,
			default:'default'
		}
	},
	methods:{
		typeIcon(icon){
			return (icon.substring(0,3) === 'fa-');
		}
	},
	created(){
		this.cardstabs=this.$children;
	},
	methods:{
		activeCardTab(activeCardTab){
			this.cardstabs.forEach(cardtab=>{
				cardtab.isActive = (cardtab.tabTitle==activeCardTab.tabTitle)
			});
		}
	}
}
</script>


