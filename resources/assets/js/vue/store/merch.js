// Merch Store
export default {
  namespaced: true,
  state: {
    nextPage: 1,
    totalPages: 0,
    items: [],
  },
  mutations: {
    setMerch(state, payload) {
      state.nextPage = payload.currentPageNumber + 1;
      state.totalPages = payload.totalPagesNumber;

      state.items.push(...payload.merch);
    },
  },
  actions: {
    requireMerch({ state, dispatch }) {
      if (!state.items.length) {
        dispatch('fetchMerch')
      }
    },
    fetchMerch({ commit, state, getters }) {
      if (!getters.hasAnotherPage) return; // Don't fetch a page that doesn't exist!

      let apiPath = '/api/merch?page=';

      return new Promise((resolve, reject) => {
        axios.get(apiPath + state.nextPage)
          .then(function (response) {
            commit('setMerch', {
              currentPageNumber: response.data.current_page,
              totalPagesNumber: response.data.last_page,
              merch: response.data.data
            });
            resolve()
          })
          .catch(function (error) {
            console.log(error);
            reject();
          });
      });
    },
  },
  getters: {
    hasAnotherPage: state => {
      if (state.totalPages === 0) return true;
      return (state.nextPage <= state.totalPages);
    }
  }
}
