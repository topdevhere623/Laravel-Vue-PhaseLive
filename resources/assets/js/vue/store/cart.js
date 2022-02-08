import Vue from 'vue';
import store from 'store';

import CartManager from '../CartManager';

// Cart Store
export default {
    namespaced: true,
    state: {
        items: [],
        loading: true
    },
    mutations: {
        reset(state) {
            state.items = [];
        },
        loaded(state, value) {
            state.loading = value;
        },
        addItem(state, item) {
            if(typeof item.format === 'undefined') {
                item.format = 'mp3';
            }

            const exists = !!state.items.find(i => i.id === item.id);
            if (!exists) {
              state.items.push(item)
            }
        },
        removeItem(state, index) {
            state.items.splice(index, 1);
        },
        changeItemFormat(state, {item, format}) {
            for(let i = 0; i < state.items.length; i++) {
                if(state.items[i] === item) {
                    state.items[i].format = format;
                    Vue.set(state.items, i, state.items[i])
                }
            }
        }
    },
    actions: {
        addItem({ state, commit }, item, format = 'mp3') {
            item.format = format;
            let already = _.find(state.items, (iterable) => {
                return iterable.id === item.id &&
                    iterable.type === item.type;
            });
            if(!already) {
                commit('addItem', item);
                CartManager.saveCookie();
                CartManager.saveItemToServer(item);
            }
        },
        removeItem({ state, commit }, item) {
            for(let i = 0; i < state.items.length; i++) {
                if(state.items[i].id === item.id && state.items[i].type === item.type) {
                    // Inform the server of the removal
                    axios.post('/api/cart/item/remove', {
                        type: item.type,
                        id: item.id,
                    });

                    // Remove from the local store
                    commit('removeItem', i);
                    CartManager.saveCookie(state.items);
                }
            }
        },
        changeItemFormat({state, commit}, {item, format}) {
            CartManager.changeItemFormat(item, format);
            commit('changeItemFormat', {item, format});
        },
        load({ commit }) {
          return new Promise((resolve, reject) => {
              commit('reset');
              CartManager.load()
                  .then(data => {
                      for(let i = 0; i < data.length; i++) {
                          commit('addItem', data[i]);
                      }
                  }).catch(() => {
                      reject();
                      // No server / cookie items set
                  })
                  .finally(() => {
                      resolve();
                  })
          });
        },
        reset({ commit }) {
            commit('reset');
            CartManager.reset();
        },
        setLoading({ commit }, value) {
          commit('loaded', value);
        }
    },
    getters: {
        isInCart: (state) => (item) => {
            return Boolean(state.items.find(iterable => {
                return iterable.id === item.id &&
                    iterable.type === item.type
            }));
        },
        getItemPrice: (state) => (item) => {
            for(let i = 0; i < state.items.length; i++) {
                if(state.items[i] === item) {
                    let price = state.items[i].price;
                    if(state.items[i].format === 'wav') {
                        if(state.items[i].type === 'release') {
                            price += parseInt(store.state.app.settings[2].wav_fee) * state.items[i].tracks.length;
                        } else {
                            price += parseInt(store.state.app.settings[2].wav_fee);
                        }
                    }
                    return price;
                }
            }
        },
        getTotal: (state, getters) => {
            let total = 0;
            for(let i = 0; i < state.items.length; i++) {
                total += getters.getItemPrice(state.items[i]);
            }
            return (total / 100).toFixed(2)
        },
        getTax: (state, getters) => {
            return getters.getTotal
        },
    }
}