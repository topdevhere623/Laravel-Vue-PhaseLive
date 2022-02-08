<template>
  <div class="page-content-padded">
    <div class="page-main">
      <div v-if="order">
        <p style="margin-bottom: 20px;">Your order for the following featured dates for the release {{ order.featured_dates[0].release.name }}
          failed</p>
        <ul v-for="(date, index) in order.featured_dates" :key="index">
          <li>{{ moment(date.featured_date).format('Do MMMM YYYY') }}</li>
        </ul>

        <p style="margin-top: 20px;">Please make payment for {{ calculateTotal }}</p>

        <div style="width: 350px; margin-top: 50px;">
          <div id="card-element" style="margin-bottom: 20px;"></div>
          <div id="card-errors" role="alert"></div>
        </div>

        <ph-button @click.native="pay" :loading="loading">Pay</ph-button>
      </div>

      <spinner style="margin: 3em auto;" v-else
               :animation-duration="1000"
               :size="80"
               color="black"
      />
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex'
import StripeMixin from '../helpers/mixins/stripe-mixin'
import {HalfCircleSpinner as Spinner} from 'epic-spinners'
import Vue from "vue";

export default {
  name: "failed-payment",

  data() {
    return {
      orderId: null,
      intent: null,
      moment: window.moment
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
      return formatter.format(this.order.amount / 100)
    },
  },

  mounted() {
    this.setup()
  },

  methods: {
    async setup() {
      this.user = this.$store.getters['app/getUser'];
      this.orderId = this.$route.params.order_id

      await this.fetchOrder()
      await this.retrieveIntent()
    },

    async fetchOrder() {
      await axios.get('/api/featured-dates/fetch-order/' + this.orderId)
          .then(response => {
            this.order = response.data
          })

      await this.setupCardElement()
    },

    async retrieveIntent() {
      const queryString = window.location.search
      const urlParams = new URLSearchParams(queryString)
      axios.post(`/api/featured-dates/failed-order/intent`, {
        intentId: urlParams.get('payment_id')
      }).then(response => {
        this.intent = response.data
      })
    },

    async pay() {
      this.loading = true

      stripe.confirmCardPayment(this.intent.client_secret, {
        payment_method: this.intent.last_payment_error.payment_method.id
      }).then(result => {
        if (result.error) {
          Vue.notify({
            group: 'main',
            type: 'error',
            title: result.error.message,
          })
        } else {
          if (result.paymentIntent.status === 'succeeded') {
            Vue.notify({
              group: 'main',
              type: 'success',
              title: 'Payment successful.',
            })
            this.loading = false
            this.complete = true
          }
        }
      })
    }
  },

  components: {
    Spinner,
  },

  mixins: [
    StripeMixin,
  ],
}
</script>

<style scoped>

</style>
