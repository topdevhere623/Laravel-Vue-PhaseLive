<template>
    <ph-panel id="billing">
        <h2>Billing</h2>
        <hr>
        <h3>Payment Method</h3>

        <existing-card-account :card="card" />

        <!-- Stripe Elements Placeholder -->
        <div id="card-element" style="margin-bottom: 20px;"></div>

        <ph-button id="card-button" size="medium" :loading="submitting">Save</ph-button>
    </ph-panel>
</template>

<script>
  import Vue from 'vue'
  import { mapState } from 'vuex'
  import PaymentMixin from './payment-mixin'
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'
  import ExistingCardAccount from '../../../global/existing-card-account';

  export default {
    data() {
      return {
        loadedInitialCardData: false,
        submitting: false,
        submitted: false,
        clientSecret: null,

        card: null,
        error_message: '',
      }
    },

    mounted: function () {
      this.getClientSecret().then(secret => this.clientSecret = secret)
      this.payment()
      this.getPaymentMethod()
    },

    computed: {
      ...mapState([
        'app'
      ]),
    },

    methods: {
      payment() {
        const stripe = Stripe(process.env.MIX_STRIPE_KEY)
        const elements = stripe.elements()
        const cardElement = elements.create('card', { hidePostalCode: true })
        const cardButton = document.getElementById('card-button')

        cardElement.mount('#card-element')

        cardButton.addEventListener('click', async () => {
          this.submitting = true
          const {setupIntent, error} = await stripe.confirmCardSetup(
            this.clientSecret.client_secret, {
              payment_method: {
                card: cardElement,
                billing_details: {name: this.app.user.name},
              },
            },
          )

          if (error) {
            this.submitting = false
          } else {
            await axios.post('/api/account/billing', {
              payment_method: setupIntent.payment_method
            }).then(({ data }) => {
              this.submitting = false

              // Update user details in store
              this.$store.commit('app/setUser', data.user);

              Vue.notify({
                group: 'main',
                type: 'success',
                title: 'Payment type added to account.',
              })
            }).catch(error => {
              this.submitting = false
            })
          }
        })
      },

      getPaymentMethod() {
        axios.get('/api/account/billing/method')
            .then(response => {
              this.card = response.data.payment_method
            })
      },
    },
    mixins: [
      PaymentMixin,
    ],
    components: {
      Spinner,
      ExistingCardAccount,
    },
  }
</script>

<style lang="scss" scoped>
    .error-msg {
        color: #ff6e6e;
        font-size: 12px;
    }

    .saved-card {
        div {
            margin: 10px 0;
        }
    }

    .checkbox-container {
        margin: 15px 0;
    }

    .payment-info {
        margin: 1em 0;
        background: white;
        padding: 1em;

        p {
            line-height: 150%;
        }
    }

    .card {
        margin: 2em 0;
        width: 50%;
    }
</style>
