(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[25],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-ty.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/dashboard/diagram-ty.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _charts_BarChart__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../charts/BarChart */ "./resources/js/pages/charts/BarChart.js");
//
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
  components: {
    LineChart: _charts_BarChart__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      datacollection: null
    };
  },
  mounted: function mounted() {
    this.fillData();
  },
  methods: {
    fillData: function fillData() {
      this.datacollection = {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
        datasets: [{
          label: 'Our Share ',
          backgroundColor: 'green',
          data: [this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt()]
        }]
      };
    },
    getRandomInt: function getRandomInt() {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 0;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-ty.vue?vue&type=template&id=3e675c03&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/dashboard/diagram-ty.vue?vue&type=template&id=3e675c03& ***!
  \******************************************************************************************************************************************************************************************************************/
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
    [
      _c("v-card-title", [_vm._v("Typhoon")]),
      _vm._v(" "),
      _c(
        "v-card-text",
        [
          _c("line-chart", {
            attrs: { height: "175", "chart-data": _vm.datacollection }
          }),
          _vm._v(" "),
          _c(
            "v-card-actions",
            [_c("v-spacer"), _vm._v(" Cresta zone"), _c("v-spacer")],
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

/***/ "./resources/js/pages/charts/BarChart.js":
/*!***********************************************!*\
  !*** ./resources/js/pages/charts/BarChart.js ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\resources\\js\\pages\\charts\\BarChart.js: Unexpected token, expected \",\" (50:1)\n\n\u001b[0m \u001b[90m 48 |\u001b[39m     \u001b[36mthis\u001b[39m\u001b[33m.\u001b[39mrenderChart(\u001b[36mthis\u001b[39m\u001b[33m.\u001b[39mchartData\u001b[33m,\u001b[39m \u001b[36mthis\u001b[39m\u001b[33m.\u001b[39moptions)\u001b[0m\n\u001b[0m \u001b[90m 49 |\u001b[39m   }\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 50 |\u001b[39m }\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m  \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n    at Parser._raise (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:810:17)\n    at Parser.raiseWithData (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:803:17)\n    at Parser.raise (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:764:17)\n    at Parser.unexpected (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:9980:16)\n    at Parser.expect (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:9954:28)\n    at Parser.parseObjectLike (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:11770:14)\n    at Parser.parseExprAtom (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:11298:23)\n    at Parser.parseExprSubscripts (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10954:23)\n    at Parser.parseUpdate (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10934:21)\n    at Parser.parseMaybeUnary (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10912:23)\n    at Parser.parseExprOps (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10769:23)\n    at Parser.parseMaybeConditional (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10743:23)\n    at Parser.parseMaybeAssign (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10706:21)\n    at C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10673:39\n    at Parser.allowInAnd (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:12390:16)\n    at Parser.parseMaybeAssignAllowIn (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:10673:17)\n    at Parser.parseExportDefaultExpression (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:13808:24)\n    at Parser.parseExport (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:13718:31)\n    at Parser.parseStatementContent (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:12702:27)\n    at Parser.parseStatement (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:12596:17)\n    at Parser.parseBlockOrModuleBlockBody (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:13185:25)\n    at Parser.parseBlockBody (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:13176:10)\n    at Parser.parseProgram (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:12519:10)\n    at Parser.parseTopLevel (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:12510:25)\n    at Parser.parse (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:14241:10)\n    at parse (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\parser\\lib\\index.js:14293:38)\n    at parser (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\core\\lib\\parser\\index.js:52:34)\n    at parser.next (<anonymous>)\n    at normalizeFile (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\core\\lib\\transformation\\normalize-file.js:82:38)\n    at normalizeFile.next (<anonymous>)\n    at run (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\core\\lib\\transformation\\index.js:29:50)\n    at run.next (<anonymous>)\n    at Function.transform (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\@babel\\core\\lib\\transform.js:25:41)\n    at transform.next (<anonymous>)\n    at step (C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\gensync\\index.js:261:32)\n    at C:\\Users\\PGAS\\OneDrive\\Documents\\project01\\node_modules\\gensync\\index.js:273:13");

/***/ }),

/***/ "./resources/js/pages/dashboard/diagram-ty.vue":
/*!*****************************************************!*\
  !*** ./resources/js/pages/dashboard/diagram-ty.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _diagram_ty_vue_vue_type_template_id_3e675c03___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./diagram-ty.vue?vue&type=template&id=3e675c03& */ "./resources/js/pages/dashboard/diagram-ty.vue?vue&type=template&id=3e675c03&");
/* harmony import */ var _diagram_ty_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./diagram-ty.vue?vue&type=script&lang=js& */ "./resources/js/pages/dashboard/diagram-ty.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _diagram_ty_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _diagram_ty_vue_vue_type_template_id_3e675c03___WEBPACK_IMPORTED_MODULE_0__["render"],
  _diagram_ty_vue_vue_type_template_id_3e675c03___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/dashboard/diagram-ty.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/dashboard/diagram-ty.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/pages/dashboard/diagram-ty.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_ty_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./diagram-ty.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-ty.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_ty_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/dashboard/diagram-ty.vue?vue&type=template&id=3e675c03&":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/dashboard/diagram-ty.vue?vue&type=template&id=3e675c03& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_ty_vue_vue_type_template_id_3e675c03___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./diagram-ty.vue?vue&type=template&id=3e675c03& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-ty.vue?vue&type=template&id=3e675c03&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_ty_vue_vue_type_template_id_3e675c03___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_ty_vue_vue_type_template_id_3e675c03___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);