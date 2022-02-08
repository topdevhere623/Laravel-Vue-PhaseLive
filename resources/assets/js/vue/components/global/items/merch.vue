<template>
    <div class="p-item">
        <div class="p-item-image">
            <avatar
                :size="130"
                :src="merch.image.files.medium.url"
                :tile="true"
            />
        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <span>{{ merch.title }}</span>
                </div>
            </div>
            <div class="event-date-location">
                <div class="merch-description">
                    <p>{{ merch.description }}</p>
                </div>
                <div>
                    <span
                        class="merch-link"
                        v-for="(link, index) in merch.links"
                        :key="index"
                    >
                        <a :href="link.link" target="_blank"
                            ><i :class="`fab fa-${link.shop}`"></i
                        ></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Actions from "global/actions/actions";
    import ActionMenu from "global/actions/action-menu";
    import Avatar from "global/avatar";

    export default {
        props: {
            merch: {
                type: Object,
                required: true
            }
        },
        data() {
            return {};
        },
        created: function() {},
        methods: {},
        components: {
            Actions,
            ActionMenu,
            Avatar
        },
        filters: {
            addPrefix(value) {
                value = `//${value}`;
                return value;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .merch-description {
        padding-bottom: 20px;
    }
    .merch-link {
        margin-right: 5px;
        font-size: 18px;
    }
</style>
