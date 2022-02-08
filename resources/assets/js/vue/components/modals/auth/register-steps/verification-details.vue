<template>
    <div>
        <h1>Verification Details</h1>

        <div>
            <p>The following details are required to provide verification and a method of payment for sales, these can
                be added later in your account area but must be complete before uploading a release</p>

            <div>
                <label for="document">Document</label>
                <input type="file" id="document" name="document" accept=".jpeg,.jpg,.png">
            </div>

            <div>
                <label for="additional_document">Additional document</label>
                <input type="file" id="additional_document" name="additional_document" accept=".jpeg,.jpg,.png">
            </div>

            <ph-button @click.native="submitForm" :loading="loading">Upload</ph-button>
            <ph-button @click.native.prevent="$emit('finished')">
                Skip
            </ph-button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: 'verification-details',

        data() {
            return {
                loading: false,
            }
        },

        computed: {
            ...mapGetters({
                tempUser: 'app/getTempUser',
            }),
        },

        methods: {
            async submitForm() {
                this.loading = true
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
                    await axios.post('/api/auth/marketplace/update', {
                        token: result.token.id,
                        user_id: this.tempUser.id,
                    }).then(() => {
                        this.$notify({
                            group: 'main',
                            type: 'success',
                            title: 'Successfully uploaded document',
                        })
                        this.$emit('document_uploaded')
                        this.$emit('finished')
                        this.loading = false
                    }).catch(error => {
                        this.$notify({
                            group: 'main',
                            type: 'error',
                            title: 'Error uploading document',
                        })
                        this.loading = false
                    })
                } else {
                    this.$notify({
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
        }
    }
</script>

<style lang="scss" scoped>

</style>
