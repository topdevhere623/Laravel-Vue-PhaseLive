<template>
    <div class="page-content-padded page-profile-fan" style="overflow:hidden;">
        <aside class="sidebar-left">
            <profile-avatar class="centered-block" id="profile-avatar" :user="mutableUser" :size="190" />
            <user-left-sidebar :user="user" />
        </aside>
        <!-- MAIN CONTENT -->
        <div class="page-main">
            <profile-navigation />
            <router-view :user="user" />
        </div>
        <aside class="sidebar-right">
            <user-right-sidebar :user="user" :news="news" />
        </aside>
    </div>
</template>

<script>
    import ProfileMixin from './profile-mixin';

    import FollowAction from './partials/follow-action';
    import ProfileNavigation from './partials/profile-navigation';

    import ProfileAvatar from './partials/avatar';
    import UserRightSidebar from 'global/sidebars/user-right-sidebar'
    import UserLeftSidebar from 'global/sidebars/user-left-sidebar'

    export default {
        components: {
            ProfileAvatar,
            ProfileNavigation,
            FollowAction,
            UserRightSidebar,
            UserLeftSidebar,
        },
        mixins: [
            ProfileMixin
        ]
    }
</script>

<style lang="scss" scoped>

    #profile-avatar {
        margin-bottom: 2em;
        max-width: 190px;
    }

</style>
