webpackJsonp([0],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Home.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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
    return {};
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a93a002c\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Home.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.margin-top[data-v-a93a002c] {\n  margin-top: 55px;\n}\n.height-fill[data-v-a93a002c] {\n  height: 100vh!important;\n}\n.resultContainer[data-v-a93a002c] {\n  min-height: 450px;\n}\nh1[data-v-a93a002c], h2[data-v-a93a002c] {\n  font-weight: normal;\n}\nul[data-v-a93a002c] {\n  list-style-type: none;\n  padding: 0;\n}\nli[data-v-a93a002c] {\n  display: inline-block;\n  margin: 0 10px;\n}\na[data-v-a93a002c] {\n  color: #42b983;\n}\n.padding-clear[data-v-a93a002c] {\n  padding: 0 !important;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a93a002c\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Home.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("v-content", { staticClass: "padding-clear" }, [
    _c(
      "section",
      [
        _c(
          "v-parallax",
          { attrs: { src: "/img/bg.jpg", height: "600" } },
          [
            _c(
              "v-layout",
              {
                staticClass: "white--text",
                attrs: { column: "", "align-center": "", "justify-center": "" }
              },
              [
                _c(
                  "h1",
                  { staticClass: "white--text mb-2 display-1 text-xs-center" },
                  [_vm._v("DonateSupp")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "subheading mb-3 text-xs-center" }, [
                  _vm._v("Facilisis sed odio morbi quis")
                ]),
                _vm._v(" "),
                !_vm.$store.state.api_token
                  ? _c(
                      "v-btn",
                      {
                        attrs: { color: "primary", dark: "", large: "" },
                        on: {
                          click: function($event) {
                            _vm.$router.push({ name: "Login" })
                          }
                        }
                      },
                      [_vm._v("\n          Начать использовать\n        ")]
                    )
                  : _c(
                      "v-btn",
                      {
                        attrs: { color: "primary", dark: "", large: "" },
                        on: {
                          click: function($event) {
                            _vm.$router.push({ name: "MyProfile" })
                          }
                        }
                      },
                      [_vm._v("\n          Мой профиль\n        ")]
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
      "section",
      [
        _c(
          "v-layout",
          {
            staticClass: "my-5",
            attrs: { column: "", wrap: "", "align-center": "" }
          },
          [
            _c(
              "v-flex",
              { staticClass: "my-3", attrs: { xs12: "", sm4: "" } },
              [
                _c("div", { staticClass: "text-xs-center" }, [
                  _c("h2", { staticClass: "headline" }, [
                    _vm._v("Facilisis sed odio morbi quis")
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "subheading" }, [
                    _vm._v("\n            Tristique risus nec\n          ")
                  ])
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "v-flex",
              { attrs: { xs12: "" } },
              [
                _c(
                  "v-container",
                  { attrs: { "grid-list-xl": "" } },
                  [
                    _c(
                      "v-layout",
                      {
                        attrs: {
                          wrap: "",
                          row: "",
                          "align-space-around": "",
                          "justify-space-around": ""
                        }
                      },
                      [
                        _c(
                          "v-flex",
                          { attrs: { xs12: "", md4: "" } },
                          [
                            _c("v-hover", {
                              scopedSlots: _vm._u([
                                {
                                  key: "default",
                                  fn: function(ref) {
                                    var hover = ref.hover
                                    return _c(
                                      "v-card",
                                      {
                                        staticClass:
                                          "transparent resultContainer",
                                        class: "elevation-" + (hover ? 20 : 2)
                                      },
                                      [
                                        _c(
                                          "v-parallax",
                                          {
                                            attrs: {
                                              height: "450",
                                              src:
                                                "https://images.wallpaperscraft.ru/image/call_of_duty_black_ops_3_activision_publishing_103670_540x960.jpg"
                                            }
                                          },
                                          [
                                            _c(
                                              "v-card-title",
                                              {
                                                staticClass:
                                                  "layout justify-center",
                                                attrs: { "primary-title": "" }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "headline text-xs-center"
                                                  },
                                                  [_vm._v("Viverra nibh cras")]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c("v-card-text", [
                                              _vm._v(
                                                "\n                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Eros donec ac odio tempor orci dapibus. Tellus pellentesque eu tincidunt tortor aliquam nulla. Elit ullamcorper dignissim cras tincidunt lobortis. Est pellentesque elit ullamcorper dignissim cras. Eget nullam non nisi est sit amet facilisis. \n                    "
                                              )
                                            ])
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
                        ),
                        _vm._v(" "),
                        _c(
                          "v-flex",
                          { attrs: { xs12: "", md4: "" } },
                          [
                            _c("v-hover", {
                              scopedSlots: _vm._u([
                                {
                                  key: "default",
                                  fn: function(ref) {
                                    var hover = ref.hover
                                    return _c(
                                      "v-card",
                                      {
                                        staticClass:
                                          "transparent resultContainer",
                                        class: "elevation-" + (hover ? 20 : 2)
                                      },
                                      [
                                        _c(
                                          "v-parallax",
                                          {
                                            attrs: {
                                              height: "450",
                                              src:
                                                "https://images.wallpaperscraft.ru/image/killzone_shlem_svet_glaza_soldat_21150_540x960.jpg"
                                            }
                                          },
                                          [
                                            _c(
                                              "v-card-title",
                                              {
                                                staticClass:
                                                  "layout justify-center",
                                                attrs: { "primary-title": "" }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  { staticClass: "headline" },
                                                  [
                                                    _vm._v(
                                                      "Tortor pretium viverra"
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c("v-card-text", [
                                              _vm._v(
                                                "\n                      Cursus turpis massa tincidunt dui ut ornare lectus. Condimentum lacinia quis vel eros donec ac odio tempor. Sit amet mauris commodo quis imperdiet massa tincidunt. Gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Et malesuada fames ac turpis egestas sed. \n                    "
                                              )
                                            ])
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
                        ),
                        _vm._v(" "),
                        _c(
                          "v-flex",
                          { attrs: { xs12: "", md4: "" } },
                          [
                            _c("v-hover", {
                              scopedSlots: _vm._u([
                                {
                                  key: "default",
                                  fn: function(ref) {
                                    var hover = ref.hover
                                    return _c(
                                      "v-card",
                                      {
                                        staticClass:
                                          "transparent resultContainer",
                                        class: "elevation-" + (hover ? 20 : 2)
                                      },
                                      [
                                        _c(
                                          "v-parallax",
                                          {
                                            attrs: {
                                              height: "450",
                                              src:
                                                "https://images.wallpaperscraft.ru/image/alien_isolation_pc_playstation_3_playstation_4_xbox_360_xbox_one_creative_assembly_sega_total_war_ellen_ripli_93431_540x960.jpg"
                                            }
                                          },
                                          [
                                            _c(
                                              "v-card-title",
                                              {
                                                staticClass:
                                                  "layout justify-center",
                                                attrs: { "primary-title": "" }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "headline text-xs-center"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "Praesent elementum facilisis"
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c("v-card-text", [
                                              _vm._v(
                                                "\n                      Faucibus pulvinar elementum integer enim neque volutpat ac tincidunt vitae. Lectus quam id leo in vitae turpis massa sed. Aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque. In vitae turpis massa sed elementum tempus egestas. Aliquam ultrices sagittis orci a scelerisque purus.\n                    "
                                              )
                                            ])
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
      "section",
      [
        _c(
          "v-parallax",
          { attrs: { src: "/img/bg2.jpg" } },
          [
            _c(
              "v-layout",
              {
                attrs: { column: "", "align-center": "", "justify-center": "" }
              },
              [
                _c(
                  "div",
                  { staticClass: "headline white--text mb-3 text-xs-center" },
                  [
                    _vm._v(
                      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                    )
                  ]
                ),
                _vm._v(" "),
                _c("em", [_vm._v("Tortor id aliquet lectus proin.")]),
                _vm._v(" "),
                !_vm.$store.state.api_token
                  ? _c(
                      "v-btn",
                      {
                        attrs: { color: "primary", dark: "", large: "" },
                        on: {
                          click: function($event) {
                            _vm.$router.push({ name: "Login" })
                          }
                        }
                      },
                      [_vm._v("\n          Начать использовать\n        ")]
                    )
                  : _c(
                      "v-btn",
                      {
                        attrs: { color: "primary", dark: "", large: "" },
                        on: {
                          click: function($event) {
                            _vm.$router.push({ name: "MyProfile" })
                          }
                        }
                      },
                      [_vm._v("\n          Мой профиль\n        ")]
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
      "section",
      [
        _c(
          "v-container",
          { attrs: { "grid-list-xl": "" } },
          [
            _c(
              "v-layout",
              {
                staticClass: "my-5",
                attrs: { row: "", wrap: "", "justify-center": "" }
              },
              [
                _c(
                  "v-flex",
                  { attrs: { xs12: "", sm4: "" } },
                  [
                    _c(
                      "v-card",
                      { staticClass: "elevation-0 transparent" },
                      [
                        _c(
                          "v-card-title",
                          {
                            staticClass: "layout justify-center",
                            attrs: { "primary-title": "" }
                          },
                          [
                            _c("div", { staticClass: "headline" }, [
                              _vm._v("Mattis rhoncus urna")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c("v-card-text", [
                          _vm._v(
                            "\n              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Tortor id aliquet lectus proin. Felis donec et odio pellentesque diam volutpat. Tellus orci ac auctor augue.\n            "
                          )
                        ])
                      ],
                      1
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "v-flex",
                  { attrs: { xs12: "", sm4: "", "offset-sm1": "" } },
                  [
                    _c(
                      "v-card",
                      { staticClass: "elevation-0 transparent" },
                      [
                        _c(
                          "v-card-title",
                          {
                            staticClass: "layout justify-center",
                            attrs: { "primary-title": "" }
                          },
                          [
                            _c("div", { staticClass: "headline" }, [
                              _vm._v("Контакты")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c("v-card-text", [
                          _vm._v(
                            "\n              Lorem ipsum dolor sit amet, consectetur adipiscing elit.\n            "
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "v-list",
                          { staticClass: "transparent" },
                          [
                            _c(
                              "v-list-tile",
                              [
                                _c(
                                  "v-list-tile-action",
                                  [
                                    _c(
                                      "v-icon",
                                      {
                                        staticClass:
                                          "blue--text text--lighten-2"
                                      },
                                      [_vm._v("phone")]
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-list-tile-content",
                                  [
                                    _c("v-list-tile-title", [
                                      _vm._v("+7441 143 4785")
                                    ])
                                  ],
                                  1
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "v-list-tile",
                              [
                                _c(
                                  "v-list-tile-action",
                                  [
                                    _c(
                                      "v-icon",
                                      {
                                        staticClass:
                                          "blue--text text--lighten-2"
                                      },
                                      [_vm._v("place")]
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-list-tile-content",
                                  [_c("v-list-tile-title", [_vm._v("Москва")])],
                                  1
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "v-list-tile",
                              [
                                _c(
                                  "v-list-tile-action",
                                  [
                                    _c(
                                      "v-icon",
                                      {
                                        staticClass:
                                          "blue--text text--lighten-2"
                                      },
                                      [_vm._v("mdi-twitter")]
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-list-tile-content",
                                  [
                                    _c("v-list-tile-title", [
                                      _vm._v("@company_name")
                                    ])
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
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-a93a002c", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a93a002c\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Home.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a93a002c\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Home.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("6afc4ff8", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a93a002c\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Home.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a93a002c\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Home.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/js/App/pages/Home.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a93a002c\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/App/pages/Home.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}],\"syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/App/pages/Home.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a93a002c\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/App/pages/Home.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-a93a002c"
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
Component.options.__file = "resources/assets/js/App/pages/Home.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a93a002c", Component.options)
  } else {
    hotAPI.reload("data-v-a93a002c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});