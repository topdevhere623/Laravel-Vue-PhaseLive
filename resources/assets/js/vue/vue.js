import Vue from "vue";
import VeeValidate from "vee-validate";
import VModal from "vue-js-modal";
import VueProgressBar from "vue-progressbar";
import Notifications from "vue-notification";
import Snotify from "vue-snotify";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import "vue-snotify/styles/material.css";
import VCalendar from "v-calendar";
import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/dist/vueDirectiveTooltip.css';


require("vue-social-sharing");
require("../vee-validate/vee-validate");
Vue.use(Tooltip);
Vue.use(Snotify);
Vue.use(VeeValidate);
Vue.use(VModal);
Vue.use(VueProgressBar, {
  color: "#9eefe1",
  failedColor: "red",
  height: "10px",
});
Vue.use(Notifications);
Vue.use(flatPickr);
Vue.use(SocialSharing);
Vue.use(VCalendar, {
  masks: {
    input: ["DD/MM/YYYY"],
    data: ["DD/MM/YYYY"],
  },
});

Vue.mixin({
  methods: {
    $can(permissionName) {
      const user = store.getters["app/getUser"];

      return user.all_permissions.indexOf(permissionName) !== -1;
    },
  },
});

Vue.directive("click-outside", {
  bind: function(el, binding, vNode) {
    // Provided expression must evaluate to a function.
    if (typeof binding.value !== "function") {
      const compName = vNode.context.name;
      let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`;
      if (compName) {
        warn += `Found in component '${compName}'`;
      }

      console.warn(warn);
    }
    // Define Handler and cache it on the element
    const bubble = binding.modifiers.bubble;
    const handler = (e) => {
      if (bubble || (!el.contains(e.target) && el !== e.target)) {
        binding.value(e);
      }
    };
    el.__vueClickOutside__ = handler;

    // add Event Listeners
    document.addEventListener("click", handler);
  },

  unbind: function(el, binding) {
    // Remove Event Listeners
    document.removeEventListener("click", el.__vueClickOutside__);
    el.__vueClickOutside__ = null;
  },
});

Vue.filter("capitalize", function(value) {
  if (!value) return "";
  value = value.toString();

  return value.charAt(0).toUpperCase() + value.slice(1);
});

// Global Components
import PhPanel from "global/ph-panel";
Vue.component("ph-panel", PhPanel);
import PhButton from "global/ph-button";
Vue.component("ph-button", PhButton);
import PhSelect from "global/ph-select";
Vue.component("ph-select", PhSelect);
import Avatar from "global/avatar";
Vue.component("avatar", Avatar);
import BackButton from "global/back-button";
Vue.component("back-button", BackButton);
import Logo from "global/logo";
Vue.component("logo", Logo);
import GenreLogo from "global/genre-logo";
Vue.component("genre-logo", GenreLogo);

import router from "./router/router";
import store from "./store/store";

import App from "./components/app";

window.Vue = new Vue({
  router,
  store,
  components: { App },
  template: "<App/>",
}).$mount("#vue");
