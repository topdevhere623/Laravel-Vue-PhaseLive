<template>
    <div class="panel" :class="[type]">
        <slot></slot>
    </div>
</template>

<script>
    //import Component from '../';
    export default {
        props: {
            type: {
                type: String,
                default: 'info',
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
    .panel {
        margin: 1em 0;
        padding: 1em;

        @media(max-width: 415px){
            padding: 0.5em;
        }

        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
        }
    }

    // Colors
    .info {
        background: $color-grey;
    }
    .warn {
        background-color: $color-state-warn-bg;
        color: $color-state-warn-text;
        box-shadow: 0 0 0 1px $color-state-warn-shadow inset, 0 0 0 0 transparent;

        .header {
            color: $color-state-warn-header-text;
        }
    }
    .success {
        background-color: $color-state-success-bg;
        color: $color-state-success-text;
        box-shadow: 0 0 0 1px $color-state-success-shadow inset, 0 0 0 0 transparent;

        .header {
            color: $color-state-success-header-text;
        }
    }
    .error {
        background-color: $color-state-error-bg;
        color: $color-state-error-text;
        box-shadow: 0 0 0 1px $color-state-error-shadow inset, 0 0 0 0 transparent;

        .header {
            color: $color-state-error-header-text;
        }
    }
</style>