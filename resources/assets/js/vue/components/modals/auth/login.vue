<template>
    <div>
        <modal name="modal-auth-login" :maxWidth="600" height="auto" scrollable @closed="closed" adaptive>
            <div class="modal modal-auth-login" v-if="!deActivatedUser && !bannedUser">
                <div class="modal-header">
                    <logo class="modal-logo centered-block" style="width: 185px;"/>
                    <close-icon @click.native="$modal.hide('modal-auth-login')"></close-icon>
                </div>
                <div class="modal-content">
                    <p class="centered-text" style="margin: 1em 0;">
                        Don't have an account? <a href="#" @click="showRegister">Register</a>
                    </p>
                    <form class="form-login" @submit.prevent="formSubmit">

                        <input type="email" name="email" placeholder="Email" v-model="email"
                               v-validate="'required|email'" :class="{'error': errors.has('email') }"/>
                        <span class="error-msg" v-if="errors.has('email')">{{ errors.first('email') }}</span>

                        <input type="password" name="password" placeholder="Password" v-model="password"
                               v-validate="'required'" :class="{'error': errors.has('password') }"/>
                        <span class="error-msg" v-if="errors.has('password')">{{ errors.first('password') }}</span>
                        <span class="error-msg" v-if="bag.has('auth')">{{ bag.first('auth') }}</span>

                        <div class="group-wrap">
                            <label class="remember-me" style="display: flex;align-items:center;">
                                <input type="checkbox" name="remember" id="remember" v-model="remember"/>
                                Remember me
                            </label>
                            <label style="display: block;text-align:right;cursor:pointer" class="remember-me"
                                   @click="showReset">
                                Forgot password
                            </label>
                        </div>

                        <div class="centered-text">
                            <ph-button type="submit" size="medium" :loading="loading">
                                Login
                            </ph-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal modal-auth-login" v-else>
                <div class="modal-header">
                    <img src="/img/logo.png" class="modal-logo centered-block"/>
                    <close-icon @click.native="$modal.hide('modal-auth-login')"></close-icon>
                </div>
                <div class="modal-content">
                    <div v-if="deActivatedUser">
                        <p class="centered-text" style="margin: 1em 0;">
                            Your account is currently deactivated, click reactivate and try to login again.
                        </p>

                        <div class="centered-text">
                            <ph-button type="button" size="medium" :loading="loading" @click.native="reactivate">
                                Reactivate Account
                            </ph-button>
                        </div>
                    </div>
                    <div v-if="bannedUser">
                        <p class="centered-text" style="margin: 1em 0;">
                            Your account has been banned.
                        </p>
                    </div>
                </div>
            </div>
        </modal>
        <modal name="reset-password">
            <div style="position:absolute;right:0;top:0">
                <close-icon @click.native="$modal.hide('reset-password')"></close-icon>
            </div>
            <div class="container">
                <div class="reset-form-wrap" v-if="!loading && !loaded">
                    <img src="/img/logo.png" class="reset-logo modal-logo centered-block"/>
                    <form @submit.prevent="submitReset">
                        <h4>Reset your Password</h4>
                        <label for="email">Enter your email below to request a password reset link</label>
                        <input type="email" name="email" id="" v-model="email" placeholder="Email">
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div class="reset-form-wrap" v-if="loading" style="margin: auto; transition: 1s ease;">
                    <img src="/img/logo.png" class="reset-logo modal-logo centered-block"/>
                    <spinner style="margin: 0 auto;"
                             :animation-duration="1000"
                             :size="75"
                             color="black"
                    />
                </div>
                <div class="reset-form-wrap" v-if="loaded" style="margin: auto; transition: 1s ease;">
                    <img src="/img/logo.png" class="reset-logo modal-logo centered-block"/>
                    <p>A password reset link has been sent, please check your email.</p>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
  import PhButton from 'global/ph-button'
  import CloseIcon from 'global/close-icon'
  import Logo from 'global/logo'
  import Reset from '../auth/reset'
  import { RadarSpinner as Spinner } from 'epic-spinners'
  import { ErrorBag } from 'vee-validate'
  import Cookies from 'js-cookie';
  import CartManager from '../../../CartManager';

  export default {
    data() {
      return {
        variables: window.variables,
        loading: false,
        email: '',
        password: '',
        remember: false,
        deActivatedUser: false,
        bannedUser: false,
        loaded: false,
        bag: new ErrorBag,
      }
    },
    mounted: function () {

    },
    methods: {
      formSubmit: function () {
        this.$validator.validateAll().then(passes => {
          const {email, password, remember} = this
          const transferCart = this.$route.query.transferCart;
          let guestCart = null;

          if (!passes) return

          // Needs to be a string comparison as value is encoded as a string
          if (transferCart === 'true') {
            guestCart = Cookies.getJSON('phase_cart');
          }

          this.loading = true

          axios.post('/api/auth/login', {email, password, remember, guestCart}).then(function (response) {
            this.loading = false

            if (response.data.success) {
              // this.username = ''
              // this.password = ''

              // this.$store.commit('app/setUser', response.data.user)
              // this.$modal.hide('modal-auth-login')

              // Remove the cart cookie
              CartManager.reset();

              location.reload()
            } else {
              if (response.data.deactivated) {
                this.deActivatedUser = true
              } else if (response.data.banned) {
                this.bannedUser = true
              } else {
                this.bag.add({
                  field: 'auth',
                  msg: 'Your credentials are not correct.',
                })
                // this.password = ''
              }
            }
          }.bind(this)).catch(function (err) {
            this.loading = false
            this.password = ''
          }.bind(this))
        })
      },

      reactivate() {
        this.loading = true

        axios.post('/api/user/restore', {email: this.email}).then(function (response) {
          this.loading = false
          this.deActivatedUser = false

        }.bind(this)).catch(function (err) {
          this.loading = false

        }.bind(this))
      },

      showRegister: function () {
        this.$modal.hide('modal-auth-login')
        this.$modal.show('modal-auth-register')
      },

      showReset: function () {
        this.$modal.hide('modal-auth-login')
        this.$modal.show('reset-password')
      },

      submitReset() {

        this.loading = true

        axios.post('/password/reset', {email: this.email})
          .then(response => {

            this.loading = false
            this.loaded = true

          })

          .catch(response => {

            console.log(response)

          })

      },
      closed() {
        this.email = ''
        this.password = ''
        this.remember = false
        this.deActivatedUser = false
        this.bannedUser = false
        this.loaded = false
      },
    },
    components: {
      PhButton,
      CloseIcon,
      Logo,
      Reset,
      Spinner,
    },
  }
