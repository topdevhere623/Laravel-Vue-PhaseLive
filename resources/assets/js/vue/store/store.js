// Vue + Vuex
import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

// Store Modules
import AppStore from './app';
import CartStore from './cart';
import NewsStore from './news';
import SearchStore from './search';
import MessengerStore from './messenger';
import PlayerStore from './player';
import MusicStore from './music';
import MerchStore from './merch';

export default new Vuex.Store({
    modules: {
        app: AppStore,
        cart: CartStore,
        news: NewsStore,
        search: SearchStore,
        messenger: MessengerStore,
        player: PlayerStore,
        music: MusicStore,
        merch: MerchStore,
    },
})
