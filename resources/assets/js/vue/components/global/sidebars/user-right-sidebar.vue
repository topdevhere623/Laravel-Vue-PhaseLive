<template>
    <div>
        <notification-group
            title="Notifications"
            v-if="user && currentUser && user.id == currentUser.id"
            :user="user"
        ></notification-group>
        <sidebar-group
            title="Followed"
            view-all="/user/followed"
            :items="user.following.slice(0, 5)"
        ></sidebar-group>
        <sidebar-group
            title="Favourites"
            :view-all="favouritesLink"
            :items="favourites.slice(0, 5)"
        ></sidebar-group>
        <sidebar-group
            v-if="this.user.plays"
            title="Recently Played"
            view-all="/user/recently-played"
            :items="this.user.plays.slice(0, 5)"
        ></sidebar-group>
        <sidebar-group
            title="News"
            view-all="/news"
            :items="news.articles.slice(0, 5)"
        ></sidebar-group>
    </div>
</template>

<script>
    import SidebarGroup from "global/sidebar-group";
    import NotificationGroup from "global/notification-group";
    import { UserEvents } from "events";

    export default {
        name: "user-right-sidebar",

        props: {
            user: {
                type: Object,
                required: true,
            },
            news: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                favourites: [],
                currentUser: {},
                items: [],
            };
        },

        mounted() {
            this.setFavourites();
            this.currentUser = window.currentUser;
            UserEvents.$on("globalLike", (likeable) => {
                this.favourites.push(likeable);
            });
            UserEvents.$on("globalUnlike", (likeable) => {
                this.removeFav(likeable);
            });
        },

        methods: {
            setFavourites() {
                this.user.likes.forEach((item) => {
                    this.favourites.push(item.likeable);
                });
                this.favourites.reverse();
            },
            removeFav(item) {
                let likeable = this.favourites.map((fav) => fav.likeable);
                this.favourites.splice(likeable.indexOf(item), 1);
            },
        },

      computed: {
          favouritesLink() {
            if (this.user.id !== this.currentUser.id) {
              return `/user/${this.user.path}/favourites`
            }

            return '/user/favourites'
          }
      },

        components: {
            SidebarGroup,
            NotificationGroup,
        },
    };
</script>

<style lang="scss" scoped></style>
