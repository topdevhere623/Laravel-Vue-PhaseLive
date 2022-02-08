<template>
    <div class="asset">
        <avatar
                :src="asset.files.medium.url"
                :tile="true"
                :size="350"
        />
    </div>
</template>

<script>
    import Avatar from 'global/avatar';

    export default {
        props: {
            asset: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {

            }
        },
        created: function() {

        },
        methods: {

        },
        components: {
            Avatar,
        }
    }
</script>

<style lang="scss" scoped>

</style>