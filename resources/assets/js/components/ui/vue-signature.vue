<template>
	<div :id="'signature-pad-'+uid" class="signature-pad" >
		<div class="signature-pad--body">
			<canvas :id="uid" width="414" height="302"></canvas>
		</div>
		<div class="signature-pad--footer">
			<div class="signature-pad--actions">
				<div>
					<button type="button" @click="clear" class="btn btn-warning btn-round">Limpiar</button>
				</div>
				<div>
					<button type="button" @click="save" class="btn btn-success btn-round">Guardar</button>
				</div>
			</div>
		</div>
	</div>
   
</template>

<script>
    import SignaturePad from 'signature_pad';

    export default {
		name:"vueSignature",
        

        data() {
            return {
				pad: null,
				canvasWidth :'',
				canvasHeight:'',
				canvas:'',
				signaturePad:'',
				
			};
        },
		created(){
			var _this = this;
			this.uid = "canvas" + _this._uid
		},
		mounted() {
			this.canvas = document.getElementById(this.uid);
			this.signaturePad = new SignaturePad(this.canvas, {
				backgroundColor: 'rgb(255, 255, 255)'
			});
        },
        methods: {
			signature_pad(){
				this.signaturePad = new SignaturePad(this.canvas, {
					backgroundColor: 'rgb(255, 255, 255)'
				});
			},
            clear() {
                this.signaturePad.clear();
			},
			save(){
				this.$emit('signatureSave', this.signaturePad.toDataURL());
			}
	    }
    }
</script>

<style lang="scss" scoped>
	.signature-pad {
		position: relative;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
			-ms-flex-direction: column;
				flex-direction: column;
		font-size: 10px;
		width: 450px;
		height: 400px;
		margin:0 auto;
		border: 1px solid #e8e8e8;
		background-color: #fff;
		box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
		border-radius: 4px;
		padding: 16px;
		&::before,
		&::after {
			position: absolute;
			z-index: -1;
			content: "";
			width: 40%;
			height: 10px;
			bottom: 10px;
			background: transparent;
			box-shadow: 0 8px 12px rgba(0, 0, 0, 0.4);
		}

		&::before {
		left: 20px;
		-webkit-transform: skew(-3deg) rotate(-3deg);
				transform: skew(-3deg) rotate(-3deg);
		}

		&::after {
		right: 20px;
		-webkit-transform: skew(3deg) rotate(3deg);
				transform: skew(3deg) rotate(3deg);
		}
		.signature-pad--body {
			position: relative;
			-webkit-box-flex: 1;
			-ms-flex: 1;
				flex: 1;
			border: 1px solid #f4f4f4;
			
			canvas {
				position: absolute;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				display: block;
				border:1px solid rgba(0,0,0,.15);
			}
		}

		.signature-pad--footer {
			color: #C3C3C3;
			text-align: center;
			font-size: 1.2em;
			margin-top: 8px;
		}

		.signature-pad--actions {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-pack: justify;
				-ms-flex-pack: justify;
					justify-content: space-between;
			margin-top: 8px;
		}
	}
</style>