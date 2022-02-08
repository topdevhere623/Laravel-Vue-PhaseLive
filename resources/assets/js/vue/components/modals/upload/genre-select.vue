<template>
    <div class="genre-select">
        <input
            type="text"
            :placeholder="
                selectedGenres.length < max
                    ? 'Minimum of ' + min + ', maximum of ' + max + ' genres'
                    : 'Maximum number of genres reached'
            "
            v-model="searchTerm"
            @input="input"
            @keyup.down="onArrowDown"
            @keyup.up="onArrowUp"
            @keyup.enter="onEnter"
            @keydown.enter.prevent=""
            :disabled="selectedGenres.length >= max || disabled"
        />
        <ul v-show="showList" class="search-results">
            <li
                v-for="(genre, i) in searchResults"
                :key="i"
                @click="selectGenre(genre)"
                @mouseover="arrowCounter = i"
                :class="{ highlighted: i === arrowCounter }"
            >
                {{ genre.name }}
            </li>
        </ul>
        <p v-if="selectedGenres.length > 0">
            Click on a genre to remove it
        </p>
        <ul v-show="selectedGenres.length > 0" class="selected-genres">
            <li
                v-for="(genre, i) in selectedGenres"
                :key="i"
                @click="removeGenre(genre)"
            >
                {{ genre.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    import { mapState } from "vuex";
    //import Component from '../';
    export default {
        props: {
            min: {
                type: Number,
                default: 1
            },
            max: {
                type: Number,
                default: 3
            },
            disabled: {
                type: Boolean
            },
            populated: {
                type: Array,
                default: function() {
                    return [];
                }
            }
        },
        data() {
            return {
                searchTerm: "",
                searchResults: [],
                showList: false,
                selectedGenres: [],
                arrowCounter: -1
            };
        },
        created() {
            this.selectedGenres = this.populated;
        },
        computed: mapState(["app"]),
        mounted: function() {
            this.$store.dispatch("app/fetchGenres");
        },
        methods: {
            input: function() {
                if (this.searchTerm.length > 0) {
                    this.showList = true;
                    this.search();
                } else {
                    this.showList = false;
                }
            },
            search: function() {
                this.searchResults = [];
                _.forEach(this.app.genres, (genre) => {
                    if (
                        genre.name
                            .toLowerCase()
                            .includes(this.searchTerm.toLowerCase())
                    ) {
                        // If genre name includes search term
                        if (
                            !_.find(this.selectedGenres, (g) => {
                                return g.id === genre.id;
                            })
                        ) {
                            // If genre is not already selected
                            this.searchResults.push(genre);
                        }
                    }
                });
            },
            selectGenre: function(genre) {
                this.arrowCounter = -1;
                this.searchTerm = "";
                this.input();
                this.selectedGenres.push(genre);
                this.$emit("change", this.selectedGenres);
            },
            removeGenre: function(genreToDelete) {
                this.selectedGenres = _.filter(this.selectedGenres, (genre) => {
                    return genre.id !== genreToDelete.id;
                });
                this.input();
                this.$emit("change", this.selectedGenres);
            },
            onArrowDown: function() {
                if (this.arrowCounter + 1 < this.searchResults.length) {
                    this.arrowCounter += 1;
                }
            },
            onArrowUp: function() {
                if (this.arrowCounter > 0) {
                    this.arrowCounter -= 1;
                }
            },
            onEnter: function() {
                if (this.arrowCounter >= 0) {
                    this.selectGenre(this.searchResults[this.arrowCounter]);
                }
            }
        },
        components: {}
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .genre-select {
        ul.search-results {
            background: white;
            border-left: 1px solid $color-grey2;
            border-right: 1px solid $color-grey2;
            border-bottom: 1px solid $color-grey2;

            li {
                padding: 5px;
                cursor: pointer;

                &.highlighted {
                    background: darken(white, 5);
                }

                .active {
                }
            }
        }
        p {
            margin: 5px 0;
            color: $color-grey2;
            font-size: 10px;
        }
        ul.selected-genres {
            margin: 5px 0;

            li {
                display: inline-block;
                padding: 5px;
                margin-right: 5px;
                cursor: pointer;
                background: darken(white, 15);
                border-radius: 5px;

                &:hover {
                    background: darken(white, 20);
                }
            }
        }
        input {
            box-sizing: border-box;
            font-size: inherit;
            border: 1px solid $color-grey2;
            padding: 5px;
            border-radius: 2px;
            width: 100%;
        }
    }
</style>
