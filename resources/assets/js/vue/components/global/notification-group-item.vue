<template>
    <div>
        <div class="notification-card" @click="dismiss(item.id)">
                {{ item.data.message }}
                <a class="notification-dismiss" >Dismiss</a>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['item','index'],
        data () {
            return {
                moment: window.moment,
                
            }
        },
        computed: {
            
        },
        created: function() {
            
        },
        components: {
        },
        methods:{
            dismiss(id){
                axios.get(`/api/user/notifications/read/`+id)
                  .then(function (response) {
                    this.$parent.items.splice(this.index,1);
                    this.$parent.fetch();
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
    // GROUP ITEM
    .sidebar-group-item {
        display: block;
        margin: 2em 0;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .notification-card{
        border: 1px solid orange;
        margin-bottom: 5px;
        border-radius: 15px;
        padding: 8px;
        font-size: 14px;
        line-height: 18px;
    }
    .notification-dismiss{
        color: #3300ff;
    }
    .notification-dismiss:hover{
        cursor:pointer;
    }
</style>
