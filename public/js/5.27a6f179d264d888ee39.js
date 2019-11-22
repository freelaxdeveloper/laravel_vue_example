webpackJsonp([5],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Test.vue":
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
      icon: '',
      icons: []
    };
  },

  methods: {
    fetchIcons: function fetchIcons() {
      var _this = this;

      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/icons').then(function (response) {
        _this.icons = response.data;
      });
    }
  },
  created: function created() {
    this.fetchIcons();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-f7f983c6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Test.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-item-group",
    [
      _c(
        "v-btn",
        { attrs: { small: "" } },
        [
          _vm.icon
            ? _c("v-icon", {
                attrs: { left: "", dark: "" },
                domProps: { textContent: _vm._s(_vm.icon) }
              })
            : _vm._e(),
          _vm._v(" Кнопка\n  ")
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-container",
        { attrs: { "grid-list-md": "" } },
        [
          _c(
            "v-layout",
            { attrs: { wrap: "" } },
            _vm._l(_vm.icons, function(item, i) {
              return _c(
                "v-flex",
                { key: i, attrs: { xs1: "" } },
                [
                  _c("v-item", {
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(ref) {
                          var active = ref.active
                          var toggle = ref.toggle
                          return _c(
                            "v-card",
                            {
                              staticClass: "d-flex align-center",
                              attrs: {
                                color: active ? "primary" : "",
                                dark: "",
                                height: "48"
                              },
                              nativeOn: {
                                click: function($event) {
                                  return toggle($event)
                                }
                              }
                            },
                            [
                              _c(
                                "v-scroll-y-transition",
                                [
                                  _c("v-icon", {
                                    attrs: { left: "", dark: "" },
                                    domProps: { textContent: _vm._s(item) },
                                    on: {
                                      click: function($event) {
                                        _vm.icon = !active ? item : ""
                                      }
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          )
                        }
                      }
                    ])
                  })
                ],
                1
              )
            })
          )
        ],
        1
      )
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
    require("vue-hot-reload-api")      .rerender("data-v-f7f983c6", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/App/pages/Test.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Test.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-f7f983c6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Test.vue")
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
Component.options.__file = "resources/assets/js/App/pages/Test.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-f7f983c6", Component.options)
  } else {
    hotAPI.reload("data-v-f7f983c6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});