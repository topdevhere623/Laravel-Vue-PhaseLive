<template>
    <ph-panel id="manage">
        <h2>Manage Account</h2>
        <hr>
        <p>
            Deactivate or delete your account permanently.
        </p>
        
        <div>
            <ph-button
                    v-if="app.user.roles[0].name === 'artist'"
                    style="margin-bottom: 5px;"
                    size="medium"
                    @click.native="downgradeAccount"
                    :loading="downgrading"
            >
                Downgrade to Standard
            </ph-button>
            <ph-button
                    v-if="app.user.roles[0].name === 'standard'"
                    style="margin-bottom: 5px;"
                    size="medium"
                    @click.native="openVerificationModal"
                    :loading="upgrading"
            >
                Upgrade to Artist
            </ph-button>
            <ph-button style="margin-bottom: 5px;" size="medium" @click.native="deleteAccount">
                Delete Account
            </ph-button>
            <ph-button size="medium" @click.native="deactivateAccount">
                Deactivate Account
            </ph-button>
        </div>

        <delete-modal></delete-modal>
        <deactivate-modal></deactivate-modal>
        <modal
            name="modal-account-reg-form"
            @before-open="beforeOpen"
            @closed="closed"
            width="80%"
            height="auto"
            scrollable
            style="padding: 10px 35px;display: table-cell;"
        >
            <div class="modal modal-account-reg-form">
            <div class="modal-header">
                <logo class="modal-logo centered-block" style="width: 185px;" />
            </div>
            <div class="modal-content full-width" v-if="!submitted" style="padding: 10px 35px;">
                
                <connect-details
                    :user="app.user"
                    v-if="step === 2"
                    @next-step="step++"
                    @finished="submitted = true"
                ></connect-details>
                <verification-details
                    :user="app.user"
                    v-if="step === 3"
                    @finished="upgradeAccount"
                ></verification-details>
            </div>
            </div>
        </modal>
    </ph-panel>
</template>

<script>
    import DeleteModal from './../../../modals/delete'; 
    import DeactivateModal from './../../../modals/deactivate';
    import ConnectDetails from './connect-details';
    import VerificationDetails from './verification-details';
    import {mapState} from "vuex";

    export default {
        data () {
            return {
                step:1,
                upgrading: false,
                downgrading: false,
                submitted: false
            }
        },
        computed: {
            ...mapState([
                'app'
            ])
        },
        mounted: function() {
            
        },
        methods: {
            beforeOpen(){

            },
            closed(){

            },
            deactivateAccount() {
                this.$modal.show('modal-deactivate');
            },
            deleteAccount() {
                this.$modal.show('modal-delete');
            },
            openVerificationModal(){
                this.step = 2;
                this.$modal.show("modal-account-reg-form");
                this.upgrading = true;
            },
            upgradeAccount() {
                this.submitted = true;
                this.$modal.hide("modal-account-reg-form");
                axios.post('/api/account/upgrade', {user_id: this.app.user})
                    .then(response => {
                        this.$store.commit('app/setUser', response.data)
                        this.$notify({
                            group: 'main',
                            type: 'success',
                            title: 'Successfully upgraded account',
                        });
                        this.upgrading = false;
                        
                    }).finally(()=>location.reload())
            },
            downgradeAccount() {
                this.downgrading = true
                axios.post('/api/account/downgrade', {user_id: this.app.user})
                    .then(response => {
                        this.$store.commit('app/setUser', response.data)
                        this.$notify({
                            group: 'main',
                            type: 'success',
                            title: 'Successfully upgraded account',
                        });
                        this.downgrading = false
                    })
            },
        },
        components: {
            'delete-modal':DeleteModal,
            'deactivate-modal':DeactivateModal,
            'connect-details':ConnectDetails,
            'verification-details':VerificationDetails,
        }
    }
</script>

<style lang="scss" scoped>
    p {
        margin: 10px 0;
    }
</style>
