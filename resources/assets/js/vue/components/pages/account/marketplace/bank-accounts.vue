<template>
    <ph-panel>
        <h2>Bank Accounts</h2>
        <hr>
        <div v-if="!loading">
            <table>
                <tr>
                    <td>Bank Name</td>
                    <td>Last 4</td>
                    <td>Default</td>
                    <td>Actions</td>
                </tr>
                <template v-if="bankAccounts && bankAccounts.data.length">
                    <tr v-for="bankAccount in bankAccounts.data">
                        <td>{{ bankAccount.bank_name }}</td>
                        <td>{{ bankAccount.last4 }}</td>
                        <td>
                            <span v-if="bankAccount.default_for_currency"><i class="fas fa-check"></i></span>
                            <span v-else><i class="fas fa-times"></i></span>
                        </td>
                        <td>
                            <a v-if="! bankAccount.default_for_currency" href="#"
                               @click.prevent="makeDefault(bankAccount.id)">Make Default</a>
                            <a v-if="! bankAccount.default_for_currency" href="#"
                               @click.prevent="removeAccount(bankAccount.id)">Remove</a>
                        </td>
                    </tr>
                </template>
                <tr v-else>
                    No Bank accounts found.
                </tr>
            </table>
            <div class="new_card" v-if="addAccount">
                <input type="text" placeholder="Account Holder Name" v-model="newBankAccount.accountHolderName">
                <input type="text" placeholder="Account Number" v-model="newBankAccount.accountNumber">
                <input type="text" placeholder="Sort Code" v-model="newBankAccount.sortCode">
            </div>
            <ph-button v-if="!addAccount" @click.native="addAccount = true">Add new account</ph-button>
            <ph-button v-if="addAccount" @click.native="saveBankAccount" :loading="loading">Save</ph-button>
            <ph-button v-if="addAccount" @click.native="cancel">Cancel</ph-button>
        </div>
        <spinner style="margin: 3em auto;"
                 v-else
                 :animation-duration="1000"
                 :size="60"
                 :color="'black'"
        />
    </ph-panel>
</template>

<script>
    import {HalfCircleSpinner as Spinner} from 'epic-spinners'
    import PhButton from 'global/ph-button'

    export default {
        name: 'bank-accounts',

        props: {
            account: {
                type: Object
            }
        },

        data() {
            return {
                loading: true,
                bankAccounts: null,
                bankToken: null,
                addAccount: false,
                newBankAccount: {
                    country: 'GB',
                    currency: 'gbp',
                    accountNumber: null,
                    sortCode: null,
                    accountHolderName: null,
                    accountHolderType: 'individual',
                },
            }
        },

        created() {
            this.getBankAccounts()
        },

        methods: {
            getBankAccounts() {
                this.loading = true
                axios.get('/api/account/marketplace/bank_accounts')
                    .then(response => {
                        this.loading = false
                        this.bankAccounts = response.data.accounts
                    })

                this.loading = false
            },
            removeAccount(id) {
                axios.post('/api/account/marketplace/remove_bank_account', {
                    account: id,
                }).then(() => {
                    this.$notify({
                        group: 'main',
                        type: 'success',
                        title: 'Successfully removed bank account',
                    });
                    this.getBankAccounts()
                })
            },
            makeDefault(id) {
                axios.post('/api/account/marketplace/set_default_bank', {
                    account: id
                }).then(() => {
                    this.$notify({
                        group: 'main',
                        type: 'success',
                        title: 'Successfully changed default bank account',
                    });
                    this.getBankAccounts()
                })
            },
            async saveBankAccount() {
                const stripe = Stripe(process.env.MIX_STRIPE_KEY)

                const bankResult = await stripe.createToken('bank_account', {
                    country: this.newBankAccount.country,
                    currency: this.newBankAccount.currency,
                    account_number: this.newBankAccount.accountNumber,
                    routing_number: this.newBankAccount.sortCode,
                    account_holder_name: this.newBankAccount.accountHolderName,
                    account_holder_type: this.newBankAccount.accountHolderType,
                })

                if (bankResult.token) {
                    this.loading = true
                    this.bankToken = bankResult.token.id

                    await axios.post('/api/account/marketplace/add_new_bank_account', {
                        token: this.bankToken,
                    }).then(() => {
                        
                        this.$notify({
                            group: 'main',
                            type: 'success',
                            title: 'Successfully added bank account',
                        });
                        this.getBankAccounts()
                        this.$emit("bank_updated");
                        this.loading = false
                        this.cancel()
                    })
                }
            },
            cancel() {
                this.addAccount = false
                this.newBankAccount = {
                    country: 'GB',
                    currency: 'gbp',
                    accountNumber: null,
                    sortCode: null,
                    accountHolderName: null,
                    accountHolderType: 'individual',
                }
            },
        },

        components: {
            Spinner,
            PhButton,
        },
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .new_card {
        margin-top: 20px;
        margin-bottom: 20px;

        input {
            padding: 10px !important;
            box-sizing: border-box;
            font-size: 17px !important;
            border: 1px solid $color-grey4 !important;
            border-radius: 3px;
        }
    }

    table, tr {
        width: 100%;
    }

    td {
        width: 25%;
        padding: 10px 0;
    }
</style>
