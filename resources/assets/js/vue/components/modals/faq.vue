<template>
    <modal name="modal-faq" width="700px" height="auto" scrollable @before-open="beforeOpen">
        <div class="modal modal-faq">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-faq')"></close-icon>
            </div>
            <div class="modal-content" v-if="faq">
                <h2>{{ faq.question }}</h2>
                <p v-html="faq.answer.replace(/(?:\r\n|\r|\n)/g, '<br>')"></p>
            </div>
        </div>
    </modal>
</template>

<script>
    import CloseIcon from 'global/close-icon';

    export default {
        data () {
            return {
                faq: null,
            }
        },
        created: function() {

        },
        mounted: function() {

        },
        methods: {
            beforeOpen (event) {
                this.faq = event.params.faq;
            },
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
        line-height: 25px;
    }
</style>