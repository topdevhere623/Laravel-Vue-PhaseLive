<template>
    <span class="report-button" v-if="app.user.loggedin" :title="'Report ' + reportable.type" @click="showReportModal" :class="{ hidden: hidden }">
        <span>
            <i class="fa fa-exclamation-triangle"></i>
        </span>
    </span>
</template>

<script>
    //import Component from '../';
    import { mapState } from 'vuex';

    export default {
        props: {
            reportable: { // This is the object e.g. 'track', 'release', 'comment'
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
                this.$modal.show('modal-report', { reportable: this.reportable });
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