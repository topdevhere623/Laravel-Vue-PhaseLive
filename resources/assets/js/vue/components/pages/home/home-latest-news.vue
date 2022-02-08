<template>
    <div>
        <div class="home-latest-news" v-if="latestNews">
            <split-grid :data="latestNews" type="Latest News" />
        </div>

        <spinner style="margin: 3em auto;" v-else
                 :animation-duration="1000"
                 :size="80"
                 color="black"
        />
    </div>
</template>

<script>
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'
  import SplitGrid from '../../global/split-grid';

  export default {
    name: 'home-latest-news',
    props: ['latest-news'],
    components: {
      Spinner,
      SplitGrid
    }
  }
</script>

<style lang="scss" scoped>
    .home-latest-news {
        margin-top: 60px;
    }
</style>