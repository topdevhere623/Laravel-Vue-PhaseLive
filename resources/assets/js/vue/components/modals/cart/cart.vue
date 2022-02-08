<template>
  <modal
    name="modal-cart"
    width="1030px"
    height="auto"
    @opened="opened"
    @closed="closed"
    scrollable
    adaptive
  >
    <div class="modal modal-cart">
      <div class="modal-header">
        <logo style="width:183px;" />
        <!-- <img src="/img/logo.png" class="modal-logo centered-block" /> -->
        <close-icon @click.native="$modal.hide('modal-cart')"></close-icon>
      </div>
      <div class="modal-content">
        <h1 class="no-top">My Cart</h1>
        <p v-if="cart.loading">
          <spinner
            :size="50"
            color="black"
          />
        </p>
        <template v-else>
          <div v-if="cart.items.length">
            <table>
              <tr>
                <th>
                  Name
                </th>
                <th>
                  Artist
                </th>
                <th>
                  Length
                </th>
                <th>
                  Format
                </th>
                <th>
                  Price
                </th>
                <th></th>
              </tr>
              <cart-item
                v-for="item in $store.state.cart.items"
                :item="item"
                :key="item.id"
              />
            </table>

            <div class="cart-bottom-container">
              <div class="cart-bottom">
                <div class="cart-subtotal">
                  <div>
                    Sub Total:
                  </div>
                  <div>&pound;{{ $store.getters["cart/getTotal"] }}</div>
                </div>
                <ph-button size="large" @click.native="showCheckout" v-if="getUserLoggedIn">
                  Check out
                </ph-button>
                <ph-button size="large" @click.native="showCheckout" v-else>
                  Login to Check out
                </ph-button>
              </div>
            </div>
          </div>
          <div class="centered-text" v-else>
            You have no items in your cart!
          </div>
        </template>
      </div>
    </div>
  </modal>
</template>

<script>
import PhButton from "global/ph-button";
import CloseIcon from "global/close-icon";
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import { mapGetters, mapState } from "vuex";

import CartItem from "./cart-item";

export default {
  data() {
    return {};
  },
  computed: {
    ...mapState(['cart']),
    ...mapGetters('app', [
      'getUserLoggedIn'
    ])
  },

  methods: {
    async opened() {
      // await this.$store.dispatch("cart/load");
      this.$store.dispatch('cart/setLoading', false);
    },
    closed() {
      // this.$store.dispatch('cart/setLoading', true);
    },
    removeItem(item) {
      this.$store.dispatch("cart/removeItem", item);
    },
    showCheckout() {
      this.$modal.hide("modal-cart");

      /** If the user isnt logged in then log them in */
      if (!this.getUserLoggedIn) {
        /** Store the checkout modal in the query to be opened after login */
        this.$router.push({ query: { showModal: 'modal-cart', transferCart: 'true' } });

        /** The user needs to authenticate to purchase */
        this.$modal.show("modal-auth-login");
      } else {
        this.$modal.show("modal-checkout");
      }
    },
  },
  components: {
    PhButton,
    CloseIcon,
    CartItem,
    Spinner,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.modal-header {
  display: flex;
  justify-content: center;
  padding: 20px 0;
}

.modal-content {
  @media (max-width: 600px) {
    padding: 1em;
  }

  @media (max-width: 500px) {
    padding: 0.4em;
  }

  h1 {
    font-size: 34px;
  }
}

.modal-cart {
  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 5px;
  }
  td {
    padding: 15px;
  }
  th {
    padding: 15px;

    @media (max-width: 580px) {
      padding: 5px;
      font-size: 12px;
    }

    @media (max-width: 414px) {
      font-size: 11px;
    }
  }

  td:last-child {
    position: relative;
    padding: 0;
  }

  .cart-bottom-container {
    display: flex;
    justify-content: flex-end;
  }
  .cart-bottom {
    text-align: right;
  }
  .cart-subtotal {
    padding: 2em 0 2em;
    display: flex;
    align-items: flex-end;

    & > :last-child {
      margin-left: 1em;
      font-size: 36px;
      font-weight: bold;

      @media (max-width: 414px) {
        font-size: 24px;
      }
    }
  }
}
</style>
