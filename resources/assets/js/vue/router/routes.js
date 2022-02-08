/**
 * Import All Components
 */

// Generic
import PageHome from '../components/pages/home/home';

import PageNews from '../components/pages/news-index/index';
import PageNewsArticle from '../components/pages/news-article/article';

// import PageMyMusic from '../components/pages/my-music/my-music';

import PageCharts from '../components/pages/charts/charts'

import PageGenres from '../components/pages/genres/genres'
import PageGenresSingle from '../components/pages/genres/genre'

import PageNewMusic from '../components/pages/new-music/new-music'

import PageSamples from '../components/pages/sample-packs/sample-pack-genres.vue'
import PageSamplesPacks from '../components/pages/sample-packs/sample-packs.vue'
import PageSamplesPackSingle from '../components/pages/sample-packs/sample-pack.vue'

import PageDiscover from '../components/pages/discover/discover'

import PageEvent from '../components/pages/event/event'
import PagePlaylist from '../components/pages/playlist/playlist'
import PageVideo from '../components/pages/video/video'
import PageMerch from '../components/pages/merch/merch'

// User
import PageUserFollowed from '../components/pages/user/followed'
import PageUserFavourites from '../components/pages/user/favourites'
import PageUserRecentlyPlayed from '../components/pages/user/recently-played'
import PageUserMessages from '../components/pages/user/messages';
import PageUserMessageThread from '../components/pages/user/thread';
import PageUserProfileWrapper from '../components/pages/user/profile-wrapper';
import PageUserProfileAll from '../components/pages/user/profile/subviews/all';
import PageUserProfileMusic from '../components/pages/user/profile/subviews/music';
import PageUserProfileReleases from '../components/pages/user/profile/subviews/releases';
import PageUserProfileEvents from '../components/pages/user/profile/subviews/events';
import PageUserProfileVideos from '../components/pages/user/profile/subviews/videos';
import PageUserProfileMerch from '../components/pages/user/profile/subviews/merch';
import PageUserProfilePosts from '../components/pages/user/profile/subviews/posts';

// Account
import PageAccount from '../components/pages/account/account';
import PageAccountDefault from '../components/pages/account/account/account';
import PageAccountMyMusic from '../components/pages/account/my-music/my-music';
import PageAccountMyReleases from '../components/pages/account/my-releases/my-releases';
import PageAccountSalesFeedback from '../components/pages/account/sales-feedback/sales-feedback';
import PageAccountSalesFeedbackTrack from '../components/pages/account/sales-feedback/sales-feedback-track';
import PageAccountHelpSupport from '../components/pages/account/help-support/help-support';
import PageAccountEdit from '../components/pages/account/edit/edit';
import PageAccountMarketplace from '../components/pages/account/marketplace/marketplace';
import PageAccountInvoices from '../components/pages/account/invoices/invoices'

// Tracks / Releases
import PageRelease from '../components/pages/tracks-releases/release';
import PageTrack from '../components/pages/tracks-releases/track';

//posts
import PagePost from '../components/pages/post/post';

// Help & Support
// import PageHelp from '../components/pages/help/help';

// Default Page
import Page from '../components/pages/page/page';

// Error
import Page404 from '../components/pages/404';

import Login from '../components/pages/login';
import Reset from '../components/modals/auth/reset';

import PageFailedPayment from '../components/pages/failed-payment'

/**
 * Define aliases so the string representations of the components can be converted into the actual components objects
 */

let aliases = {
    'PageHome': PageHome,

    'PageNews': PageNews,
    'PageNewsArticle': PageNewsArticle,

    'PageCharts': PageCharts,

    'PageGenres': PageGenres,
    'PageGenresSingle': PageGenresSingle,

    'PageSamples': PageSamples,
    'PageSamplesPacks': PageSamplesPacks,
    'PageSamplesPackSingle': PageSamplesPackSingle,

    'PageNewMusic': PageNewMusic,

    'PageUserFollowed': PageUserFollowed,
    'PageUserFavourites': PageUserFavourites,
    'PageUserRecentlyPlayed': PageUserRecentlyPlayed,
    'PageUserMessages': PageUserMessages,
    'PageUserMessageThread': PageUserMessageThread,
    'PageUserProfileWrapper': PageUserProfileWrapper,
    'PageUserProfileAll': PageUserProfileAll,
    'PageUserProfileEvents': PageUserProfileEvents,
    'PageUserProfileMerch': PageUserProfileMerch,
    'PageUserProfileMusic': PageUserProfileMusic,
    'PageUserProfileReleases': PageUserProfileReleases,
    'PageUserProfileVideos': PageUserProfileVideos,
    'PageUserProfilePosts': PageUserProfilePosts,

    'PageAccount': PageAccount,
    'PageAccountDefault': PageAccountDefault,
    'PageAccountMyMusic': PageAccountMyMusic,
    'PageAccountMyReleases': PageAccountMyReleases,
    'PageAccountSalesFeedback': PageAccountSalesFeedback,
    'PageAccountSalesFeedbackTrack': PageAccountSalesFeedbackTrack,
    'PageAccountHelpSupport': PageAccountHelpSupport,
    'PageAccountEdit': PageAccountEdit,
    'PageAccountMarketplace': PageAccountMarketplace,
    'PageAccountInvoices': PageAccountInvoices,

    'PageRelease': PageRelease,
    'PageTrack': PageTrack,

    'PagePost': PagePost,

    'PageDiscover': PageDiscover,

    'PageEvent': PageEvent,
    'PagePlaylist': PagePlaylist,
    'PageVideo': PageVideo,
    'PageMerch': PageMerch,

    'PageFailedPayment': PageFailedPayment,

    'Page': Page,
};

/**
 * Iterate through the routes array and replace the string representation of the objects with the actual objects
 *
 * @param routes
 * @returns {*}
 */
const replaceWithObjects = (routes) =>{
    routes.forEach(function(route, index) {
        routes[index].component = aliases[route.component]

        if(routes[index].hasOwnProperty('children')) {
            replaceWithObjects(routes[index].children)
        }
    })
    return routes
}

routes = replaceWithObjects(window.routes)

routes.push(
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            noAuth: true
        }
    },
    {
       path: '*',
       component: Page404,
    },
    {
        path: 'passwordReset',
        path: '/password/change',
        component: Reset
    }
)

export default routes
