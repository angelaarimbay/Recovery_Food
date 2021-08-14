(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/quicksearch.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/dashboard/quicksearch.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      page: 1,
      dialog: false,
      search: '',
      headers: [{
        "class": 'border',
        text: 'Company',
        value: 'name'
      }, {
        "class": 'border',
        text: 'Action',
        value: 'iron'
      }],
      data: [{
        name: 'Frozen Yogurt',
        iron: '1%'
      }, {
        name: 'Ice cream sandwich Ice cream sandwich Ice cream sandwich',
        iron: '1%'
      }, {
        name: 'Eclair',
        iron: '7%'
      }, {
        name: 'Cupcake',
        iron: '8%'
      }, {
        name: 'Gingerbread',
        iron: '16%'
      }, {
        name: 'Jelly bean',
        iron: '0%'
      }, {
        name: 'Lollipop',
        iron: '2%'
      }, {
        name: 'Honeycomb',
        iron: '45%'
      }, {
        name: 'Donut',
        iron: '22%'
      }, {
        name: 'KitKat',
        iron: '6%'
      }, {
        name: 'KitKat',
        iron: '6%'
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/quicksearch.vue?vue&type=template&id=109bdc41&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/dashboard/quicksearch.vue?vue&type=template&id=109bdc41& ***!
  \*******************************************************************************************************************************************************************************************************************/
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
    "v-card",
    { staticClass: "p-4 rounded-tr-xl" },
    [
      _c(
        "v-card-title",
        { staticClass: "p-0 h6" },
        [
          _c("v-icon", { attrs: { color: "red", size: "25" } }, [
            _vm._v("mdi-magnify")
          ]),
          _vm._v(" Quick Search")
        ],
        1
      ),
      _vm._v(" "),
      _c("hr", { staticClass: "m-0" }),
      _vm._v(" "),
      _c(
        "v-card",
        { attrs: { flat: "" } },
        [
          _c("v-text-field", {
            attrs: { label: "search company" },
            model: {
              value: _vm.search,
              callback: function($$v) {
                _vm.search = $$v
              },
              expression: "search"
            }
          }),
          _vm._v(" "),
          _c(
            "v-card",
            {
              staticStyle: { "overflow-y": "auto" },
              attrs: { flat: "", height: "250" }
            },
            [
              _c("v-data-table", {
                attrs: {
                  headers: _vm.headers,
                  "sort-by": ["name"],
                  page: _vm.page,
                  items: _vm.data,
                  dense: "",
                  search: _vm.search,
                  "hide-default-footer": "",
                  "items-per-page": 6
                },
                on: {
                  "update:page": function($event) {
                    _vm.page = $event
                  }
                },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "item.iron",
                      fn: function(ref) {
                        var item = ref.item
                        return [
                          _c("v-hover", {
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(ref) {
                                    var hover = ref.hover
                                    return [
                                      _c(
                                        "v-btn",
                                        {
                                          staticClass: "px-1",
                                          class: hover
                                            ? "btn btn-info text-white"
                                            : "btn btn-link text-info",
                                          attrs: { text: "", small: "" },
                                          on: {
                                            click: function($event) {
                                              _vm.dialog = true
                                            }
                                          }
                                        },
                                        [
                                          _c("v-icon", [_vm._v(" mdi-eye ")]),
                                          _vm._v(" "),
                                          _c("small", [_vm._v(" - View ")])
                                        ],
                                        1
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              true
                            )
                          })
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
          _c("hr"),
          _vm._v(" "),
          _c(
            "v-card-actions",
            { staticClass: "p-0" },
            [
              _c("v-pagination", {
                attrs: { length: Math.ceil(_vm.data.length / 6) },
                model: {
                  value: _vm.page,
                  callback: function($$v) {
                    _vm.page = $$v
                  },
                  expression: "page"
                }
              }),
              _vm._v(" "),
              _c("v-spacer")
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-dialog",
            {
              attrs: {
                transition: "dialog-top-transition",
                "max-width": "600"
              },
              model: {
                value: _vm.dialog,
                callback: function($$v) {
                  _vm.dialog = $$v
                },
                expression: "dialog"
              }
            },
            [
              _c(
                "v-card",
                [
                  _c("v-toolbar", { attrs: { color: "danger", dark: "" } }, [
                    _vm._v("Accumulation Details")
                  ]),
                  _vm._v(" "),
                  _c("br"),
                  _vm._v(" "),
                  _c(
                    "v-card-text",
                    [
                      _c("div", { staticClass: "text-h5" }, [
                        _vm._v("Company name")
                      ]),
                      _c("br"),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        [
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        [
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        [
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "p-0 pl-2 border-bottom",
                              attrs: { xl: "4" }
                            },
                            [_vm._v("test")]
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
                    { staticClass: "justify-end" },
                    [
                      _c(
                        "v-btn",
                        {
                          attrs: { text: "" },
                          on: {
                            click: function($event) {
                              _vm.dialog = false
                            }
                          }
                        },
                        [_vm._v("Close")]
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
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/dashboard/quicksearch.vue":
/*!******************************************************!*\
  !*** ./resources/js/pages/dashboard/quicksearch.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _quicksearch_vue_vue_type_template_id_109bdc41___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./quicksearch.vue?vue&type=template&id=109bdc41& */ "./resources/js/pages/dashboard/quicksearch.vue?vue&type=template&id=109bdc41&");
/* harmony import */ var _quicksearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./quicksearch.vue?vue&type=script&lang=js& */ "./resources/js/pages/dashboard/quicksearch.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _quicksearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _quicksearch_vue_vue_type_template_id_109bdc41___WEBPACK_IMPORTED_MODULE_0__["render"],
  _quicksearch_vue_vue_type_template_id_109bdc41___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/dashboard/quicksearch.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/dashboard/quicksearch.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/pages/dashboard/quicksearch.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_quicksearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./quicksearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/quicksearch.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_quicksearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/dashboard/quicksearch.vue?vue&type=template&id=109bdc41&":
/*!*************************************************************************************!*\
  !*** ./resources/js/pages/dashboard/quicksearch.vue?vue&type=template&id=109bdc41& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_quicksearch_vue_vue_type_template_id_109bdc41___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./quicksearch.vue?vue&type=template&id=109bdc41& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/quicksearch.vue?vue&type=template&id=109bdc41&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_quicksearch_vue_vue_type_template_id_109bdc41___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_quicksearch_vue_vue_type_template_id_109bdc41___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);