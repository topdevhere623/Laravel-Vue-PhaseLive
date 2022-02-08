<template>
    <div class="page-content-padded">
        <div class="page-main" v-if="!app.user.loggedin">
            <h1 class="no-top">Login</h1>

            <form class="form-login" @submit.prevent="formSubmit">
                <input type="email" name="email" placeholder="Email" v-model="email" v-validate="'required|email'" :class="{'error': errors.has('email') }" />
                <span class="error-msg" v-if="errors.has('email')">{{ errors.first('email') }}</span>

                <input type="password" name="password" placeholder="Password" v-model="password" v-validate="'required'" :class="{'error': errors.has('password') }" />
                <span class="error-msg" v-if="errors.has('password')">{{ errors.first('password') }}</span>

                <label style="display: block">
                    <input type="checkbox" name="remember" id="remember" v-model="remember" />
                    Remember me
                </label>

                <div class="centered-text">
                    <ph-button type="submit" size="medium" :loading="loading">
                        Login
                    </ph-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import { mapState } from 'vuex';

  export default {
    data () {
      return {
        variables: window.variables,
        loading: false,
        email: '',
        password: '',
        remember: false,
        deActivatedUser:false,
        banned:false,
      }
    },

    computed: {
      ...mapState([
        'app'
      ])
    },

    methods: {
      formSubmit: function () {
        this.$validator.validateAll().then(passes => {
          const {email, password, remember} = this

          if (!passes) return

          this.loading = true;

          axios.post('/api/auth/login', {email, password, remember}).then(function (response) {
            this.loading = false;

            if (response.data.success) {
              this.username = ''
              this.password = ''

              this.$store.commit('app/setUser', response.data.user);
              window.location = '/admin';
            } else {
              if (response.data.deactivated) {
                this.deActivatedUser = true;
              } else if (response.data.banned) {
                this.banned = true;
              } else {
                this.password = ''
              }
            }
          }.bind(this)).catch(function (err) {
            this.loading = false;
            this.password = ''
          }.bind(this))
        })
      },
    }
  }
</script>

<style lang="scss" scoped>
    form.form-login {
        width: 70%;
        margin: 0 auto;

        input {
            margin: 1em 0;
            padding: 3px;

            &.error {
                border: 1px solid red;
                border-radius: 3px;
            }
        }
        .error-msg {
            color: red;
            font-size: 10px;
        }
    }
</style>
