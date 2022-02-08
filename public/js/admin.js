(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/admin"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/admin/meta.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/admin/meta.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var id = 0;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      metaSelectionMode: false,
      image: {
        'uploaded': null,
        'input': null
      },
      content: null,
      repeater: {
        slider: [],
        text: [],
        dropdown: []
      }
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get('/admin/meta/get/' + $('#page_id').val()).then(function (response) {
      if (response.data) {
        _this.repeater = response.data.repeater;
        _this.image = response.data.image;
        _this.content = response.data.content;
        console.log(_this.image);
      } else {
        reject();
      }
    });
  },
  methods: {
    addMeta: function addMeta() {
      this.metaSelectionMode = true;
    },
    selectMetaType: function selectMetaType(event) {
      this.metaSelectionMode = false;

      if (event.target.value == 'slider') {
        this.repeater.slider.push({
          id: this.repeater.slider.length,
          name: '',
          uploaded: [],
          inputs: []
        });
      } else if (event.target.value == 'text') {
        this.repeater.text.push({
          id: this.repeater.text.length,
          name: '',
          inputs: []
        });
      } else if (event.target.value == 'dropdown') {
        this.repeater.dropdown.push({
          id: this.repeater.dropdown.length,
          name: '',
          inputs: []
        });
      }
    },
    addToRepeater: function addToRepeater(idx, type) {
      if (type == 'text') {
        this.repeater[type][idx].inputs.push({
          value: ''
        });
      } else if (type == 'dropdown') {
        this.repeater[type][idx].inputs.push({
          key: '',
          value: ''
        });
      } else if (type == 'slider') {
        this.repeater[type][idx].inputs.push({
          input: null,
          uploaded: null
        });
      }
    },
    removeFromARepeater: function removeFromARepeater(idx, type, fieldIdx) {
      this.repeater[type][idx].inputs.splice(fieldIdx, 1);
    },
    removeRepeaterBlock: function removeRepeaterBlock(type, repeaterIdx) {
      this.repeater[type].splice(repeaterIdx, 1);
    }
  },
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
 //import Component from '../';

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    min: {
      type: Number,
      "default": 1
    },
    max: {
      type: Number,
      "default": 3
    },
    disabled: {
      type: Boolean
    },
    populated: {
      type: Array,
      "default": function _default() {
        return [];
      }
    }
  },
  data: function data() {
    return {
      searchTerm: "",
      searchResults: [],
      showList: false,
      selectedGenres: [],
      arrowCounter: -1
    };
  },
  created: function created() {
    this.selectedGenres = this.populated;
  },
  computed: (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapState)(["app"]),
  mounted: function mounted() {
    this.$store.dispatch("app/fetchGenres");
  },
  methods: {
    input: function input() {
      if (this.searchTerm.length > 0) {
        this.showList = true;
        this.search();
      } else {
        this.showList = false;
      }
    },
    search: function search() {
      var _this = this;

      this.searchResults = [];

      _.forEach(this.app.genres, function (genre) {
        if (genre.name.toLowerCase().includes(_this.searchTerm.toLowerCase())) {
          // If genre name includes search term
          if (!_.find(_this.selectedGenres, function (g) {
            return g.id === genre.id;
          })) {
            // If genre is not already selected
            _this.searchResults.push(genre);
          }
        }
      });
    },
    selectGenre: function selectGenre(genre) {
      this.arrowCounter = -1;
      this.searchTerm = "";
      this.input();
      this.selectedGenres.push(genre);
      this.$emit("change", this.selectedGenres);
    },
    removeGenre: function removeGenre(genreToDelete) {
      this.selectedGenres = _.filter(this.selectedGenres, function (genre) {
        return genre.id !== genreToDelete.id;
      });
      this.input();
      this.$emit("change", this.selectedGenres);
    },
    onArrowDown: function onArrowDown() {
      if (this.arrowCounter + 1 < this.searchResults.length) {
        this.arrowCounter += 1;
      }
    },
    onArrowUp: function onArrowUp() {
      if (this.arrowCounter > 0) {
        this.arrowCounter -= 1;
      }
    },
    onEnter: function onEnter() {
      if (this.arrowCounter >= 0) {
        this.selectGenre(this.searchResults[this.arrowCounter]);
      }
    }
  },
  components: {}
});

/***/ }),

/***/ "./resources/assets/js/admin.js":
/*!**************************************!*\
  !*** ./resources/assets/js/admin.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var _vue_store_store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./vue/store/store */ "./resources/assets/js/vue/store/store.js");
window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;




__webpack_require__(/*! ./vee-validate/vee-validate */ "./resources/assets/js/vee-validate/vee-validate.js");

vue__WEBPACK_IMPORTED_MODULE_2__["default"].use(vee_validate__WEBPACK_IMPORTED_MODULE_0__["default"]);
vue__WEBPACK_IMPORTED_MODULE_2__["default"].component('page-meta', __webpack_require__(/*! ./vue/components/admin/meta */ "./resources/assets/js/vue/components/admin/meta.vue"));
vue__WEBPACK_IMPORTED_MODULE_2__["default"].component('genre-select', __webpack_require__(/*! ./vue/components/modals/upload/genre-select */ "./resources/assets/js/vue/components/modals/upload/genre-select.vue"));
window.Vue = new vue__WEBPACK_IMPORTED_MODULE_2__["default"]({
  store: _vue_store_store__WEBPACK_IMPORTED_MODULE_1__["default"],
  el: '#admin'
});

/***/ }),

/***/ "./resources/assets/js/vee-validate/min-dimensions.js":
/*!************************************************************!*\
  !*** ./resources/assets/js/vee-validate/min-dimensions.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "validate": () => (/* binding */ validate),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

/**
 * Custom VeeValidate validation rule to validate minimum dimensions for an image (instead of exact dimensions, which is
 * how the default validator checks)
 *
 * @param file
 * @param width
 * @param height
 * @returns {Promise<any>}
 */
var validateImage = function validateImage(file, width, height) {
  var URL = window.URL || window.webkitURL;
  return new Promise(function (resolve) {
    var image = new Image();

    image.onerror = function () {
      return resolve({
        valid: false
      });
    };

    image.onload = function () {
      return resolve({
        valid: image.width >= Number(width) && image.height >= Number(height)
      });
    };

    image.src = URL.createObjectURL(file);
  });
};

var validate = function validate(files, _ref) {
  var _ref2 = _slicedToArray(_ref, 2),
      width = _ref2[0],
      height = _ref2[1];

  var list = [];

  for (var i = 0; i < files.length; i++) {
    // if file is not an image, reject.
    if (!/\.(jpg|svg|jpeg|png|bmp|gif)$/i.test(files[i].name)) {
      return false;
    }

    list.push(files[i]);
  }

  return Promise.all(list.map(function (file) {
    return validateImage(file, width, height);
  }));
};


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  validate: validate
});

