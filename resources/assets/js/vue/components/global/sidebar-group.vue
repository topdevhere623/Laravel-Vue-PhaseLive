<template>
    <div class="sidebar-group">
        <div class="sidebar-group-title" v-if="title">
            {{ title }}
        </div>
        <slot></slot>

        <div class="sidebar-group-items">
            <sidebar-group-item
                v-for="(item, index) in items"
                :item="item"
                :key="index"
            ></sidebar-group-item>
        </div>

        <router-link v-if="link" :to="link">
            View All <i class="fa fa-angle-double-right"></i>
        </router-link>
    </div>
</template>

<script>
    import SidebarGroupItem from "./sidebar-group-item";
    export default {
        props: ["title", "items", "viewAll"],

        data() {
            return {};
        },

        created: function() {},

        components: {
            SidebarGroupItem,
        },

        computed: {
            link() {
                return typeof this.viewAll == "string" ? this.viewAll : false;
            },
        },
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .sidebar-group {
        margin: 0 1em 3em 0;
        border-left: 6px solid $color-2;
        padding-left: 1em;
    }
    .sidebar-group-title {
        text-transform: uppercase;
        margin-bottom: 1em;
        font-size: 20px;
        font-weight: bold;
    }
    .sidebar-group-subtitle {
        margin-bottom: 0.6em;
        font-size: 15px;
        font-weight: bold;
    }
    .sidebar-group-content {
        font-size: 11px;
    }
    a {
        text-decoration: none;
    }
</style>
