import { mapState } from 'vuex';
import { UserEvents } from "events";

export default {
    props: {
        user: {
            type: Object,
            required: true,
        }
    },
    data () {
        return {
            mutableUser: this.user,
            loadingActivity: false,
            activity: [],
        }
    },
    computed: {
        ...mapState([
            'news',
        ]),
        isMe: function() {
            return this.user.id === this.$store.state.app.user.id;
        }
    },
    created: function() {
        UserEvents.$on('avatar-updated', avatar => {
            this.mutableUser.avatar = avatar;
            this.fetchActivity();
        });
        UserEvents.$on('banner-updated', banner => {
            this.mutableUser.banner = banner;
            this.fetchActivity();
        });
    },
    methods: {
        followStatusUpdated(followStatus) {
            this.mutableUser.followed = followStatus;
            if(followStatus) {
                this.mutableUser.follower_count += 1;
            } else {
                this.mutableUser.follower_count -= 1;
            }
        },
        fetchActivity() {
            this.loadingActivity = true;
            this.activity = [];
            axios.get('/api/user/' + this.user.id + '/activity').then(response => {
                this.activity = response.data;
            }).finally(() => {
                this.loadingActivity = false;
            });
        }
    }
}