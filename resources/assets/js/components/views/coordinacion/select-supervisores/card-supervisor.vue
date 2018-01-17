<template>
    <div class="col-sm-6" >
        <div class="card card-profile card-plain card-supervisor">
            <div class="col-xs-5 ">
                <div class="text-center">
                    <img class="img img-responsive img-circle z-depth-3" :src="supervisor.url_avatar.replace('public/','/storage/')" onerror='this.onerror = null; this.src="/img/supervisor.png"' style="max-width:200px;margin:0 auto;">
                </div>
            </div>
            <div class="col-xs-7 ">
                <div class="card-content">
                    <h4 class="card-title text-truncate" :title="supervisor.nombre +' '+ supervisor.apellido" v-text="supervisor.nombre + ' ' + supervisor.apellido"></h4>
                    <h6 class="category text-muted text-truncate" :title="'Usuario: ' + supervisor.user ">
                        <i class="fa fa-user-circle-o fa-1 text-muted" aria-hidden="true"></i> <span v-text="supervisor.user"></span>
                    </h6>
                    <div class="footer">
                        <button type="button" @click="$emit('select-supervisor')" class="btn btn-primary btn-just-icon btn-round">
                            <i class="material-icons">add</i>
                        </button>
                    </div>
                </div>
            </div>
        </div> 
    </div>  
</template>
<script>
export default {
    props:['supervisor'],
   
}
</script>