/***/ }),

/***/ "./resources/assets/js/vee-validate/vee-validate.js":
/*!**********************************************************!*\
  !*** ./resources/assets/js/vee-validate/vee-validate.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var _vee_validate_min_dimensions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../vee-validate/min-dimensions */ "./resources/assets/js/vee-validate/min-dimensions.js");
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }



var dictionary = {
  messages: {
    'min-dimensions': function minDimensions(field, _ref) {
      var _ref2 = _slicedToArray(_ref, 2),
          width = _ref2[0],
          height = _ref2[1];

      return 'The image must be at least ' + width + 'px x' + height + 'px.';
    }
  }
};
vee_validate__WEBPACK_IMPORTED_MODULE_0__.Validator.extend('min-dimensions', _vee_validate_min_dimensions__WEBPACK_IMPORTED_MODULE_1__["default"]);
vee_validate__WEBPACK_IMPORTED_MODULE_0__.Validator.extend('username', {
  getMessage: function getMessage(field) {
    return "The ".concat(field, " contains invalid characters.");
  },
  validate: function validate(value) {
    var ex = /[^a-zA-Z0-9.\-_]/g;

    if (ex.exec(value)) {
      return false;
    }

    return true;
  }
});
vee_validate__WEBPACK_IMPORTED_MODULE_0__.Validator.localize('en', dictionary);

/***/ }),

/***/ "./resources/assets/js/vue/CartManager.js":
/*!************************************************!*\
  !*** ./resources/assets/js/vue/CartManager.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! js-cookie */ "./node_modules/js-cookie/src/js.cookie.js");
/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(js_cookie__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! store */ "./resources/assets/js/vue/store/store.js");



function CartManager() {
  var _this = this;

  /**
   * Check the server and the cookie to see if there is any cart data.
   *
   * @returns {Promise<any>}
   */
  this.load = function () {
    return new Promise(function (resolve, reject) {
      // Try first to load from server
      _this.loadFromServer().then(function (data) {
        resolve(data);
      }) // Empty data received from server, check cookie
      ["catch"](function () {
        _this.loadFromCookie().then(function (data) {
          resolve(data);
        })["catch"](function () {
          reject();
        });
      });
    });
  };
  /**
   * Set the phase_cart cookie to store
   */


  this.saveCookie = function () {
    setTimeout(function () {
      var storeItems = store__WEBPACK_IMPORTED_MODULE_1__["default"].state.cart.items;
      var toSave = [];

      for (var i = 0; i < storeItems.length; i++) {
        toSave.push({
          id: storeItems[i].id,
          type: storeItems[i].type,
          format: storeItems[i].format ? storeItems[i].format : 'mp3'
        });
      }

      js_cookie__WEBPACK_IMPORTED_MODULE_0___default().set('phase_cart', toSave);
    }, 0);
  };
  /**
   * Add an item to a logged in users cart.
   *
   * @param item
   */


  this.saveItemToServer = function (item) {
    axios.post('/api/cart/item/add', {
      type: item.type,
      id: item.id,
      format: item.format
    });
  };
  /**
   * Check the server for logged in users cart information
   *
   * @returns {Promise<any>}
   */


  this.loadFromServer = function () {
    return new Promise(function (resolve, reject) {
      axios.get('/api/cart/item/list').then(function (response) {
        if (response.data) {
          resolve(_this.setFormatProperly(response.data));
        } else {
          reject();
        }
      });
    });
  };
  /**
   * Check the cookie for cart data and query the server to get item information
   *
   * @returns {Promise<any>}
   */


  this.loadFromCookie = function () {
    var cart = js_cookie__WEBPACK_IMPORTED_MODULE_0___default().getJSON('phase_cart');
    return new Promise(function (resolve, reject) {
      if (cart) {
        axios.post('/api/cart/guest/details', {
          items: cart
        }).then(function (response) {
          // Loop through the cookie data and response data and set the format correctly on the server data
          // according the the cookie
          for (var i = 0; i < response.data.length; i++) {
            for (var x = 0; x < cart.length; x++) {
              if (response.data[i].id === cart[x].id && response.data[i].type === cart[x].type) {
                response.data[i].format = cart[x].format;
              }
            }
          }

          resolve(response.data);
        });
      } else {
        reject();
      }
    });
  };
  /**
   * Update the saved format of an item in the cart (mp3/wav)
   *
   * @param item
   * @param format
   */


  this.changeItemFormat = function (item, format) {
    // Update item on server
    axios.post('/api/cart/item/change', {
      id: item.id,
      type: item.type,
      format: format
    }); // Update item in cookie

    _this.saveCookie();
  };
  /**
   * Data from the server returns the format as a sub-property of a 'pivot' property. Move it to the correct place in the
   * object
   * @param data
   * @returns {*}
   */


  this.setFormatProperly = function (data) {
    for (var i = 0; i < data.length; i++) {
      if (data[i].pivot) {
        data[i].format = data[i].pivot.download_format;
        data[i].pivot = undefined;
      }
    }

    return data;
  };
  /**
   * Remove the cart cookie
   */


  this.reset = function () {
    js_cookie__WEBPACK_IMPORTED_MODULE_0___default().remove('phase_cart');
  };
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (new CartManager());

/***/ }),

/***/ "./resources/assets/js/vue/User.js":
/*!*****************************************!*\
  !*** ./resources/assets/js/vue/User.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ User)
/* harmony export */ });
/**
 * Retrieve, store and manipulate data relating to the currently
 * logged in user.
 *
 * @constructor
 */
function User() {
  var _this = this;

  // From JSON API
  // Remembering to update these variables when the user schema or relationships changes is tricky!
  this.bio = '';
  this.loggedin = false;
  this.id = -1;
  this.avatar_id = -1;
  this.banner_id = -1;
  this.path = '';
  this.name = '';
  this.last_name = '';
  this.first_name = '';
  this.email = '';
  this.payment_method = '';
  this.paypal_linked = false;
  this.social_web = '';
  this.social_youtube = '';
  this.social_twitter = '';
  this.social_facebook = '';
  this.deleted_at = '';
  this.created_at = '';
  this.updated_at = '';
  this.account_type = '';
  this.avatar = {};
  this.banner = {};
  this.followed = {};
  this.releases = {
    current_page: 0,
    data: [],
    last_page: 1
  };
  this.all_permissions = [], this.interests = [], this.tracks_count_this_month = 0, this.account_verified = false, this.plays = [], this.events = null,
  /**
   * Set (login) user data
   * @param data
   */
  this.set = function (data) {
    for (var key in data) {
      _this[key] = data[key];
    }

    _this.loggedin = true;
  };
  /**
   * Unset (logout) user data
   */

  this.unset = function () {
    for (var key in _this) {
      if (typeof _this[key] !== 'function') {
        _this[key] = null;
      }
    }

    _this.loggedin = false;
  };
  /**
   * Get user favourites for a certain favouritable type
   *
   * @param favouritable e.g. 'track'
   */


  this.favourites = function (favouritable) {// ...
  };

  this.getFollowed = function () {
    window.axios.get('/api/user/followed').then(function (response) {
      _this.followed = response.data;
    });
  };
  /**
   * Get user messages
   */


  this.messages = function () {// ...
  };

  this.removeRelease = function (release) {
    _this.releases.data.splice(_this.releases.data.indexOf(release), 1);
  };

  this.updateStatus = function (data) {
    var index = _this.releases.data.indexOf(data.release);

    _this.releases.data[index].status = data.status;
  };

  this.incrementTrackCount = function () {
    _this.tracks_count_this_month++;
  };
}

