<template>
    <tr class="data-row">
        <td>
            {{ item.name }}
        </td>
        <td>
            {{ artist }}
        </td>
        <td>
            {{ length }}
            <!-- {{ moment().startOf('day').seconds(length).format('mm:ss') }} -->
        </td>
        <td>
            <ph-select name="format" title="Format" v-model="format" @input="updateFormat"
                       :options="{
                           mp3: 'MP3',
                           wav: 'WAV + £' + (wav_fee / 100).toFixed(2)
                       }"
            />
        </td>
        <td>
            £{{ (($store.getters['cart/getItemPrice'](item)) / 100).toFixed(2) }}
        </td>
        <td>
            <close-icon :zoom="2" @click.native="$store.dispatch('cart/removeItem', item)"></close-icon>
        </td>
    </tr>
</template>

<script>
    //import Component from '../';
    import CloseIcon from 'global/close-icon';

    export default {
        props: {
            item: {
                required: true,
                type: Object,
            }
        },
        data () {
            return {
                format: (this.item.format ? this.item.format : 'mp3'),
            }
        },
        computed: {
            wav_fee() {
                console.log(this.$store.state.app.settings[2].wav_fee)
                // console.log(this.$store.state.state.app.settings[2].wav_fee)
                if(this.item.type === 'release') {
                    return this.$store.state.app.settings[2].wav_fee * this.item.tracks.length;
                } else {
                    return this.$store.state.app.settings[2].wav_fee;
                }
            },
            length() {
                let length = 0

                if (this.item.type === 'release') {
                    this.item.tracks.map(track => {
                        length += track.length
                    })
                } else {
                    length = this.item.length
                }

                return moment().startOf('day').seconds(length).format('mm:ss')
            },
            artist() {
                if (this.item.type === 'release') {
                    return this.item.tracks[0].artist.name
                } else {
                    return this.item.artist.name
                }
            }
        },
        // mounted: function() {
        //     if(this.item.format) {
        //         this.format = this.item.format;
        //     }
        // },
        methods: {
            updateFormat() {
                this.$store.dispatch('cart/changeItemFormat', {
                    item: this.item,
                    format: this.format,
                });
            }
        },
        components: {
            CloseIcon
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    tr.data-row {
        //height: 45px;
        background: $color-grey;

        .close-icon {
            width: 100%;
            height: 100%;
            position: absolute;
        }
    }
    th,td {
        padding: 15px;

        @media(max-width: 580px){
            padding: 5px;
            font-size: 12px;
        }

        @media(max-width: 500px){
            font-size: 11px;
        }

        @media(max-width: 414px){
            font-size: 10px;
        }

        @media(max-width: 360px){
            padding: 2px;
        }
    }
    td:last-child {
        position: relative;
        padding: 0;
    }
</style>
