<template>
    <router-link v-if="link" :to="link">
        <div class="info-button">
            <span>
                <i class="fa fa-info-circle"></i>
            </span>
        </div>
    </router-link>
</template>

<script>
    //import Component from '../';
    export default {
        props: {
            infoable: { // This is the object e.g. 'track', 'release', 'article'
                type: Object,
                required: true,
            },
        },
        data () {
            return {

            }
        },
        computed: {
            link: function() {
                return this.getRouterObject(this.infoable);
            }
        },
        methods: {

        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    .info-button {

    }
</style>