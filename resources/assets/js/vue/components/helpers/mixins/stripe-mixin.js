export default {
    data() {
        return {
            loadedInitialCardData: false,
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
            paymentId: null,
        }
    },
    computed: {
        userHasCard: function () {
            return !!this.user && !!(this.user.card_brand && this.user.card_last_four);
        },
    },
    methods: {
        async getSetupIntent() {
            await axios.post('/api/featured-dates/create-setup-intent', {
                user_id: this.user.id,
                // items: this.featuredDates.length,
            }).then(response => {
                this.secret = response.data.client_secret
                this.paymentId = response.data.payment_method
            })
        },
        async setupCardElement() {
            this.stripe = Stripe(process.env.MIX_STRIPE_KEY)
            const elements = this.stripe.elements()
            this.cardElement = elements.create('card', { hidePostalCode: true })

            this.cardElement.mount('#card-element')

            this.loadedInitialCardData = true

            this.showCardInput()

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
    }
}
