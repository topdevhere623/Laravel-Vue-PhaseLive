<template>
    <div>
        <div v-if="user">
            <user-profile-pro v-if="isPro" :user="user" />
            <user-profile-fan v-else :user="user" />
        </div>
    </div>
</template>

<script>
    import store from 'store';

    import UserProfileFan from './profile/profile-fan';
    import UserProfilePro from './profile/profile-pro';

    export default {
        data () {
            return {
                user: null,
            }
        },
        beforeRouteEnter (to, from, next) {
            store.dispatch('news/requireArticles');
            // if(to.params.path === store.state.app.user.path) { // If the authenticated user is requesting their own profile
            //     next(vm => {
            //         vm.setUser(store.state.app.user)
            //     });
            // } else {
                next(vm => {
                    vm.fetchUser(to.params.path).then(user => {
                        vm.setUser(user);
                    })
                });
            // }
        },
        beforeRouteUpdate (to, from, next) {
            this.user = null;
            this.fetchUser(to.params.path).then(user => {
                this.setUser(user);
                next();
            });
        },
        computed: {
            isPro: function() {
                return (this.user.account_type === 'pro')
            }
        },
        created: function() {

        },
        methods: {
            fetchUser(path) {
                return new Promise(function(resolve, reject) {
                    let appUserID = (store.state.app.user) ? store.state.app.user.id : '';
                    axios.get('/api/user/' + path+'?app-user='+appUserID).then(response => {
                        resolve(response.data);
                    });
                }.bind(this));
            },
            setUser(user) {
                this.user = user;
            },
        },
        components: {
            UserProfileFan,
            UserProfilePro,
        }
    }
</script>

<style lang="scss">
    .page-profile-pro, .page-profile-fan {
        .sidebar-group-subtitle {
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
        }
        .profile-action {
            cursor: pointer;
            margin-right: 20px;
        }
        .profile-social {
            font-size: 20px;
            padding: 1em 0 1px;
            overflow: auto;
        }
        .profile-social-item {
            lost-column: 1/5;
        }
    }
</style>
