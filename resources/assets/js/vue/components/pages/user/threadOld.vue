<template>
    <div class="page-content-padded">
        <aside class="sidebar-left">
            <sidebar-group title="Notifications" :view-all="true" :items="[]"></sidebar-group>
        </aside>
        <div class="page-main single-thread-page" v-if="loaded">
            <div class="otheruser-data">
                <avatar :src="otherUser.avatar.files.original.url" :alt="otherUser.avatar.alt" :size="100" :center="false" />
                <h1 class="no-top">{{ otherUser.name }}</h1>
            </div>
            <div class="thread-messages" ref="messages" @scroll="messagesScrolled">
                <div class="thread-message-row" v-for="message in messages.data">
                    <div class="thread-message" :class="messageClass(message)">
                        <div class="message-avatar">
                            <avatar :src="getMessageUser(message).avatar.files.original.url" :alt="getMessageUser(message).avatar.alt" :size="40" />
                        </div>
                        <div class="message-body">
                            {{ message.body }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="thread-respond">
                <add-text type="message" :thread="this.thread" @success="replied"></add-text>
            </div>
        </div>
        <div class="page-main" v-else>
            <spinner style="margin: 3em auto;"
                     :animation-duration="1000"
                     :size="60"
                     color="black"
            />
        </div>
        <aside class="sidebar-right">
            <sidebar-group title="Followed" :view-all="true" :items="[]"></sidebar-group>
            <sidebar-group title="Favourites" :view-all="true" :items="[]"></sidebar-group>
        </aside>
    </div>
</template>

<script>
    import { HalfCircleSpinner as Spinner } from 'epic-spinners'

    import AddText from 'global/add-text/add-text';
    import SidebarGroup from 'global/sidebar-group';
    import MessageThread from './messages/message-thread';
    import PhButton from 'global/ph-button';

    export default {
        data () {
            return {
                loaded: false,
                composing: false,
                thread: null,

                messages: {
                    data: [],
                    currentPage: 0,
                    lastPage: 1,
                }
            }
        },
        computed: {
            otherUser: function() { // Get the other user who is in the thread
                if(this.loaded) {
                    if (this.$store.state.app.user.id === this.thread.sender.id) {
                        return this.thread.receiver;
                    } else {
                        return this.thread.sender;
                    }
                }
            },
        },
        mounted: function() {
            this.fetchThread().then(() => {
                this.fetchMessages();
            });
        },
        beforeRouteUpdate() {
            this.reset();
            this.fetchThread().then(() => {
                this.fetchMessages();
            });
        },
        methods: {
            fetchThread() {
                this.thread = null;
                return new Promise((resolve, reject)=> {
                    axios.get('/api/thread/' + this.$route.params.threadid).then(response => {
                        this.thread = response.data;
                        this.loaded = true;
                        resolve();
                    });
                });
            },
            messagesScrolled() {
                if(this.$refs.messages.scrollTop < 150) {
                    this.fetchMessages()
                }
            },
            scrollToBottom() {
                this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
            },
            fetchMessages() {
                if(this.messages.currentPage < this.messages.lastPage) {
                    this.messages.currentPage += 1;

                    axios.get('/api/thread/' + this.$route.params.threadid + '/messages?page=' + this.messages.currentPage).then(response => {
                        this.messages.lastPage = response.data.last_page;
                        this.messages.data.unshift(...response.data.data.reverse());
                        if(this.messages.currentPage === 1) {
                            setTimeout(() => {
                                this.scrollToBottom();
                            }, 0);
                        }
                    });
                }
            },
            messageClass(message) { // Decide whether to apply the 'mine' or 'not-mine' class to a message.
                if(message.user_id === this.$store.state.app.user.id) {
                    return 'mine';
                } else {
                    return 'not-mine';
                }
            },
            getMessageUser(message) {
                if(message.user_id === this.thread.sender.id) {
                    return this.thread.sender;
                } else {
                    return this.thread.receiver;
                }
            },
            replied(event) {
                this.messages.data.push(event);
                this.scrollToBottom();
            },
            reset() {
                this.loaded = false;
                this.composing = false;
                this.thread = null;
                this.messages = {
                    data: [],
                    currentPage: 0,
                    lastPage: 1,
                }
            }
        },
        components: {
            Spinner,
            AddText,
            SidebarGroup,
            MessageThread,
            PhButton,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .single-thread-page {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .otheruser-data {
        display: flex;
        align-items: center;
        margin-bottom: 1em;

        h1 {
            margin: 0 0 0 0.5em;
        }
    }

    .user-messages-container {
        margin: 3em 0;
    }
    .thread-messages {
        overflow: scroll;
        flex: 1;
        max-height: 50vh;
        padding-right: 10px;
        //box-shadow: 0 -5px 5px -5px #333;

        /*
        &::-webkit-scrollbar {
            appearance: none;
            width: 7px;
            max-width: 7px;
            height: 100%;
        }
        &::-webkit-scrollbar-track {
            background: $color-grey;
        }
        */
        &::-webkit-scrollbar-thumb {
            background: $color-2;
        }
    }
    .thread-message-row {
        width: 100%;
        overflow: auto;
        margin: 1em 0;
    }
    .thread-message {
        display: flex;
        justify-content: space-between;
        max-width: 80%;
        padding: 1em;
        border-radius: 20px;

        &.mine {
            float: right;
            background: $color-grey;

            .message-avatar {
                order: 2;
                margin-left: 1em;
            }
            .message-body {
                order: 1;
            }
        }
        &.not-mine {
            float: left;

            .message-avatar {
                margin-right: 1em;
            }
        }
    }
    .message-body {
        line-height: 130%;
    }
</style>