<template>
    <div class="sidebar-group">

        <div class="sidebar-group-title" v-if="title">
            {{ title }}
        </div>
        <slot>
        </slot>
        <div v-if="items.length">
            <div class="notifications-box" :class="{active:active}">
                <notification-group-item v-for="(item,index) in items" :item="item" :key="item.id" :index="index"></notification-group-item>
            </div>
            <a v-show="items.length > 2" @click="active=!active" class="view-all">
                View All <i class="fa fa-angle-double-right" ></i>
            </a>
        </div>
    </div>
</template>

<script>
    import NotificationGroupItem from './notification-group-item';
    export default {
        props: ['title','user'],

        data () {
            return {
                toggleCat:false,
                active:false,
                items:[]
            }
        },

        created: function() {
            this.fetch();
        },
        mounted: function(){
            this.notificationHandler();
        },

        components: {
            NotificationGroupItem
        },
        methods:{
            notificationHandler(){
                let userId = this.user.id;
                window.Echo.private('App.User.' + userId)
                .notification((notification) => {
                    this.fetch();
                });
            },
            fetch(){
                let userId = this.user.id;
                axios.get('/api/user/notifications/'+userId)
                  .then(function (response) {
                    this.items = response.data;
                  }.bind(this))
                  .catch(function (error) {
                    console.log(error);
                  });
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .sidebar-group {
        margin: 0 1em 3em 0;
        border-left: 6px solid $color-2;
        padding-left: 1em;
    }
    .sidebar-group-title {
        text-transform: uppercase;
        margin-bottom: 1em;
        font-size: 20px;
        font-weight: bold;
    }
    .sidebar-group-subtitle {
        margin-bottom: 0.6em;
        font-size: 15px;
        font-weight: bold;
    }
    .sidebar-group-content {
        font-size: 11px;
    }
    a {
        text-decoration: none;
    }
    /* .expand-enter defines the starting state for entering */
    /* .expand-leave defines the ending state for leaving */
    .notifications-box {
      -webkit-transition: max-height 1s;
      -moz-transition: max-height 1s;
      -ms-transition: max-height 1s;
      -o-transition: max-height 1s;
      transition: max-height 1s;
      max-height: 77px;
      margin-bottom:7px;
      overflow:scroll;
    }
    .notifications-box.active{
        max-height: 780px;
    }
    .view-all:hover{
        cursor:pointer;
    }
</style>
