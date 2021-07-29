(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/survey/infosheet.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _survey_infosheet_survey_list_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../survey/infosheet_survey_list.vue */ "./resources/js/pages/survey/infosheet_survey_list.vue");
/* harmony import */ var _survey_infosheet_ires_list_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../survey/infosheet_ires_list.vue */ "./resources/js/pages/survey/infosheet_ires_list.vue");
/* harmony import */ var _survey_infosheet_natcat_list_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../survey/infosheet_natcat_list.vue */ "./resources/js/pages/survey/infosheet_natcat_list.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      panel: [2],
      overlay: true,
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false,
      menu2: false,
      lookup_dialog: false,
      btn_list: '',
      risk_dialog: false,
      AValue: {
        account: 'Company1',
        accountid: '123',
        address: '123 Street, Bacolod'
      },
      MKValue: {
        lor: 'Bacolod 1',
        ptfrom: '2021-06-16',
        ptto: '2021-06-16',
        coverage: 'Industrial All Risk',
        tsi: 'PHP 500,000,000.00',
        premium: '0.25%',
        broker: 'Test Broker',
        commrate: '15%',
        subjectivities: 'UW renewal',
        remarks: 'Test remarks'
      },
      UWValue: {
        retention: 'PHP 10,000.00',
        share: 'PHP 1,000,000.00',
        rifacul: 'PHP 2,000,00.00',
        subjectivities: 'test subject',
        remarks: 'test remarks for UW'
      },
      RMValue: {
        lat: 123,
        lng: 456,
        survey: "2021-01-21",
        nextyear: '2022',
        ires: 'Average',
        eq: 'Moderate',
        tp: 'Moderate',
        fl: 'Low',
        remarks: 'Test data only'
      },
      levellist: [{
        name: 'High',
        value: 'High'
      }, {
        name: 'Moderate',
        value: 'Moderate'
      }, {
        name: 'Low',
        value: 'Low'
      }],
      CValue: {
        lossratio: '5%',
        Fireloss: 'Nil',
        EQloss: 'Nil',
        TPloss: '2015 - Typhoon A, Claimed paid = 100k',
        FLloss: 'Nil',
        Otherlosses: 'Nil'
      }
    };
  },
  components: {
    surveylist: _survey_infosheet_survey_list_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    ireslist: _survey_infosheet_ires_list_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    natcatlist: _survey_infosheet_natcat_list_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  created: function created() {
    var _this = this;

    setTimeout(function () {
      _this.overlay = false;
    }, 500);
  },
  methods: {
    btnOnClick: function btnOnClick(type) {
      this.risk_dialog = true;
      this.btn_list = type;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet.vue?vue&type=template&id=35829f36&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/survey/infosheet.vue?vue&type=template&id=35829f36& ***!
  \**************************************************************************************************************************************************************************************************************/
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
      _c(
        "v-overlay",
        { attrs: { value: _vm.overlay } },
        [
          _c("v-progress-circular", {
            attrs: { indeterminate: "", size: "64" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-card-text",
        [
          _c(
            "p",
            { staticClass: "text-h6 text--primary" },
            [
              _c("v-icon", [_vm._v("mdi-pencil-box-outline")]),
              _vm._v(" - Risk Information Sheet\r\n        ")
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-card-actions",
            [
              _c(
                "v-btn",
                { staticClass: "success text-p", attrs: { small: "" } },
                [_vm._v("Company Loop-up")]
              ),
              _vm._v(" "),
              _c(
                "v-btn",
                { staticClass: "blue text-p", attrs: { dark: "", small: "" } },
                [_vm._v("Print")]
              ),
              _vm._v(" "),
              _c("v-spacer")
            ],
            1
          ),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "h4" },
            [
              _c("v-text-field", {
                attrs: { label: "Account Name", "hide-details": "auto" },
                model: {
                  value: _vm.AValue.account,
                  callback: function($$v) {
                    _vm.$set(_vm.AValue, "account", $$v)
                  },
                  expression: "AValue.account"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "caption" },
            [
              _c("v-text-field", {
                attrs: { label: "Account ID #", "hide-details": "auto" },
                model: {
                  value: _vm.AValue.accountid,
                  callback: function($$v) {
                    _vm.$set(_vm.AValue, "accountid", $$v)
                  },
                  expression: "AValue.accountid"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "caption" },
            [
              _c("v-text-field", {
                attrs: { label: "Address", "hide-details": "auto" },
                model: {
                  value: _vm.AValue.address,
                  callback: function($$v) {
                    _vm.$set(_vm.AValue, "address", $$v)
                  },
                  expression: "AValue.address"
                }
              })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-expansion-panels",
        {
          attrs: { multiple: "" },
          model: {
            value: _vm.panel,
            callback: function($$v) {
              _vm.panel = $$v
            },
            expression: "panel"
          }
        },
        [
          _c(
            "v-expansion-panel",
            { attrs: { dense: "" } },
            [
              _c(
                "v-expansion-panel-header",
                { attrs: { color: "danger text-white" } },
                [_c("b", [_vm._v("Marketing Section")])]
              ),
              _vm._v(" "),
              _c(
                "v-expansion-panel-content",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { lg: "6" } },
                        [
                          _c(
                            "v-card",
                            { staticClass: "p-4 mt-2" },
                            [
                              _c(
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Location of Risk",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.lor,
                                          callback: function($$v) {
                                            _vm.$set(_vm.MKValue, "lor", $$v)
                                          },
                                          expression: "MKValue.lor"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-row",
                                [
                                  _c("v-col", { attrs: { lg: "2" } }, [
                                    _vm._v(
                                      "\r\n                          Policy Term:\r\n                        "
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "5" } },
                                    [
                                      _c(
                                        "v-menu",
                                        {
                                          ref: "menu",
                                          attrs: {
                                            "close-on-content-click": false,
                                            "return-value": _vm.date,
                                            transition: "scale-transition",
                                            "offset-y": "",
                                            "min-width": "auto"
                                          },
                                          on: {
                                            "update:returnValue": function(
                                              $event
                                            ) {
                                              _vm.date = $event
                                            },
                                            "update:return-value": function(
                                              $event
                                            ) {
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
                                                            label: "From",
                                                            "prepend-icon":
                                                              "mdi-calendar",
                                                            readonly: ""
                                                          },
                                                          model: {
                                                            value: _vm.date,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.date = $$v
                                                            },
                                                            expression: "date"
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
                                              attrs: {
                                                "no-title": "",
                                                scrollable: ""
                                              },
                                              model: {
                                                value: _vm.date,
                                                callback: function($$v) {
                                                  _vm.date = $$v
                                                },
                                                expression: "date"
                                              }
                                            },
                                            [
                                              _c("v-spacer"),
                                              _vm._v(" "),
                                              _c(
                                                "v-btn",
                                                {
                                                  attrs: {
                                                    text: "",
                                                    color: "primary"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      _vm.menu = false
                                                    }
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    "\r\n                                Cancel\r\n                              "
                                                  )
                                                ]
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "v-btn",
                                                {
                                                  attrs: {
                                                    text: "",
                                                    color: "primary"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.$refs.menu.save(
                                                        _vm.date
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    "\r\n                                OK\r\n                              "
                                                  )
                                                ]
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
                                    "v-col",
                                    { attrs: { lg: "5" } },
                                    [
                                      _c(
                                        "v-menu",
                                        {
                                          ref: "menu",
                                          attrs: {
                                            "close-on-content-click": false,
                                            "return-value": _vm.date,
                                            transition: "scale-transition",
                                            "offset-y": "",
                                            "min-width": "auto"
                                          },
                                          on: {
                                            "update:returnValue": function(
                                              $event
                                            ) {
                                              _vm.date = $event
                                            },
                                            "update:return-value": function(
                                              $event
                                            ) {
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
                                                            label: "To",
                                                            "prepend-icon":
                                                              "mdi-calendar",
                                                            readonly: ""
                                                          },
                                                          model: {
                                                            value: _vm.date,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.date = $$v
                                                            },
                                                            expression: "date"
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
                                              attrs: {
                                                "no-title": "",
                                                scrollable: ""
                                              },
                                              model: {
                                                value: _vm.date,
                                                callback: function($$v) {
                                                  _vm.date = $$v
                                                },
                                                expression: "date"
                                              }
                                            },
                                            [
                                              _c("v-spacer"),
                                              _vm._v(" "),
                                              _c(
                                                "v-btn",
                                                {
                                                  attrs: {
                                                    text: "",
                                                    color: "primary"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      _vm.menu = false
                                                    }
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    "\r\n                                Cancel\r\n                              "
                                                  )
                                                ]
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "v-btn",
                                                {
                                                  attrs: {
                                                    text: "",
                                                    color: "primary"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.$refs.menu.save(
                                                        _vm.date
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    "\r\n                                OK\r\n                              "
                                                  )
                                                ]
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
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Existing Coverage",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.coverage,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.MKValue,
                                              "coverage",
                                              $$v
                                            )
                                          },
                                          expression: "MKValue.coverage"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Total Sum Insured",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.tsi,
                                          callback: function($$v) {
                                            _vm.$set(_vm.MKValue, "tsi", $$v)
                                          },
                                          expression: "MKValue.tsi"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Existing Premium",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.premium,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.MKValue,
                                              "premium",
                                              $$v
                                            )
                                          },
                                          expression: "MKValue.premium"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Broker/Agent",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.broker,
                                          callback: function($$v) {
                                            _vm.$set(_vm.MKValue, "broker", $$v)
                                          },
                                          expression: "MKValue.broker"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Commission Rate",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.commrate,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.MKValue,
                                              "commrate",
                                              $$v
                                            )
                                          },
                                          expression: "MKValue.commrate"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Renewal Subjectivities",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.MKValue.subjectivities,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.MKValue,
                                              "subjectivities",
                                              $$v
                                            )
                                          },
                                          expression: "MKValue.subjectivities"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-textarea", {
                                        attrs: {
                                          outlined: "",
                                          rows: "2",
                                          name: "input-7-2",
                                          label: "Remarks"
                                        },
                                        model: {
                                          value: _vm.MKValue.remarks,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.MKValue,
                                              "remarks",
                                              $$v
                                            )
                                          },
                                          expression: "MKValue.remarks"
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
                      ),
                      _vm._v(" "),
                      _c("v-col", { attrs: { lg: "6" } })
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
            "v-expansion-panel",
            [
              _c(
                "v-expansion-panel-header",
                { attrs: { color: "danger text-white" } },
                [_c("b", [_vm._v("Underwriting Section")])]
              ),
              _vm._v(" "),
              _c(
                "v-expansion-panel-content",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { lg: "6" } },
                        [
                          _c(
                            "v-card",
                            { staticClass: "p-4 mt-2" },
                            [
                              _c(
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Retention",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.UWValue.retention,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.UWValue,
                                              "retention",
                                              $$v
                                            )
                                          },
                                          expression: "UWValue.retention"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Quata Share",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.UWValue.share,
                                          callback: function($$v) {
                                            _vm.$set(_vm.UWValue, "share", $$v)
                                          },
                                          expression: "UWValue.share"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "RI Facul",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.UWValue.rifacul,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.UWValue,
                                              "rifacul",
                                              $$v
                                            )
                                          },
                                          expression: "UWValue.rifacul"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "4" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            color: "blue",
                                            block: "",
                                            small: "",
                                            dark: ""
                                          }
                                        },
                                        [_vm._v("Download RI List")]
                                      )
                                    ],
                                    1
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
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Renewal Subjectivities",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.UWValue.subjectivities,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.UWValue,
                                              "subjectivities",
                                              $$v
                                            )
                                          },
                                          expression: "UWValue.subjectivities"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-textarea", {
                                        attrs: {
                                          outlined: "",
                                          rows: "2",
                                          name: "input-7-2",
                                          label: "Remarks"
                                        },
                                        model: {
                                          value: _vm.UWValue.remarks,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.UWValue,
                                              "remarks",
                                              $$v
                                            )
                                          },
                                          expression: "UWValue.remarks"
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
            "v-expansion-panel",
            [
              _c(
                "v-expansion-panel-header",
                { attrs: { color: "danger text-white" } },
                [_c("b", [_vm._v("Risk engineering Section")])]
              ),
              _vm._v(" "),
              _c(
                "v-expansion-panel-content",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { lg: "6" } },
                        [
                          _c(
                            "v-card",
                            { staticClass: "p-4 mt-2" },
                            [
                              _c(
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Longitude",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.RMValue.lng,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "lng", $$v)
                                          },
                                          expression: "RMValue.lng"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "6" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Latitude",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.RMValue.lat,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "lat", $$v)
                                          },
                                          expression: "RMValue.lat"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Latest Survey",
                                          readonly: "",
                                          disabled: ""
                                        },
                                        model: {
                                          value: _vm.RMValue.survey,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "survey", $$v)
                                          },
                                          expression: "RMValue.survey"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "4" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            color: "blue",
                                            block: "",
                                            small: "",
                                            dark: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.btnOnClick(0)
                                            }
                                          }
                                        },
                                        [_vm._v("Survey List")]
                                      )
                                    ],
                                    1
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
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Proposed Next Survey Year",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.RMValue.nextyear,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.RMValue,
                                              "nextyear",
                                              $$v
                                            )
                                          },
                                          expression: "RMValue.nextyear"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("v-col", { attrs: { lg: "4" } })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "IRES Rating",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.RMValue.ires,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "ires", $$v)
                                          },
                                          expression: "RMValue.ires"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "4" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            color: "blue",
                                            block: "",
                                            small: "",
                                            dark: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.btnOnClick(1)
                                            }
                                          }
                                        },
                                        [_vm._v("Download IRES")]
                                      )
                                    ],
                                    1
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
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-select", {
                                        attrs: {
                                          items: _vm.levellist,
                                          "item-value": "value",
                                          "item-text": "name",
                                          label: "Earthquake Exposure",
                                          dense: ""
                                        },
                                        model: {
                                          value: _vm.RMValue.eq,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "eq", $$v)
                                          },
                                          expression: "RMValue.eq"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-select", {
                                        attrs: {
                                          items: _vm.levellist,
                                          "item-value": "value",
                                          "item-text": "name",
                                          label: "Typhoon Exposure",
                                          dense: ""
                                        },
                                        model: {
                                          value: _vm.RMValue.tp,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "tp", $$v)
                                          },
                                          expression: "RMValue.tp"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "8" } },
                                    [
                                      _c("v-select", {
                                        attrs: {
                                          items: _vm.levellist,
                                          "item-value": "value",
                                          "item-text": "name",
                                          label: "Flood Exposure",
                                          dense: ""
                                        },
                                        model: {
                                          value: _vm.RMValue.fl,
                                          callback: function($$v) {
                                            _vm.$set(_vm.RMValue, "fl", $$v)
                                          },
                                          expression: "RMValue.fl"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "4" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            color: "blue",
                                            block: "",
                                            small: "",
                                            dark: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.btnOnClick(2)
                                            }
                                          }
                                        },
                                        [_vm._v("Download NatCat")]
                                      )
                                    ],
                                    1
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
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-textarea", {
                                        attrs: {
                                          outlined: "",
                                          rows: "2",
                                          name: "input-7-2",
                                          label: "Remarks"
                                        },
                                        model: {
                                          value: _vm.RMValue.remarks,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.RMValue,
                                              "remarks",
                                              $$v
                                            )
                                          },
                                          expression: "RMValue.remarks"
                                        }
                                      })
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
                                  _c("v-btn", { attrs: { color: "primary" } }, [
                                    _vm._v("Post")
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
          ),
          _vm._v(" "),
          _c(
            "v-expansion-panel",
            [
              _c(
                "v-expansion-panel-header",
                { attrs: { color: "danger text-white" } },
                [_c("b", [_vm._v("Claims Section")])]
              ),
              _vm._v(" "),
              _c(
                "v-expansion-panel-content",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { lg: "6" } },
                        [
                          _c(
                            "v-card",
                            { staticClass: "p-4 mt-2" },
                            [
                              _c(
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "5 - Year Loss Ratio",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.CValue.lossratio,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.CValue,
                                              "lossratio",
                                              $$v
                                            )
                                          },
                                          expression: "CValue.lossratio"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Fire Loss",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.CValue.Fireloss,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.CValue,
                                              "Fireloss",
                                              $$v
                                            )
                                          },
                                          expression: "CValue.Fireloss"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Earthquake Loss",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.CValue.EQloss,
                                          callback: function($$v) {
                                            _vm.$set(_vm.CValue, "EQloss", $$v)
                                          },
                                          expression: "CValue.EQloss"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Typhoon Loss",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.CValue.TPloss,
                                          callback: function($$v) {
                                            _vm.$set(_vm.CValue, "TPloss", $$v)
                                          },
                                          expression: "CValue.TPloss"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Flood Loss",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.CValue.FLloss,
                                          callback: function($$v) {
                                            _vm.$set(_vm.CValue, "FLloss", $$v)
                                          },
                                          expression: "CValue.FLloss"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-col",
                                    { attrs: { lg: "12" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          label: "Other Losses",
                                          "hide-details": "auto"
                                        },
                                        model: {
                                          value: _vm.CValue.Otherlosses,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.CValue,
                                              "Otherlosses",
                                              $$v
                                            )
                                          },
                                          expression: "CValue.Otherlosses"
                                        }
                                      })
                                    ],
                                    1
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
                                    { attrs: { lg: "3" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            color: "blue",
                                            block: "",
                                            small: "",
                                            dark: ""
                                          }
                                        },
                                        [_vm._v("Claims Details")]
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
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { width: "900" },
          model: {
            value: _vm.lookup_dialog,
            callback: function($$v) {
              _vm.lookup_dialog = $$v
            },
            expression: "lookup_dialog"
          }
        },
        [
          _c(
            "v-card",
            [
              _c("v-card-title", { staticClass: "text-h5 grey lighten-2" }, [
                _vm._v("\r\n            Search Information Sheet\r\n          ")
              ]),
              _vm._v(" "),
              _c("v-card-text", [_c("br")]),
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
                          _vm.lookup_dialog = false
                        }
                      }
                    },
                    [_vm._v("\r\n              Close\r\n            ")]
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
        "v-dialog",
        {
          attrs: { width: "900" },
          model: {
            value: _vm.risk_dialog,
            callback: function($$v) {
              _vm.risk_dialog = $$v
            },
            expression: "risk_dialog"
          }
        },
        [
          _c(
            "v-card",
            [
              _vm.btn_list == 0 ? [_c("surveylist")] : _vm._e(),
              _vm._v(" "),
              _vm.btn_list == 1 ? [_c("ireslist")] : _vm._e(),
              _vm._v(" "),
              _vm.btn_list == 2 ? [_c("natcatlist")] : _vm._e(),
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
                          _vm.risk_dialog = false
                        }
                      }
                    },
                    [_vm._v("\r\n              Close\r\n            ")]
                  )
                ],
                1
              )
            ],
            2
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

