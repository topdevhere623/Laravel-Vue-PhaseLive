<template>

<div class="password-reset">
    <div v-if="!loading && !loaded">
    <h1>Reset password</h1>
    <form @submit.prevent="submit" autocomplete="false">
        <input v-model="password" class="form-element" type="password" name="password" id="" placeholder="New password" autocomplete="false">
        <input v-model="password_confirmation" class="form-element" type="password" name="password_confirmation" id="" placeholder="Confirm new password" autocomplete="false">
        <button class="form-element" type="submit">Submit</button>
    </form>
    </div>
    <div v-if="loading">
         <spinner style="margin: 0 auto;"
                     :animation-duration="1000"
                     :size="75"
                     color="black"
            />
    </div>
    <div v-if="loaded">
        <p>Your Password has been reset, you will be redirected shortly</p>
        <div style="display:flex;justify-content:center;margin-top:50px;">
            <orbit-spinner
            :animation-duration="1200"
            :size="55"
            color="#3300ff"
            />
        </div>
    </div>
</div>

</template>

<script>
    import CloseIcon from 'global/close-icon';
    import Logo from 'global/logo';
    import { RadarSpinner as Spinner } from 'epic-spinners';
    import { OrbitSpinner } from 'epic-spinners'

    export default {
        data () {
            return {
                password: '',
                password_confirmation: '',
                email: '',
                token: '',
                loading: false,
                loaded: false
            }
        },

        mounted: function() {
            const urlParams = new URLSearchParams(window.location.search);
            this.token = urlParams.get('token');
            this.email = urlParams.get('email');
        },

        methods: {
            
            submit() {
                this.loading = true

                const {email, password, token, password_confirmation} = this
                axios.post('/password/change', {password, password_confirmation , email, token}
                ).then(response => {
                    this.loading = false;
                    this.loaded = true;
                    setTimeout(this.reload(), 5000);

                }).catch(response => {
                    console.log(response);
                });
            },

            reload() {
                window.location.href = "/";
            }
        },

        components: {
            CloseIcon,
            Logo,
            Spinner,
            OrbitSpinner

        }
    }
</script>

<style lang="scss" scoped>
.password-reset {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top:50px;

    .reset-form-wrap {
        padding: 40px 0;
    }
    .form-element {
        margin: 10px 0;
    }
     button {
        cursor: pointer;
        display: inline-block;
        background: none;
        border-radius: 999px;
        outline: none;
        font-size: 10px;
        padding: 7px 12px;
        letter-spacing: 1px;
        border: 2px solid #3300ff;
        color: #3300ff;
        font-size: 110%;
        }
    form {
        width: 100%;
        padding: 0;
    }
    
}
    
</style>


   