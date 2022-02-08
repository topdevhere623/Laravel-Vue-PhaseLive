<template>
    <div class="message-thread">
        <div class="avatar-wrap">
            <avatar :size="98" :src="getReceiver(thread, 'avatar')" :labels="{tr: { text: 'Admin', color: 'blue' }}"></avatar>
        </div>
        <div class="detail">
            <div class="info-top">
                {{ getReceiver(thread, 'name') }} <small>{{ moment(thread.last_message.date.date).calendar() }}</small>
            </div>
            <div class="message">
                {{ thread.last_message.body }}
            </div>
            <div class="actions">
                <div class="action">
                    <like-button :likeable="thread" @like="liked" @unlike="unliked"></like-button>
                </div>
                <div class="action">
                    <router-link :to="{ path: `/user/thread/${thread.id}`}">Reply</router-link>
                </div>
                <div class="action">
                    <router-link :to="{ path: `/user/thread/${thread.id}`}">Expand</router-link>
                </div>
                <!-- <div class="action">
                    <i class="fa fa-image"></i>
                </div> -->
                <div class="action">
                    <report-button :reportable="thread" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LikeButton from 'global/actions/like-button';
    import ReportButton from 'global/actions/report-button';
    //import Component from '../';
    import { mapState } from 'vuex';

    export default {
        props: {
            thread: {
                // type: Object,
                required: true,
            }
        },
        data () {
            return {
                moment: window.moment,
            }
        },
        computed: {
            otherUser: function() {
                if(this.$store.state.app.user.id === this.thread.sender.id) {
                    return this.thread.receiver;
                } else {
                    return this.thread.sender;
                }
            },

            ...mapState([
                'app',
                'messenger'
            ])
        },
        methods: {
            // THIS IS REPEATED PLEASE MOVE TO SOMEWHERE GLOBAL
            getReceiver(thread, property = null) {
                const result = thread.users.filter(user => {
                    const userID = this.app.user.id;
                    return user.id != userID;
                });

                user = result.shift();
                if (property) return user[property];
                return user;
            },
            liked() {
                this.thread.is_liked = true;
                this.thread.likes_count += 1;
            },
            unliked() {
                this.thread.is_liked = false;
                this.thread.likes_count -= 1;
            }
        },
        components: {
            LikeButton,
            ReportButton
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .message-thread {
        height: 150px;
        padding: 22px;
        box-sizing: border-box;
        width: 100%;
        background: $color-grey;
        display: flex;
        align-items: center;
        justify-content: flex-start;

        .avatar-wrap {
            padding-right: 45px;

            img {
                width: 98px;
                height: 98px;
                border-radius: 100%;
            }
        }
        .detail {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
        }
        .info-top {
            color: $color-blue;
            font-size: 15px;
            font-weight: bold;

            small {
                font-size: 9px;
                color: $color-grey2;
            }
        }
        .message {
            font-size: 11px;
        }
        .actions {
            width: 30%;
            font-size: 11px;
            font-weight: bold;

            display: flex;
            align-items: center;
            justify-content: flex-start;
            .action {
                padding: 0 8px 0 0;
            }
        }

        &:nth-child(2n) {
            background: white;
        }
    }
</style>