<template>
    <div class="page-content-padded page-news-index">
        <div class="page-main">
          <div class="genres">
            <div class="genres-container">
              <div v-for="genre in app.genres" :key="genre.name" class="genre">
                <router-link :to="{ path: `/samples/${genre.id}` }">
                  <div class="genre-bg" :style="{'background-image': `url(${genre.image.files.original.url})`}"
                    style="background-size: cover;"
                  >
                      <!-- <img :src="genre.image.files.original.url" alt=""> -->
                      <div class="genre-name">
                        {{ genre.name }}
                      </div>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <aside class="sidebar-right">
            <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
        </aside>
    </div>
</template>

<script>
  import { mapState } from 'vuex';
  import SidebarGroup from 'global/sidebar-group';
  import store from 'store';

  export default {
      components: { SidebarGroup },

      computed: mapState([
        'app',
        'news'
      ]),

      beforeRouteEnter (to, from, next) {
        store.dispatch('app/fetchGenres')
          .then(() => {
            next();
          });
      },
  }
</script>

<style lang="scss" scoped>
  .genres {
    margin-bottom: 2em;
    padding: 0 1em;
    box-sizing: border-box;

    a {
      text-decoration: none;
    }
  }
  .genres-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 0 -1em;
  }
  .genre {
    width: 30%;
    padding: 1em;
    position: relative;
    height: 350px;
    margin-bottom: 20px;
    .genre-bg {
        width: 100%;
        height: 100%;
    }

    img {
      width: 100%;
      height: auto;
    }
    .genre-name {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 16px;
      position: absolute;
      color: #fff;
      top: 50%;
      left: 50%;
      transform: translate(-50%);
    }
  }
  @media (max-width: 768px) {
    .genre {
      width: 45%;
    }
  }
</style>
