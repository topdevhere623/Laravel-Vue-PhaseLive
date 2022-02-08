// Search Store
export default {
    namespaced: true,
    state: {
        visible: false,
        searchTerm: '',
    },
    mutations: {
        toggleSearch (state, value = null) {
            if(value === null) {
                state.visible = !state.visible;
            } else {
                state.visible = value;
            }
        },
        setSearchTerm (state, newSearchTerm) {
            state.searchTerm = newSearchTerm;
        }
    },
    actions: {},
    getters: {
        getSearchTerm: state => {
            return state.searchTerm;
        }
    }
}