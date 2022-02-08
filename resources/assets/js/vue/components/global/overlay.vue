<template>
    <!-- <div :style="`background: rgb(${color1}); background: linear-gradient(310deg, rgba(${color1},0.5) 0%, rgba(${color2},0.6) 60%);`"></div> -->
    <div
        style=" background-image: linear-gradient(120deg, #9eefe1 5%, #0050ff 96%);mix-blend-mode: multiply;"
    ></div>
</template>

<script>
    export default {
        name: "overlay",
        props: {
            color1: {
                type: String,
                default: "53,5,255"
            },
            color2: {
                type: String,
                default: "158,239,255"
            }
        }
    };
</script>

<style lang="scss" scoped>
    div {
        z-index: 10;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }
</style>
