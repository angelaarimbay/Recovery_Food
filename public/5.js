(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      menu: false,
      date: new Date().toISOString().substr(0, 10),
      iris_dialog: false,
      iris_headers: [{
        text: 'Dated',
        value: 'date'
      }, {
        text: 'Title',
        value: 'title'
      }, {
        text: 'Description',
        value: 'description'
      }, {
        text: 'Attachment',
        value: 'filename'
      }, {
        text: 'Action',
        value: 'id'
      }],
      iris_data: [],
      iris_add_dialog: false,
      data: {
        title: '5%',
        description: 'Nil',
        dated: '2020-01-23',
        file: '2015 - Typhoon A, Claimed paid = 100k'
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=template&id=031b6f6c&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=template&id=031b6f6c& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("v-card-title", { staticClass: "text-h5 grey lighten-2" }, [
        _vm._v("\r\n            IRES          \r\n        ")
      ]),
      _vm._v(" "),
      _c(
        "v-card-text",
        [
          _c(
            "v-card-text",
            [
              _c(
                "v-btn",
                {
                  staticClass: "info",
                  attrs: { small: "" },
                  on: {
                    click: function($event) {
                      _vm.iris_add_dialog = true
                    }
                  }
                },
                [_vm._v("Add new")]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("v-data-table", {
            staticClass: "elevation-1",
            attrs: {
              headers: _vm.iris_headers,
              items: _vm.iris_data,
              "items-per-page": 5
            },
            scopedSlots: _vm._u(
              [
                {
                  key: "item.filename",
                  fn: function(ref) {
                    var item = ref.item
                    return [
                      _c(
                        "v-btn",
                        { attrs: { small: "", color: "blue", dark: "" } },
                        [_vm._v("Download")]
                      )
                    ]
                  }
                }
              ],
              null,
              true
            )
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { width: "800" },
          model: {
            value: _vm.iris_add_dialog,
            callback: function($$v) {
              _vm.iris_add_dialog = $$v
            },
            expression: "iris_add_dialog"
          }
        },
        [
          _c(
            "v-card",
            [
              _c("v-card-title", { staticClass: "text-h5 grey lighten-2" }, [
                _vm._v("\r\n            Add New Survey\r\n          ")
              ]),
              _vm._v(" "),
              _c(
                "v-card-text",
                [
                  _c(
                    "v-container",
                    [
                      _c("v-text-field", {
                        attrs: { label: "Title", "hide-details": "auto" },
                        model: {
                          value: _vm.data.title,
                          callback: function($$v) {
                            _vm.$set(_vm.data, "title", $$v)
                          },
                          expression: "data.title"
                        }
                      }),
                      _vm._v(" "),
                      _c("v-text-field", {
                        attrs: { label: "Description", "hide-details": "auto" },
                        model: {
                          value: _vm.data.description,
                          callback: function($$v) {
                            _vm.$set(_vm.data, "description", $$v)
                          },
                          expression: "data.description"
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "v-menu",
                        {
                          ref: "menu",
                          attrs: {
                            "max-width": "280",
                            "close-on-content-click": false,
                            "return-value": _vm.date,
                            transition: "scale-transition",
                            "offset-ymin-width": "auto"
                          },
                          on: {
                            "update:returnValue": function($event) {
                              _vm.date = $event
                            },
                            "update:return-value": function($event) {
                              _vm.date = $event
                            }
                          },
                          scopedSlots: _vm._u([
                            {
                              key: "activator",
                              fn: function(ref) {
                                var on = ref.on
                                var attrs = ref.attrs
                                return [
                                  _c(
                                    "v-text-field",
                                    _vm._g(
                                      _vm._b(
                                        {
                                          attrs: {
                                            label: "Date",
                                            "prepend-icon": "mdi-calendar",
                                            readonly: ""
                                          },
                                          model: {
                                            value: _vm.data.dated,
                                            callback: function($$v) {
                                              _vm.$set(_vm.data, "dated", $$v)
                                            },
                                            expression: "data.dated"
                                          }
                                        },
                                        "v-text-field",
                                        attrs,
                                        false
                                      ),
                                      on
                                    )
                                  )
                                ]
                              }
                            }
                          ]),
                          model: {
                            value: _vm.menu,
                            callback: function($$v) {
                              _vm.menu = $$v
                            },
                            expression: "menu"
                          }
                        },
                        [
                          _vm._v(" "),
                          _c(
                            "v-date-picker",
                            {
                              attrs: { "no-title": "", scrollable: "" },
                              model: {
                                value: _vm.data.dated,
                                callback: function($$v) {
                                  _vm.$set(_vm.data, "dated", $$v)
                                },
                                expression: "data.dated"
                              }
                            },
                            [
                              _c("v-spacer"),
                              _vm._v(" "),
                              _c(
                                "v-btn",
                                {
                                  attrs: { text: "", color: "primary" },
                                  on: {
                                    click: function($event) {
                                      _vm.menu = false
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\r\n                      Cancel\r\n                  "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "v-btn",
                                {
                                  attrs: { text: "", color: "primary" },
                                  on: {
                                    click: function($event) {
                                      return _vm.$refs.menu.save(_vm.data.dated)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\r\n                      OK\r\n                  "
                                  )
                                ]
                              )
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("v-text-field", {
                        attrs: { label: "Filename", "hide-details": "auto" },
                        model: {
                          value: _vm.data.lossratio,
                          callback: function($$v) {
                            _vm.$set(_vm.data, "lossratio", $$v)
                          },
                          expression: "data.lossratio"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("v-divider"),
              _vm._v(" "),
              _c(
                "v-card-actions",
                [
                  _c("v-spacer"),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      attrs: { color: "blue darken-1", text: "" },
                      on: {
                        click: function($event) {
                          _vm.iris_add_dialog = false
                        }
                      }
                    },
                    [_vm._v("\r\n              Close\r\n            ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      attrs: { color: "primary darken-1", text: "" },
                      on: {
                        click: function($event) {
                          _vm.iris_add_dialog = false
                        }
                      }
                    },
                    [_vm._v("\r\n              Save\r\n            ")]
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
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/survey/infosheet_ires_list.vue":
/*!***********************************************************!*\
  !*** ./resources/js/pages/survey/infosheet_ires_list.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _infosheet_ires_list_vue_vue_type_template_id_031b6f6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./infosheet_ires_list.vue?vue&type=template&id=031b6f6c& */ "./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=template&id=031b6f6c&");
/* harmony import */ var _infosheet_ires_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./infosheet_ires_list.vue?vue&type=script&lang=js& */ "./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _infosheet_ires_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _infosheet_ires_list_vue_vue_type_template_id_031b6f6c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _infosheet_ires_list_vue_vue_type_template_id_031b6f6c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/survey/infosheet_ires_list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_ires_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./infosheet_ires_list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_ires_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=template&id=031b6f6c&":
/*!******************************************************************************************!*\
  !*** ./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=template&id=031b6f6c& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_ires_list_vue_vue_type_template_id_031b6f6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./infosheet_ires_list.vue?vue&type=template&id=031b6f6c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet_ires_list.vue?vue&type=template&id=031b6f6c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_ires_list_vue_vue_type_template_id_031b6f6c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_ires_list_vue_vue_type_template_id_031b6f6c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);