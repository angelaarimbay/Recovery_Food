(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-eq.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/dashboard/diagram-eq.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _charts_BarChart__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../charts/BarChart */ "./resources/js/pages/charts/BarChart.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
    BarChart: _charts_BarChart__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {
      zone: [],
      amount: [],
      options: {
        animation: false,
        responsiveAnimationDuration: 0,
        tooltips: {
          enabled: true,
          mode: 'single',
          callbacks: {
            label: function label(tooltipItems, data) {
              return '₱' + tooltipItems.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              callback: function callback(value, index, values) {
                if (parseInt(value) >= 1000) {
                  console.log(index);
                  return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                  return '₱' + value;
                }
              }
            }
          }]
        }
      },
      chartHeight: 175,
      datacollection: {}
    };
  },
  mounted: function mounted() {
    this.chartvalue();
  },
  methods: {
    fillData: function fillData() {
      this.datacollection = {
        labels: this.zone,
        datasets: [{
          label: 'Our Share',
          backgroundColor: '#cc0022',
          data: this.amount
        }]
      };
    },
    getRandomInt: function getRandomInt() {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 0;
    },
    chartvalue: function chartvalue() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.progressBar = true;
                _context.next = 3;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/api/get/accumulation/chart1").then(function (result) {
                  console.log(result.data);
                  _this.zone = result.data.zone;
                  _this.amount = result.data.amount;

                  _this.fillData();

                  _this.progressBar = false;
                })["catch"](function (res) {
                  _this.progressBar = false;
                });

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-eq.vue?vue&type=template&id=245deeaa&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/dashboard/diagram-eq.vue?vue&type=template&id=245deeaa& ***!
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
      _c("v-card-title", [_vm._v("Full TSI / Our TSI")]),
      _vm._v(" "),
      _c(
        "v-card-text",
        [
          _c("bar-chart", {
            attrs: {
              options: _vm.options,
              height: _vm.chartHeight,
              "chart-data": _vm.datacollection
            }
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
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_chartjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-chartjs */ "./node_modules/vue-chartjs/es/index.js");

var reactiveProp = vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["mixins"].reactiveProp;
/* harmony default export */ __webpack_exports__["default"] = ({
  "extends": vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["Bar"],
  mixins: [reactiveProp],
  props: ['options'],
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          callback: function callback(value, index, values) {
            if (parseInt(value) >= 1000) {
              return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
              return '$' + value;
            }
          }
        }
      }]
    }
  },
  mounted: function mounted() {
    // this.chartData is created in the mixin.
    // If you want to pass options please create a local options object 
    this.renderChart(this.chartData, this.options);
  }
});

/***/ }),

/***/ "./resources/js/pages/dashboard/diagram-eq.vue":
/*!*****************************************************!*\
  !*** ./resources/js/pages/dashboard/diagram-eq.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _diagram_eq_vue_vue_type_template_id_245deeaa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./diagram-eq.vue?vue&type=template&id=245deeaa& */ "./resources/js/pages/dashboard/diagram-eq.vue?vue&type=template&id=245deeaa&");
/* harmony import */ var _diagram_eq_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./diagram-eq.vue?vue&type=script&lang=js& */ "./resources/js/pages/dashboard/diagram-eq.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _diagram_eq_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _diagram_eq_vue_vue_type_template_id_245deeaa___WEBPACK_IMPORTED_MODULE_0__["render"],
  _diagram_eq_vue_vue_type_template_id_245deeaa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/dashboard/diagram-eq.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/dashboard/diagram-eq.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/pages/dashboard/diagram-eq.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_eq_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./diagram-eq.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-eq.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_eq_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/dashboard/diagram-eq.vue?vue&type=template&id=245deeaa&":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/dashboard/diagram-eq.vue?vue&type=template&id=245deeaa& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_eq_vue_vue_type_template_id_245deeaa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./diagram-eq.vue?vue&type=template&id=245deeaa& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/dashboard/diagram-eq.vue?vue&type=template&id=245deeaa&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_eq_vue_vue_type_template_id_245deeaa___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_diagram_eq_vue_vue_type_template_id_245deeaa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);