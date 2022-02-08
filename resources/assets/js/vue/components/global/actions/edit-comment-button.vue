<template>
    <span class="report-button" v-if="app.user.loggedin" :title="'Edit ' + comment.type" @click="showEditCommentModal" :class="{ hidden: hidden }">
        <span>
            <i class="fas fa-pen"></i>
        </span>
    </span>
</template>

<script>
    //import Component from '../';
    import { mapState } from 'vuex';

    export default {
        name: 'edit-comment-button',
        props: {
            comment: { // This is the object e.g. 'track', 'release', 'comment'
                type: Object,
                required: true,
            },
            hidden: {
                type: Boolean,
                default: false,
            }
        },
        data () {
            return {

            }
        },
        computed: mapState([
            'app',
        ]),
        methods: {
            showEditCommentModal() {
                this.$modal.show('modal-edit-comment', { comment: this.comment });
            }
        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    .report-button {
        cursor: pointer;
    }
    .hidden {
        display: none;
    }
</style>