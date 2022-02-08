<template>
    <modal name="modal-checkout" width="600px" height="auto" @closed="closed" @before-close="closed" @opened="opened" scrollable adaptive>
        <div class="modal modal-checkout">
            <div class="modal-header">
                <img src="/img/logo.png" class="modal-logo centered-block"/>
                <close-icon @click.native="$modal.hide('modal-checkout')"></close-icon>
            </div>
            <div class="modal-content">
                <div v-if="!complete">
                    <h2 class="payment-info-header">Payment Information</h2>
                    <div v-show="loadedInitialCardData">
                        <div v-if="userHasCard && !stripePayment">
                          <existing-card-account :card="card" />

                          <div class="card-details-info" @click.prevent="showCardInput">Add new card</div>
                        </div>

                        <div v-show="!userHasCard || stripePayment">
                          <div id="card-element" style="margin-bottom: 20px;"></div>
                          <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                    <div v-show="!loadedInitialCardData">
                        <spinner style="margin: 3em auto;"
                                 :animation-duration="1000"
                                 :size="60"
                                 :color="'black'"
                        />
                    </div>
                    <h2 class="no-top">Order Information</h2>
                    <table>
                        <tr>
                            <td>
                                Cart Subtotal
                            </td>
                            <td>
                                &pound;{{ $store.getters['cart/getTotal'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Taxes
                            </td>
                            <td>
                                &pound;{{ taxes }}
                            </td>
                        </tr>
                        <tr class="border-top bold">
                            <td>
                                Total
                            </td>
                            <td>
                                &pound;{{ total }}
                            </td>
                        </tr>
                    </table>
                    <p class="alert" v-if="total >= (parseInt(settings.purchase_approval_threshold) / 100)">
                        As this purchase is greater than £{{ parseInt(settings.purchase_approval_threshold) / 100 }}, it
                        will need to be manually approved by an admin.
                    </p>
                    <div v-show="!loadedInitialCardData">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <div v-show="loadedInitialCardData">
                        <ph-button id="paymentButton" @click.native="pay" size="large" :loading="loading">Pay</ph-button>
                    </div>
                    <p v-show="loadedInitialCardData">
                        By confirming this purchase, you agree to the Phase Terms of Use.
                    </p>
                </div>
                <div v-else>
                    <ph-panel type="error" v-if="error">
                        <h2 class="no-top header">Error!</h2>
                        <p>
                            There was an error processing your payment. You have not been charged.
                        </p>
                    </ph-panel>
                    <ph-panel type="success" v-else>
                        <h2 class="no-top header">Success!</h2>
                        <p>
                            Your purchase is complete. Visit your
                            <router-link to="/account/mymusic" @click.native="$modal.hide('modal-checkout');">music
                            </router-link>
                            page to download your tracks now!
                        </p>
                    </ph-panel>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
  import Vue from 'vue'
  import PhButton from 'global/ph-button'
  import CloseIcon from 'global/close-icon'
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'
  import { mapState } from 'vuex'
  import ExistingCardAccount from '../../global/existing-card-account';

  export default {
    data() {
      return {
        // State
        loadedInitialCardData: false,
        settings: window.settings,
        loading: false,
        complete: false,
        error: false,
        secret: null,
        cardElement: null,
        order: null,
        stripe: null,
        card: null,
        stripePayment: false,
        user: null,
      }
    },
    computed: {
      ...mapState(['app']),
      items() {
        return this.$store.state.cart.items
      },
      subtotal: function () {
        return this.$store.getters['cart/getTotal']
      },
      taxes: function () {
        return (this.subtotal * 0.2).toFixed(2)
      },
      total: function () {
        return (parseFloat(this.taxes) + parseFloat(this.subtotal)).toFixed(2)
      },
      userHasCard: function () {
        return !!this.user && !!(this.user.card_brand && this.user.card_last_four);
      },
    },
    methods: {
      async getPaymentIntent() {
        await axios.post('/api/order/payment/intent', {
          items: this.items,
          order_id: this.order.id,
        }).then(response => {
          this.secret = response.data
        })
      },
      async setupCardElement() {
        this.stripe = Stripe(process.env.MIX_STRIPE_KEY)
        const elements = this.stripe.elements()
        this.cardElement = elements.create('card', { hidePostalCode: true })

        this.cardElement.mount('#card-element')

        this.loadedInitialCardData = true

        this.cardElement.addEventListener('change', ({error}) => {
          const displayError = document.getElementById('card-errors');
          if (error) {
            displayError.textContent = error.message;
          } else {
            displayError.textContent = '';
          }
        });
      },
      showCardInput() {
        this.stripePayment = true;
      },
      async pay() {
        this.loading = true
        if (!this.order) {
          await axios.post('/api/order/create', {
            items: this.items,
            existing_account: !this.stripePayment,
          }).then(response => {
            this.order = response.data
          }).catch(err => {
            this.loading = false
          })
        }

        if (this.stripePayment || !this.userHasCard) {
          await this.getPaymentIntent()
          const result = await this.stripe.confirmCardPayment(this.secret, {
            payment_method: {
              card: this.cardElement,
              billing_details: {
                name: this.app.user.name,
                email: this.app.user.email
              }
            }
          })

          if (result.error) {
            Vue.notify({
              group: 'main',
              type: 'error',
              title: result.error.message,
            })
            this.loading = false
          } else {
            if (result.paymentIntent.status === 'succeeded') {
              Vue.notify({
                group: 'main',
                type: 'success',
                title: 'Payment complete.',
              })
              this.loading = false
              this.complete = true
            }
          }
        } else {
          Vue.notify({
            group: 'main',
            type: 'success',
            title: 'Payment complete.',
          })
          this.loading = false
          this.complete = true
        }

        this.$store.dispatch('cart/reset');
      },
      opened() {
        // Rehydrate the user on open
        this.user = this.$store.getters['app/getUser'];
        axios.get('/api/account/billing/method')
          .then(response => {
            this.card = response.data.payment_method
            this.showCard = !!!response.data.payment_method
          })
          this.setupCardElement()
      },
      closed() {
        this.stripe = null
        this.order = null
        this.secret = null
        this.cardElement = null
        this.complete = false
        this.stripePayment = false
      },
    },
    components: {
      PhButton,
      CloseIcon,
      Spinner,
      ExistingCardAccount,
    },
  }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .payment-info-header {
        margin-bottom: 10px;
    }

    .card-details-info {
      text-decoration: underline;
      margin: 1em 0;
      cursor: pointer;
    }

    p:first-of-type {
        margin-bottom: 2em;
    }

    p:last-of-type {
        margin-top: 1em;
    }

    input {
        font-size: 100%;
    }

    table {
        width: 100%;
        margin-bottom: 2em;
    }

    tr.border-top {
        border-top: 1px solid;
    }

    td {
        padding: 1em 0;
    }
</style>