/***/ }),

/***/ "./resources/assets/js/vue/store/app.js":
/*!**********************************************!*\
  !*** ./resources/assets/js/vue/store/app.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _User__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../User */ "./resources/assets/js/vue/User.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

// App Store


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    navigation: {},
    user: new _User__WEBPACK_IMPORTED_MODULE_1__["default"](),
    tempUser: null,
    settings: [],
    genres: [],
    releases: [],
    classes: [],
    keys: [],
    page: {},
    feed: [],
    plans: [],
    pricePerFeaturedSlot: ""
  },
  mutations: {
    setNavigation: function setNavigation(state, data) {
      state.navigation = data;
    },
    setUser: function setUser(state, user) {
      state.user.set(user);
    },
    unsetUser: function unsetUser(state) {
      state.user.unset();
    },
    setTempUser: function setTempUser(state, user) {
      state.tempUser = user;
    },
    unsetTempUser: function unsetTempUser(state) {
      state.tempUser = null;
    },
    setUserAvatar: function setUserAvatar(state, avatar) {
      state.user.avatar = avatar;
    },
    setUserBanner: function setUserBanner(state, banner) {
      state.user.banner = banner;
    },
    setUserReleases: function setUserReleases(state, releases) {
      var _state$user$releases$;

      (_state$user$releases$ = state.user.releases.data).push.apply(_state$user$releases$, _toConsumableArray(releases.data));

      state.user.releases.current_page = releases.current_page;
      state.user.releases.next_page_url = releases.next_page_url;
      state.user.releases.prev_page_url = releases.prev_page_url;
      state.user.releases.last_page = releases.last_page;
      state.user.releases.from = releases.from;
      state.user.releases.to = releases.to;
    },
    setUserEvents: function setUserEvents(state, events) {
      state.user.events = events;
    },
    setSettings: function setSettings(state, settings) {
      state.settings = settings;
    },
    setGenres: function setGenres(state, genres) {
      state.genres = genres;
    },
    setReleases: function setReleases(state, releases) {
      state.releases = releases;
    },
    setReleaseClasses: function setReleaseClasses(state, releaseClasses) {
      var keys = Object.keys(releaseClasses);

      for (var i = 0; i < keys.length; i++) {
        state.classes.push({
          val: keys[i],
          name: releaseClasses[keys[i]]
        });
      }
    },
    setMusicKeys: function setMusicKeys(state, musicKeys) {
      var keys = Object.keys(musicKeys);

      for (var i = 0; i < keys.length; i++) {
        state.keys.push({
          val: keys[i],
          name: musicKeys[keys[i]]
        });
      }
    },
    setPageData: function setPageData(state, data) {
      state.page = data;
    },
    setFeed: function setFeed(state, feed) {
      state.feed = feed;
    },
    setPlans: function setPlans(state, plans) {
      state.plans = plans;
    },
    setPrice: function setPrice(state, price) {
      state.pricePerFeaturedSlot = price;
    },
    removeUserReleaseFromState: function removeUserReleaseFromState(state, release) {
      state.user.removeRelease(release);
    },
    updateStatus: function updateStatus(state, data) {
      state.user.updateStatus(data);
    },
    incrementTrackCount: function incrementTrackCount(state) {
      state.user.incrementTrackCount();
    }
  },
  actions: {
    fetchNavigation: function fetchNavigation(_ref) {
      var commit = _ref.commit,
          state = _ref.state;
      var data = {
        main_menu: [{
          title: "My Feed",
          to: "/",
          only: {
            authenticated: true,
            guest: false
          }
        }, {
          title: "New Music",
          to: "/new"
        }, {
          title: "Charts",
          to: "/charts"
        }, {
          title: "Genres",
          to: "/genres"
        }, {
          title: "Discover",
          to: "/discover"
        }],
        slideout_menu: [{
          action: "modal",
          title: "Login",
          modal: "modal-auth-login",
          only: {
            guest: true
          }
        }, {
          action: "modal",
          title: "Register",
          modal: "modal-auth-register",
          only: {
            guest: true
          }
        }, {
          title: "My Account",
          to: "/account",
          only: {
            authenticated: true,
            guest: false
          }
        }, {
          title: "My Profile",
          to: "/account/profile",
          only: {
            authenticated: true,
            guest: false
          }
        }, {
          title: "My Music",
          to: "/account/mymusic",
          only: {
            authenticated: true,
            guest: false
          }
        }, {
          title: "Private Messages",
          to: "/user/messages",
          only: {
            authenticated: true,
            guest: false
          }
        }, {
          action: "modal",
          title: "Cart",
          only: {
            authenticated: true,
            guest: false
          },
          modal: "modal-cart"
        }, {
          title: "News",
          to: "/news"
        }, {
          title: "Help & Support",
          to: "/help"
        }],
        footer_one: [{
          title: "Charts",
          to: "/charts"
        }, {
          title: "Genres",
          to: "/genres"
        }, {
          title: "Discover",
          to: "/discover"
        }, {
          title: "News",
          to: "/news"
        }],
        footer_two: [// {
          //     title: "Sample Packs",
          //     to: "/samples"
          // },
          // {
          //     title: "News",
          //     to: "/news"
          // }
        ],
        footer_three: [// {
        //     title: "About",
        //     to: "/about"
        // },
        {
          title: "Help & Support",
          to: "/help"
        }, {
          action: 'modal',
          title: 'Join Mailing List',
          modal: 'modal-mailing-list'
        }],
        footer_four: [{
          action: "modal",
          title: "Login",
          modal: "modal-auth-login",
          only: {
            guest: true
          }
        }, {
          action: "modal",
          title: "Register",
          modal: "modal-auth-register",
          only: {
            guest: true
          }
        }],
        footer_five: [// {
          //     action: 'modal',
          //     title: 'Join Mailing List',
          //     modal: 'modal-mailing-list',
          // },
        ],
        footer_lower: [{
          title: "Terms of Service",
          to: "/terms"
        }, {
          title: "Privacy",
          to: "/privacy"
        }]
      };
      commit("setNavigation", data);
    },
    fetchGenres: function fetchGenres(_ref2) {
      var commit = _ref2.commit,
          state = _ref2.state;
      if (state.genres.length) return; // Don't re-fetch if data is already set.

      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/genres").then(function (response) {
          commit("setGenres", response.data.data);
          resolve();
        })["catch"](function (error) {
          console.log(error);
          reject();
        });
      });
    },
    fetchReleases: function fetchReleases(_ref3) {
      var commit = _ref3.commit,
          state = _ref3.state;
      if (state.releases.length) return; // Don't re-fetch if data is already set.

      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/releases/latest").then(function (response) {
          commit("setReleases", response.data.data);
          resolve();
        })["catch"](function (error) {
          console.log(error);
          reject();
        });
      });
    },
    fetchPageData: function fetchPageData(_ref4, page) {
      var commit = _ref4.commit;
      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().post("/api/page", {
          path: page
        }).then(function (response) {
          commit("setPageData", response.data);
          resolve();
        })["catch"](function (error) {
          console.error(error);
          reject();
        });
      });
    },
    fetchFeed: function fetchFeed(_ref5) {
      var commit = _ref5.commit,
          state = _ref5.state;
      // TODO - how does this result get cleared?
      if (state.feed.length) return; // Don't re-fetch if data is already set.

      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/feed").then(function (response) {
          // console.log(response.data);
          commit("setFeed", response.data.data);
          resolve();
        })["catch"](function (error) {
          // !! IDEA - catch and handle 422 errors.
          reject();
        });
      });
    },
    fetchPlans: function fetchPlans(_ref6) {
      var commit = _ref6.commit,
          state = _ref6.state;
      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get("api/plans").then(function (response) {
          commit("setPlans", response.data);
          resolve();
        })["catch"](function (error) {
          reject();
        });
      });
    },
    fetchPricePerFeaturedSlot: function fetchPricePerFeaturedSlot(_ref7) {
      var commit = _ref7.commit,
          state = _ref7.state;
      axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/price-per-featured-slot").then(function (response) {
        commit("setPrice", response.data);
      })["catch"](function (e) {
        return;
      });
    },
    fetchUsersReleases: function fetchUsersReleases(_ref8) {
      var commit = _ref8.commit,
          state = _ref8.state,
          getters = _ref8.getters;
      if (!getters.releasesHasAnotherPage) return;
      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/account/releases/mine/?page=".concat(state.user.releases.current_page + 1)).then(function (response) {
          commit("setUserReleases", response.data);
          resolve();
        })["catch"](function (error) {
          reject();
        });
      });
    },
    fetchUsersEvents: function fetchUsersEvents(_ref9) {
      var commit = _ref9.commit,
          state = _ref9.state;
      axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/event/".concat(state.user.id, "/list")).then(function (response) {
        commit("setUserEvents", response.data);
      });
    },
    removeUserRelease: function removeUserRelease(_ref10, release) {
      var commit = _ref10.commit;
      axios__WEBPACK_IMPORTED_MODULE_0___default()["delete"]("/api/account/releases/mine/delete/".concat(release.id)).then(function (response) {
        commit("removeUserReleaseFromState", release);
      });
    },
    updateUserRelease: function updateUserRelease(_ref11, data) {
      var commit = _ref11.commit;
      axios__WEBPACK_IMPORTED_MODULE_0___default().patch("/api/account/releases/mine/".concat(data.release.id), {
        status: data.status
      }).then(function (response) {
        commit("updateStatus", data);
      });
    }
  },
  getters: {
    getClassByKey: function getClassByKey(state) {
      return function (key) {
        for (var i = 0; i < state.classes.length; i++) {
          if (state.classes[i].val === key) {
            return state.classes[i];
          }
        }
      };
    },
    getKeyByKey: function getKeyByKey(state) {
      return function (key) {
        for (var i = 0; i < state.keys.length; i++) {
          if (state.keys[i].val === key) {
            return state.keys[i];
          }
        }
      };
    },
    getNavigation: function getNavigation(state) {
      return state.navigation;
    },
    getPageData: function getPageData(state) {
      return state.page;
    },
    getFeed: function getFeed(state) {
      return state.feed;
    },
    getPlans: function getPlans(state) {
      return state.plans;
    },
    getFeaturedSlotPrice: function getFeaturedSlotPrice(state) {
      return state.pricePerFeaturedSlot;
    },
    getUsersReleases: function getUsersReleases(state) {
      return state.user.releases;
    },
    getUsersEvents: function getUsersEvents(state) {
      return state.user.events;
    },
    releasesHasAnotherPage: function releasesHasAnotherPage(state) {
      if (state.user.releases.last_page === 1) return true;
      return state.user.releases.current_page < state.user.releases.last_page;
    },
    getUser: function getUser(state) {
      return state.user;
    },
    getUserLoggedIn: function getUserLoggedIn(state) {
      return state.user.loggedin;
    },
    getTempUser: function getTempUser(state) {
      return state.tempUser;
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/cart.js":
/*!***********************************************!*\
  !*** ./resources/assets/js/vue/store/cart.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var store__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! store */ "./resources/assets/js/vue/store/store.js");
/* harmony import */ var _CartManager__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../CartManager */ "./resources/assets/js/vue/CartManager.js");


 // Cart Store

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    items: [],
    loading: true
  },
  mutations: {
    reset: function reset(state) {
      state.items = [];
    },
    loaded: function loaded(state, value) {
      state.loading = value;
    },
    addItem: function addItem(state, item) {
      if (typeof item.format === 'undefined') {
        item.format = 'mp3';
      }

      var exists = !!state.items.find(function (i) {
        return i.id === item.id;
      });

      if (!exists) {
        state.items.push(item);
      }
    },
    removeItem: function removeItem(state, index) {
      state.items.splice(index, 1);
    },
    changeItemFormat: function changeItemFormat(state, _ref) {
      var item = _ref.item,
          format = _ref.format;

      for (var i = 0; i < state.items.length; i++) {
        if (state.items[i] === item) {
          state.items[i].format = format;
          vue__WEBPACK_IMPORTED_MODULE_2__["default"].set(state.items, i, state.items[i]);
        }
      }
    }
  },
  actions: {
    addItem: function addItem(_ref2, item) {
      var state = _ref2.state,
          commit = _ref2.commit;
      var format = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'mp3';
      item.format = format;

      var already = _.find(state.items, function (iterable) {
        return iterable.id === item.id && iterable.type === item.type;
      });

      if (!already) {
        commit('addItem', item);
        _CartManager__WEBPACK_IMPORTED_MODULE_1__["default"].saveCookie();
        _CartManager__WEBPACK_IMPORTED_MODULE_1__["default"].saveItemToServer(item);
      }
    },
    removeItem: function removeItem(_ref3, item) {
      var state = _ref3.state,
          commit = _ref3.commit;

      for (var i = 0; i < state.items.length; i++) {
        if (state.items[i].id === item.id && state.items[i].type === item.type) {
          // Inform the server of the removal
          axios.post('/api/cart/item/remove', {
            type: item.type,
            id: item.id
          }); // Remove from the local store

          commit('removeItem', i);
          _CartManager__WEBPACK_IMPORTED_MODULE_1__["default"].saveCookie(state.items);
        }
      }
    },
    changeItemFormat: function changeItemFormat(_ref4, _ref5) {
      var state = _ref4.state,
          commit = _ref4.commit;
      var item = _ref5.item,
          format = _ref5.format;
      _CartManager__WEBPACK_IMPORTED_MODULE_1__["default"].changeItemFormat(item, format);
      commit('changeItemFormat', {
        item: item,
        format: format
      });
    },
    load: function load(_ref6) {
      var commit = _ref6.commit;
      return new Promise(function (resolve, reject) {
        commit('reset');
        _CartManager__WEBPACK_IMPORTED_MODULE_1__["default"].load().then(function (data) {
          for (var i = 0; i < data.length; i++) {
            commit('addItem', data[i]);
          }
        })["catch"](function () {
          reject(); // No server / cookie items set
        })["finally"](function () {
          resolve();
        });
      });
    },
    reset: function reset(_ref7) {
      var commit = _ref7.commit;
      commit('reset');
      _CartManager__WEBPACK_IMPORTED_MODULE_1__["default"].reset();
    },
    setLoading: function setLoading(_ref8, value) {
      var commit = _ref8.commit;
      commit('loaded', value);
    }
  },
  getters: {
    isInCart: function isInCart(state) {
      return function (item) {
        return Boolean(state.items.find(function (iterable) {
          return iterable.id === item.id && iterable.type === item.type;
        }));
      };
    },
    getItemPrice: function getItemPrice(state) {
      return function (item) {
        for (var i = 0; i < state.items.length; i++) {
          if (state.items[i] === item) {
            var price = state.items[i].price;

            if (state.items[i].format === 'wav') {
              if (state.items[i].type === 'release') {
                price += parseInt(store__WEBPACK_IMPORTED_MODULE_0__["default"].state.app.settings[2].wav_fee) * state.items[i].tracks.length;
              } else {
                price += parseInt(store__WEBPACK_IMPORTED_MODULE_0__["default"].state.app.settings[2].wav_fee);
              }
            }

            return price;
          }
        }
      };
    },
    getTotal: function getTotal(state, getters) {
      var total = 0;

      for (var i = 0; i < state.items.length; i++) {
        total += getters.getItemPrice(state.items[i]);
      }

      return (total / 100).toFixed(2);
    },
    getTax: function getTax(state, getters) {
      return getters.getTotal;
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/merch.js":
/*!************************************************!*\
  !*** ./resources/assets/js/vue/store/merch.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

// Merch Store
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    nextPage: 1,
    totalPages: 0,
    items: []
  },
  mutations: {
    setMerch: function setMerch(state, payload) {
      var _state$items;

      state.nextPage = payload.currentPageNumber + 1;
      state.totalPages = payload.totalPagesNumber;

      (_state$items = state.items).push.apply(_state$items, _toConsumableArray(payload.merch));
    }
  },
  actions: {
    requireMerch: function requireMerch(_ref) {
      var state = _ref.state,
          dispatch = _ref.dispatch;

      if (!state.items.length) {
        dispatch('fetchMerch');
      }
    },
    fetchMerch: function fetchMerch(_ref2) {
      var commit = _ref2.commit,
          state = _ref2.state,
          getters = _ref2.getters;
      if (!getters.hasAnotherPage) return; // Don't fetch a page that doesn't exist!

      var apiPath = '/api/merch?page=';
      return new Promise(function (resolve, reject) {
        axios.get(apiPath + state.nextPage).then(function (response) {
          commit('setMerch', {
            currentPageNumber: response.data.current_page,
            totalPagesNumber: response.data.last_page,
            merch: response.data.data
          });
          resolve();
        })["catch"](function (error) {
          console.log(error);
          reject();
        });
      });
    }
  },
  getters: {
    hasAnotherPage: function hasAnotherPage(state) {
      if (state.totalPages === 0) return true;
      return state.nextPage <= state.totalPages;
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/messenger.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/vue/store/messenger.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// Message Store
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    threads: [],
    currentThread: [],
    unreadThreads: []
  },
  mutations: {
    removeReadThread: function removeReadThread(state, index) {
      state.unreadThreads.splice(index, 1);
    },
    setThreads: function setThreads(state, threads) {
      state.threads = threads;
    },
    setUnreadThreads: function setUnreadThreads(state, threads) {
      state.unreadThreads = [];
      threads.forEach(function (thread) {
        if (thread.read_at === null) {
          state.unreadThreads.push(thread);
        }
      });
    },
    addThread: function addThread(state, thread) {
      state.threads.push(thread);
    },
    setCurrentThread: function setCurrentThread(state, thread) {
      state.currentThread = thread;
    },
    newMessageInThread: function newMessageInThread(state, payload) {
      // state.threads.forEach(item => {
      var thread = payload.thread,
          message = payload.message;

      if (state.currentThread.id == 1) {
        state.currentThread.messages.push(message);
      } // });

    }
  },
  actions: {
    fetchThreads: function fetchThreads(_ref) {
      var commit = _ref.commit;
      axios.get('/api/threads/mine').then(function (response) {
        commit('setThreads', response.data);
        commit('setUnreadThreads', response.data);
      })["catch"](function (error) {
        return console.log(error);
      });
    },
    getCurrentThread: function getCurrentThread(_ref2, id) {
      var commit = _ref2.commit,
          dispatch = _ref2.dispatch;
      axios.get("/api/thread/".concat(id)).then(function (response) {
        commit('setCurrentThread', response.data);
        dispatch('fetchThreads'); //to get latest unread messages for top dropdown
      })["catch"](function (error) {
        return console.log(error);
      });
    },
    markread: function markread(_ref3, payload) {
      var commit = _ref3.commit;
      //send ajax call to mark thread as read for current user
      axios.get("/api/thread/markread/".concat(payload.id)).then(function (response) {
        commit('removeReadThread', payload.index);
      })["catch"](function (error) {
        return console.log(error);
      }); //remove the message from unreadThreads array

      console.log(payload.id, payload.index);
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/music.js":
/*!************************************************!*\
  !*** ./resources/assets/js/vue/store/music.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    nextPage: 1,
    totalPages: 0,
    items: []
  },
  mutations: {
    setMusic: function setMusic(state, data) {
      var _state$items;

      state.nextPage = data.currentPageNumber + 1;
      state.totalPages = data.totalPagesNumber;

      (_state$items = state.items).push.apply(_state$items, _toConsumableArray(data.items)); // state.items = data

    }
  },
  actions: {
    fetchMusic: function fetchMusic(_ref) {
      var commit = _ref.commit,
          state = _ref.state,
          getters = _ref.getters;
      if (!getters.hasAnotherPage) return;
      return new Promise(function (resolve, reject) {
        axios__WEBPACK_IMPORTED_MODULE_0___default().get("/api/new-music?page=".concat(state.nextPage)).then(function (response) {
          commit('setMusic', {
            currentPageNumber: response.data.current_page,
            totalPagesNumber: response.data.last_page,
            items: response.data.data
          });
          resolve();
        })["catch"](function (error) {
          console.log(error);
          reject();
        });
      });
    }
  },
  getters: {
    hasAnotherPage: function hasAnotherPage(state) {
      if (state.totalPages === 0) return true;
      return state.nextPage <= state.totalPages;
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/news.js":
/*!***********************************************!*\
  !*** ./resources/assets/js/vue/store/news.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

// News Store
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    nextPage: 1,
    totalPages: 0,
    categoryPath: null,
    articles: [],
    categories: []
  },
  mutations: {
    setArticles: function setArticles(state, payload) {
      var _state$articles;

      state.nextPage = payload.currentPageNumber + 1;
      state.totalPages = payload.totalPagesNumber;

      (_state$articles = state.articles).push.apply(_state$articles, _toConsumableArray(payload.articles));
    },
    setCategories: function setCategories(state, categories) {
      state.categories = categories;
    },

    /**
     * Update the user's like boolean for an article
     * Does not POST to server because that is handled by the like button
     */
    likeArticle: function likeArticle(state, articleid) {
      for (var i = 0; i < state.articles.length; i++) {
        if (state.articles[i].id === articleid) {
          state.articles[i].like_count += 1;
          state.articles[i].is_liked = true;
        }
      }
    },
    unlikeArticle: function unlikeArticle(state, articleid) {
      for (var i = 0; i < state.articles.length; i++) {
        if (state.articles[i].id === articleid) {
          state.articles[i].like_count -= 1;
          state.articles[i].is_liked = false;
        }
      }
    },
    shareArticle: function shareArticle(state, articleid) {
      for (var i = 0; i < state.articles.length; i++) {
        if (state.articles[i].id === articleid) {
          state.articles[i].shares_count += 1;
          state.articles[i].is_shared = true;
        }
      }
    }
  },
  actions: {
    requireArticles: function requireArticles(_ref, categoryPath) {
      var state = _ref.state,
          dispatch = _ref.dispatch;

      if (!state.articles.length || categoryPath !== state.categoryPath) {
        dispatch('fetchArticles', categoryPath);
      }
    },
    fetchArticles: function fetchArticles(_ref2, categoryPath) {
      var commit = _ref2.commit,
          state = _ref2.state,
          getters = _ref2.getters;

      if (categoryPath !== state.categoryPath) {
        // We are now requesting data on a different category, discard existing data
        state.nextPage = 1;
        state.totalPages = 0;
        state.articles = [];
      }

      state.categoryPath = categoryPath;
      if (!getters.hasAnotherPage) return; // Don't fetch a page that doesn't exist!

      var apiPath = '/api/news?page=';

      if (state.categoryPath) {
        apiPath = '/api/news/category/' + state.categoryPath + '/?page=';
      }

      return new Promise(function (resolve, reject) {
        axios.get(apiPath + state.nextPage).then(function (response) {
          commit('setArticles', {
            currentPageNumber: response.data.current_page,
            totalPagesNumber: response.data.last_page,
            articles: response.data.data
          });
          resolve();
        })["catch"](function (error) {
          console.log(error);
          reject();
        });
      });
    },
    fetchCategories: function fetchCategories(_ref3) {
      var commit = _ref3.commit,
          state = _ref3.state;
      if (state.categories.length) return; // Don't fetch categories if we already have them!

      return new Promise(function (resolve, reject) {
        axios.get('/api/categories').then(function (response) {
          commit('setCategories', response.data.data);
          resolve();
        })["catch"](function (error) {
          console.log(error);
          reject();
        });
      });
    }
  },
  getters: {
    hasAnotherPage: function hasAnotherPage(state) {
      if (state.totalPages === 0) return true;
      return state.nextPage <= state.totalPages;
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/player.js":
/*!*************************************************!*\
  !*** ./resources/assets/js/vue/store/player.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// Player Store
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    track: {
      name: ''
    },
    status: {
      set: false,
      playing: false,
      dragging: false,
      muted: false,
      position: -1,
      // Percentage between 0 and 1
      time: {
        current: 0,
        max: -1 // Default

      }
    },
    repeat: false,
    shuffle: false
  },
  mutations: {
    setCurrentTime: function setCurrentTime(state, value) {
      state.status.time.current = value;
    },
    setMaxTime: function setMaxTime(state, value) {
      state.status.time.max = value;
    },
    setPosition: function setPosition(state, value) {
      state.status.position = value;
    },
    setPlaying: function setPlaying(state, value) {
      state.status.playing = value;
    },
    setMuted: function setMuted(state, value) {
      state.status.muted = value;
    },
    setRepeat: function setRepeat(state, value) {
      state.repeat = value;
    },
    setDragging: function setDragging(state, value) {
      state.status.dragging = value;
    },
    setTrack: function setTrack(state, value) {
      state.track = value;
      state.status.set = true;
    }
  },
  actions: {},
  getters: {
    getTrack: function getTrack(state) {
      return state.track;
    },
    getTrackByType: function getTrackByType(state) {
      return function (type) {
        return state.track[type];
      };
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/search.js":
/*!*************************************************!*\
  !*** ./resources/assets/js/vue/store/search.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// Search Store
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  namespaced: true,
  state: {
    visible: false,
    searchTerm: ''
  },
  mutations: {
    toggleSearch: function toggleSearch(state) {
      var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

      if (value === null) {
        state.visible = !state.visible;
      } else {
        state.visible = value;
      }
    },
    setSearchTerm: function setSearchTerm(state, newSearchTerm) {
      state.searchTerm = newSearchTerm;
    }
  },
  actions: {},
  getters: {
    getSearchTerm: function getSearchTerm(state) {
      return state.searchTerm;
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/vue/store/store.js":
/*!************************************************!*\
  !*** ./resources/assets/js/vue/store/store.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app */ "./resources/assets/js/vue/store/app.js");
/* harmony import */ var _cart__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./cart */ "./resources/assets/js/vue/store/cart.js");
/* harmony import */ var _news__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./news */ "./resources/assets/js/vue/store/news.js");
/* harmony import */ var _search__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./search */ "./resources/assets/js/vue/store/search.js");
/* harmony import */ var _messenger__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./messenger */ "./resources/assets/js/vue/store/messenger.js");
/* harmony import */ var _player__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./player */ "./resources/assets/js/vue/store/player.js");
/* harmony import */ var _music__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./music */ "./resources/assets/js/vue/store/music.js");
/* harmony import */ var _merch__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./merch */ "./resources/assets/js/vue/store/merch.js");
// Vue + Vuex


