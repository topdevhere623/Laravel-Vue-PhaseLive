<template>
    <ph-panel v-if="verification">
        <h2>Verification Details</h2>
        <hr>
        <div v-if="verification && verification.length">
            <div v-for="(file, index) in verification" :key="index">
                <label :for="file">{{ file }}</label>
                <input type="file" :id="file" :name="file" accept=".jpeg,.jpg,.png">
            </div>

            <ph-button @click.native="submitForm" :loading="loading">Upload</ph-button>
        </div>
        <div v-else>
            You have supplied all the required documents.
        </div>
    </ph-panel>
</template>

<script>
  export default {
    name: 'verification-details',

    props: {
      account: {
        type: Object || null,
      },
    },

    data() {
      return {
        loading: false,
        verification: null,
        files: null,
        verified:false
      }
    },

     watch: {
      account: {
        handler: function (val, oldVal) { 
          this.initVerification();
        },
        deep: true
      },
    },

    mounted() {
      this.initVerification();
      // this.files = this.retrieveFiles()
    },

    methods: {
      initVerification(){
        if(this.account && this.account.requirements.pending_verification.length && !this.verified && this.account.external_accounts.data.length>0){
          this.verification = this.account.requirements.pending_verification.filter(item => {
            return item.startsWith('individual.verification')
          }).map(item => {
            return item.split('.').pop()
          })
        }else{
          this.verification = null;
        }
      },
      async submitForm() {
        const stripe = Stripe(process.env.MIX_STRIPE_KEY)
        const files = await this.uploadFiles({
          document: document.querySelector(`#document`) ? document.querySelector(`#document`).files[0] : null,
          additional_document: document.querySelector(`#additional_document`) ? document.querySelector(`#additional_document`).files[0] : null,
        })

        const verification = {
          document: {
            front: files.document ? files.document.id : null,
          },
          additional_document: {
            front: files.additional_document ? files.additional_document.id : null,
          },
        }

        const result = await stripe.createToken('account', {
          account: {
            individual: {
              verification: verification,
            },
          },
        })

        if (result.token) {
          await axios.post('/api/account/marketplace/update', {
            token: result.token.id,
          }).then((response) => {
            console.log(response);
            Vue.$notify({
              group: 'main',
              type: 'success',
              title: 'Successfully uploaded document',
            })
            this.$emit('document_uploaded')
            this.verified = true;
            this.loading = false
          }).catch(error => {
            Vue.$notify({
              group: 'main',
              type: 'error',
              title: 'Error uploading document',
            })
          })
        } else {
          Vue.$notify({
            group: 'main',
            type: 'error',
            title: 'Error uploading document',
          })
          this.loading = false
        }
      },

      async uploadFiles(files) {
        const document = await this.uploadFile(files.document)
        const additional_document = await this.uploadFile(files.additional_document)

        return {
          document: document,
          additional_document: additional_document,
        }
      },

      async uploadFile(file) {
        if (file) {
          const data = new FormData()
          data.append('file', file)
          data.append('purpose', 'identity_document')
          this.loading = true
          const fileResult = await fetch('https://uploads.stripe.com/v1/files', {
            method: 'POST',
            headers: {'Authorization': `Bearer ${process.env.MIX_STRIPE_KEY}`},
            body: data,
          })

          return await fileResult.json()
        }
      },

      async retrieveFiles() {
        const files = this.account.individual.verification.document.front
        await axios.get(`/api/account/marketplace/get_file/${files}`)
          .then(response => {
            // axios.get(`/api/account/marketplace/get_file_link/${response.data.}`)
            this.files = response.data
          })
      },
    },
  }
</script>

<style lang="scss" scoped>

</style>
