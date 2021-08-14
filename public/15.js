(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[15],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/accounts.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/auth/accounts.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      overlay: true,
      headers: [{
        text: 'id',
        value: 'id'
      }, {
        text: 'Survey Pdf',
        value: 'calories'
      }, {
        text: 'Action',
        value: 'fat'
      }],
      desserts: [{
        name: 'Frozen Yogurt',
        calories: 159,
        fat: 6.0
      }, {
        name: 'Ice cream sandwich',
        calories: 237,
        fat: 9.0
      }, {
        name: 'Eclair',
        calories: 262,
        fat: 16.0
      }, {
        name: 'Cupcake',
        calories: 305,
        fat: 3.7
      }, {
        name: 'Gingerbread',
        calories: 356,
        fat: 16.0
      }, {
        name: 'Jelly bean',
        calories: 375,
        fat: 0.0
      }, {
        name: 'Lollipop',
        calories: 392,
        fat: 0.2
      }, {
        name: 'Honeycomb',
        calories: 408,
        fat: 3.2
      }, {
        name: 'Donut',
        calories: 452,
        fat: 25.0
      }, {
        name: 'KitKat',
        calories: 518,
        fat: 26.0
      }]
    };
  },
  created: function created() {
    var _this = this;

    setTimeout(function () {
      _this.overlay = false;
    }, 500);
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/accounts.vue?vue&type=template&id=f28ef158&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/auth/accounts.vue?vue&type=template&id=f28ef158& ***!
  \***********************************************************************************************************************************************************************************************************/
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
    "v-card-text",
    [
      _c(
        "p",
        { staticClass: "text-h6 text--primary" },
        [
          _c("v-icon", [_vm._v("mdi-account-multiple")]),
          _vm._v(" - Manage Accounts\n       ")
        ],
        1
      ),
      _vm._v(" "),
      _c("p", [_vm._v("adjective")]),
      _vm._v(" "),
      _c("v-data-table", {
        staticClass: "elevation-1",
        attrs: {
          headers: _vm.headers,
          items: _vm.desserts,
          "items-per-page": 5
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/auth/accounts.vue":
/*!**********************************************!*\
  !*** ./resources/js/pages/auth/accounts.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _accounts_vue_vue_type_template_id_f28ef158___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./accounts.vue?vue&type=template&id=f28ef158& */ "./resources/js/pages/auth/accounts.vue?vue&type=template&id=f28ef158&");
/* harmony import */ var _accounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./accounts.vue?vue&type=script&lang=js& */ "./resources/js/pages/auth/accounts.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _accounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _accounts_vue_vue_type_template_id_f28ef158___WEBPACK_IMPORTED_MODULE_0__["render"],
  _accounts_vue_vue_type_template_id_f28ef158___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/auth/accounts.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/auth/accounts.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/pages/auth/accounts.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_accounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./accounts.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/accounts.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_accounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/auth/accounts.vue?vue&type=template&id=f28ef158&":
/*!*****************************************************************************!*\
  !*** ./resources/js/pages/auth/accounts.vue?vue&type=template&id=f28ef158& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_accounts_vue_vue_type_template_id_f28ef158___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./accounts.vue?vue&type=template&id=f28ef158& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/accounts.vue?vue&type=template&id=f28ef158&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_accounts_vue_vue_type_template_id_f28ef158___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_accounts_vue_vue_type_template_id_f28ef158___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);