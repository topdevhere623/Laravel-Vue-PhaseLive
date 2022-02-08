<template>
    <div>
        <ph-panel>
            <h2>All Releases</h2>
            <hr>
            <ph-button
                    @click.native="selectGraph('releases', 'revenue')"
                    :color="graphSelected('releases', 'revenue')">
                Revenue
            </ph-button>
            <ph-button
                    @click.native="selectGraph('releases', 'volume')"
                    :color="graphSelected('releases', 'volume')">
                Volume
            </ph-button>
            <!-- <ph-button
                    @click.native="selectGraph('releases', 'likes')"
                    :color="graphSelected('releases', 'likes')">
                Likes
            </ph-button> -->
            <!-- ******************************** -->
            <div v-if="stats.releases.selected === 'revenue'">
                <chart
                        v-if="stats.releases.revenue"

                        name="Sales Revenue (All Releases)"
                        data-type="currency"
                        :data="stats.releases.revenue"
                        x-label="Month"
                        y-label="Total Sales"
                />
                <div class="loading" v-else>
                    <spinner style="margin: 3em auto;"

                             :animation-duration="1000"
                             :size="60"
                             :color="'black'"
                    />
                </div>
            </div>
            <!-- ******************************** -->
            <div v-if="stats.releases.selected === 'volume'">
                <chart
                        v-if="stats.releases.volume"

                        name="Sales Volume (All Releases)"
                        data-type="integer"
                        :data="stats.releases.volume"
                        x-label="Month"
                        y-label="Total Sales Volume"
                />
                <div class="loading" v-else>
                    <spinner style="margin: 3em auto;"

                             :animation-duration="1000"
                             :size="60"
                             :color="'black'"
                    />
                </div>
            </div>
            <!-- ******************************** -->
            <!-- <div v-if="stats.releases.selected === 'likes'">
                <chart
                        v-if="stats.releases.likes"

                        name="New Likes (All Releases)"
                        data-type="integer"
                        :data="stats.releases.likes"
                        x-label="Month"
                        y-label="New Likes"
                />
                <div class="loading" v-else>
                    <spinner style="margin: 3em auto;"

                             :animation-duration="1000"
                             :size="60"
                             :color="'black'"
                    />
                </div>
            </div> -->
            <!-- ******************************** -->
        </ph-panel>
        <ph-panel>
            <h2>All Tracks</h2>
            <hr>
            <ph-button
                    @click.native="selectGraph('tracks', 'revenue')"
                    :color="graphSelected('tracks', 'revenue')">
                Revenue
            </ph-button>
            <ph-button
                    @click.native="selectGraph('tracks', 'volume')"
                    :color="graphSelected('tracks', 'volume')">
                Volume
            </ph-button>
            <!-- <ph-button
                    @click.native="selectGraph('tracks', 'likes')"
                    :color="graphSelected('tracks', 'likes')">
                Likes
            </ph-button> -->
            <!-- ******************************** -->
            <div v-if="stats.tracks.selected === 'revenue'">
                <chart
                        v-if="stats.tracks.revenue"

                        name="Sales Revenue (All Tracks)"
                        data-type="currency"
                        :data="stats.tracks.revenue"
                        x-label="Month"
                        y-label="Total Sales"
                />
                <div class="loading" v-else>
                    <spinner style="margin: 3em auto;"

                             :animation-duration="1000"
                             :size="60"
                             :color="'black'"
                    />
                </div>
            </div>
            <!-- ******************************** -->
            <div v-if="stats.tracks.selected === 'volume'">
                <chart
                        v-if="stats.tracks.volume"

                        name="Sales Volume (All Tracks)"
                        data-type="integer"
                        :data="stats.tracks.volume"
                        x-label="Month"
                        y-label="Total Sales Volume"
                />
                <div class="loading" v-else>
                    <spinner style="margin: 3em auto;"

                             :animation-duration="1000"
                             :size="60"
                             :color="'black'"
                    />
                </div>
            </div>
            <!-- ******************************** -->
            <!-- <div v-if="stats.tracks.selected === 'likes'">
                <chart
                        v-if="stats.tracks.likes"

                        name="New Likes (All Tracks)"
                        data-type="integer"
                        :data="stats.tracks.likes"
                        x-label="Month"
                        y-label="New Likes"
                />
                <div class="loading" v-else>
                    <spinner style="margin: 3em auto;"

                             :animation-duration="1000"
                             :size="60"
                             :color="'black'"
                    />
                </div>
            </div> -->
        </ph-panel>
    </div>
</template>

<script>
    //import Component from '../';
    import AccountMenu from '../account-menu';
    import Chart from './chart';
    import { UserEvents } from "events";
    import { HalfCircleSpinner as Spinner } from 'epic-spinners';

    export default {
        data () {
            return {
                stats: {
                    releases: {
                        selected: 'revenue',
                        revenue: null,
                        volume: null,
                        likes: null,
                    },
                    tracks: {
                        selected: 'revenue',
                        revenue: null,
                        volume: null,
                        likes: null,
                    }
                },
            }
        },
        mounted() {
            this.loadGraph('releases', 'revenue');

            this.loadGraph('tracks', 'revenue');
          UserEvents.$emit('updateTitle', 'Sales & Feedback')
        },
        methods: {
            // Other
            loadGraph(group, graph) {
                if(this.stats[group][graph] == null) {
                    axios.get('/api/account/stats/' + graph + '/' + group + '/all').then(response => {
                        this.stats[group][graph] = response.data;
                    });
                }
            },
            selectGraph(group, graph) {
                this.loadGraph(group, graph);
                setTimeout(() => {
                    this.stats[group].selected = graph;
                    // window.Vue.$forceUpdate();
                },0);
            },
            graphSelected(group, graph) {
                return (this.stats[group].selected === graph ? 'blue' : '');
            }
        },
        components: {
            AccountMenu,
            Chart,
            Spinner,
        }
    }
</script>

<style lang="scss" scoped>
    div.loading {
        text-align: center;
    }
</style>