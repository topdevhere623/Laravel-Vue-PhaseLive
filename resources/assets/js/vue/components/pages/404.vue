<template>
    <div class="page-content-padded">
        <div class="page-main">
            <h1 class="no-top">Page Not Found</h1>
        </div>
        <aside class="sidebar-right">
            <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
        </aside>
    </div>
</template>

<script>
    import SidebarGroup from '../global/sidebar-group';
    import { mapState } from 'vuex';

    export default {
        data () {
            return {

            }
        },

        computed: mapState(['news']),

        created: function() {},

        components: {
            SidebarGroup,
        }
    }
</script>

<style lang="scss" scoped>

</style>