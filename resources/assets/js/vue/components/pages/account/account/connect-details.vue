<template>
	<div>
		
		<form @submit.prevent="handleForm" id="account-form">
			<h1>Connect Details</h1>
			<p>The following details are required to provide verification and a method of payment for sales, these can be added later in your account area but must be complete before uploading a release</p>

			<div class="flex">
				<div class="input">
					<div>First Name:</div>
					<div>
						<input type="text" name="first_name" v-model="account.individual.first_name" tabindex="1" v-validate="'required|max:255'" data-vv-as="first name" />
						<span class="error-message">{{ errors.first("first_name") }}</span>
					</div>
				</div>
				<div class="input">
					<div>Last Name:</div>
					<div>
						<input type="text" name="last_name" v-model="account.individual.last_name" tabindex="1" v-validate="'required|max:255'" data-vv-as="last name" />
						<span class="error-message">{{ errors.first("last_name") }}</span>
					</div>
				</div>
			</div>
			<div class="flex">
				<div class="input" style="align-items: center;">
					<div>Gender:</div>
					<div>
						<select name="gender" id="gender" v-model="account.individual.gender" style="width:100%;" v-validate="'required'">
							<option value="">Gender</option>
							<option value="male">Male</option>
							<option value="male">Female</option>
						</select>
						<span class="error-message">{{ errors.first("gender") }}</span>
					</div>
				</div>
				<div class="input">
					<div>DOB:</div>
					<div class="flex dob-fields" style="flex-direction:column;">
						<input
							name="day" 
							id="day" 
							type="text"
							placeholder="Day"
							v-model="account.individual.dob.day"
							v-validate="'required|between:1,31'"
						/>
						<input
							name="month" 
							id="month" 
							type="text"
							placeholder="Month"
							v-model="account.individual.dob.month"
							v-validate="'required|between:1,12'"
						/>
						<input
							name="year" 
							id="year" 
							type="text"
							maxlength="4"
							placeholder="Year"
							v-model="account.individual.dob.year"
							v-validate="'required|min_value:1900|max_value:2020'"
						/>
						<span class="error-message flex">{{
                            errors.first("day") || errors.first("month") || errors.first("year")
                        }}</span>
					</div>
				</div>
			</div>
			
			<div class="flex">
				<div class="input">
					<div>Email:</div>
					<div>
						<input type="text" name="email" v-model="account.individual.email" v-validate="'required|email'" />
						<span class="error-message">{{ errors.first("email") }}</span>
					</div>
				</div>
				<div class="input">
					<div>Phone:</div>
					<div>
						<input type="text" name="phone" placeholder="+441234567890"  v-model="account.individual.phone" v-validate="{ required: true, regex: /((\+44?))\d{11}/}" />
						<span class="error-message">{{ errors.first("phone") }}</span>
					</div>
				</div>
			</div>
			<div class="flex">
				<div class="input">
					<div>Address:</div>
					<div>
						<input type="text" name="line1" v-model="account.individual.address.line1" v-validate="'required'" placeholder="Line 1" />
						<span class="error-message">{{
                            errors.first("line1")
                        }}</span>
						<input type="text" name="line2" v-model="account.individual.address.line2" placeholder="Line 2" />
						<input type="text" name="city" v-model="account.individual.address.city" v-validate="'required'" placeholder="City" />
						<span class="error-message">{{
                            errors.first("city")
                        }}</span>
						<input type="text" name="state" v-model="account.individual.address.state" placeholder="County" />
						<input type="text" name="postal_code" v-model="account.individual.address.postal_code" v-validate="'required'" placeholder="Post Code" />
						<span class="error-message">{{
                            errors.first("postal_code")
                        }}</span>
						<input type="text" name="country" v-model="account.individual.address.country" v-validate="'required'" placeholder="Country" />
						<span class="error-message">{{
                            errors.first("country")
                        }}</span>
					</div>
				</div>
			</div>

			<div class="flex" style="flex-direction:column;">
				<div class="input">
					<div>Accept Terms of Service:</div>
					<input name="terms" type="checkbox" v-model="account.tos_shown_and_accepted" v-validate="'required'" data-vv-as="Terms and Conditions" />
				</div>
				<span class="error-message">{{
                            errors.first("terms")
                	}}</span>
			</div>
			
			<div class="error-message flex" v-if="connectErrors">
			{{connectErrors}}
			</div>

			<div class="submit-buttons">
				<div class="button-wrap">
					<ph-button size="large" :loading="submitting">
						Submit
					</ph-button>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
	name: "connect-details",
	props:["user"],
	data() {
		return {
			date: "",
			connectErrors: null,
			accountToken: null,
			submitting: false,
			account: {
				business_type: "individual",
				individual: {
					first_name: '',
					last_name: '',
					dob: {
						day: "",
						month: "",
						year: "",
					},
					gender: '',
					email: '',
					phone: '',
					address: {
						line1: '',
						line2: "",
						city: '',
						state: '',
						postal_code: '',
						country: '',
					},
				},
				website: null,
				tos_shown_and_accepted: false,
			},
		};
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

		if (this.user) {
			this.account.individual.first_name = this.user.first_name;
			this.account.individual.last_name = this.user.last_name;
			this.account.individual.email = this.user.email;
			this.account.individual.phone = this.user.phone ? this.user.phone : '';
			this.account.website = this.user.social_web;
		}
	},

	computed: {
		...mapGetters({
			tempUser: "app/getTempUser",
		}),
		currentYear() {
			return new Date().getFullYear();
		},
	},

	methods: {
		async getAccountToken() {
			const stripe = Stripe(process.env.MIX_STRIPE_KEY);

			await stripe
				.createToken("account", this.account)
				.then((result) => {
					if (result.token) {
						this.connectErrors = null;
						this.accountToken = result.token.id;
					}
					if (result.error) {
						this.connectErrors = result.error.message;
						this.submitting = false;
					}
				})
				.catch((error) => {
					this.connectErrors = error.message;
					this.submitting = false;
				});
		},
		async handleForm() {
			this.$validator.validate().then(async (valid) => {
				if (valid) {
					this.connectErrors = null;
					this.submitting = true;

					await this.getAccountToken();

					if (this.accountToken && !this.connectErrors) {
						await axios
							.post("/api/auth/marketplace/create", {
								account_token: this.accountToken,
								user_id: this.user.id,
								website: this.account.website,
							})
							.then((response) => {
								this.submitting = false;
								this.$emit("next-step");
							})
							.catch((error) => {
								this.submitting = false;
								this.connectErrors = error.response.data.message;
							});
					}
				}
			});
		},
	},
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.submit-buttons {
	display: flex;
	flex-direction: column;

	.button-wrap {
		padding: 10px 0;
		display: flex;
		justify-content: center;
	}
}

.full-width {
	flex-basis: 100%;
}

.dob-fields {
	input,
	select {
		margin: 10px 0;
	}
}

.input {
	flex: 1;
	display: flex;
	margin: 1.8em 0;
	width: 48%;
	padding: 0 20px;

	& > div:first-of-type {
		width: 125px;
		display: flex;
		align-items: center;
	}

	& > div:last-of-type {
		flex: 1;
		position: relative;
	}

	input,
	select {
		padding: 10px !important;
		box-sizing: border-box;
		font-size: 17px !important;
		border: 1px solid $color-grey4 !important;
		border-radius: 3px;
	}
}
</style>
