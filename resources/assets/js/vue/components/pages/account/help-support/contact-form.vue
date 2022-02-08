<template>
    <div class="contact-form">
        <h2>Still didn't find what you're looking for?</h2>
        <h3>Send us a message using the form below.</h3>
        <ph-panel type="error" v-if="error === true">
            <h4>Error!</h4>
            <p>
                We encountered an unknown error when submitting this form. Please try again later.
            </p>
        </ph-panel>
        <form v-if="!submitted">
            <input
                    type="email"
                    v-model="input.email"
                    placeholder="Email"
                    name="email"
                    :disabled="submitting"
                    v-validate="'required|email'"
            />
            <span class="error-message">{{ errors.first('email') }}</span>

            <input
                    type="text"
                    v-model="input.name"
                    placeholder="Name"
                    name="name"
                    :disabled="submitting"
                    v-validate="'required'"
            />
            <span class="error-message">{{ errors.first('name') }}</span>

            <textarea
                    placeholder="Message"
                    rows="10"
                    v-model="input.message"
                    name="message"
                    :disabled="submitting"
                    v-validate="'required'"
            ></textarea>
            <span class="error-message">{{ errors.first('message') }}</span>
            <br>
            <br>
            <ph-button size="medium" @click.native.prevent="submit" :loading="submitting">Send</ph-button>
        </form>
        <ph-panel type="success" v-else>
            <h4>Success!</h4>
            <p>
                Your message was submitted successsfully.
            </p>
        </ph-panel>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        submitting: false,
        submitted: false,
        error: false,
        input: {
          email: '',
          name: '',
          message: '',
        }
      }
    },
    created: function() {

    },
    methods: {
      submit() {
        this.$validator.validateAll().then(passes => {
          if(passes) {
            this.submitting = true;
            this.error = false;
            axios.post('/api/help/contact', this.input).then(() => {
              this.submitted = true;
            }).catch(() => {
              this.error = true;
            }).finally(() => {
              this.submitting = false;
            });
          }
        });
      },
    },
    components: {

    }
  }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .contact-form {
      form{
        @media(max-width: 700px){
          padding-left: 0;
          width: 90%;
        }
      }
    }
    .error-message {
        position: absolute;
        color: red;
        font-size: 13px;
    }
    input, textarea {
        margin: 30px 0 5px;
        padding: 10px;
        border: 1px solid $color-grey;
    }
</style>