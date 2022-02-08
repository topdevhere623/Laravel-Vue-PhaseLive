<template>
    <div>
        <!-- <ph-button
            @click.native="$modal.show('modal-create-event')"
            size="medium"
        >
            Add Event
        </ph-button>
        <spinner
            style="margin: 3em auto;"
            :animation-duration="1000"
            :size="60"
            color="black"
            v-show="loadingEvents"
        />
        <item v-for="event in events" :item="event" :key="event.id" /> -->

        <my-music />
    </div>
</template>

<script>
    import ProfileMixin from "../profile-mixin";
    import { HalfCircleSpinner as Spinner } from "epic-spinners";
    import Item from "global/items/item";
    import MyMusic from "../../../../../components/pages/account/my-music/my-music";

    export default {
        data() {
            return {
                loadingEvents: false,
                events: []
            };
        },
        created: function() {
            this.fetchEvents();
        },
        methods: {
            fetchEvents() {
                this.loadingEvents = true;
                axios
                    .get("/api/user/" + this.user.id + "/events")
                    .then((response) => {
                        this.events = response.data;
                    })
                    .finally(() => {
                        this.loadingEvents = false;
                    });
            }
        },
        mixins: [ProfileMixin],
        components: {
            Item,
            Spinner,
            MyMusic
        }
    };
</script>

<style lang="scss" scoped></style>
