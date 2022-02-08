<template>
  <modal
    name="modal-auth-register-form"
    @before-open="beforeOpen"
    @closed="closed"
    width="70%"
    height="auto"
    scrollable
  >
    <div class="modal modal-auth-register-form">
      <div class="modal-header">
        <logo class="modal-logo centered-block" style="width: 185px;" />
        <close-icon
          @click.native="$modal.hide('modal-auth-register-form')"
        ></close-icon>
      </div>
      <div class="modal-content full-width" v-if="!submitted">
        <!--                <div class="membership-selection">-->
        <!--                    <div class="membership-type" v-for="plan in plans" :key="plan.id" @click="selectedPlan = plan">-->
        <!--                        <img src="https://placehold.it/150x150" :alt="plan.title"-->
        <!--                             :class="{ selected : isSelected(plan) }"/>-->
        <!--                        <span>{{ plan.title }}</span>-->
        <!--                    </div>-->
        <!--                </div>-->
        <form class="register-form" v-if="selectedPlan">
          <personal-details
            v-if="step === 1"
            :selected-plan="selectedPlan"
            @next-step="nextStep"
          ></personal-details>
          <connect-details
            v-if="step === 2"
            @finished="onHandleFinished"
          ></connect-details>

          <div
            class="time-confirmation-text"
            style="padding: 20px 50px"
            v-if="selectedPlan.id !== 1"
          >
            <br />
            <p style="margin-top: 30px;">
              *
              {{ selectedPlan.id === 2 ? "Artist" : "Artist Pro" }} Applications
              are subject to a verification process. This may take up to 48
              hours.
            </p>
          </div>
        </form>
      </div>
      <div class="modal-content" v-else>
        <h2>
          Your registration was successful!
        </h2>
        <p>
          Please check your email for account activation instructions.
        </p>
        <div class="flex justify-center" style="padding: 20px 0;">
          <ph-button size="large" @click.native.prevent="showLoginModal">
            Login
          </ph-button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "global/close-icon";
import Logo from "global/logo";
import PersonalDetails from "./register-steps/personal-details";
import ConnectDetails from "./register-steps/connect-details";
import VerificationDetails from "./register-steps/verification-details";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      step: 1,
      selectedPlan: null,
      submitted: false,
    };
  },
  computed: {
    ...mapGetters({
      plans: "app/getPlans",
    }),
  },
  methods: {
    isSelected(plan) {
      return plan === this.selectedPlan;
    },
    beforeOpen(event) {
      this.selectedPlan = event.params.type;
    },
    closed() {
      this.selectedPlan = null;
      this.submitted = false;
    },
    onHandleFinished() {
      this.submitted = true;
      this.step = 1;
    },
    nextStep() {
      if (this.selectedPlan.title === "Standard") {
        return (this.submitted = true);
      }

      this.step++;
    },
    showLoginModal() {
      this.$modal.hide("modal-auth-register-form");
      this.$modal.show("modal-auth-login");
    },
  },
  components: {
    CloseIcon,
    Logo,
    PersonalDetails,
    ConnectDetails,
    VerificationDetails,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.membership-selection {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;
}

.membership-type {
  text-align: center;
  flex-basis: 33%;

  img {
    padding: 0;

    &.selected {
      border: 10px solid $color-2;
    }
  }

  span {
    display: block;
    margin-top: 30px;
    text-transform: uppercase;
    font-size: 20px;
  }
}

.time-confirmation-text {
  @media (max-width: 768px) {
    padding: 20px 8px !important;

    p {
      margin-top: 0px !important;
    }
  }
}
</style>
