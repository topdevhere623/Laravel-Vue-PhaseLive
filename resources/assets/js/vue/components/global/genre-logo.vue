<template>
  <router-link
    :to="getRouterObject(genre)"
    style="height:200px;width:200px;"
    :style="genre.id % 2 != 0 ? 'color:#3300ff;background:#fff;' : null"
  >
    <div class="genre-name">
      {{ genre.name }}
    </div>
  </router-link>
</template>

<script>
export default {
  props: ["genre"],
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
}
</style>
