<template>
    <div class="slideout-wrap">
        <div id="slideout-menu" class="slideout-menu">
            <div class="slideout-top" id="slideout-close" @click="toggle">
                <close-icon class="float-right" />
            </div>

            <navigation-list
                @menuClicked="toggle"
                :items="navigation.slideout_menu"
            />

            <div v-if="$store.state.app.user.loggedIn">
                <hr>
                <ul>
                    <li
                            v-if="
                                $store.state.app.user.roles[0].name == 'admin'
                            "
                    >
                        <a href="/admin">Admin</a>
                    </li>
                    <li>
                        <a href="/#" @click="logout">
                            Sign out
                        </a>
                    </li>
                </ul>
            </div>

            <div class="slideout-social">
                <div class="social-icon">
                    <a href="https://instagram.com" target="_blank"
                        ><i class="fab fa-instagram"></i
                    ></a>
                </div>
                <div class="social-icon">
                    <a href="https://facebook.com" target="_blank"
                        ><i class="fab fa-facebook-f"></i
                    ></a>
                </div>
                <div class="social-icon">
                    <a href="https://twitter.com" target="_blank"
                        ><i class="fab fa-twitter"></i
                    ></a>
                </div>
            </div>
        </div>

        <!--        <div class="slideout-wrap__overlay" @click="toggle"></div>-->
    </div>
</template>

<script>
    import { mapGetters, mapState } from "vuex";
    import NavigationList from "../helpers/navigation-list.vue";
    import CloseIcon from "global/close-icon";

    export default {
        components: {
            CloseIcon,
            NavigationList
        },

        computed: {
            ...mapGetters({ navigation: "app/getNavigation" })
        },

        methods: {
            toggle() {
                this.$emit("slideoutToggle");
            },
            logout: function() {
                this.loggingOut = true;
                var self = this;
                axios.get("/api/auth/logout").then(function(response) {
                    self.loggingOut = false;
                    self.$store.commit("app/unsetUser");
                    self.$router.push("/");
                });
                this.$emit("slideoutToggle");
            }
        }
    };
</script>

<style lang="scss" scoped>
    // menu
    .slideout-menu {
        position: fixed;
        top: 0;
        bottom: 0;
        width: 400px;
        min-height: 100vh;
        overflow-y: scroll;
        z-index: 5000;
        background:#fff;
        box-shadow: 0 0 10px 2px rgba(0,0,0,0.3);
    }

    // clickable overlay
    .slideout-wrap__overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        cursor: pointer;
    }

    // wrapper
    .slideout-wrap {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
