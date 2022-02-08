<template>
    <div>
        <div v-if="account && account.requirements && (account.requirements.currently_due.length || account.requirements.pending_verification.length) && ($refs.verification && !$refs.verification.verified)">
            To receive payouts you need to supply the following information:
            <ul>
                <li v-for="(requirement, index) in account.requirements.currently_due" :key="`due_${index}`">
                    {{ requirement.replace('\.', ' ').replace('\.', ' ').replace('_', ' ') }}
                </li>
                <li v-for="(requirement, index) in account.requirements.pending_verification" :key="`pending_${index}`">
                    {{ requirement.replace('\.', ' ').replace('\.', ' ').replace('_', ' ') }}
                </li>
            </ul>
        </div>

        <div v-if="!loading">
            <personal-details :account="account" @account_updated="fetchAccount" />

            <bank-accounts :account="account" @bank_updated="fetchAccount" v-if="account" />

            <verification-details :account="account" @document_uploaded="fetchAccount" ref="verification" />
        </div>

        <spinner style="margin: 3em auto;"
                 v-else
                 :animation-duration="1000"
                 :size="60"
                 :color="'black'"
        />
    </div>
</template>

<script>
  import { mapState } from 'vuex'
  import { UserEvents } from 'events'
  import BankAccounts from './bank-accounts'
  import PersonalDetails from './personal-details'
  import VerificationDetails from './verification-details'
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'

  export default {
    name: 'marketplace',

    data() {
      return {
        account: null,
        loading: false,
        requirements: null,
      }
    },
    computed: {
      ...mapState([
        'app',
      ]),
    },
    created() {
      UserEvents.$emit('updateTitle', 'Verification')
      this.loading = true
      this.fetchAccount()
    },
    watch: {
      account: {
        handler: function (val, oldVal) { 
          this.account = val;
        },
        deep: true
      },
    },
    methods: {
      fetchAccount() {
        console.log('fetch');
        axios.get('/api/account/marketplace/account').then(response => {
          this.account = response.data.account
          this.requirements = response.data.requirements
          this.loading = false
        })
      },
    },

    components: {
      BankAccounts,
      PersonalDetails,
      VerificationDetails,
      Spinner,
    },
  }
</script>

<style lang="scss" scoped>

</style>
