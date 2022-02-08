<template>
    <div class="page-content-padded page-news-index">
        <div class="page-main">
            <h1 v-if="page.page">{{ page.page.title }}</h1>

            <div v-if="page.metas">
                <img :src="page.metas.image" />
            </div>

            <div v-if="page.metas" v-html="page.metas.content"></div>
        </div>

        <aside class="sidebar-right">
            <sidebar-group
                title="News"
                :items="news.articles.slice(0, 5)"
            ></sidebar-group>
        </aside>
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import SidebarGroup from "global/sidebar-group";

export default {
    components: { SidebarGroup },

    data() {
        return {
            // mainImage: null,
            // content: null,
        };
    },

    mounted() {
        this.fetchData();
    },

    watch: {
        $route: "fetchData"
    },

    computed: {
        ...mapState(["news"]),
        ...mapGetters({
            page: "app/getPageData"
        })
    },

    methods: {
        async fetchData() {
            await this.$store.dispatch("app/fetchPageData", this.$route.path);
            // await this.sortMetas()
        }
        // sortMetas() {
        //     this.metas = []
        //     this.mainImage = null
        //     this.content = null
        //     this.page.metas.forEach((meta) => {
        //         if (meta.key == 'main_image') {
        //             this.mainImage = meta.value ? meta.value : ''
        //         } else if (meta.key == 'content') {
        //             this.content = meta.value ? meta.value : ''
        //         } else {
        //             let data = {}
        //             data.key = meta.key
        //             data.type = meta.option
        //             data.value = JSON.parse(meta.value)
        //             this.metas.push(data)
        //         }
        //     })
        // }
    }
};
</script>

<style>
</style>
