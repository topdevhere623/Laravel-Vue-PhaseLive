<template>
    <span class="report-button" v-if="app.user.loggedin" :title="'Delete ' + deleteable.type" @click="showReportModal" :class="{ hidden: hidden }">
        <span>
            <i class="fa fa-trash"></i>
        </span>
    </span>
</template>

<script>
    //import Component from '../';
    import { mapState } from 'vuex';

    export default {
        name: 'delete-button',
        props: {
            deleteable: { // This is the object e.g. 'track', 'release', 'comment'
                type: Object,
                required: true,
            },
            hidden: {
                type: Boolean,
                default: false,
            }
        },
        data () {
            return {

            }
        },
        computed: mapState([
            'app',
        ]),
        methods: {
            showReportModal() {
                this.$modal.show('modal-delete-confirm', { deleteable: this.deleteable });
            }
        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    .report-button {
        cursor: pointer;
    }
    .hidden {
        display: none;
    }
</style>