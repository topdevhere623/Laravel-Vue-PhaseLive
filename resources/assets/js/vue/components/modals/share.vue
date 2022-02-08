<template>
    <modal name="modal-share" width="700px" height="auto" scrollable @before-open="beforeOpen">
        <div class="modal modal-share">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-share')"></close-icon>
            </div>
            <div class="modal-content">
                <h2>Share {{ shareable.type }}</h2>
                <p>
                    Write a comment to show your followers.
                </p>
                <textarea placeholder="Comment" rows="4" v-model="message"></textarea>
                <item :item="shareable" />
                <br>
                <ph-button
                        size="large"
                        :loading="submitting"
                        @click.native="submit">
                    Share
                </ph-button>
            </div>
        </div>
    </modal>
</template>

<script>
    import { SocialEvents } from "events";
    import CloseIcon from 'global/close-icon';
    import Item from 'global/items/item';

    export default {
        data () {
            return {
                submitting: false,
                shareable: {},
                message: '',
            }
        },
        created: function() {

        },
        methods: {
            beforeOpen (event) {
                this.shareable = event.params.shareable;
            },
            submit() {
                this.submitting = true;
                axios.post('/api/social/share/' + this.shareable.type + '/' + this.shareable.id, {
                    message: this.message,
                }).then(response => {
                    this.$modal.hide('modal-share');
                    SocialEvents.$emit('shared', this.shareable);
                    this.$notify({
                        group: 'main',
                        type: 'success',
                        title: 'Sucessfully shared!',
                    });
                }).finally(() => {
                    this.submitting = false;
                })
            },
        },
        components: {
            CloseIcon,
            Item,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    p {
        margin-bottom: 15px;
    }
    textarea {
        width: 100%;
        border: none;
        padding: 8px;
        font-size: 12px;
        font-size: inherit;
        resize: vertical;
        font-family: $font-comfortaa;
    }
</style>