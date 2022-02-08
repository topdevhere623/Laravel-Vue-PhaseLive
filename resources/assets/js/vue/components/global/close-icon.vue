<template>
    <div class="close-icon">
        <i class="fa fa-times" :class="'fa-' + zoom + 'x'"></i>
    </div>
</template>

<script>
    //import Component from '../';
    export default {
        props: {
            zoom: {
                type: Number,
                default: 3,
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
    .close-icon {
        width: 80px;
        height: 80px;
        background: $color-secondary;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: $color-secondary;
        color: white;

        @media(max-width: 500px){
            width: 60px;
            height: 60px;
        }

        @media(max-width: 390px){
            width: 50px;
            height: 50px;
        }
    }
</style>