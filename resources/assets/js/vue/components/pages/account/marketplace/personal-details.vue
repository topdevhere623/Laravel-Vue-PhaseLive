<template>
    <ph-panel>
        <h2>Personal Details</h2>
        <hr />
        <div v-if="mutableAccount">
            <div class="flex pb-4">
                <div class="flex flex-1 pr-4">
                    <div class="flex w-1/3 items-center">First Name:</div>
                    <div class="w-2/3">
                        <input
                            class="w-full"
                            type="text"
                            name="first_name"
                            v-model="mutableAccount.individual.first_name"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("first_name")
                        }}</span>
                    </div>
                </div>
                <div class="flex flex-1">
                    <div class="flex w-1/3 items-center">Last Name:</div>
                    <div class="w-2/3">
                        <input
                            class="w-full"
                            type="text"
                            name="last_name"
                            v-model="mutableAccount.individual.last_name"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("last_name")
                        }}</span>
                    </div>
                </div>
            </div>

            <div class="flex pb-4">
                <div class="flex flex-1 pr-4">
                    <div class="flex w-1/3 items-center">Email:</div>
                    <div class="w-2/3">
                        <input
                            class="w-full"
                            type="email"
                            name="email"
                            v-model="mutableAccount.individual.email"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("email")
                        }}</span>
                    </div>
                </div>
                <div class="flex flex-1">
                    <div class="flex w-1/3 items-center">Phone:</div>
                    <div class="w-2/3">
                        <input
                            class="w-full"
                            type="text"
                            name="phone"
                            v-model="mutableAccount.individual.phone"
                            v-validate="{ required: true, regex: /((\+44?))\d{11}/}"
                        />
                        <span class="error-message">{{
                            errors.first("phone")
                        }}</span>
                    </div>
                </div>
            </div>

            <div class="flex pb-4">
                <div class="flex flex-1 pr-4">
                    <div class="flex w-1/3 items-center">DOB:</div>
                    <div class="w-2/3 flex flex-dir-col">
                        <div class="flex">
                            <input
                                class="w-1/3 pr-4"
                                type="text"
                                name="day"
                                v-model="mutableAccount.individual.dob.day"
                                placeholder="Day"
                                v-validate="'required|between:1,31'"
                            />
                            <input
                                class="w-1/3 pr-4"
                                type="text"
                                name="month"
                                v-model="mutableAccount.individual.dob.month"
                                placeholder="Month"
                                v-validate="'required|between:1,12'"
                            />
                            <input
                                class="w-1/3"
                                type="text"
                                name="year"
                                v-model="mutableAccount.individual.dob.year"
                                placeholder="Year"
                                v-validate="'required|min_value:1900'"
                            />
                        </div>
                        <span class="error-message flex">{{
                            errors.first("day") || errors.first("month") || errors.first("year")
                        }}</span>
                    </div>

                </div>
                <div class="flex flex-1">
                    <div class="flex w-1/3 items-center">Website:</div>
                    <div class="w-2/3">
                        <input
                            class="w-full"
                            type="text"
                            name="website"
                            v-model="mutableAccount.business_profile.url"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("website")
                        }}</span>
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="flex w-1/2 pr-4">
                    <div class="flex w-1/3">Address</div>
                    <div class=" w-2/3">
                        <input
                            class="w-full mb-4"
                            type="text"
                            name="line1"
                            v-model="mutableAccount.individual.address.line1"
                            placeholder="Line 1"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("line1")
                        }}</span>
                        <input
                            class="w-full mb-4"
                            type="text"
                            name="line2"
                            v-model="mutableAccount.individual.address.line2"
                            placeholder="Line 2"
                        />
                        <input
                            class="w-full mb-4"
                            type="text"
                            name="city"
                            v-model="mutableAccount.individual.address.city"
                            placeholder="City"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("city")
                        }}</span>
                        <input
                            class="w-full mb-4"
                            type="text"
                            name="state"
                            v-model="mutableAccount.individual.address.state"
                            placeholder="County"
                        />
                        <input
                            class="w-full mb-4"
                            type="text"
                            name="postal_code"
                            v-model="
                                mutableAccount.individual.address.postal_code
                            "
                            v-validate="'required'"
                            placeholder="Post Code"
                        />
                        <span class="error-message">{{
                            errors.first("postal_code")
                        }}</span>
                    </div>
                </div>
                <div v-if="!account" class="w-1/2 flex">
                    <div class="flex w-1/3">
                        <label for="tos_shown_and_accepted ">TOS</label>
                    </div>
                    <div class="w-2/3">
                        <input
                            type="checkbox"
                            id="tos_shown_and_accepted"
                            name="tos_shown_and_accepted"
                            v-model="mutableAccount.tos_shown_and_accepted"
                            v-validate="'required'"
                        />
                        <span class="error-message">{{
                            errors.first("tos_shown_and_accepted") ? 'You must agree to the terms of service.' : ''
                        }}</span>
                    </div>
                </div>
            </div>
            <div class="flex error-message mt-2 mb-2" v-if="stripeError">
                {{ stripeError }}
            </div>
            <div>
                <ph-button
                    @click.native="createOrUpdateAccount"
                    :loading="loading"
                    >Save</ph-button
                >
            </div>
        </div>
    </ph-panel>
