<template>
    <div class="discover">
        <filter-container>
            <genre-filter v-model="filters.genres" :single="true">
                <h3>
                    <span class="fa-layers fa-fw fa-lg">
                        <i class="fas fa-circle" style="color:#3300ff"></i>
                        <i class="fa-inverse fa-layers-text" data-fa-transform="shrink-6 down-1">1</i>
                    </span>
                    Choose your interest
                </h3>
            </genre-filter>
            <class-filter v-model="filters.classes" :single="true">
                <h3>
                    <span class="fa-layers fa-fw fa-lg">
                        <i class="fas fa-circle" style="color:#3300ff"></i>
                        <i class="fa-inverse fa-layers-text" data-fa-transform="shrink-6 down-1">2</i>
                    </span>
                    Select a Class
                </h3>
            </class-filter>
            <filter-filter v-model="filters.filter" :single="true">
                <h3>
                    <span class="fa-layers fa-fw fa-lg">
                        <i class="fas fa-circle" style="color:#3300ff"></i>
                        <i class="fa-inverse fa-layers-text" data-fa-transform="shrink-6 down-1">3</i>
                    </span>
                    Select a Filter
                </h3>
            </filter-filter>
        </filter-container>

        <div class="discover-results">
            <div class="discover-start" v-if="!filters.classes.length && !filters.genres.length && !filters.filter.length || !results && !loading">
                <div>
                    Choose from the filters on the left to discover new music
                </div>
            </div>
            <div v-else-if="results && (filters.classes.length || filters.genres.length || filters.filter.length)">
                <div class="discover-section">
                    <h2>Results</h2>
                    <div class="discover-row">
                        <div class="discover-result" v-for="album in results">
                            <release-tile :release="album" :size="150"></release-tile>
                        </div>
                    </div>
                </div>
                <div style="margin: 0 0 4em 0" class="centered-text" v-if="nextPageUrl">
                    <ph-button
                            size="medium"
                            color="blue2"
                            :loading="loadingNextPage"
                            @click.native="loadNextPage"
                    >Load More</ph-button>
                </div>
            </div>
            <div v-else>
                <spinner style="margin: 3em auto;"
                     :animation-duration="1000"
                     :size="60"
                     color="black"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import { BreedingRhombusSpinner as Spinner } from 'epic-spinners';
    import FilterContainer from 'global/filters/filter-container';
    import ClassFilter from 'global/filters/class-filter';
    import GenreFilter from 'global/filters/genre-filter';
    import FilterFilter from 'global/filters/filter-filter';
    import ReleaseTile from 'global/releases/release-tile';

    export default {
        name: "dis",

        components: {
            Spinner,
            FilterContainer,
            GenreFilter,
            ClassFilter,
            FilterFilter,
            ReleaseTile
        },

        data() {
            return {
                loading: false,
                filters: {
                    classes: [],
                    genres: [],
                    filter: []
                },
                results: null,
                nextPageUrl: null,
                loadingNextPage: false
            }
        },

        watch: {
            filters: {
                handler: function() {
                    this.getFilteredResults()
                },
                deep: true,
            }
        },

        methods: {
            getFilteredResults() {
                this.results = null;
                this.loading = true;
                axios.post('/api/dis', this.filters)
                    .then(response => {
                        this.results = response.data.data;
                        this.nextPageUrl = response.data.next_page_url;
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },

            loadNextPage() {
                this.loadingNextPage = true;
                axios.post('/api/dis' + this.nextPageUrl, this.filters)
                    .then(response => {
                        let newResults = [],
                            currentResults = this.results;
                        Object.entries(response.data.data).forEach(([key, item]) => {
                            newResults.push(item)
                        });
                        this.results = currentResults.concat(newResults);
                        this.nextPageUrl = response.data.next_page_url;
                        this.loadingNextPage = false;
                    })
            }
        }
    }
</script>

<style scoped lang="scss">
    .discover {
        padding: 1em;
    }
    .discover-start {
        display: flex;
        justify-content: center;
        padding-top: 100px;
        font-size: 25px;
        div {
            width: 50%;
            text-align: center;
        }
    }
    .discover-results {
        lost-column: 4/5 0 30px;
    }
    .discover-section {
        overflow: auto;
        padding-bottom: 30px;

        h2 {
            font-size: 40px;
        }
    }
    .discover-result {
        lost-column: 1/3;

        @media screen and (min-width: 1000px) {
            lost-column: 1/4;
        }
        @media screen and (min-width: 1450px) {
            lost-column: 1/5;
        }
        @media screen and (min-width: 1600px) {
            lost-column: 1/6;
        }
        @media screen and (min-width: 1650px) {
            lost-column: 1/7;
        }
    }
</style>