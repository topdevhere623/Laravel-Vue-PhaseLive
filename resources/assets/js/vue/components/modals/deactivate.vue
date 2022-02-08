<template>
    <modal name="modal-deactivate" width="500px" height="auto" scrollable adaptive>
        <div class="modal modal-deactivate">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-deactivate')"></close-icon>
            </div>
            <div class="modal-content">
                <h2>Deactivate Account</h2>
                <p>
                    Are you sure you want to deactivate your account?
                </p>
                    
                <div class="save-button">
                    <ph-button size="large" @click.native="deactivateAccount" :loading="submitting">Deactivate</ph-button>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import { mapState } from 'vuex';
    import CloseIcon from 'global/close-icon';
    export default {
        data () {
            return {
                submitting: false,
                response: null,
            }
        },
        created: function() {

        },
        mounted: function() {

        },
        computed: {
            ...mapState([
                'app'
            ])
        },
        methods: {
            deactivateAccount() {
                    this.submitting = true;
                    axios.get('/api/user/delete/'+this.app.user.id).then(response => {
                        window.location.href = '/';
                    }).catch(() => {
                        this.submitting = false;
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
        margin-top: 1.5em;
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