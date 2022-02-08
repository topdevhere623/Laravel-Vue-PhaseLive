<template>
    <div class="back">
        <span @click="back">{{ text }}</span>
    </div>
</template>

<script>
    export default {
        name: "back-button",

        props: {
            text: {
                type: String,
                default: "Back",
            },
        },

        methods: {
            back() {
                this.$router.back();
            },
        },
    };
</script>

<style lang="scss" scoped>
    .back {
      display:flex;
      align-items:center;
        cursor: pointer;
        display: inline-block;
        background: none;
        border-radius: 999px;
        outline: none;
        font-size: 10px;
        padding: 7px 12px;
        letter-spacing: 1px;
        border: 1px solid #000;
        color: #fff;
        background: #000;
        text-align: center;
    }
</style>
