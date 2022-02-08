<template>
    <modal name="modal-mailing-list" width="360px" height="auto" scrollable adaptive>
        <div class="modal modal-mailing-list">
            <div class="modal-header">
                <logo class="modal-logo centered-block" style="width: 175px;"/>
                <close-icon @click.native="$modal.hide('modal-mailing-list')"></close-icon>
            </div>
            <div class="modal-content">
                <form @submit.prevent="submit">
                    <input type="email" name="email" placeholder="Email" v-model="email" v-validate="'required|email'" />

                    <div class="centered-text">
                        <ph-button type="submit" size="medium" :loading="loading">
                            Submit
                        </ph-button>
                    </div>
                </form>
            </div>
        </div>
    </modal>
</template>

<script>
  import PhButton from 'global/ph-button';
  import CloseIcon from 'global/close-icon';
  import Logo from 'global/logo';
  import { HalfCircleSpinner as Spinner } from 'epic-spinners';
  import { ErrorBag } from 'vee-validate';

  export default {
    name: 'mailing-list',

    data() {
      return {
        loading: false,
        email: '',
      }
    },

    methods: {
      submit() {
        this.$validator.validateAll().then(passes => {
          if (!passes) return

          this.loading = true;

          axios.post('/api/mailing-list', {email: this.email})
              .then(response => {
                this.loading = false;

                this.$notify({
                  group: 'main',
                  type: 'success',
                  title: response.data.message,
                });

                this.email = ''

                this.$modal.hide('modal-mailing-list');
              }).catch(error => {
                this.loading = false;

                this.$notify({
                  group: 'main',
                  type: 'error',
                  title: error.data.message,
                });

                this.$modal.hide('modal-mailing-list');
              })
        })
      }
    },

    components: {
      PhButton,
      CloseIcon,
      Logo,
      Spinner
    }
  }
</script>

<style lang="scss" scoped>
  input {
    margin: 1em 0;
    padding: 5px;
    border: 1px solid #e6e6e6;
    border-radius: 5px;
  }

</style>
