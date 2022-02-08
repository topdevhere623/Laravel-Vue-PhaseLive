<template>
    <modal name="featured-dates-payment"
           :adaptive="true"
           :clickToClose="false"
           @opened="setupPayment"
           @before-open="setupData"
           :minHeight="400"
           height="auto"
           width="100%"
           :maxWidth="660"
           :scrollable="true"
    >
        <div class="modal modal-payment">
            <h2>Payment</h2>

            <p>You have selected the following dates to feature your release {{ release.name }}</p>
            <span v-for="(featuredDate, index) in featuredDates" :key="index">
                <span v-if="index > 0"> - </span> {{ featuredDate }}
            </span>

            <p class="total">Total: {{ calculateTotal }}</p>
            <p>Payment will only be taken if the release is approved.</p>

            <div>
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
              <div v-show="!loadedInitialCardData">
                <i class="fa fa-spinner fa-spin"></i>
              </div>
                <ph-button v-show="loadedInitialCardData" id="paymentButton" @click.native="pay" :loading="loading">Pay</ph-button>
                <ph-button @click.native="cancel">Cancel</ph-button>
            </div>
        </div>
    </modal>
</template>

<script>
  import { mapState } from 'vuex'
  import PhButton from 'global/ph-button'
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'
  import ExistingCardAccount from '../global/existing-card-account'
  import StripeMixin from '../helpers/mixins/stripe-mixin'
  import Vue from "vue";

  export default {
    name: 'featured-dates-payment',

    data() {
      return {
        featuredDates: [],
        releaseId: null,
        release: {}
      }
    },

    computed: {
      ...mapState(['app']),
      calculateTotal() {
        const formatter = new Intl.NumberFormat('en-GB', {
          style: 'currency',
          currency: 'GBP',
          minimumFractionDigits: 2,
        })
        return formatter.format(this.featuredDates.length * this.app.pricePerFeaturedSlot)
      },
    },

    methods: {
      setupData(event) {
        this.featuredDates = event.params.featuredDates
        this.releaseId = event.params.release
      },

      setupPayment() {
        this.user = this.$store.getters['app/getUser'];

        axios.get('/api/account/billing/method')
            .then(response => {
              this.card = response.data.payment_method
              this.showCard = !!!response.data.payment_method
            })

        this.setupCardElement()
      },

      async pay() {
        this.loading = true
        const vm = this;

        if (this.stripePayment) {
          await this.getSetupIntent()
          const result = await this.stripe.confirmCardSetup(this.secret, {
            payment_method: {
              card: this.cardElement,
              billing_details: {
                name: this.app.user.name,
                email: this.app.user.email,
              }
            }
          })
          // const result = await this.stripe.confirmCardPayment(this.secret, {
          //   payment_method: {
          //     card: this.cardElement,
          //     billing_details: {
          //       name: this.app.user.name,
          //       email: this.app.user.email
          //     }
          //   }
          // })

          if (result.error) {
            Vue.notify({
              group: 'main',
              type: 'error',
              title: result.error.message,
            })
            this.loading = false
          } else {
            if (result.setupIntent.status === 'succeeded') {
              axios.post('/api/featured-dates/create', {
                dates: this.featuredDates,
                release_id: this.releaseId,
                user_id: this.app.user.id,
                payment_id: result.setupIntent.payment_method,
              })

              Vue.notify({
                group: 'main',
                type: 'success',
                title: 'Payment requested.',
              })
              this.loading = false
              this.complete = true

              this.$modal.hide('featured-dates-payment')
            }
          }
        }

        this.loading = false
      },

      cancel() {
        this.$modal.hide('featured-dates-payment')
      }
    },

    components: {
      PhButton,
      Spinner,
      ExistingCardAccount,
    },

    mixins: [
        StripeMixin,
    ],
  }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .modal-payment {
        padding: 5px 30px 30px 30px;
    }
    #card-element {
        max-width: 500px;
    }

    p {
        margin-bottom: 10px;
    }

    .total {
        font-weight: bold;
        font-size: 18px;
        padding-top: 20px;
        padding-bottom: 10px;
    }
</style>
