<template>
    <div>
        <close-icon
            v-if="search.visible"
            id="close"
            @click.native="toggleSearch"
            :class="{ searching: search.visible }"
        ></close-icon>

        <ul v-else class="misc-buttons">
            <!-- <li v-if="!app.user.loggedin">
                <ph-button
                    other="thick"
                    @click.native="$modal.show('modal-auth-login')"
                    color="white"
                    >Sign In</ph-button
                >
            </li> -->

            <li
                v-if="app.user.loggedin"
                v-click-outside="() => (dropdown = false)"
            >
                <span @click="toggleNav">
                    <i class="fa fa-ellipsis-h fa-2x"></i>
                </span>

                <div class="dropdown" :class="{ open: dropdown }">
                    <ul>
                        <li @click="dropdown = false">
                            <router-link :to="{ name: 'account_default' }">
                                My Account
                            </router-link>
                        </li>
                        <li @click="dropdown = false">
                            <a @click="showCart" href="#">
                                My Cart
                            </a>
                        </li>
                        <hr />
                        <li @click="dropdown = false">
                            <router-link :to="'/user/' + app.user.path">
                                My Profile
                            </router-link>
                        </li>
                        <li @click="dropdown = false">
                            <router-link :to="{ name: 'mymusic' }">
                                My Music
                            </router-link>
                        </li>
                        <li @click="dropdown = false">
                            <router-link to="/user/messages">
                                Private Messages
                            </router-link>
                        </li>
                        <hr />
                        <li @click="dropdown = false">
                            <router-link :to="{ name: 'help' }">
                                Help & Support
                            </router-link>
                        </li>
                        <li
                            @click="dropdown = false"
                            v-if="
                                $store.state.app.user.roles[0].name == 'admin'
                            "
                        >
                            <a href="/admin">Admin</a>
                        </li>
                        <!-- <li @click="dropdown = false">
                            <a href="/#" @click="logout">
                                Sign out
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import CloseIcon from "global/close-icon";
    export default {
        data() {
            return {
                dropdown: false
            };
        },
        computed: mapState(["app", "search"]),
        created: function() {},
        methods: {
            toggleSearch: function() {
                this.$store.commit("search/toggleSearch");
            },
            toggleNav() {
                this.dropdown = !this.dropdown;
            },
            showCart: function() {
                this.$modal.show("modal-cart");
            },
            logout: function() {
                // this.loggingOut = true;
                var self = this;
                axios.get("/api/auth/logout").then(function(response) {
                    // self.loggingOut = false;
                    self.$store.commit("app/unsetUser");
                });
            }
        },
        components: {
            CloseIcon
        }
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .searching {
        border-bottom: 1px solid $color-secondary;
    }

    .misc-buttons {
        list-style: none;
        padding: 25px 0 0;
        margin: 0;
        text-align: center;
        position: relative;

        li {
            display: inline-block;
        }
    }

    .account-button {
        color: $color-blue;
    }
    .fa-ellipsis-h {
        color: $color-blue;
        cursor: pointer;
    }
    .dropdown {
        background: $color-grey;
        position: absolute;
        right: 20px;
        top: 80px;
        font-size: 12px;
        padding: 10px;
        text-align: left;
        width: 120px;
        max-height: 0;
        transition: all 0.4s ease;
        visibility: hidden;
        opacity: 0;
        &.open {
            max-height: 300px;
            visibility: visible;
            opacity: 1;
            filter: drop-shadow(0px 5px 5px rgba(0,0,0,.3));

            ul {
                max-height: 300px;
                visibility: visible;
            }
        }

        ul {
            display: flex;
            flex-direction: column;
            transition: all 0.4s ease;
            max-height: 0;
            visibility: hidden;

            hr {
                border: 1px solid #000;
                width: 90%;
            }

            a {
                text-decoration: none;
                padding: 5px 0;
                display: block;
            }
        }
    }
</style>
