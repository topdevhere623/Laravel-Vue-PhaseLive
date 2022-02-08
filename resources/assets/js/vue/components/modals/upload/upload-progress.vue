<template>
  <div>
    <spinner
      style="margin: 3em auto"
      :animation-duration="1000"
      :size="60"
      :color="variables.colors.color2"
      v-if="upload.progress < 100"
    />
    <div class="upload-progress">
      <div class="progress-outer">
        <div
          class="progress-inner"
          :style="'width: ' + upload.progress + '%'"
        ></div>
      </div>
    </div>
    <p class="upload-status">
      {{ upload.message }}<span v-if="upload.progress < 100">...</span>
      <br /><br />
      <span class="bold">{{ upload.progress }}%</span>
    </p>

    <p class="upload-info italic" v-if="upload.progress < 100">
      We're uploading your release. Please don't leave or refresh this
      page.
    </p>
    <p class="upload-info italic" v-else>
      We need to approve your release before it goes live. You can check
      the status of your release by visiting your
      <router-link
        to="/account/releases"
        @click.native="closeModal"
      >
        releases page
      </router-link>.
    </p>
  </div>
</template>

<script>
import { BreedingRhombusSpinner } from "epic-spinners";

export default {
  props: ['upload'],
  components: {
    spinner: BreedingRhombusSpinner,
  },
  data: () => ({
    variables: window.variables,
  }),
  methods: {
    closeModal() {
      this.$modal.hide("modal-upload");
    },
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.upload-status {
  margin: 2em 0 4em;
  text-align: center;
}

.upload-info {
  line-height: 25px;
  margin: 2em 0 4em;
  text-align: center;
  width: 100%;

  @media (max-width: 414px) {
    font-size: 13px;
    margin: 2em 0 2em;
  }
}

.upload-progress {
  margin: 40px auto;
  max-width: 350px;
  padding: 0 20px;

  .progress-outer {
    border: 1px solid $color-blue;
    border-radius: 5px;
  }

  .progress-inner {
    background: $color-blue2;
    height: 25px;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}
</style>