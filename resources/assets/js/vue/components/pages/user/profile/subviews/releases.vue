<template>
    <div>
        <spinner
            style="margin: 3em auto;"
            :animation-duration="1000"
            :size="60"
            color="black"
            v-if="loading"
        />

        <div v-if="releases.length > 0">
            <item
                v-for="release in releases"
                :item="release"
                :key="release.id"
            />
        </div>

        <div v-if="!releases.length && !loading">
            <p>No releases yet</p>
        </div>

        <div class="centered-text loadMoreButton" v-if="releases.length && !loading && moreToFetch">
            <ph-button size="large" @click.native="getNextPage" :loading="fetchingMore">
                Show Me More
            </ph-button>
        </div>
    </div>
</template>

<script>
import ProfileMixin from '../profile-mixin';
import { HalfCircleSpinner as Spinner } from 'epic-spinners';
import Item from 'global/items/item';
import PhButton from 'global/ph-button';

export default {
    props: ['user'],

    data () {
        return {
            loading: false,
            fetchingMore: false,
            releases: [],
            pagination: {},
        }
    },

    created() {
        this.getInitialState();
    },

    computed: {
        pageUrl() {
            return this.pagination.next_page_url ||  `/api/user/${this.user.id}/releases?page=1`;
        },

        moreToFetch() {
            // Check the properties exist and they are equal. If they are equal we are on the last page
            return this.pagination.to && this.pagination.total && this.pagination.to != this.pagination.total;
        }
    },

    methods: {
        async getInitialState() {
            this.loading = true;
            await this.fetchReleases('initial');
            this.loading = false;
        },

        async getNextPage() {
            this.fetchingMore = true;
            await this.fetchReleases('newPage');
            this.fetchingMore = false;
        },

        async fetchReleases(type) {
            try {
                const { data: { data: releases, ...pagination } } = await axios.get(this.pageUrl);
                this.pagination = pagination;

                if (type === 'initial') { // Set the state
                    this.releases = releases;
                } else { // Append results dont overwrite it
                    this.releases = [
                        ...this.releases,
                        ...releases
                    ]
                }
            } catch (e) {
                this.$notify({
                    group: 'main',
                    type: 'error',
                    title: 'Unable to fetch releases',
                });
            }
        }
    },

    mixins: [
        ProfileMixin
    ],

    components: {
        Item,
        Spinner,
        PhButton
    }
}
</script>

<style lang="scss" scoped>
    .loadMoreButton {
        margin: 4em 0;
    }
</style>
