<template>
    <ul class="action-sub-menu">
        <li>
            Dutty Bassline <i class="fa fa-caret-right"></i>
            <action-sub-menu :actionable="{}" v-for="x in test" :key="x"></action-sub-menu>
        </li>
        <li>D-D-D-Dubstep</li>
        <li>Grime Rhymes</li>
        <li>Drum & Bass</li>
    </ul>
</template>

<script>
    // import ActionSubMenu from './action-sub-menu';
    export default {
        // name: 'action-sub-menu',
        props: {
            actionable: { // This is the object e.g. 'track', 'release', 'article'
                type: Object,
                required: true,
            },
            test: {
                type: Number,
                default: 0,
            }
        },
        data () {
            return {
                display: false,
            }
        },
        mounted() {
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
            // ActionSubMenu
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    ul.action-sub-menu {
        display: none;
        position: absolute;
        left: 100%;
        top: -1px;
        background: $color-grey;
        border: 1px solid #FFF;
        box-sizing: border-box;
        white-space:nowrap;
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
    }
</style>