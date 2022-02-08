<template>
    <div class="track-list">
        <table v-if="tracks.length">
            <tr class="header-row">
                <th></th>
                <th>Name</th>
                <th>Length</th>
                <th>Format</th>
                <th>Genres</th>
                <th>Key</th>
                <th>BPM</th>
                <th></th>
            </tr>
            <tr v-for="track in tracks" class="data-row" :key="track.id">
                <td>
                    <play-pause-button :track="track" :size="15" />
                </td>
                <td @click="trackClicked($event, track)">
                    {{ track.name }}
                </td>
                <td @click="trackClicked($event, track)">
                    {{ moment().startOf('day').seconds(track.length).format('mm:ss') }}
                </td>
                <td @click="trackClicked($event, track)">
                    WAV, MP3 (320kbps)
                </td>
                <td @click="trackClicked($event, track)">
                    <span v-for="(genre, index) in track.genres" :key="index">{{ genre.name }}<span v-if="track.genres[index + 1]">, </span></span>
                </td>
                <td v-html="$store.getters['app/getKeyByKey'](track.key).name" @click="trackClicked($event, track)">

                </td>
                <td @click="trackClicked($event, track)">
                    {{ track.bpm }}
                </td>
                <td v-if="getUserLoggedIn">
                    <add-to-cart-button :product="track" />
                </td>
            </tr>
        </table>
        <div v-else class="no-tracks">
            There are no available tracks for this release yet.
        </div>
    </div>
</template>

<script>
    import PlayPauseButton from "./play-pause-button";
    import AddToCartButton from 'global/add-to-cart-button';
    import { mapGetters } from 'vuex';

    export default {
        props: {
            tracks: {
                type: Array,
                required: true,
            }
        },
        data () {
            return {
                moment: window.moment,
                playing: false,
            }
        },
        computed: {
            ...mapGetters('app', [
                'getUserLoggedIn'
            ])
        },
        created: function() {

        },
        methods: {
            trackClicked(event, track) {
                this.$router.push({ name: 'track', params: { trackid: track.slug }})
            },
        },
        components: {
            PlayPauseButton,
            AddToCartButton,
        }
    }
</script>

<style lang="scss" scoped>

    @import "~styles/helpers/_variables.scss";

    .no-tracks {
        padding: 20px;
        text-align: center;
        color: rgba(0,0,0,.5);
    }
    .track-list {
        background: lighten($color-grey, 4);
        
        @media(max-width: 500px){
            margin: 0 calc(-48vw + 50%);
        }

    }
    table {
        width: 100%;
        font-size: 12px;

        @media(max-width: 575px){
            font-size: 10px!important;
        }

        @media(max-width: 445px){
            font-size: 9px!important;
        }

        tr.data-row {
            background: lighten($color-grey, 4);

            &:hover {
                background: darken($color-grey, 2);
            }

            &:nth-child(2n) {
                background: $color-grey;
            }

            td:not(:first-child) {
                cursor: pointer;
            }
            td {
                padding-top: 1.5em;
                padding-bottom: 1.5em;

                &:not(:first-child):before {
                    color: white;
                    content: '|';
                    font-size: 1.5em;
                    position: relative;
                    left: -3px;

                    @media(max-width: 360px){
                        content: none!important;
                    }
                }

                @media(max-width: 600px){
                    &:nth-child(5n){
                        display: none;
                    }

                    &:nth-child(6n){
                        display: none;
                    }

                    &:nth-child(7n){
                        display: none;
                    }
                
                }
            }
        }
        th {
            text-align: left;
            padding: 2em 0;

            @media(max-width: 600px){
                &:nth-child(5n){
                    display: none;
                }

                &:nth-child(6n){
                    display: none;
                }

                &:nth-child(7n){
                    display: none;
                }
                
            }

        }

        td:first-child, th:first-child {
            padding-left: 15px;
            padding-right: 10px;

            @media(max-width: 445px){
                padding-left: 6px!important;
                padding-right: 6px!important;
            }

            @media(max-width: 339px){
                padding-left: 3px!important;
                padding-right: 5px!important;
            }
        }
    }

</style>