/***/ "./resources/js/pages/survey/infosheet.vue":
/*!*************************************************!*\
  !*** ./resources/js/pages/survey/infosheet.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _infosheet_vue_vue_type_template_id_35829f36___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./infosheet.vue?vue&type=template&id=35829f36& */ "./resources/js/pages/survey/infosheet.vue?vue&type=template&id=35829f36&");
/* harmony import */ var _infosheet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./infosheet.vue?vue&type=script&lang=js& */ "./resources/js/pages/survey/infosheet.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _infosheet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _infosheet_vue_vue_type_template_id_35829f36___WEBPACK_IMPORTED_MODULE_0__["render"],
  _infosheet_vue_vue_type_template_id_35829f36___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/survey/infosheet.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/survey/infosheet.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/pages/survey/infosheet.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./infosheet.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/survey/infosheet.vue?vue&type=template&id=35829f36&":
/*!********************************************************************************!*\
  !*** ./resources/js/pages/survey/infosheet.vue?vue&type=template&id=35829f36& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_vue_vue_type_template_id_35829f36___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./infosheet.vue?vue&type=template&id=35829f36& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/survey/infosheet.vue?vue&type=template&id=35829f36&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_vue_vue_type_template_id_35829f36___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_infosheet_vue_vue_type_template_id_35829f36___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);