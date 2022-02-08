<template>
  <modal name="modal-auth-register" width="80%" height="auto" adaptive>
    <div class="modal modal-auth-register">
      <div class="modal-header">
        <logo class="modal-logo centered-block" style="width: 185px;" />
        <close-icon
          @click.native="$modal.hide('modal-auth-register')"
        ></close-icon>
      </div>
      <div class="modal-content">
        <!-- <h1 class="no-top centered-text">Become part of the Underground Music Community</h1> -->
        <p class="centered-text" style="margin-top:50px;">
          Already a member? <a href="#" @click="showLogin">Login</a>
        </p>
        <div class="register-selections">
          <div
            class="register-selections-option"
            v-for="plan in plans"
            :key="plan.id"
          >
            <img
              class="plan_img"
              v-if="plan.role_id == 5"
              src="/img/artist.jpg"
            />
            <img
              class="plan_img"
              v-if="plan.role_id == 6"
              src="/img/artist_pro.jpg"
            />
            <img
              class="plan_img"
              v-if="plan.role_id == 4"
              src="/img/standard.jpg"
            />
            <div
              class="option-title"
              style="display: flex;justify-content: center;align-items: flex-start;"
            >
              <span>{{
                plan.title === "Artist Pro" ? "Artist" : plan.title
              }}</span>
              <span v-if="plan.title == 'Artist Pro'" class="plan_subtitle"
                ><small>Pro</small></span
              >
            </div>
            <div class="button-container">
              <ph-button size="giant" @click.native="showRegisterForm(plan)">
                Join
              </ph-button>
            </div>
            <div class="option-features" v-html="plan.content"></div>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import PhButton from "global/ph-button";
import CloseIcon from "global/close-icon";
import Logo from "global/logo";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      email: "",
      password: "",
      remember: false,
    };
  },
  mounted: function() {
    //this.$modal.show('modal-auth-register');
  },
  computed: {
    ...mapGetters({
      plans: "app/getPlans",
    }),
  },
  methods: {
    showLogin() {
      this.$modal.hide("modal-auth-register");
      this.$modal.show("modal-auth-login");
    },
    showRegisterForm(plan) {
      this.$modal.hide("modal-auth-register");
      this.$modal.show("modal-auth-register-form", { type: plan });
    },
  },
  components: {
    PhButton,
    CloseIcon,
    Logo,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.register-selections {
  width: 100%;
  display: flex;
  justify-content: space-between;
  margin: 2em 0 0;
  overflow-x: scroll;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 20px;

  @media (max-width: 1000px) {
    grid-template-columns: repeat(1, 1fr);
    grid-gap: 10px;
  }

  .register-selections-option {
    min-width: 250px;
    border-radius: 20px;
    border: 4px solid;
    padding: 1em;

    @media (max-width: 1085px) and (min-width: 1001px) {
      min-width: 223px;
    }

    @media (max-width: 395px) {
      min-width: 182px;
    }

    .plan_img {
      width: 170px;
      display: block;
      margin: 0 auto;
      margin-top: 20px;
    }

    &:first-child {
      border-color: #9fede1;
    }

    &:nth-child(2) {
      border-color: #9ccefd;
    }

    &:last-child {
      border-color: #699bfd;
    }

    .option-title,
    .option-cost {
      text-align: center;
      font-size: 40px;
      margin: 1em 0;
      font-weight: bold;

      span:nth-child(2) {
        text-transform: uppercase;
        display: flex;
        font-size: 19px;
        font-weight: normal;
        margin-left: 5px;
        letter-spacing: 2px;
      }
    }

    .button-container {
      display: flex;
      justify-content: center;
    }

    .option-subtitle {
      text-align: center;
      margin: 0.5em 0 3em;
    }
    .button {
      width: 90%;
      display: block;
      margin: 0 auto;
      border: solid;

      @media (max-width: 400px) {
        width: 86%;
      }
    }
    .option-features {
      background: white;
      border-radius: 20px;
      padding: 1em;
      margin-top: 3em;
      text-align: center;
      font-size: 13px;

      p {
        font-size: 13px;
        margin: 1em auto;
        width: 70%;
      }
    }
    .option-point {
      color: $color-blue;
    }
  }
}
</style>
