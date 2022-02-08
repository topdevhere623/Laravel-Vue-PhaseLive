<template>
    <ph-panel id="notifications">
        <h2>Email Notifications</h2>
        <hr />
        <div v-if="loaded">
            <div class="options-container">
                <div class="options-column">
                    <h3>Activities</h3>
                    <ul>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.activity_follower_on_me_email" />
                                New Follower
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.activity_share_on_mine_email" />
                                Share my post
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.activity_post_from_followee_email" />
                                New post from someone I follow
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.activity_like_on_mine_email" />
                                New like on my post
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.activity_comment_on_mine_email" />
                                New comment on my post
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.activity_message_email" />
                                New message
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="options-column">
                    <h3>Phase News and Offers</h3>
                    <ul>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.phase_new_features_email" />
                                New Phase features
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.phase_surveys_feedback_email" />
                                Surveys and feedback
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.phase_tips_offers_email" />
                                Phase tips and offers
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" v-model="options.phase_newsletter_email" />
                                Phase newsletter
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <ph-button size="medium" @click.native="save" :loading="submitting">Save</ph-button>
        </div>
        <spinner style="margin: 3em auto;"

                 v-else
                 :animation-duration="1000"
                 :size="60"
                 :color="'black'"
        />
    </ph-panel>
</template>

<script>
    import { HalfCircleSpinner as Spinner } from 'epic-spinners'

    export default {
        data () {
            return {
                loaded: false,
                submitting: false,
                options: {
                    activity_follower_on_me_email: false,
                    activity_share_on_mine_email: false,
                    activity_post_from_followee_email: false,
                    activity_like_on_mine_email: false,
                    activity_comment_on_mine_email: false,
                    activity_message_email: false,
                    phase_new_features_email: false,
                    phase_surveys_feedback_email: false,
                    phase_tips_offers_email: false,
                    phase_newsletter_email: false,
                }
            }
        },
        computed: {

        },
        mounted: function() {
            this.fetch();
        },
        methods: {
            fetch() {
                this.loaded = false;
                axios.get('/api/account/notifications').then(response => {
                    for (var property in response.data) {
                        response.data[property] = !!response.data[property];
                    }
                    this.options = response.data;
                }).finally(() => {
                    this.loaded = true;
                });
            },
            save() {
                this.submitting = true;
                axios.post('/api/account/notifications', this.options).then(response => {
                    this.$notify({
                        group: 'main',
                        type: 'success',
                        title: 'Sucessfully saved notification settings',
                    });
                }).catch(() => {
                    this.$notify({
                        group: 'main',
                        type: 'error',
                        title: 'Error saving notification settings. Please try again later',
                    });
                }).finally(() => {
                    this.submitting = false;
                });
            }
        },
        components: {
            Spinner
        }
    }
</script>

<style lang="scss" scoped>
    .options-container {
        margin: 15px 0;
        overflow: auto;
    }
    .options-column {
        lost-column: 1/2;
    }
    li {
        margin: 5px 0;
    }
</style>
