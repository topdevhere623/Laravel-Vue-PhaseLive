<template>
  <footer class="main">
<!--    <div class="footer-overlay"></div>-->
    <div class="footer-upper">
      <div class="footer-logo">
        <logo color="black" />
        <!-- <img src="/img/logo.png" alt="logo"> -->
      </div>
      <div class="footer-links">
        <navigation-list class="footer-menu" :items="navigation.footer_one" />
        <navigation-list class="footer-menu" :items="navigation.footer_two" />
        <navigation-list class="footer-menu" :items="navigation.footer_three" />
        <navigation-list class="footer-menu" :items="navigation.footer_four" />
        <navigation-list class="footer-menu" :items="navigation.footer_five" />
      </div>
      <div class="footer-social">
        <a href="https://facebook.com"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
        <a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a>
        <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <div class="footer-lower">
      <div>&copy; phase {{ new Date().getFullYear() }}</div>
      <div>
        <navigation-list
          class="footer-lower-menu"
          :items="navigation.footer_lower"
        />
      </div>
    </div>
  </footer>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import NavigationList from "../helpers/navigation-list.vue";

export default {
  components: { NavigationList },

  computed: {
    ...mapState(["app"]),
    ...mapGetters({ navigation: "app/getNavigation" }),
  },
};
</script>

<style lang="scss" scoped>
.footer-menu {
  margin: 0 25px;
}
.footer-logo {
  max-width: 183px;
}

footer {
    margin-top: 40px;
  position: relative;

  .footer-overlay {
    position: absolute;
    top: -50px;
    left: 0;
    background: red;
    height: 50px;
    width: 100%;
    background: linear-gradient(
      0deg,
      rgba(255, 255, 255, 1) 0%,
      rgba(0, 0, 0, 0) 100%
    );
  }
}
</style>
