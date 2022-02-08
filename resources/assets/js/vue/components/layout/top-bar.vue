<template>
    <div id="nav_wrapper">
        <header class="top-bar" :class="{ searching: search.visible }">
            <div
                class="search-toggle"
                @click="toggleSearch"
                :class="searchClass"
            >
                <i class="fa fa-search"></i>
            </div>

            <form v-if="search.visible">
                <input
                    type="text"
                    placeholder="START SEARCH BY TYPING ARTIST, ALBUM, GENRE, CLASS OR KEY TAGS"
                    v-model="searchTerm"
                    v-on:keydown.enter.prevent=""
                />
            </form>

            <router-link class="logo" to="/" v-if="!search.visible">
                <logo
                    style="width: 183px;"
                    :color="logoColor"
                />
                <!--            <p class="tagline">-->
                <!--                {{ app.settings['logo_title'] }}-->
                <!--            </p>-->
            </router-link>

            <div
                class="user-actions"
                :class="{ 'right-padded': !app.user.loggedin }"
                v-if="!search.visible"
            >
                <ph-button
                    :color="buttonClass"
                    other="thick"
                    @click.native="showAuthModal"
                    v-if="!app.user.loggedin"
                >
                    Create Account
                </ph-button>

                <ph-button
                    v-if="!app.user.loggedin"
                    :color="buttonClass"
                    other="thick"
                    @click.native="$modal.show('modal-auth-login')"
                    >Sign In</ph-button
                >

                <ph-button
                    other="thick"
                    @click.native="logout"
                    :loading="loggingOut"
                    v-else
                >
                    Logout
                </ph-button>
            </div>
        </header>
        <header class="responsive">
            <div
                class="top"
                id="mobile-toggle"
                @click="$emit('slideoutToggle')"
            >
                <div class="top mobile-toggle">
                    <i class="fa fa-bars"></i>
                </div>
            </div>

            <router-link class="logo" to="/" v-if="!search.visible">
                <logo style="width: 145px;" />
            </router-link>

            <div
                class="search-toggle"
                @click="toggleSearch"
                :class="searchClass"
            >
                <i class="fa fa-search"></i>
            </div>

            <form v-if="search.visible">
                <input
                    type="text"
                    placeholder="SEARCH"
                    v-model="searchTerm"
                    v-on:keydown.enter.prevent=""
                />
            </form>
        </header>
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import PhButton from "global/ph-button";
    import Logo from "global/logo";
    import { PlayerEvents } from "../../event-bus";

    export default {
        data() {
            return {
                loggingOut: false,
                searchTerm: "",
                path: ""
            };
        },
        computed: {
            ...mapState(["app", "search"]),
            buttonClass() {
                return this.$route.path === "/" ? "white-border" : ""
            },
            logoColor() {
                if (this.app.user.loggedin) {
                    return 'black'
                } else if (this.$route.path === "/") {
                    return 'white'
                } else {
                    return 'black'
                }
            },
            searchClass() {
                let classes = [];
                if (this.search.visible) {
                    classes.push("searching");
                }
                if (this.$route.path === "/" && !this.app.user.loggedin) {
                    classes.push("white");
                }

                return classes;
            }
        },
        watch: {
            searchTerm(newSearchTerm) {
                // When our local search term updates, update vuex
                this.$store.commit("search/setSearchTerm", newSearchTerm);
            }
        },
        created: function() {
            this.path = this.$route.path;
        },
        methods: {
            toggleSearch: function() {
                this.$store.commit("search/toggleSearch");
            },
            showAuthModal: function() {
                this.$modal.show("modal-auth-register");
            },
            logout: function() {
                this.loggingOut = true;
                this.$store.commit('player/setPlaying', false);
                PlayerEvents.$emit('pause')
                var self = this;
                axios.get("/api/auth/logout").then(function(response) {
                    self.loggingOut = false;
                    self.$store.dispatch("cart/reset");
                    self.$store.commit("app/unsetUser");
                    self.$router.push("/");
                });
            }
        },
        components: {
            PhButton,
            Logo
        }
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    #nav_wrapper {
        z-index: 100;
        header.top-bar {
            @media (max-width: 1000px) {
                display: none;
            }

            height: 80px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 20;

            &.searching {
                background: white;
                justify-content: flex-start;
                border-bottom: 1px solid $color-secondary;
            }

            .search-toggle {
                font-size: 2rem;
                width: 80px;
                height: 80px;
                line-height: 80px;
                box-sizing: border-box;
                cursor: pointer;
                color: $color-primary;
                flex: 1;
                padding-left: 1em;
                &.white {
                    color: white;
                }

                &.searching {
                    text-align: center;
                    padding-left: 0;
                    flex: initial;
                    background: white;
                    color: $color-primary;
                    border-right: 1px solid $color-secondary;
                }
            }
            .logo {
                display: block;
                text-decoration: none;
                color: initial;
                flex: 3;
                text-align: center;

                p {
                    font-weight: bold;
                    margin-left: 93px;
                    margin-top: -14px;
                }
            }
            .user-actions {
                display: flex;
                flex: 1;
                justify-content: flex-end;
                div:first-of-type {
                    padding-right: 1em;
                }
                &.right-padded {
                    padding-right: 2em;
                }
            }
        }
        header.responsive {
            justify-content: space-between;
            background: white;
            padding: 20px;
            opacity: 0;
            display: none;
            @media (max-width: 1000px) {
                display: flex;
                align-items: center;
                opacity: 1;
                transition: 1s cubic-bezier(0.55, 0.085, 0.68, 0.53);
            }

            svg {
                &:hover {
                    cursor: pointer;
                }
            }

            .mobile-toggle {
                svg {
                    width: 50px;
                    height: 32px;
                    margin-left: -11px;
                }
            }

            .search-toggle {
                svg {
                    height: 35px;
                    width: 27px;
                }
            }
        }
    }
</style>
