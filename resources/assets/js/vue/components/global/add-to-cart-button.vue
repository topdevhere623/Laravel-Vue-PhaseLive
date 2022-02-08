<template>
    <span class="atc-button" @click="toggle">
        &pound;{{ (product.price / 100).toFixed(2) }}
        <span v-show="loading">
            <i class="fas fa-spinner fa-spin"></i>
        </span>
        <span v-show="!isInCart(product) && !loading">
            <i class="fas fa-cart-plus"></i>
        </span>
        <span v-show="isInCart(product) && !loading">
            <i class="fas fa-check"></i>
        </span>
    </span>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        props: {
            product: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {
                loading: false
            }
        },
        computed: {
            ...mapGetters('cart', [
                'isInCart',
            ]),
            ...mapGetters('app', [
                'getUserLoggedIn'
            ])
        },
        methods: {
            toggle() {
                // if(!this.getUserLoggedIn){
                //     this.$modal.show("modal-auth-register");
                //     return;
                // }

                if(this.isInCart(this.product)) {
                    this.removeFromCart()
                } else {
                    this.addToCart()
                }
            },
            addToCart() {
                this.$store.dispatch('cart/addItem', this.product);
            },
            removeFromCart() {
                this.$store.dispatch('cart/removeItem', this.product);
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .atc-button {
        padding: 10px;
        display: inline-block;
        background: $color-blue;
        color: white;
        border-radius: 5px;
        cursor: pointer;

        &:hover {
            background: darken($color-blue, 10);
        }
    }
</style>