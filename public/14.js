(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[14],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/maps/accumulation.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/maps/accumulation.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var scriptjs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! scriptjs */ "./node_modules/scriptjs/dist/script.js");
/* harmony import */ var scriptjs__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(scriptjs__WEBPACK_IMPORTED_MODULE_2__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr && (typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]); if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


var map, mapin, mapout;
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Map",
  map: '',
  data: function data() {
    return {
      map: null,
      page: 1,
      overlay: true,
      cresta_selected: {
        our_si: ''
      },
      dialog_list: false,
      dialog_sub: false,
      map_dialog: false,
      cresta_search: '',
      cresta_headers: [{
        "class": 'border',
        text: 'Cresta ID',
        value: 'cresta_id'
      }, {
        "class": 'border',
        text: 'Our Sum Insured',
        value: 'our_si'
      }, {
        "class": 'border',
        text: 'Action',
        value: 'data'
      }],
      cresta_data: [],
      cresta_gps: '',
      cresta_date: '',
      company_search: '',
      company_headers: [{
        "class": 'border',
        text: 'Company name',
        value: 'insured'
      }, {
        "class": 'border',
        text: 'Our SI Retention',
        value: 'our_si_or'
      }, {
        "class": 'border',
        text: 'Our SI Treaty',
        value: 'our_si_tty'
      }, {
        "class": 'border',
        text: 'Our SI Facul',
        value: 'our_si_fac'
      }, {
        "class": 'border',
        text: 'Information Sheet',
        value: 'data'
      }],
      company_data: []
    };
  },
  created: function created() {
    this.getList();
  },
  methods: {
    callmap: function callmap() {
      this.map_dialog = true;
      this.initMap(13, 1);
    },
    initMap: function initMap(zooms, type) {
      var _this = this;

      scriptjs__WEBPACK_IMPORTED_MODULE_2___default()("https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsOP0trKOpMqg5zDI_3WitmyNRA3JDBs&libraries=places", function () {
        var myLatLng = _this.cresta_gps[0][0];

        if (type === 1) {
          mapin = new google.maps.Map(document.getElementById("mapin"), {
            center: myLatLng,
            zoom: zooms,
            mapTypeId: 'roadmap'
          });
        } else {
          mapout = new google.maps.Map(document.getElementById("mapout"), {
            center: myLatLng,
            zoom: zooms,
            mapTypeId: 'roadmap'
          });
        }

        if (type === 1) {
          map = mapin;
        } else {
          map = mapout;
        }

        var infoWindow = new google.maps.InfoWindow();

        _this.cresta_gps.forEach(function (_ref, i) {
          var _ref2 = _slicedToArray(_ref, 2),
              position = _ref2[0],
              title = _ref2[1];

          var marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            // label: `${i + 1}`,
            optimized: false
          }); // Add a click listener for each marker, and set up the info window.

          marker.addListener("click", function () {
            infoWindow.close();
            infoWindow.setContent(marker.getTitle());
            infoWindow.open(marker.getMap(), marker);
          });
        });
      });
    },
    getList: function getList() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var self;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                self = _this2;
                _context.next = 3;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/api/get/accumulation/list").then(function (result) {
                  self.cresta_date = result.data.date;
                  self.cresta_data = result.data.data;
                  self.cresta_gps = result.data.gps;
                  self.overlay = false;
                })["catch"](function (res) {
                  self.overlay = false;
                });

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getCompanyList: function getCompanyList(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var self;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.overlay = true;
                self = _this3;
                _context2.next = 4;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/api/get/accumulation/company/list", {
                  params: {
                    cresta: value.cresta_id
                  }
                }).then(function (result) {
                  _this3.dialog_list = true;
                  _this3.cresta_selected = value;
                  self.company_data = result.data.data;
                  self.cresta_gps = result.data.gps;
                  _this3.overlay = false;
                })["catch"](function (res) {
                  _this3.overlay = false;
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getFormatDate: function getFormatDate(e, format) {
      var date = moment(e);
      return date.format(format);
    }
  }
});

/***/ }),

/***/ "./node_modules/scriptjs/dist/script.js":
/*!**********************************************!*\
  !*** ./node_modules/scriptjs/dist/script.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  * $script.js JS loader & dependency manager
  * https://github.com/ded/script.js
  * (c) Dustin Diaz 2014 | License MIT
  */