</template>

<script>
    import { mapState } from "vuex";

    export default {
        name: "personal-details",

        props: {
            account: {
                type: Object || null,
            },
        },

        data() {
            return {
                loading: false,
                stripeError:null,
                accountToken: null,
                mutableAccount: {
                    individual: {
                        first_name: "",
                        last_name: "",
                        email: "",
                        phone: "",
                        dob: {
                            day: "",
                            month: "",
                            year: "",
                        },
                        address: {
                            line1: "",
                            line2: "",
                            city: "",
                            state: "",
                            postal_code: "",
                        },
                    },
                    tos_shown_and_accepted: false,
                    business_profile: {
                        url: "",
                    },
                },
            };
        },

        computed: {
            ...mapState(["app"]),
        },

        mounted() {

            const dict = {
                custom: {
                    phone: {
                        required: 'This field is required',
                        regex:'Phone number needs to be in the format +44xxxxxxxxxx'
                    },
                }
            };

            this.$validator.localize('en', dict);

            if (this.account) {
                this.mutableAccount = this.account;
                this.mutableAccount.tos_shown_and_accepted = true;
                this.mutableAccount.business_profile.url = this.account.business_profile.url ? this.account.business_profile.url : '';
            } else {
                this.mutableAccount.individual.first_name = this.app.user.first_name;
                this.mutableAccount.individual.last_name = this.app.user.last_name;
                this.mutableAccount.individual.email = this.app.user.email;
            }
        },

        methods: {
            async createOrUpdateAccount() {
                const method = this.account ? "update" : "create";

                this.$validator.validate().then(async (valid) => {
                    if (valid) {
                        await this.createToken();

                        if (this.accountToken) {
                            await axios
                                .post(`/api/account/marketplace/${method}`, {
                                    token: this.accountToken.id,
                                    business_profile: {
                                        url: this.mutableAccount
                                            .business_profile.url,
                                    },
                                })
                                .then((response) => {
                                    this.loading = false;
                                    this.$emit("account_updated");
                                    Vue.$notify({
                                        group: "main",
                                        type: "success",
                                        title: `Account ${method}d.`,
                                    });
                                })
                                .catch((error) => {
                                    this.stripeError = error.response.data.message;
                                    this.loading = false;
                                });
                        }
                    }
                });
            },

            async createToken() {
                this.loading = true;
                const stripe = Stripe(process.env.MIX_STRIPE_KEY);
                this.stripeError = null;

                await stripe
                    .createToken("account", {
                        account: {
                            business_type: "individual",
                            individual: {
                                first_name: this.mutableAccount.individual
                                    .first_name,
                                last_name: this.mutableAccount.individual
                                    .last_name,
                                email: this.mutableAccount.individual.email,
                                phone: this.mutableAccount.individual.phone,
                                dob: this.mutableAccount.individual.dob,
                                address: {
                                    line1: this.mutableAccount.individual
                                        .address.line1
                                        ? this.mutableAccount.individual.address
                                              .line1
                                        : "",
                                    line2: this.mutableAccount.individual
                                        .address.line2
                                        ? this.mutableAccount.individual.address
                                              .line2
                                        : "",
                                    city: this.mutableAccount.individual.address
                                        .city
                                        ? this.mutableAccount.individual.address
                                              .city
                                        : "",
                                    state: this.mutableAccount.individual
                                        .address.state
                                        ? this.mutableAccount.individual.address
                                              .state
                                        : "",
                                    postal_code: this.mutableAccount.individual
                                        .address.postal_code
                                        ? this.mutableAccount.individual.address
                                              .postal_code
                                        : "",
                                },
                            },
                            tos_shown_and_accepted: this.mutableAccount
                                .tos_shown_and_accepted,
                        },
                    })
                    .then((result) => {
                        if (result.error) {
                            this.loading = false;
                            this.stripeError = result.error.message;

                        } else {
                            this.accountToken = result.token;
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            },
        },
    };
</script>

<style lang="scss" scoped>
    .flex {
        display: flex;
    }

    .flex-1 {
        flex: 1;
    }

    .items-center {
        align-items: center;
    }

    .w-1\/2 {
        width: 50%;
    }

    .w-1\/3 {
        width: 33.333%;
    }

    .w-2\/3 {
        width: 66.666%;
    }

    .w-full {
        width: 100%;
    }

    input {
        padding: 10px !important;
        box-sizing: border-box;
        font-size: 17px !important;
        border: 1px solid #7d7d7d !important;
        border-radius: 3px;
    }

    .pr-4 {
        padding-right: 1rem;
    }

    .pb-4 {
        padding-bottom: 1rem;
    }

    .py-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }
    .flex-dir-col{
        flex-direction: column;
    }
</style>
