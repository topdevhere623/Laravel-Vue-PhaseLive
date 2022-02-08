<template>
    <modal name="modal-report" width="500px" height="auto" scrollable @before-open="beforeOpen">
        <div class="modal modal-report">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-report')"></close-icon>
            </div>
            <div class="modal-content">
                <h2>Report {{ reportable.type }}</h2>
                <p>
                    You can report content on Phase if you believe it does not conform to the content policy.
                </p>
                <div v-if="!response">
                        <textarea name="message" v-model="message" :disabled="submitting" :placeholder="'Please briefly explain why this ' + reportable.type + ' breaks the rules'" v-validate="'required'"><b>test</b></textarea>
                    <span class="error-msg" v-if="errors.has('message')">{{ errors.first('message') }}</span>
                    <div class="save-button">
                        <ph-button size="large" @click.native="submit" :loading="submitting">Submit</ph-button>
                    </div>
                </div>
                <div v-else>
                    <ph-panel type="success" v-if="response.success">
                        <h2 class="no-top header">Success!</h2>
                        <p>
                            Thank you for your report! We will review it and decide on the appropriate action.
                        </p>
                    </ph-panel>
                    <ph-panel type="error" v-else>
                        <h2 class="no-top header">Report failed!</h2>
                        <p>
                            {{ response.message }}
                        </p>
                    </ph-panel>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import CloseIcon from 'global/close-icon';

    export default {
        data () {
            return {
                reportable: {},
                message: '',
                submitting: false,
                response: null,
            }
        },
        created: function() {

        },
        mounted: function() {

        },
        methods: {
            beforeOpen (event) {
                this.reportable = event.params.reportable;
                this.message = '';
                this.submitting = false;
                this.response = null;
            },
            submit() {
                this.$validator.validateAll().then(passes => {
                    if(!passes) return;
                    this.submitting = true;
                    axios.post('/api/report', {
                        type: this.reportable.type,
                        id: this.reportable.id,
                        message: this.message,
                    }).then(response => {
                        this.submitting = false;
                        this.response = response.data
                    }).catch(() => {
                        this.submitting = false;
                    });
                });
            }
        },
        components: {
            CloseIcon,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    h2 {
        margin-bottom: 0;
    }
    p {
        margin: 1em 0;
    }
    textarea {
        box-sizing: border-box;
        border: 1px solid $color-grey2;
        padding: 5px;
        width: 100%;
        height: 50px;
    }
    .save-button {
        margin-top: 1em;
        text-align: center;
    }
    .error-msg {
        font-size: 70%;
        color: red;
    }
</style>