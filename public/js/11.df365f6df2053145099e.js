webpackJsonp([11],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/MyProfile.vue":
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



/* harmony default export */ __webpack_exports__["default"] = ({
  computed: {
    user: function user() {
      return this.$store.state.user;
    }
  },
  data: function data() {
    return {
      link: '',
      links: [],
      donatLink: ''
    };
  },

  methods: {
    goLink: function goLink(link) {
      window.location = link + '/#/?settings=1';
    },
    doCopy: function doCopy(text) {
      var _this = this;

      this.$copyText(text).then(function (e) {
        _this.$store.dispatch('snackbar', { text: 'Скопировано в буфер обмена' });
      }, function (e) {
        _this.$store.dispatch('snackbar', { text: 'Ошибка при копировании', color: 'error' });
      });
    },
    goTransaction: function goTransaction() {
      this.$router.push({ name: 'Payment', params: { id: this.user.id } });
    },
    fetchLink: function fetchLink() {
      var _this2 = this;

      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/streamlink').then(function (response) {
        _this2.link = response.data;
      });
    },
    fetchDonatLink: function fetchDonatLink() {
      var _this3 = this;

      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/donatlink').then(function (response) {
        _this3.donatLink = response.data;
      });
    },
    fetchLinks: function fetchLinks() {
      var _this4 = this;

      __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/fetchlinks').then(function (response) {
        _this4.links = response.data;
      });
    },
    editDonatePage: function editDonatePage() {
      this.$router.push({ name: 'Payment', params: { id: this.user.id } });
      this.dialog = false;
      this.$store.dispatch('rightDrawerToggle', true);
      this.$store.dispatch('rightDrawerChange', 'donate');
    }
  },
  created: function created() {
    this.fetchLink();
    this.fetchDonatLink();
    this.fetchLinks();
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-125ef662\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/MyProfile.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.img-circle[data-v-125ef662] {\n  background-color: #fff;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-125ef662\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/MyProfile.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-layout",
    [
      _c(
        "v-container",
        { attrs: { fluid: "", "fill-height": "" } },
        [
          _c(
            "v-layout",
            { attrs: { row: "", wrap: "", "align-center": "" } },
            [
              _c("v-flex", { attrs: { xs12: "", md4: "" } }, [
                _vm.user
                  ? _c(
                      "div",
                      { staticClass: "text-xs-center" },
                      [
                        _c("v-avatar", { attrs: { size: "125px" } }, [
                          _c("img", {
                            staticClass: "img-circle elevation-7 mb-1",
                            attrs: { src: _vm.user.avatar }
                          })
                        ]),
                        _vm._v(" "),
                        _c("div", {
                          staticClass: "headline",
                          domProps: { textContent: _vm._s(_vm.user.name) }
                        }),
                        _vm._v(" "),
                        _c("div", {
                          staticClass:
                            "subheading text-xs-center grey--text pt-1 pb-3",
                          domProps: { textContent: _vm._s(_vm.user.email) }
                        })
                      ],
                      1
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c(
                "v-flex",
                { attrs: { xs12: "", sm6: "", md3: "" } },
                [
                  _c("v-text-field", {
                    attrs: {
                      readonly: "",
                      label: "Ссылка на уведомление доната во время стрима",
                      outline: "",
                      "append-outer-icon": "mdi-settings",
                      "append-icon": "mdi-content-copy"
                    },
                    on: {
                      "click:append-outer": function($event) {
                        _vm.goLink(_vm.link)
                      },
                      "click:append": function($event) {
                        _vm.doCopy(_vm.link)
                      }
                    },
                    model: {
                      value: _vm.link,
                      callback: function($$v) {
                        _vm.link = $$v
                      },
                      expression: "link"
                    }
                  }),
                  _vm._v(" "),
                  _c("v-text-field", {
                    attrs: {
                      box: "",
                      readonly: "",
                      label: "Ссылка на уведомление подписки во время стрима",
                      outline: "",
                      "append-icon": "mdi-content-copy",
                      "append-outer-icon": "mdi-settings"
                    },
                    on: {
                      "click:append-outer": function($event) {
                        _vm.goLink(_vm.links.subscription)
                      },
                      "click:append": function($event) {
                        _vm.doCopy(_vm.links.subscription)
                      }
                    },
                    model: {
                      value: _vm.links.subscription,
                      callback: function($$v) {
                        _vm.$set(_vm.links, "subscription", $$v)
                      },
                      expression: "links.subscription"
                    }
                  }),
                  _vm._v(" "),
                  _c("v-text-field", {
                    attrs: {
                      readonly: "",
                      label:
                        "Ссылка на уведомление платной подписки во время стрима",
                      outline: "",
                      "append-outer-icon": "mdi-settings",
                      "append-icon": "mdi-content-copy"
                    },
                    on: {
                      "click:append-outer": function($event) {
                        _vm.goLink(_vm.links.paidsubscription)
                      },
                      "click:append": function($event) {
                        _vm.doCopy(_vm.links.paidsubscription)
                      }
                    },
                    model: {
                      value: _vm.links.paidsubscription,
                      callback: function($$v) {
                        _vm.$set(_vm.links, "paidsubscription", $$v)
                      },
                      expression: "links.paidsubscription"
                    }
                  }),
                  _vm._v(" "),
                  _c("v-text-field", {
                    attrs: {
                      readonly: "",
                      label: "Ссылка на донат",
                      "append-icon": "mdi-content-copy",
                      "append-outer-icon": "mdi-settings",
                      outline: ""
                    },
                    on: {
                      "click:append-outer": _vm.editDonatePage,
                      "click:append": function($event) {
                        _vm.doCopy(_vm.donatLink)
                      }
                    },
                    model: {
                      value: _vm.donatLink,
                      callback: function($$v) {
                        _vm.donatLink = $$v
                      },
                      expression: "donatLink"
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
    require("vue-hot-reload-api")      .rerender("data-v-125ef662", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-125ef662\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/MyProfile.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-125ef662\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/MyProfile.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("134f01c4", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-125ef662\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MyProfile.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-125ef662\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MyProfile.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/js/App/pages/MyProfile.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-125ef662\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/MyProfile.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/MyProfile.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-125ef662\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/MyProfile.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-125ef662"
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
Component.options.__file = "resources/assets/js/App/pages/MyProfile.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-125ef662", Component.options)
  } else {
    hotAPI.reload("data-v-125ef662", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});