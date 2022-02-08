<template>
    <span class="comment-button" v-if="app.user.loggedin" title="Comment" @click="showCommentModal">
        <span>
            <i class="fa fa-comment-alt"></i>
        </span>
    </span>
</template>

<script>
    import { SocialEvents } from "events";
    import { mapState } from 'vuex';

    export default {
        props: {
            commentable: { // This is the object e.g. 'track', 'release', 'article'
                type: Object,
                required: true,
            },
        },
        data () {
          return {
            mutableCommentable: this.commentable,
          }
        },
        computed: mapState(['app']),
      mounted() {
        SocialEvents.$on('commented', commentable => {
          if(commentable.id === this.mutableCommentable.id) {
            this.commented();
          }
        });
      },
        methods: {
            showCommentModal() {
                this.$modal.show('modal-comment', { commentable: this.commentable });
            },
            commented() {
              this.$emit('commented');
            }
        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .comment-button {
        cursor: pointer;
    }
</style>
