<template>
    <component :is="pageComponent" :featured-items="featuredItems" :chart-items="chartItems"></component>
</template>

<script>
  import { mapState } from 'vuex';
  import store from 'store';
  import LoggedIn from './logged-in'
  import LoggedOut from './logged-out'

  export default {
    components: {
      LoggedIn,
      LoggedOut
    },
    data() {
      return {
        featuredItems: [],
        chartItems: [],
      }
    },
    computed: {
      ...mapState([
        'app',
        'news'
      ]),
      pageComponent() {
        return this.app.user.loggedin ? LoggedIn : LoggedOut;
      }
    },
    beforeRouteEnter (to, from, next) {
      store.dispatch('app/fetchReleases').then(() => {
        store.dispatch('app/fetchGenres');
      }).then(() => {
        next(vm => {
          vm.getFeaturedReleases();
          vm.getChart();
        });
      });
    },
    methods: {
      getFeaturedReleases() {
        axios.get('/api/releases/featured/6')
          .then(response => {
            this.featuredItems = response.data.data;
          })
          .catch(error => {
            console.log(error);
          });
      },
      getChart() {
        axios.post('/api/charts/10')
          .then(response => {
            this.chartItems = response.data
          });
      }
    }
  }
</script>
