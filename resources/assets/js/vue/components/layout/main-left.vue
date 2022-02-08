<template>
    <div :class="{ searching: search.visible }">
        <div class="top" id="mobile-toggle" @click="$emit('slideoutToggle')">
            <div class="top mobile-toggle">
                <i class="fa fa-bars"></i>
            </div>
        </div>

        <nav class="main-nav">
            <navigation-list :items="navigation.main_menu" />
        </nav>
    </div>
</template>

<script>
    import NavigationList from "../helpers/navigation-list.vue";
    import { mapState, mapGetters } from "vuex";

    export default {
        components: { NavigationList },

        computed: {
            ...mapState(["search"]),
            ...mapGetters({ navigation: "app/getNavigation" })
        }
    };
</script>

<style lang="scss" scoped></style>
