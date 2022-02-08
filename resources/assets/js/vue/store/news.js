// News Store
export default {
    namespaced: true,
    state: {
        nextPage: 1,
        totalPages: 0,
        categoryPath: null,
        articles: [],
        categories: [],
    },
    mutations: {
        setArticles (state, payload) {
            state.nextPage = payload.currentPageNumber + 1;
            state.totalPages = payload.totalPagesNumber;

            state.articles.push(...payload.articles);
        },
        setCategories (state, categories) {
            state.categories = categories;
        },
        /**
         * Update the user's like boolean for an article
         * Does not POST to server because that is handled by the like button
         */
        likeArticle (state, articleid) {
            for(let i = 0; i < state.articles.length; i++) {
                if(state.articles[i].id === articleid) {
                    state.articles[i].like_count += 1;
                    state.articles[i].is_liked = true;
                }
            }
        },
        unlikeArticle (state, articleid) {
            for(let i = 0; i < state.articles.length; i++) {
                if(state.articles[i].id === articleid) {
                    state.articles[i].like_count -= 1;
                    state.articles[i].is_liked = false;
                }
            }
        },
        shareArticle (state, articleid) {
            for(let i = 0; i < state.articles.length; i++) {
                if(state.articles[i].id === articleid) {
                    state.articles[i].shares_count += 1;
                    state.articles[i].is_shared = true;
                }
            }
        },
    },
    actions: {
        requireArticles({state, dispatch}, categoryPath) {
            if(!state.articles.length || categoryPath !== state.categoryPath) {
                dispatch('fetchArticles', categoryPath)
            }
        },
        fetchArticles ({commit, state, getters}, categoryPath) {
            if(categoryPath !== state.categoryPath) { // We are now requesting data on a different category, discard existing data
                state.nextPage = 1;
                state.totalPages = 0;
                state.articles = [];
            }
            state.categoryPath = categoryPath;

            if(!getters.hasAnotherPage) return; // Don't fetch a page that doesn't exist!

            let apiPath = '/api/news?page=';
            if(state.categoryPath) {
                apiPath = '/api/news/category/' + state.categoryPath + '/?page='
            }

            return new Promise((resolve, reject) => {
                axios.get(apiPath + state.nextPage)
                    .then(function (response) {
                        commit('setArticles', {
                            currentPageNumber: response.data.current_page,
                            totalPagesNumber: response.data.last_page,
                            articles: response.data.data
                        });
                        resolve()
                    })
                    .catch(function (error) {
                        console.log(error);
                        reject();
                    });
            });
        },
        fetchCategories ({commit, state}) {
            if(state.categories.length) return; // Don't fetch categories if we already have them!
            return new Promise((resolve, reject) => {
                axios.get('/api/categories')
                    .then(function (response) {
                        commit('setCategories', response.data.data);
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
