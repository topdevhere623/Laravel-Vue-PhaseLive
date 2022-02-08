<template>
    <sup class="label"
         :class="[color, size]"
    >
        <slot></slot>
    </sup>
</template>

<script>
    //import Component from '../';
    export default {
        props: {
            color: {
                type: String,
                required: false,
            },
            size: {
                type: String,
                default: 'medium',
            }
        },
        data () {
            return {

            }
        },
        created: function() {

        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .label {
        color: white;
        text-transform: uppercase;
        font-size: small;
        display: inline-block;
        background: black;
        padding: 4px 6px 1px;
        border-radius: 8px;

        // Colors
        &.blue {
            background: $color-blue;
        }
        &.green {
            background: $color-green;
        }
        &.orange {
            background: $color-orange;
        }
        &.grey {
            background: $color-grey4;
        }

        // Sizes
        &.small {
            font-size: 10px;
        }
        &.medium {
            font-size: 13px;
        }
    }
</style>