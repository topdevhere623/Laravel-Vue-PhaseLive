<template>
    <ul class="navigation-list">
        <li v-for="item in items" :key="item.title" v-if="auth(item)" :class="getListItemClass(item)" @click="$emit('menuClicked')">
            <span v-if="getAction(item) == 'to'" :class="getLinkClass(item)">
                <router-link class="navigation-list__item" :to="item.to">{{ item.title }}</router-link>
            </span>

            <span v-else :class="getLinkClass(item)">
                <router-link class="navigation-list__item" to="#" @click.prevent.native="$modal.show(item.modal)">{{ item.title }}</router-link>
            </span>
        </li>
    </ul>
</template>


<script>
import { mapState } from 'vuex'

export default {
    props: {
        items: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            item: {
                action: 'to',
                listClass: '',
                linkClass: '',
                only: { authenticated: false, guest: false }
            },

            // available link actions
            actions: ['to', 'modal'],
        }
    },

    computed: mapState(['app']),

    methods: {
        getLinkClass({ linkClass }) {
            return ! linkClass ? this.item.linkClass : linkClass
        },

        getListItemClass({ listClass }) {
            return ! listClass ? this.item.listClass : listClass
        },

        getAction({ action }) {
            return ! action ? this.item.action : action
        },

        getOnlyAuthenticated({ authenticated }) {
            return ! authenticated ? this.item.only.authenticated : authenticated
        },

        getOnlyGuest({ guest }) {
            return ! guest ? this.item.only.guest : guest
        },

        auth({ only }) {
            // show if no options are specified
            if ( ! only) {
                return true
            }

            const guest = this.getOnlyGuest(only)
            const authenticated = this.getOnlyAuthenticated(only)

            // show if nothing is specified
            if (authenticated && guest || ! authenticated && ! guest) {
                return true
            }

            // show if the user is authenticated
            if (authenticated && ! guest && this.app.user.loggedin) {
                return true
            }

            // show if the user is guest
            if (! authenticated && guest && ! this.app.user.loggedin) {
                return true
            }

            return false
        }
    }
}
</script>

<style lang="scss" scoped>
.navigation-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.navigation-list__item {
    padding: 0;
    margin: 0;
    outline: 0;
    border: 0;
    background: transparent;
    text-decoration: none;
    cursor: pointer;
}
</style>