vue__WEBPACK_IMPORTED_MODULE_0__["default"].use(vuex__WEBPACK_IMPORTED_MODULE_1__["default"]); // Store Modules









/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (new vuex__WEBPACK_IMPORTED_MODULE_1__["default"].Store({
  modules: {
    app: _app__WEBPACK_IMPORTED_MODULE_2__["default"],
    cart: _cart__WEBPACK_IMPORTED_MODULE_3__["default"],
    news: _news__WEBPACK_IMPORTED_MODULE_4__["default"],
    search: _search__WEBPACK_IMPORTED_MODULE_5__["default"],
    messenger: _messenger__WEBPACK_IMPORTED_MODULE_6__["default"],
    player: _player__WEBPACK_IMPORTED_MODULE_7__["default"],
    music: _music__WEBPACK_IMPORTED_MODULE_8__["default"],
    merch: _merch__WEBPACK_IMPORTED_MODULE_9__["default"]
  }
}));

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/**\n *\n * FONTS\n *\n */\n/**\n *\n * COLORS\n *\n */\n[data-v-5266f739]:root {\n  --strong-blue: #3300ff;\n  --very-light-pink: #e6e6e6;\n  --light-aqua: #9eefe1;\n  --black: #000000;\n  --brown-grey: #848484;\n  --white: #ffffff;\n  --bright-sky-blue: #00ccff;\n  --cyan: #00ffff;\n  --primary-blue: #0000ff;\n  --cloudy-blue: #bcbec0;\n}\n\n/*\n * State Colors\n */\n.genre-select ul.search-results[data-v-5266f739] {\n  background: white;\n  border-left: 1px solid #a5a5a5;\n  border-right: 1px solid #a5a5a5;\n  border-bottom: 1px solid #a5a5a5;\n}\n.genre-select ul.search-results li[data-v-5266f739] {\n  padding: 5px;\n  cursor: pointer;\n}\n.genre-select ul.search-results li.highlighted[data-v-5266f739] {\n  background: #f2f2f2;\n}\n.genre-select p[data-v-5266f739] {\n  margin: 5px 0;\n  color: #a5a5a5;\n  font-size: 10px;\n}\n.genre-select ul.selected-genres[data-v-5266f739] {\n  margin: 5px 0;\n}\n.genre-select ul.selected-genres li[data-v-5266f739] {\n  display: inline-block;\n  padding: 5px;\n  margin-right: 5px;\n  cursor: pointer;\n  background: #d9d9d9;\n  border-radius: 5px;\n}\n.genre-select ul.selected-genres li[data-v-5266f739]:hover {\n  background: #cccccc;\n}\n.genre-select input[data-v-5266f739] {\n  box-sizing: border-box;\n  font-size: inherit;\n  border: 1px solid #a5a5a5;\n  padding: 5px;\n  border-radius: 2px;\n  width: 100%;\n}", "",{"version":3,"sources":["webpack://./resources/assets/sass/helpers/_variables.scss","webpack://./resources/assets/js/vue/components/modals/upload/genre-select.vue"],"names":[],"mappings":"AAAA;;;;EAAA;AAQA;;;;EAAA;AAKA;EACE,sBAAA;EACA,0BAAA;EACA,qBAAA;EACA,gBAAA;EACA,qBAAA;EACA,gBAAA;EACA,0BAAA;EACA,eAAA;EACA,uBAAA;EACA,sBAAA;ACFF;;ADyBA;;EAAA;ACsGI;EACI,iBAAA;EACA,8BAAA;EACA,+BAAA;EACA,gCAAA;AAzHR;AA2HQ;EACI,YAAA;EACA,eAAA;AAzHZ;AA2HY;EACI,mBAAA;AAzHhB;AAgII;EACI,aAAA;EACA,cDvIM;ECwIN,eAAA;AA9HR;AAgII;EACI,aAAA;AA9HR;AAgIQ;EACI,qBAAA;EACA,YAAA;EACA,iBAAA;EACA,eAAA;EACA,mBAAA;EACA,kBAAA;AA9HZ;AAgIY;EACI,mBAAA;AA9HhB;AAkII;EACI,sBAAA;EACA,kBAAA;EACA,yBAAA;EACA,YAAA;EACA,kBAAA;EACA,WAAA;AAhIR","sourcesContent":["/**\n *\n * FONTS\n *\n */\n$font-comfortaa: \"Comfortaa\", cursive;\n$font-montserrat: \"Montserrat\", sans-serif;\n\n/**\n *\n * COLORS\n *\n */\n:root {\n  --strong-blue: #3300ff;\n  --very-light-pink: #e6e6e6;\n  --light-aqua: #9eefe1;\n  --black: #000000;\n  --brown-grey: #848484;\n  --white: #ffffff;\n  --bright-sky-blue: #00ccff;\n  --cyan: #00ffff;\n  --primary-blue: #0000ff;\n  --cloudy-blue: #bcbec0;\n}\n\n\n$color-blue: #3300ff;\n$color-blue2: #366efc;\n\n$color-2: #9eefe1;\n\n$color-grey: #e6e6e6;\n$color-grey2: #a5a5a5;\n$color-grey3: #221f1f;\n$color-grey4: #7d7d7d;\n\n$color-green: #33cc99;\n$color-orange: #ff9933;\n\n// Main Colour Declarations\n$color-primary: $color-blue;\n$color-secondary: $color-2;\n$color-footer-upper: $color-grey;\n$color-footer-lower: $color-blue2;\n\n/*\n * State Colors\n */\n// Success\n$color-state-success-bg: #fcfff5;\n$color-state-success-text: #2c662d;\n$color-state-success-shadow: #a3c293;\n$color-state-success-header-text: #1a531b;\n\n// Error\n$color-state-error-bg: #fff6f6;\n$color-state-error-text: #9f3a38;\n$color-state-error-shadow: #e0b4b4;\n$color-state-error-header-text: #912d2b;\n\n// Warn\n$color-state-warn-bg: #fffaf3;\n$color-state-warn-text: #573a08;\n$color-state-warn-shadow: #c9ba9b;\n$color-state-warn-header-text: #794b02;\n\n$padding-sm: 15px;\n$padding-xs: 8px;\n","\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n@import \"~styles/helpers/_variables.scss\";\n.genre-select {\n    ul.search-results {\n        background: white;\n        border-left: 1px solid $color-grey2;\n        border-right: 1px solid $color-grey2;\n        border-bottom: 1px solid $color-grey2;\n\n        li {\n            padding: 5px;\n            cursor: pointer;\n\n            &.highlighted {\n                background: darken(white, 5);\n            }\n\n            .active {\n            }\n        }\n    }\n    p {\n        margin: 5px 0;\n        color: $color-grey2;\n        font-size: 10px;\n    }\n    ul.selected-genres {\n        margin: 5px 0;\n\n        li {\n            display: inline-block;\n            padding: 5px;\n            margin-right: 5px;\n            cursor: pointer;\n            background: darken(white, 15);\n            border-radius: 5px;\n\n            &:hover {\n                background: darken(white, 20);\n            }\n        }\n    }\n    input {\n        box-sizing: border-box;\n        font-size: inherit;\n        border: 1px solid $color-grey2;\n        padding: 5px;\n        border-radius: 2px;\n        width: 100%;\n    }\n}\n"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {

"use strict";


/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js":
/*!************************************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/cssWithMappingToString.js ***!
  \************************************************************************/
/***/ ((module) => {

"use strict";


function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr && (typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]); if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

module.exports = function cssWithMappingToString(item) {
  var _item = _slicedToArray(item, 4),
      content = _item[1],
      cssMapping = _item[3];

  if (!cssMapping) {
    return content;
  }

  if (typeof btoa === "function") {
    // eslint-disable-next-line no-undef
    var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(cssMapping))));
    var data = "sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(base64);
    var sourceMapping = "/*# ".concat(data, " */");
    var sourceURLs = cssMapping.sources.map(function (source) {
      return "/*# sourceURL=".concat(cssMapping.sourceRoot || "").concat(source, " */");
    });
    return [content].concat(sourceURLs).concat([sourceMapping]).join("\n");
  }

  return [content].join("\n");
};