(function (name, definition) {
  if ( true && module.exports) module.exports = definition()
  else if (true) !(__WEBPACK_AMD_DEFINE_FACTORY__ = (definition),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__))
  else {}
})('$script', function () {
  var doc = document
    , head = doc.getElementsByTagName('head')[0]
    , s = 'string'
    , f = false
    , push = 'push'
    , readyState = 'readyState'
    , onreadystatechange = 'onreadystatechange'
    , list = {}
    , ids = {}
    , delay = {}
    , scripts = {}
    , scriptpath
    , urlArgs

  function every(ar, fn) {
    for (var i = 0, j = ar.length; i < j; ++i) if (!fn(ar[i])) return f
    return 1
  }
  function each(ar, fn) {
    every(ar, function (el) {
      fn(el)
      return 1
    })
  }

  function $script(paths, idOrDone, optDone) {
    paths = paths[push] ? paths : [paths]
    var idOrDoneIsDone = idOrDone && idOrDone.call
      , done = idOrDoneIsDone ? idOrDone : optDone
      , id = idOrDoneIsDone ? paths.join('') : idOrDone
      , queue = paths.length
    function loopFn(item) {
      return item.call ? item() : list[item]
    }
    function callback() {
      if (!--queue) {
        list[id] = 1
        done && done()
        for (var dset in delay) {
          every(dset.split('|'), loopFn) && !each(delay[dset], loopFn) && (delay[dset] = [])
        }
      }
    }
    setTimeout(function () {
      each(paths, function loading(path, force) {
        if (path === null) return callback()
        
        if (!force && !/^https?:\/\//.test(path) && scriptpath) {
          path = (path.indexOf('.js') === -1) ? scriptpath + path + '.js' : scriptpath + path;
        }
        
        if (scripts[path]) {
          if (id) ids[id] = 1
          return (scripts[path] == 2) ? callback() : setTimeout(function () { loading(path, true) }, 0)
        }

        scripts[path] = 1
        if (id) ids[id] = 1
        create(path, callback)
      })
    }, 0)
    return $script
  }

  function create(path, fn) {
    var el = doc.createElement('script'), loaded
    el.onload = el.onerror = el[onreadystatechange] = function () {
      if ((el[readyState] && !(/^c|loade/.test(el[readyState]))) || loaded) return;
      el.onload = el[onreadystatechange] = null
      loaded = 1
      scripts[path] = 2
      fn()
    }
    el.async = 1
    el.src = urlArgs ? path + (path.indexOf('?') === -1 ? '?' : '&') + urlArgs : path;
    head.insertBefore(el, head.lastChild)
  }

  $script.get = create

  $script.order = function (scripts, id, done) {
    (function callback(s) {
      s = scripts.shift()
      !scripts.length ? $script(s, id, done) : $script(s, callback)
    }())
  }

  $script.path = function (p) {
    scriptpath = p
  }
  $script.urlArgs = function (str) {
    urlArgs = str;
  }
  $script.ready = function (deps, ready, req) {
    deps = deps[push] ? deps : [deps]
    var missing = [];
    !each(deps, function (dep) {
      list[dep] || missing[push](dep);
    }) && every(deps, function (dep) {return list[dep]}) ?
      ready() : !function (key) {
      delay[key] = delay[key] || []
      delay[key][push](ready)
      req && req(missing)
    }(deps.join('|'))
    return $script
  }

  $script.done = function (idOrDone) {
    $script([null], idOrDone)
  }

  return $script
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/maps/accumulation.vue?vue&type=template&id=ba7a24b8&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/maps/accumulation.vue?vue&type=template&id=ba7a24b8& ***!
  \***************************************************************************************************************************************************************************************************************/
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
        "p",
        { staticClass: "text-h6 text--primary" },
        [
          _c("v-icon", [_vm._v("mdi-transcribe")]),
          _vm._v(" Accumulation\n       ")
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-card-text",
        [
          _c(
            "v-row",
            [
              _c(
                "v-col",
                { attrs: { lg: "5" } },
                [
                  _c(
                    "v-card",
                    { staticClass: "p-4 rounded-tr-xl" },
                    [
                      _vm._v(
                        " \n                   Current Accumulation Data as of: " +
                          _vm._s(
                            _vm.getFormatDate(_vm.cresta_date, "MMMM D, YYYY")
                          ) +
                          "\n                   "
                      ),
                      _c("hr", { staticClass: "m-0" }),
                      _vm._v(" "),
                      _c(
                        "v-card",
                        { attrs: { flat: "" } },
                        [
                          _c("v-text-field", {
                            attrs: { label: "Search Cresta ID" },
                            model: {
                              value: _vm.cresta_search,
                              callback: function($$v) {
                                _vm.cresta_search = $$v
                              },
                              expression: "cresta_search"
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "v-card",
                            {
                              staticStyle: { "overflow-y": "auto" },
                              attrs: { flat: "" }
                            },
                            [
                              _c("v-data-table", {
                                attrs: {
                                  headers: _vm.cresta_headers,
                                  "sort-by": ["name"],
                                  page: _vm.page,
                                  items: _vm.cresta_data,
                                  dense: "",
                                  search: _vm.cresta_search,
                                  "hide-default-footer": "",
                                  "items-per-page": 10
                                },
                                on: {
                                  "update:page": function($event) {
                                    _vm.page = $event
                                  }
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "item.our_si",
                                      fn: function(ref) {
                                        var item = ref.item
                                        return [
                                          _c(
                                            "div",
                                            { staticClass: "text-right" },
                                            [
                                              _vm._v(
                                                "      ₱ " +
                                                  _vm._s(
                                                    item.our_si
                                                      .toString()
                                                      .replace(
                                                        /\B(?=(\d{3})+(?!\d))/g,
                                                        "."
                                                      )
                                                  )
                                              )
                                            ]
                                          )
                                        ]
                                      }
                                    },
                                    {
                                      key: "item.data",
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
                                                          attrs: {
                                                            text: "",
                                                            small: ""
                                                          },
                                                          on: {
                                                            click: function(
                                                              $event
                                                            ) {
                                                              return _vm.getCompanyList(
                                                                item
                                                              )
                                                            }
                                                          }
                                                        },
                                                        [
                                                          _c("v-icon", [
                                                            _vm._v("mdi-eye ")
                                                          ])
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
                          !_vm.cresta_search
                            ? _c(
                                "v-card-actions",
                                { staticClass: "p-0" },
                                [
                                  _c("v-pagination", {
                                    attrs: {
                                      length: Math.ceil(
                                        _vm.cresta_data.length / 10
                                      )
                                    },
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
                              )
                            : _vm._e()
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
                { attrs: { lg: "7" } },
                [
                  _c("v-card", {
                    staticClass: "pb-4",
                    attrs: {
                      flat: "",
                      width: "100%",
                      height: "400",
                      id: "mapout"
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
        "v-dialog",
        {
          attrs: {
            fullscreen: "",
            "hide-overlay": "",
            transition: "dialog-bottom-transition"
          },
          model: {
            value: _vm.dialog_list,
            callback: function($$v) {
              _vm.dialog_list = $$v
            },
            expression: "dialog_list"
          }
        },
        [
          _c(
            "v-card",
            { attrs: { "max-height": "40", tile: "" } },
            [
              _c(
                "v-toolbar",
                { attrs: { flat: "", dark: "", color: "primary" } },
                [
                  _c(
                    "v-btn",
                    {
                      attrs: { icon: "", dark: "" },
                      on: {
                        click: function($event) {
                          _vm.dialog_list = false
                        }
                      }
                    },
                    [_c("v-icon", [_vm._v("mdi-close")])],
                    1
                  ),
                  _vm._v(" "),
                  _c("v-toolbar-title", [_vm._v("Cresta Accumulation")]),
                  _vm._v(" "),
                  _c("v-spacer"),
                  _vm._v(" "),
                  _c("v-toolbar-items")
                ],
                1
              ),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c(
                "v-card-text",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { lg: "12" } },
                        [
                          _c("div", { staticClass: "h4" }, [
                            _vm._v(
                              "Cresta ID: " +
                                _vm._s(_vm.cresta_selected.cresta_id)
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", [
                            _vm._v("View Location in "),
                            _c(
                              "a",
                              {
                                staticClass: "pl-0",
                                staticStyle: { "text-transform": "none" },
                                on: { click: _vm.callmap }
                              },
                              [_vm._v("Google Map")]
                            )
                          ]),
                          _vm._v(" "),
                          _c("v-text-field", {
                            attrs: { label: "Search Company" },
                            model: {
                              value: _vm.company_search,
                              callback: function($$v) {
                                _vm.company_search = $$v
                              },
                              expression: "company_search"
                            }
                          }),
                          _vm._v(" "),
                          _c("v-data-table", {
                            attrs: {
                              headers: _vm.company_headers,
                              page: _vm.page,
                              items: _vm.company_data,
                              dense: "",
                              search: _vm.company_search,
                              "items-per-page": 10
                            },
                            on: {
                              "update:page": function($event) {
                                _vm.page = $event
                              }
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "item.our_si_or",
                                  fn: function(ref) {
                                    var item = ref.item
                                    return [
                                      _c("div", { staticClass: "text-right" }, [
                                        _vm._v(
                                          "  ₱ " +
                                            _vm._s(
                                              item.our_si_or
                                                .toString()
                                                .replace(
                                                  /\B(?=(\d{3})+(?!\d))/g,
                                                  "."
                                                )
                                            )
                                        )
                                      ])
                                    ]
                                  }
                                },
                                {
                                  key: "item.our_si_tty",
                                  fn: function(ref) {
                                    var item = ref.item
                                    return [
                                      _c("div", { staticClass: "text-right" }, [
                                        _vm._v(
                                          "  ₱ " +
                                            _vm._s(
                                              item.our_si_tty
                                                .toString()
                                                .replace(
                                                  /\B(?=(\d{3})+(?!\d))/g,
                                                  "."
                                                )
                                            )
                                        )
                                      ])
                                    ]
                                  }
                                },
                                {
                                  key: "item.our_si_fac",
                                  fn: function(ref) {
                                    var item = ref.item
                                    return [
                                      _c("div", { staticClass: "text-right" }, [
                                        _vm._v(
                                          "  ₱ " +
                                            _vm._s(
                                              item.our_si_fac
                                                .toString()
                                                .replace(
                                                  /\B(?=(\d{3})+(?!\d))/g,
                                                  "."
                                                )
                                            )
                                        )
                                      ])
                                    ]
                                  }
                                },
                                {
                                  key: "item.data",
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
                                                      attrs: {
                                                        text: "",
                                                        small: ""
                                                      },
                                                      on: {
                                                        click: function(
                                                          $event
                                                        ) {
                                                          return _vm.initMap()
                                                        }
                                                      }
                                                    },
                                                    [
                                                      _c("v-icon", [
                                                        _vm._v("mdi-eye")
                                                      ]),
                                                      _vm._v(" "),
                                                      _c("small", [
                                                        _vm._v(" - View ")
                                                      ])
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
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("v-divider"),
                  _vm._v(" "),
                  _c("v-card-text", [
                    _c("div", { staticClass: " h4" }, [
                      _vm._v(
                        "Total Accumulation:  ₱ " +
                          _vm._s(
                            _vm.cresta_selected.our_si
                              .toString()
                              .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                          )
                      )
                    ])
                  ])
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
          attrs: { width: "1100" },
          model: {
            value: _vm.map_dialog,
            callback: function($$v) {
              _vm.map_dialog = $$v
            },
            expression: "map_dialog"
          }
        },
        [
          _c(
            "v-card",
            [
              _c("v-card-title", { staticClass: "text-h5 grey lighten-2" }, [
                _vm._v("\n              Google Map\n           ")
              ]),
              _vm._v(" "),
              _c("v-card", {
                staticClass: "pb-4",
                attrs: { width: "100%", height: "400", id: "mapin" }
              }),
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
                          _vm.map_dialog = false
                        }
                      }
                    },
                    [_vm._v("\n               Close\n               ")]
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

/***/ "./resources/js/pages/maps/accumulation.vue":
/*!**************************************************!*\
  !*** ./resources/js/pages/maps/accumulation.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _accumulation_vue_vue_type_template_id_ba7a24b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./accumulation.vue?vue&type=template&id=ba7a24b8& */ "./resources/js/pages/maps/accumulation.vue?vue&type=template&id=ba7a24b8&");
/* harmony import */ var _accumulation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./accumulation.vue?vue&type=script&lang=js& */ "./resources/js/pages/maps/accumulation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _accumulation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _accumulation_vue_vue_type_template_id_ba7a24b8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _accumulation_vue_vue_type_template_id_ba7a24b8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/maps/accumulation.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/maps/accumulation.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/maps/accumulation.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_accumulation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./accumulation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/maps/accumulation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_accumulation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/maps/accumulation.vue?vue&type=template&id=ba7a24b8&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/maps/accumulation.vue?vue&type=template&id=ba7a24b8& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_accumulation_vue_vue_type_template_id_ba7a24b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./accumulation.vue?vue&type=template&id=ba7a24b8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/maps/accumulation.vue?vue&type=template&id=ba7a24b8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_accumulation_vue_vue_type_template_id_ba7a24b8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_accumulation_vue_vue_type_template_id_ba7a24b8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);