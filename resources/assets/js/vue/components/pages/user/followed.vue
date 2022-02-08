<template>
    <div class="page-content-padded">
        <!-- <aside class="sidebar-left">
            <notification-group title="Notifications" v-if="user" :user="user"></notification-group>
        </aside> -->

        <div class="page-main">
            <h1 class="no-top">My Followed</h1>

            <div v-if="user">
                <div v-for="person in user.followed" :key="person.id">
                    <router-link :to="'/user/' + person.path" class="sidebar-group-item">
                        <user :user="person" />
<!--                        <div class="sgi-upper">-->
<!--                            <avatar class="sgi-image"-->
<!--                                    :tile="true"-->
<!--                                    :size="70"-->
<!--                                    :src="user.avatar.files.thumb.url"-->
<!--                                    alt=""-->
<!--                                    :center="false"-->
<!--                            />-->
<!--                            <div class="sgi-info">-->
<!--                                <div class="sgi-title">{{ user.name }}</div>-->
<!--                                <div class="sgi-date">{{ moment(user.created_at).format("MMMM D, YYYY") }}</div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </router-link>
                </div>
            </div>
        </div>

        <!-- <aside class="sidebar-right">
            <sidebar-group title="Favourites" :view-all="true" :items="[]"></sidebar-group>
        </aside> -->
    </div>
</template>

<script>
  import { mapState, mapGetters } from 'vuex';
  import Avatar from 'global/avatar';
  import User from 'global/items/user'
  import SidebarGroup from 'global/sidebar-group';
  import NotificationGroup from 'global/notification-group'

  export default {
    name: 'followed',

    computed: {
      ...mapState([
        'app',
        'news',
      ]),
      ...mapGetters({user: 'app/getUser'})
    },

    data () {
      return {
        moment: window.moment
      }
    },

    mounted() {
      this.user.getFollowed()
    },

    components: {
      User,
      Avatar,
      SidebarGroup,
      NotificationGroup,
    }
  }
</script>

<style lang="scss" scoped>

</style>