/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/***/ ((module) => {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_style_index_0_id_5266f739_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!../../../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_style_index_0_id_5266f739_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_style_index_0_id_5266f739_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./resources/assets/js/vue/components/admin/meta.vue":
/*!***********************************************************!*\
  !*** ./resources/assets/js/vue/components/admin/meta.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _meta_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./meta.vue?vue&type=script&lang=js& */ "./resources/assets/js/vue/components/admin/meta.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;



/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _meta_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  "62768153",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/vue/components/admin/meta.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/assets/js/vue/components/modals/upload/genre-select.vue":
/*!***************************************************************************!*\
  !*** ./resources/assets/js/vue/components/modals/upload/genre-select.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _genre_select_vue_vue_type_template_id_5266f739_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./genre-select.vue?vue&type=template&id=5266f739&scoped=true& */ "./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=template&id=5266f739&scoped=true&");
/* harmony import */ var _genre_select_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./genre-select.vue?vue&type=script&lang=js& */ "./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=script&lang=js&");
/* harmony import */ var _genre_select_vue_vue_type_style_index_0_id_5266f739_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true& */ "./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _genre_select_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _genre_select_vue_vue_type_template_id_5266f739_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _genre_select_vue_vue_type_template_id_5266f739_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "5266f739",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/vue/components/modals/upload/genre-select.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/assets/js/vue/components/admin/meta.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/assets/js/vue/components/admin/meta.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_meta_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./meta.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/admin/meta.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_meta_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./genre-select.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true&":
/*!*************************************************************************************************************************************!*\
  !*** ./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true& ***!
  \*************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_13_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_style_index_0_id_5266f739_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!../../../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-13[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=style&index=0&id=5266f739&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=template&id=5266f739&scoped=true&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=template&id=5266f739&scoped=true& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_template_id_5266f739_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_template_id_5266f739_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_genre_select_vue_vue_type_template_id_5266f739_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./genre-select.vue?vue&type=template&id=5266f739&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=template&id=5266f739&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=template&id=5266f739&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/assets/js/vue/components/modals/upload/genre-select.vue?vue&type=template&id=5266f739&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "genre-select" }, [
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.searchTerm,
          expression: "searchTerm",
        },
      ],
      attrs: {
        type: "text",
        placeholder:
          _vm.selectedGenres.length < _vm.max
            ? "Minimum of " + _vm.min + ", maximum of " + _vm.max + " genres"
            : "Maximum number of genres reached",
        disabled: _vm.selectedGenres.length >= _vm.max || _vm.disabled,
      },
      domProps: { value: _vm.searchTerm },
      on: {
        input: [
          function ($event) {
            if ($event.target.composing) {
              return
            }
            _vm.searchTerm = $event.target.value
          },
          _vm.input,
        ],
        keyup: [
          function ($event) {
            if (
              !$event.type.indexOf("key") &&
              _vm._k($event.keyCode, "down", 40, $event.key, [
                "Down",
                "ArrowDown",
              ])
            ) {
              return null
            }
            return _vm.onArrowDown($event)
          },
          function ($event) {
            if (
              !$event.type.indexOf("key") &&
              _vm._k($event.keyCode, "up", 38, $event.key, ["Up", "ArrowUp"])
            ) {
              return null
            }
            return _vm.onArrowUp($event)
          },
          function ($event) {
            if (
              !$event.type.indexOf("key") &&
              _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
            ) {
              return null
            }
            return _vm.onEnter($event)
          },
        ],
        keydown: function ($event) {
          if (
            !$event.type.indexOf("key") &&
            _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
          ) {
            return null
          }
          $event.preventDefault()
        },
      },
    }),
    _vm._v(" "),
    _c(
      "ul",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.showList,
            expression: "showList",
          },
        ],
        staticClass: "search-results",
      },
      _vm._l(_vm.searchResults, function (genre, i) {
        return _c(
          "li",
          {
            key: i,
            class: { highlighted: i === _vm.arrowCounter },
            on: {
              click: function ($event) {
                return _vm.selectGenre(genre)
              },
              mouseover: function ($event) {
                _vm.arrowCounter = i
              },
            },
          },
          [_vm._v("\n            " + _vm._s(genre.name) + "\n        ")]
        )
      }),
      0
    ),
    _vm._v(" "),
    _vm.selectedGenres.length > 0
      ? _c("p", [_vm._v("\n        Click on a genre to remove it\n    ")])
      : _vm._e(),
    _vm._v(" "),
    _c(
      "ul",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.selectedGenres.length > 0,
            expression: "selectedGenres.length > 0",
          },
        ],
        staticClass: "selected-genres",
      },
      _vm._l(_vm.selectedGenres, function (genre, i) {
        return _c(
          "li",
          {
            key: i,
            on: {
              click: function ($event) {
                return _vm.removeGenre(genre)
              },
            },
          },
          [_vm._v("\n            " + _vm._s(genre.name) + "\n        ")]
        )
      }),
      0
    ),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/admin.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=admin.js.map