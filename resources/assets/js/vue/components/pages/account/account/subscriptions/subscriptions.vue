<template>
    <ph-panel id="subscriptions">
        <h2>Subscriptions</h2>
        <hr>
        <p>
            All subscriptions are billed monthly.
        </p>
        <subscription-plan
                v-for="plan in plans"
                v-if="plansLoaded && subscriptionsLoaded"
                :plan="plan"
                :subscription="getSubscriptionForPlan(plan)"
                :key="plan.id"
        />
        <div v-show="!(plansLoaded && subscriptionsLoaded)">
            <spinner style="margin: 3em auto;"
                     :animation-duration="1000"
                     :size="60"
                     :color="'black'"
            />
        </div>
    </ph-panel>
</template>

<script>
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'

  import SubscriptionPlan from './subscription-plan'

  export default {
    data() {
      return {
        plans: [],
        plansLoaded: false,
        subscriptions: [],
        subscriptionsLoaded: false,
      }
    },
    computed: {},
    mounted: function () {
      this.getSubscriptionPlans()
      this.getSubscriptions()
    },
    methods: {
      async getSubscriptionPlans() {
        this.plansLoaded = false
        await axios.get('/api/account/subscription/plans').then(response => {
          this.plansLoaded = true
          this.plans = response.data
        })
      },
      async getSubscriptions() {
        this.subscriptionsLoaded = false
        await axios.get('/api/account/subscription/subscriptions').then(response => {
          this.subscriptionsLoaded = true
          this.subscriptions = response.data
        })
      },
      getSubscriptionForPlan(plan) {
        return _.find(this.subscriptions, {'stripe_plan': this.toSnakeCase(plan.title)})
      },
      toSnakeCase(str) {
        return str &&
          str
            .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
            .map(x => x.toLowerCase())
            .join('_')
      },
    },
    components: {
      Spinner,
      SubscriptionPlan,
    },
  }
</script>

<style lang="scss" scoped>
    p {
        margin: 10px 0;
    }
</style>
