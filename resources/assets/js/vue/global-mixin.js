import Vue from 'vue';
import Filter from 'bad-words'

/**
 * Global mixin applied to the main vue instance.
 */
Vue.mixin({
    data () {
        return {
            filter: new Filter()
        }
    },
    created() {
        this.filter.addWords(...window.bad_words)
    },
    methods: {
        /**
         * Given an item which could have a router view associated with it (e.g. a single release page or a single users
         * profile), return the vue-router object which can be passed to a router-link component to link to the right
         * page
         *
         * @param item
         * @returns {*}
         */
        getRouterObject(item) {
            switch(item.type) {
                case 'news':
                    return { name: 'article', params: { article: item.id }};
                case 'release':
                    return { name: 'release', params: { releaseid: item.slug }};
                case 'track':
                    return { name: 'track', params: { trackid: item.slug }};
                case 'user':
                    return { name: 'profile_all', params: { path: item.path }};
                case 'genre':
                    return { name: 'genre', params: { genreid: item.slug }};
                case 'post':
                    return { name: 'post', params: { postid: item.id }};
                case 'playlist':
                    return { name: 'playlist', params: { playlistid: item.id }};
                case 'event':
                    return { name: 'event', params: { eventid: item.id }};
                case 'video':
                    return { name: 'video', params: { videoid: item.id }};
                case 'merch':
                    return { name: 'merch', params: { merchid: item.id }};
            }
        },
        /**
         * Given a release or a track, decide if it is considered 'new' by checking if it was released within the last 7
         * days
         *
         * @param item
         * @returns {boolean}
         */
        isNew(item) {
            let release_date = null;
            switch (item.type) {
                case 'release':
                    release_date = item.release_date;
                    break;
                case 'track':
                    release_date = item.release.release_date;
                    break;
            }
            return (window.moment().diff(release_date, 'days') <= 7);
        },
        /**
         * Show a toast notification of type error.
         *
         * @param msg
         */
        notifyError(msg = null) {
            if(!msg) {
                msg = "An unknown error occurred when attempting that action. Please try again later."
            }
            this.$notify({
                group: 'main',
                type: 'error',
                title: msg,
            });
        },
        limitChars (text, num=100) {
            return text.length > num ? text.substring(0, num) + '...' : text;
        },
        range (start, end, step = 1) {
            const len = Math.floor((end - start) / step) + 1
            return Array(len).fill().map((_, idx) => start + (idx * step))
        }
    }
});
