/**
 * Retrieve, store and manipulate data relating to the currently
 * logged in user.
 *
 * @constructor
 */
export default function User()
{
    // From JSON API
    // Remembering to update these variables when the user schema or relationships changes is tricky!
    this.bio = '';
    this.loggedin = false;
    this.id = -1;
    this.avatar_id = -1;
    this.banner_id = -1;
    this.path = '';
    this.name = '';
    this.last_name = '';
    this.first_name = '';
    this.email = '';
    this.payment_method = '';
    this.paypal_linked = false;
    this.social_web = '';
    this.social_youtube = '';
    this.social_twitter = '';
    this.social_facebook = '';
    this.deleted_at = '';
    this.created_at = '';
    this.updated_at = '';
    this.account_type = '';
    this.avatar = {};
    this.banner = {};
    this.followed = {}
    this.releases = {
        current_page: 0,
        data: [],
        last_page: 1,
    }
    this.all_permissions = [],
    this.interests = [],
    this.tracks_count_this_month = 0,
    this.account_verified = false,
    this.plays = [],
    this.events = null,

    /**
     * Set (login) user data
     * @param data
     */
    this.set = (data) =>
    {
        for(let key in data) {
            this[key] = data[key];
        }
        this.loggedin = true;
    };

    /**
     * Unset (logout) user data
     */
    this.unset = () =>
    {
        for(let key in this) {
            if(typeof(this[key]) !== 'function') {
                this[key] = null;
            }
        }
        this.loggedin = false;
    };

    /**
     * Get user favourites for a certain favouritable type
     *
     * @param favouritable e.g. 'track'
     */
    this.favourites = (favouritable) =>
    {
        // ...
    };

    this.getFollowed = () => {
        window.axios.get('/api/user/followed').then(response => {
            this.followed = response.data
        })
    }

    /**
     * Get user messages
     */
    this.messages = () =>
    {
        // ...
    };

    this.removeRelease = release => {
        this.releases.data.splice(this.releases.data.indexOf(release), 1)
    }

    this.updateStatus = (data) => {
        const index = this.releases.data.indexOf(data.release)
        this.releases.data[index].status = data.status
    }

    this.incrementTrackCount = () => {
        this.tracks_count_this_month++
    }
}
