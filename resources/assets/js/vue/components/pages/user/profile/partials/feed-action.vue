<template>
    <div>
        <div class="feed-action" :class="index % 2 === 0 ? '' : 'alt'">
            <div class="action-info">
                <div>
<!--                    <img-->
<!--                        src="/img/phase-black.svg"-->
<!--                    />-->
                    <p v-if="type('user_followed_user')">
                        {{ thisUser.name }} started following
                        {{ action.item.name }}
                    </p>

                    <p
                        v-else-if="
                            type('user_posted_status_update') &&
                                action.created_by === thisUser.id
                        "
                    >
                        {{ thisUser.name }} posted
                    </p>
                    <p
                        v-else-if="
                            type('user_posted_status_update') &&
                                action.created_by !== thisUser.id
                        "
                    >
                        {{ action.item.user.name }} posted on
                        {{ thisUser.name }}'s profile
                    </p>
                    <p v-else-if="type('user_shared_item')">
                        {{ thisUser.name }} shared a
                        {{ action.item.shareable.type }}
                    </p>
                    <p v-else-if="type('user_avatar_updated')">
                        {{ thisUser.name }} uploaded a new avatar
                    </p>
                    <p v-else-if="type('user_uploaded_release')">
                        {{ thisUser.name }} uploaded a new release
                    </p>
                    <p v-else-if="type('user_liked_item')">
                        {{ thisUser.name }} liked this {{ action.item.type }}
                    </p>
                    <p v-else-if="type('user_created_event')">
                        {{ thisUser.name }} created a new event
                    </p>
                    <p v-else-if="type('user_created_merch')">
                        {{ thisUser.name }} created a new merch
                    </p>
                    <p v-else-if="type('user_uploaded_video')">
                        {{ thisUser.name }} uploaded a video
                    </p>
                    <p v-else-if="type('user_placed_order')">
                        {{ thisUser.name }} placed an order
                    </p>
                  <p v-else-if="type('user_submitted_report')">
                    {{ thisUser.name }} submitted {{action.item.type}}
                  </p>
                </div>
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.19 23.6"><title>Phase Icon</title><path d="M35.77,8.1a1.36,1.36,0,0,0-1.42,1.38v2.26H32V4.95a1.42,1.42,0,0,0-2.84,0v6.8H26.63V3.45a1.42,1.42,0,0,0-2.84,0v8.31H21.27V1.38a1.42,1.42,0,0,0-2.84,0V11.75H16V5.52a1.42,1.42,0,0,0-2.84,0v6.28H10.85V3.74A1.36,1.36,0,0,0,9.43,2.36,1.36,1.36,0,0,0,8,3.74v8H5.52v-4A1.36,1.36,0,0,0,4.1,6.39,1.36,1.36,0,0,0,2.68,7.77v4H0v4.18a1.36,1.36,0,0,0,1.42,1.38,1.36,1.36,0,0,0,1.42-1.38V12.07H5.39V20a1.36,1.36,0,0,0,1.42,1.38A1.36,1.36,0,0,0,8.23,20V12h2.32v6.28A1.36,1.36,0,0,0,12,19.62a1.36,1.36,0,0,0,1.42-1.38V12h2.39V22.21a1.42,1.42,0,0,0,2.84,0V12h2.5v8.2a1.42,1.42,0,0,0,2.84,0V12h2.49v6.8a1.42,1.42,0,0,0,2.84,0V12h2.45v2.26a1.42,1.42,0,0,0,2.84,0V12h2.61V9.49A1.36,1.36,0,0,0,35.77,8.1Z" fill="#f1f1f2"/><path d="M5.56,12.07V7.8A1.36,1.36,0,0,0,4.14,6.42,1.36,1.36,0,0,0,2.72,7.8v4.27Z" fill="#cff"/><path d="M10.84,12V3.77A1.36,1.36,0,0,0,9.42,2.39,1.36,1.36,0,0,0,8,3.77V12Z" fill="#9cf"/><path d="M16,12V5.55a1.42,1.42,0,0,0-2.84,0V12Z" fill="#66f"/><path d="M0,11.8v4.27a1.36,1.36,0,0,0,1.42,1.38,1.36,1.36,0,0,0,1.42-1.38V11.8Z" fill="#e0fcf9"/><path d="M5.38,11.8V20A1.36,1.36,0,0,0,6.8,21.37,1.36,1.36,0,0,0,8.21,20V11.8Z" fill="#9ff"/><path d="M10.56,11.8v6.4A1.36,1.36,0,0,0,12,19.59,1.36,1.36,0,0,0,13.4,18.2V11.8Z" fill="#9cc0ff"/><path d="M15.76,11.8V22.21a1.42,1.42,0,0,0,2.84,0V11.8Z" fill="blue"/></svg> -->
<!--                <div-->
<!--                    v-if="-->
<!--                        type('user_posted_status_update') ||-->
<!--                            type('user_uploaded_video')-->
<!--                    "-->
<!--                    style="display: flex;justify-content: flex-end;"-->
<!--                >-->
<!--                    <a class="delete_action" @click.prevent="deleteAction"-->
<!--                        >Delete</a-->
<!--                    >-->
<!--                </div>-->
            </div>
            <!-- <hr class="color-2" /> -->
            <item :item="action.item" :id="action.id" />
        </div>
    </div>
</template>

<script>
    import Item from "global/items/item";

    export default {
        props: {
            action: {
                type: Object,
                required: true,
            },
            thisUser: {
                type: Object,
                required: true,
            },
            index: {
                type: Number,
            },
        },
        data() {
            return {
                mutableUser: this.user,
                activity: [],
            };
        },
        methods: {
            type(check) {
                return this.action.event_type === check;
            },
            // deleteAction() {
            //     axios
            //         .post("/api/feed/" + this.action.id + "/delete")
            //         .then((response) => {
            //             this.$emit('delete-action')
            //         })
            //         .catch(function(error) {
            //             console.log(error);
            //         });
            // },
        },
        components: {
            Item,
        },
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .feed-action {
        margin: 1em 0;
        padding: 1em;
        background: #ffffff;

        &.alt {
            background: #e6e6e6;
        }
    }
    .action-info {
        margin-bottom: 0.5em;
        display: flex;
        justify-content: space-between;
        align-items: center;

        div {
            width: 70%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            p {
                font-size:12px;
            }
            img {
                margin-right:20px;
                filter: drop-shadow(2px 2px 1px rgba(0,0,0,0.3));
                width:50px;

            }
        }
    }
    .delete_action {
        background: #3300ff;
        border-color: #3300ff;
        color: white;
        padding: 7px 20px;
        border-radius: 25px;
        cursor: pointer;
    }

    .hide {
        display: none !important;
    }
</style>