</script>

<style lang="scss" scoped>
    form.form-login {
        width: 60%;
        margin: 0 auto;
        padding-left: 0;

        @media(max-width: 640px){
          width: 80%;
          padding-right: 1.4em;
        }

        input {
            margin: 1em 0;
            padding: 10px;
            border: 1px solid #e6e6e6;
            border-radius: 3px;

            &.error {
                border: 1px solid red;
                border-radius: 3px;
            }
        }

        .error-msg {
            color: red;
            font-size: 10px;
        }

        .remember-me {
            font-size: 12px;
            font-weight: bold;
            width: 50%;

            @media(max-width: 388px){
              font-size: 11px;
            }

            input {
                margin: 0 6px 0 3px;
            }
        }

        .group-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 40px 0;

        }
    }

    .reset-form-wrap {
        padding: 50px 0;
        font-family: Comfortaa;

        img {
            margin-bottom: 30px;
        }

        input {
            margin: 30px 0;
        }

        label {
            font-size: 12px;
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
            border: 2px solid #30f;
            color: #30f;
            font-size: 110%;
        }

        h4 {
            margin-top: 70px;
        }
    }

    .container {
        max-width: 80%;
        margin: 0 auto;
        height: 100%;
        display: flex;
        align-items: center;
    }

    img.reset-logo {
        position: absolute;
        top: 28px;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
