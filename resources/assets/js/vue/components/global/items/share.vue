<template>
    <div class="share">
        <div class="share-message">
            {{ share.message }}
        </div>
        <item :item="share.shareable" />
    </div>
</template>

<script>
    export default {
        props: {
            share: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {

            }
        },
        beforeCreate: function () {
            // Import the component asynchronously because share requires item and item requires share but item requires
            // share first
            this.$options.components.Item = require('./item')
        },
        created: function() {

        },
        methods: {

        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    .share-message {
        margin: 10px 0;
    }
</style>