<template>
    <div class="p-item">
        <div class="p-item-image">
            <avatar
                :size="130"
                :src="post.user.avatar.files.thumb.url"
                :recent="post.is_recent"
            />
        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <span>{{ post.user.name }}</span>
                </div>
            </div>
            <div class="p-post-text">
                <img
                    v-if="post.attachment"
                    :src="post.attachment.files.medium.url"
                    :alt="post.attachment.alt"
                    class="p-post-image"
                />
                {{ postBody }}
            </div>
            <div class="p-item-meta">
                <actions :actionable="post" :id="id"></actions>
                <div class="p-item-time">
                    {{ moment(post.created_at).fromNow() }}
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
            post: {
                type: Object,
                required: true,
            },
          id: {
              type: Number,
              default: null,
          }
        },
        data () {
            return {
                moment: window.moment,
            }
        },
        computed: {
          postBody() {
              if(this.post.body){
                return this.filter.clean(this.post.body)
              }else{
                  return '';
              }
          }
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
    .p-post-text {
        flex: 1;
        font-size: 14px;
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        margin-bottom: 2em;
    }
    .p-item-title {
        font-size: 19px;
    }
    .p-item-main {
        justify-content: flex-start;
    }
    .p-post-image {
        height: 120px;
        width: auto;
        margin-bottom: 1em;
    }
</style>
