webpackJsonp([6],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Profile.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__("./node_modules/axios/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);
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



/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      user: null
    };
  },

  computed: {
    user_id: function user_id() {
      return this.$route.params.id;
    }
  },
  methods: {
    goTransaction: function goTransaction() {
      this.$router.push({ name: 'Payment', params: { id: this.user_id } });
    },
    fetchUserInfo: function fetchUserInfo() {
      var _this = this;

      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/user/info/' + this.user_id).then(function (response) {
        _this.user = response.data;
      }).catch(function () {
        _this.$store.dispatch('snackbar', { text: 'Пользователь не найден', color: 'error' });
        _this.$router.go(-1);
      });
    }
  },
  created: function created() {
    this.fetchUserInfo();
  },

  watch: {
    user_id: function user_id() {
      this.fetchUserInfo();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-adb51224\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Profile.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-container",
    [
      _vm.user
        ? _c(
            "v-layout",
            { attrs: { row: "", wrap: "" } },
            [
              _c(
                "v-flex",
                { attrs: { xs12: "", "d-flex": "" } },
                [
                  _c("v-flex", { attrs: { xs6: "" } }, [
                    _c("img", {
                      staticClass: "img-circle elevation-7 mb-1",
                      attrs: { src: _vm.user.avatar }
                    })
                  ]),
                  _vm._v(" "),
                  _c("v-flex", { attrs: { xs6: "" } }, [
                    _c("div", {
                      staticClass: "headline",
                      domProps: { textContent: _vm._s(_vm.user.name) }
                    })
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-flex",
                { attrs: { xs12: "" } },
                [
                  _c(
                    "v-btn",
                    {
                      attrs: { color: "primary" },
                      on: { click: _vm.goTransaction }
                    },
                    [_vm._v("Донатить")]
                  )
                ],
                1
              )
            ],
            1
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-adb51224", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/App/pages/Profile.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Profile.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-adb51224\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Profile.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/App/pages/Profile.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-adb51224", Component.options)
  } else {
    hotAPI.reload("data-v-adb51224", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});