<template>
    <div>
        <login />
        <register-select />
        <register />
        <!-- <reset /> -->
    </div>
</template>

<script>
    import Login from './auth/login';
    import RegisterSelect from './auth/register-select';
    import Register from './auth/register';
    import Reset from './auth/reset';

    export default {
        data () {
            return {

            }
        },
        mounted: function() {

        },
        components: {
            Login,
            RegisterSelect,
            Register,
            Reset
        }
    }
</script>

<style lang="scss" scoped>

</style>