<template>
    <div>
        <card-notify v-for="(notification, index) in list" :key="index" :data="notification" :index="index"></card-notify>
        <infinite-loading @infinite="infiniteHandler">
            <span slot="no-more"></span>
        </infinite-loading>
    </div>
</template>
<script>
import cardNotify from './notification-card.vue';
import InfiniteLoading from 'vue-infinite-loading';
export default {
    components: {
        'card-notify':cardNotify,
        InfiniteLoading,
    },
    data(){
        return {
            list:[],
        }
    },
    methods: {
        infiniteHandler($state) {
            let self = this;
            axios.get('/notificaciones/loadMore/', {
                params: {
                    page: this.list.length / 10 + 1,
                },
            }).then(({ data }) => {
                if (data.length) {
                    self.list = self.list.concat(data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        }
    },
}
</script>

