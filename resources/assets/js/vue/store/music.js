import axios from 'axios';

export default {
  namespaced: true,
  state: {
    nextPage: 1,
    totalPages: 0,
    items: []
  },
  mutations: {
    setMusic(state, data) {
      state.nextPage = data.currentPageNumber + 1;
      state.totalPages = data.totalPagesNumber;

      state.items.push(...data.items);
      // state.items = data
    }
  },
  actions: {
    fetchMusic({commit, state, getters}) {
      if (!getters.hasAnotherPage) return;
      return new Promise((resolve, reject) => {
        axios.get(`/api/new-music?page=${state.nextPage}`)
          .then(function (response) {
            commit('setMusic', {
              currentPageNumber: response.data.current_page,
              totalPagesNumber: response.data.last_page,
              items: response.data.data
            });
            resolve();
          })
          .catch(function (error) {
            console.log(error);
            reject();
          });
      });
    }
  },
  getters: {
    hasAnotherPage: state => {
      if (state.totalPages === 0) return true;
      return (state.nextPage <= state.totalPages);
    }
  }
}
