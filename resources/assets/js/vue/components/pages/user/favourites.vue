<template>
    <div class="page-content-padded">

        <div class="page-main">
            <h1 class="no-top">My Favourites</h1>
            <div v-if="favourites.length">
                <div class="filters">
                    <span
                        :class="{ active: filter === 'all' }"
                        class="filter"
                        @click="filter = 'all'"
                        >All</span>
                    <span
                        :class="{ active: filter === 'release' }"
                        class="filter"
                        @click="filter = 'release'"
                        >Releases</span>
                    <span
                        :class="{ active: filter === 'track' }"
                        class="filter"
                        @click="filter = 'track'"
                        >Tracks</span>
                    <span
                        :class="{ active: filter === 'news' }"
                        class="filter"
                        @click="filter = 'news'"
                        >News</span>
                </div>
                <div v-for="like in filteredFavourites" :key="like.id">
                    <item :item="like.likeable" />
                </div>

                <ph-button
                    @click.native="loadMore"
                    v-show="showLoadMore"
                    :loading="loading"
                    >Load More</ph-button>
            </div>
            <div v-else>
              No Favourites
            </div>

            <spinner
                style="margin: 3em auto;"
                :animation-duration="1000"
                :size="60"
                color="black"
                v-show="!favourites"
            />
        </div>

    </div>
</template>

<script>
import Item from "global/items/item";
import { mapState, mapGetters } from "vuex";
import SidebarGroup from "global/sidebar-group";
import NotificationGroup from "global/notification-group";
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import { UserEvents } from "../../../event-bus";

export default {
    name: "favourites",

    data() {
        return {
            favourites: null,
            page: 1,
            showLoadMore: true,
            loading: false,
            filter: "all",
            filteredFavourites: null
        };
    },

    watch: {
        filter(newFilter, oldFilter) {
            if (newFilter === "all") {
                return (this.filteredFavourites = this.favourites);
            }

            return (this.filteredFavourites = this.favourites.filter(
                fav => fav.likeable_type === newFilter
            ));
        },
        favourites(newValue) {
            this.filteredFavourites = newValue;
        }
    },

    computed: {
        ...mapState(["app", "news"]),
        ...mapGetters({ user: "app/getUser" })
    },

    async mounted() {
        await this.fetchFavourites();
        this.user.getFollowed();
        UserEvents.$on("globalUnlike", this.removeFav);
    },

    methods: {
        removeFav(item) {
            let likeable = this.favourites.map(fav => fav.likeable);

            this.favourites.splice(likeable.indexOf(item), 1);
        },
        async fetchFavourites() {
          const userId = this.$attrs.user ? this.$attrs.user.id : this.user.id
            axios
                .get(`/api/user/${userId}/favourites?page=${this.page}`)
                .then(response => {
                    this.loading = true;
                    this.favourites = this.favourites || [];
                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            this.favourites.push(item);
                            this.loading = false;
                        });
                    } else {
                        this.showLoadMore = false;
                        this.loading = false;
                    }
                    if (response.data.length < 10) {
                        this.showLoadMore = false;
                    }
                });
        },
        loadMore() {
            this.page++;
            this.fetchFavourites();
        }
    },

    components: {
        NotificationGroup,
        SidebarGroup,
        Spinner,
        Item
    }
};
</script>

<style lang="scss" scoped>
.filters {
    display: flex;

    .filter {
        cursor: pointer;
        margin-right: 20px;
        &.active {
            text-decoration: underline;
        }
    }
}
</style>
