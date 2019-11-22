webpackJsonp([17],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Follows.vue":
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
      follows: [],
      followInfo: null,
      followInfoDialog: false
    };
  },

  methods: {
    fetchFollowInfo: function fetchFollowInfo(channel) {
      var _this = this;

      this.$store.dispatch('loader', true);
      // this.followInfo = channel
      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/twitch/channels/' + channel).then(function (response) {
        console.log('response', response.data);
        _this.followInfo = response.data;
        _this.$store.dispatch('loader', false);
      });
    },
    fetchfollows: function fetchfollows() {
      var _this2 = this;

      this.$store.dispatch('loader', true);
      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/twitch/followsList').then(function (response) {
        _this2.follows = response.data.follows;
        _this2.$store.dispatch('loader', false);
      });
      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/twitch/test').then(function (response) {
        console.log('test', response.data);
      });
    }
  },
  created: function created() {
    this.fetchfollows();
  },

  watch: {
    followInfo: function followInfo(val) {
      if (null !== val) {
        this.followInfoDialog = true;
      }
    },
    followInfoDialog: function followInfoDialog(val) {
      if (false === val) {
        this.followInfo = null;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-027838b2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Follows.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.v-expansion-panel__header {\n  padding: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-027838b2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Follows.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-layout",
    { attrs: { row: "" } },
    [
      _c(
        "v-flex",
        { attrs: { xs12: "", sm6: "", "offset-sm3": "" } },
        [
          _c(
            "v-list",
            { attrs: { subheader: "" } },
            [_c("v-subheader", [_vm._v("Мои подписчики")])],
            1
          ),
          _vm._v(" "),
          _c(
            "v-expansion-panel",
            _vm._l(_vm.follows, function(follow) {
              return _c(
                "v-expansion-panel-content",
                { key: follow.user._id },
                [
                  _c(
                    "div",
                    {
                      staticClass: "test",
                      attrs: { slot: "header" },
                      slot: "header"
                    },
                    [
                      _c(
                        "v-list-tile",
                        { attrs: { avatar: "" } },
                        [
                          _c("v-list-tile-avatar", [
                            _c("img", { attrs: { src: follow.user.logo } })
                          ]),
                          _vm._v(" "),
                          _c(
                            "v-list-tile-content",
                            [
                              _c("v-list-tile-title", {
                                domProps: {
                                  textContent: _vm._s(follow.user.display_name)
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-card",
                    [
                      _c(
                        "v-card-text",
                        [
                          _vm._v(
                            "\n            " +
                              _vm._s(follow.user.bio) +
                              " \n            "
                          ),
                          _c(
                            "v-btn",
                            {
                              attrs: { small: "" },
                              on: {
                                click: function($event) {
                                  _vm.fetchFollowInfo(follow.user._id)
                                }
                              }
                            },
                            [_vm._v("Подробнее")]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            })
          )
        ],
        1
      ),
      _vm._v(" "),
      _vm.followInfo
        ? _c(
            "v-dialog",
            {
              attrs: { "max-width": "500" },
              model: {
                value: _vm.followInfoDialog,
                callback: function($$v) {
                  _vm.followInfoDialog = $$v
                },
                expression: "followInfoDialog"
              }
            },
            [
              _c(
                "v-card",
                [
                  _c("v-img", {
                    attrs: {
                      src: _vm.followInfo.profile_banner,
                      "aspect-ratio": "2.75"
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "v-card-title",
                    { staticClass: "headline" },
                    [
                      _c(
                        "v-list-tile",
                        { attrs: { avatar: "" } },
                        [
                          _c("v-list-tile-avatar", [
                            _c("img", { attrs: { src: _vm.followInfo.logo } })
                          ]),
                          _vm._v(" "),
                          _c(
                            "v-list-tile-content",
                            [
                              _c("v-list-tile-title", [
                                _vm._v(
                                  "\n                " +
                                    _vm._s(_vm.followInfo.display_name) +
                                    "\n              "
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "v-list-tile-sub-title",
                                [
                                  _c(
                                    "v-chip",
                                    {
                                      staticClass: "ml-0",
                                      attrs: {
                                        small: "",
                                        color: "green lighten-4"
                                      }
                                    },
                                    [
                                      _c(
                                        "v-avatar",
                                        [_c("v-icon", [_vm._v("mdi-eye")])],
                                        1
                                      ),
                                      _vm._v(
                                        "\n                  " +
                                          _vm._s(_vm.followInfo.views) +
                                          " просмотров\n                "
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-chip",
                                    {
                                      staticClass: "ml-0",
                                      attrs: {
                                        color: "green lighten-4",
                                        small: ""
                                      }
                                    },
                                    [
                                      _c(
                                        "v-avatar",
                                        [
                                          _c("v-icon", [
                                            _vm._v("mdi-account-group")
                                          ])
                                        ],
                                        1
                                      ),
                                      _vm._v(
                                        "\n                  " +
                                          _vm._s(_vm.followInfo.followers) +
                                          " подписчиков\n                "
                                      )
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-card-actions",
                    [
                      _c("v-spacer"),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { color: "green darken-1", flat: "flat" },
                          on: {
                            click: function($event) {
                              _vm.followInfoDialog = false
                            }
                          }
                        },
                        [_vm._v("\n          Закрыть\n        ")]
                      )
                    ],
                    1
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
    require("vue-hot-reload-api")      .rerender("data-v-027838b2", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-027838b2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Follows.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-027838b2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Follows.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("cd8252ac", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-027838b2\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Follows.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-027838b2\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Follows.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/js/App/pages/Follows.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-027838b2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Follows.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Follows.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-027838b2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Follows.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "resources/assets/js/App/pages/Follows.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-027838b2", Component.options)
  } else {
    hotAPI.reload("data-v-027838b2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});