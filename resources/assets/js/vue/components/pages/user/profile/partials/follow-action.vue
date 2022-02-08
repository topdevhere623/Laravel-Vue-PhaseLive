<template>
    <div class="profile-action" @click="toggle">
        <span v-show="user.followed" >
            <i class="fa fa-check-circle"></i> Following
        </span>
        <span v-show="!user.followed" >
            <i class="fa fa-plus-circle"></i> Follow
        </span>
    </div>
</template>

<script>
    //import Component from '../';
    export default {
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {
            
            }
        },
        created: function() {

        },
        methods: {
            toggle() {
                if(this.user.followed) {
                    this.unfollow()
                } else {
                    this.follow()
                }
            },
            follow() {
                this.$emit('update', true);
                axios.get('/api/user/follow/' + this.user.id);
            },
            unfollow() {
                this.$emit('update', false);
                axios.get('/api/user/unfollow/' + this.user.id);
            },
        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>

</style>