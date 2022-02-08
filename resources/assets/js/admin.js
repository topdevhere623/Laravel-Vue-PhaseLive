window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

import Vue from 'vue';
import VeeValidate from 'vee-validate';
import store from './vue/store/store';
require('./vee-validate/vee-validate');

Vue.use(VeeValidate);

Vue.component('page-meta', require('./vue/components/admin/meta'));
Vue.component('genre-select', require('./vue/components/modals/upload/genre-select'))

window.Vue = new Vue({
    store,
    el: '#admin',
});
