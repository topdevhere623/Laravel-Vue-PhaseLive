<template>
    <router-link :to="getRouterObject(user)" class="p-item">
        <div class="p-item-image">
            <avatar :size="130"
                    :src="user.avatar.files.thumb.url"
                    :recent="user.is_recent"
            />
        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <span>{{ user.name }}</span>
                </div>
            </div>
            <div class="p-post-text">
                {{ user.bio }}
            </div>
            <!--<div class="p-item-meta">-->
                <!--<actions :actionable="post"></actions>-->
                <!--<div class="p-item-time">-->
                    <!--{{ moment(post.created_at).fromNow() }}-->
                <!--</div>-->
            <!--</div>-->
        </div>
    </router-link>
</template>

<script>
    import Actions from 'global/actions/actions';
    import ActionMenu from 'global/actions/action-menu';
    import Avatar from 'global/avatar';

    export default {
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {
                moment: window.moment,
            }
        },
        created: function() {

        },
        methods: {

        },
        components: {
            Actions,
            ActionMenu,
            Avatar,
        }
    }
</script>

<style lang="scss" scoped>
    a {
        text-decoration: none;
    }
    .p-post-text {
        flex: 1;
        font-size: 14px;
    }
    .p-item-title {
        font-size: 19px;
    }
    .p-item-main {
        justify-content: flex-start;
    }
</style>