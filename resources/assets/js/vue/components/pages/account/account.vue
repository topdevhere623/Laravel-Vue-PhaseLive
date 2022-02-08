<template>
    <div class="page-content-padded">
        <!-- <aside class="sidebar-right">
            <sidebar-group title="My Tracks" :view-all="true" :items="[]"></sidebar-group>
            <sidebar-group title="My Albums" :view-all="true" :items="[]"></sidebar-group>
        </aside> -->
        <div class="page-main">
            <h1>{{ pageTitle }}</h1>
            <h2 class="account-type">Account Type - {{app.user.account_type}}</h2>
            <account-menu active="account"></account-menu>
            <transition mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
        <!-- <aside class="sidebar-right">
            <sidebar-group title="Followed" :view-all="true" :items="[]"></sidebar-group>
            <sidebar-group title="Favourites" :view-all="true" :items="[]"></sidebar-group>
        </aside> -->
    </div>
</template>

<script>
    import SidebarGroup from 'global/sidebar-group';
    import AccountMenu from './account-menu';
    import { UserEvents } from "events";

    import { mapState } from 'vuex'

    export default {
        data () {
            return {
                pageTitle: 'My Account',
            }
        },
        created: function() {
            UserEvents.$on('updateTitle', title => this.pageTitle = title)
        },
        components: {
            SidebarGroup,
            AccountMenu,
        },
        computed: {
            ...mapState(['app'])
        }
    }
</script>

<style lang="scss" scoped>
.account-type {
    margin: 40px 0;
    font-weight: bold;
    text-transform: capitalize;
}
</style>