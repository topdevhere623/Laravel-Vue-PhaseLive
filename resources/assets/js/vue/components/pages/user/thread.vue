<template>
    <div class="page-content-padded">
        <aside class="sidebar-left">
            <sidebar-group title="Notifications" :view-all="true" :items="[]"></sidebar-group>
        </aside>
        
        <div class="page-main single-thread-page">
            <div class="thread-messages" id="messages">
                <div class="thread-message-row" v-for="message in currentThread.messages" :key="message.id">
                    <div class="thread-message" :class="didSendMessage(message)">
                        <div class="message-avatar">
                            <avatar :src="getMessageSender(message, 'avatar')" :size="40" />
                        </div>
                        <div class="message-body">
                            {{ message.body }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="thread-respond">
                <add-text type="message" @keydown.enter.prevent :thread="currentThread" @success="appendNewMessage($event)"></add-text>
            </div>
        </div>
        
        <aside class="sidebar-right">
            <sidebar-group title="Followed" :view-all="true" :items="[]"></sidebar-group>
            <sidebar-group title="Favourites" :view-all="true" :items="[]"></sidebar-group>
        </aside>
    </div>
</template>

<script>
    import SidebarGroup from 'global/sidebar-group';
    import { mapActions, mapState } from 'vuex';
    import store from 'store';
    import AddText from 'global/add-text/add-text';
    import { MessageEvents } from '../../../event-bus';
    
    export default {
        components: { SidebarGroup, AddText },

        computed: {
            ...mapState('messenger', [
                'currentThread'
            ]),

            ...mapState('app', [
                'user'
            ])
        },

        mounted() {
            MessageEvents.$on('newMessage', (data) => {this.appendNewMessage(data)});
        },

        created() {
            const id = this.$route.params.threadid;
            this.getCurrentThread(id);
        }, 

        watch: {
            currentThread: {
                handler() {
                    setTimeout(() => this.scrollToLatest(), 0)
                },

                deep: true
            },
            '$route.params.threadid': function (id) {
              store.dispatch('messenger/getCurrentThread',id).then(() => {
                  // setTimeout(() => this.scrollToLatest(), 0)
                });
            }
        },
        methods: {
            ...mapActions('messenger', [
                'getCurrentThread'
            ]),

            getMessageSender(message, field = null) {
                const users = this.currentThread.users;
               
                const user = users.filter(user => {

                          return user.id === message.sender;
                       });

                const result = user.shift();

                if (field) return result[field];
                
                return result;
            },

            didSendMessage(message) {
                const sender = this.getMessageSender(message);
                return sender.id === this.user.id ? 'mine' : 'not-mine';
            },

            scrollToLatest() {
                const wrapper = document.getElementById('messages');
                wrapper.scrollTo({ top: wrapper.scrollHeight, behavior: 'smooth' });
                // wrapper.scrollTop = wrapper.scrollHeight;
            },

            appendNewMessage(event) {
                this.currentThread.messages.push(event);
                // this.messages.push({
                //         body:this.message,
                //         date:new Date(),
                //         sender:this.app.user.id
                //     })
            }
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
        text-align: right;

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
            text-align: left;

            .message-avatar {
                margin-right: 1em;
            }
        }
    }
    .message-body {
        line-height: 130%;
    }
</style>
