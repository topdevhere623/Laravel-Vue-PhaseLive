<template>
    <nav class="sub-nav" :class="classes">
        <ul>
            <li :class="{ active: active === 'account'}">
                <router-link :to="{ name: 'account_default' }">
                    My Account
                </router-link>
            </li>
            <li :class="{ active: active === 'invoices' }" v-if="$can('create unlimited releases')">
                <router-link :to="{ name: 'account_invoices' }">
                    Billing
                </router-link>
            </li>
            <li :class="{ active: active === 'verification' }" v-if="$can('create releases')">
                <router-link :to="{ name: 'account_marketplace' }">
                    Verification
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'mymusic' }">
                    My Music
                </router-link>
            </li>
            <li :class="{ active: active === 'releases'}" v-if="$can('create releases')">
                <router-link :to="{ name: 'account_releases' }">
                    My Releases
                </router-link>
            </li>
            <li :class="{ active: active === 'stats'}" v-if="$can('create releases')">
                <router-link :to="{ name: 'account_stats' }">
                    Sales & Feedback
                </router-link>
            </li>
            <li :class="{ active: active === 'profile'}">
                <router-link :to="{ name: 'account_edit' }">
                    Profile
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
  export default {
    props: {
      active: {
        type: String,
        default: 'account',
      },
      center: {
        type: Boolean,
        default: false,
      },
      white: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {}
    },
    computed: {
      classes() {
        let classes = []
        if (this.center) {
          classes.push('center')
        }
        if (this.white) {
          classes.push('white')
        }
        return classes
      },
    },
    created: function () {

    },
    components: {},
  }
</script>

<style lang="scss" scoped>

    .sub-nav{
      @media(max-width: 380px){
        padding-right: 6em;
      }
    }

    .center {
        text-align: center;
    }

    .white a {
        color: white;
    }
</style>
