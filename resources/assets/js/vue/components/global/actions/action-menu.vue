<template>
    <div class="action-menu-container">
        <span class="action-menu-toggle" @click="toggleMenu">
            <i class="fa fa-ellipsis-h"></i>
        </span>
        <div class="action-menu" v-if="display">
            <ul>
                <li>
                    <i class="fa fa-plus fa-fw"></i> Add to playlist <i class="fa fa-caret-right"></i>
                    <action-sub-menu :actionable="{}" :test="1"></action-sub-menu>
                </li>
                <li><i class="fa fa-plus-square fa-fw"></i> Play next</li>
                <li @click="remaining_dl -= 1"><a :href="'/api/mymusic/download/' + download.format + '/' + download.track_id" target="_blank"><i class="fa fa-download fa-fw"></i> Download <span style="text-transform: uppercase">{{ download.format }}</span> ({{ remaining_dl }} left)</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    import ActionSubMenu from './action-sub-menu';
    export default {
        props: {
            actionable: { // This is the object e.g. 'track', 'release', 'article'
                type: Object,
                required: true,
            },
            download: {
                type: Object,
                required: false,
            }
        },
        data () {
            return {
                remaining_dl: -1,
                display: false,
            }
        },
        mounted() {
            this.remaining_dl = 3 - this.download.count;
            document.addEventListener('click', this.handleClickOutside);
        },
        destroyed() {
            document.removeEventListener('click', this.handleClickOutside);
        },
        methods: {
            handleClickOutside(evt) {
                if (!this.$el.contains(evt.target)) {
                    this.display = false;
                }
            },
            toggleMenu() {
                this.display = !this.display;
            }
        },
        components: {
            ActionSubMenu
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .action-menu-container {
        position: relative;
        font-size: 14px;
    }
    .action-menu-toggle {
        position: relative;
        z-index: 999999;
    }
    .action-menu {
        position: absolute;
        font-size: 11px;
        font-weight: bold;
        //margin: -23px 0 0 -10px;
        padding-top: 25px;
        border: 1px solid #FFF;
        background: $color-grey;
        top: -9px;
        left: -9px;
        white-space:nowrap;
        z-index: 99;
    }
    li {
        padding: 10px;
        position: relative;

        &:hover {
            background: darken($color-grey, 5);

            & > ul.action-sub-menu {
                display: block;
            }
        }

        a {
            text-decoration: none;
        }
    }
</style>