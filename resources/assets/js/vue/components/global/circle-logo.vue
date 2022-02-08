<template>
  <a
    :class="{ invert: invert }"
    :style="`width:${width};height:${height};`"
  >
    <slot></slot>
  </a>
</template>

<script>
export default {
  props: {
    invert: {
      type: Boolean,
    },
    height: {
      type: String,
    },
    width: {
      type: String,
    },
  },
};
</script>

<style lang="scss" scoped>
a {
  background: #3300ff;
  border-radius: 50%;
  border: 2px solid #3300ff;
  text-decoration: none;
  display: flex;
  height: 100%;
  justify-content: center;
  align-items: center;
  color: #ffffff;
  font-weight: bold;
  width: 100%;

  &.invert {
    color: #3300ff;
    background: #fff;
  }
}
</style>
