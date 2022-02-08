<template>
    <div :class="'masonry-item ' + item.component">
        <!-- discovery-post -->
        <div class="masonry-inner masonry-inner-fixed">
            <h4>Post</h4>
            <p>{{ item.body }}</p>
            <!-- <div class="date-xxl">
                Posted {{ moment(item.created_at).format("MMM Do") }}
            </div> -->
        </div>
    </div>
</template>

<script>
    export default {
        props: { item: Object },
    };
</script>

<style lang="scss" scoped>
    .feed-post {
        min-height: 140px;
    }
</style>
