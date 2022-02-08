<template>
    <div class="p-item">
        <div class="p-item-image">
            <avatar :size="130"
                    :src="news.image.files.original.url"
                    :recent="news.is_recent"
            />
        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <span>{{ news.title }}</span>
                </div>
            </div>
            <div class="release-description">
                {{ news.content.trunc(110) }}
            </div>
            <div class="p-item-meta">
                <actions :actionable="news"></actions>
                <div class="p-item-time">
                    {{ moment(news.published_at).fromNow() }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Actions from 'global/actions/actions';
    import ActionMenu from 'global/actions/action-menu';
    import Avatar from 'global/avatar';

    export default {
        props: {
            news: {
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
    .release-description {
        flex: 1;
        font-size: 14px;
        padding: 20px 0;
    }
    .item-title {
        font-size: 19px;
    }
    .item-main {
        justify-content: flex-start;
    }
</style>