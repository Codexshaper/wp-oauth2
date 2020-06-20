(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["spa"],{

/***/ "./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/App.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/App.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  name: 'App',\n  data: () => ({\n    appName: 'Spa'\n  }),\n\n  mounted() {\n    axios.post('http://localhost/laravel-woocommerce/csrf-token', {\n      token: 'hello',\n      'wbp_nonce': 'my_nonce'\n    }).then(res => {\n      console.log(res);\n    }).catch(err => {\n      console.log(err.response);\n    });\n  }\n\n});\n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Home.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/pages/Home.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n//\n//\n//\n//\n//\n//\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  name: 'Home',\n\n  data() {\n    return {\n      msg: 'Welcome to Your Vue.js Frontend App'\n    };\n  }\n\n});\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Home.vue?./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Login.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/pages/Login.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var vform__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vform */ \"./node_modules/vform/dist/vform.common.js\");\n/* harmony import */ var vform__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vform__WEBPACK_IMPORTED_MODULE_0__);\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  middleware: 'guest',\n\n  metaInfo() {\n    return {\n      title: this.$t('login')\n    };\n  },\n\n  data: () => ({\n    form: new vform__WEBPACK_IMPORTED_MODULE_0___default.a({\n      email: '',\n      password: ''\n    }),\n    remember: false\n  }),\n  methods: {\n    async login() {\n      // Submit the form.\n      const {\n        data\n      } = await this.form.post('/api/login');\n      console.log(data); // Save the token.\n\n      this.$store.dispatch('auth/saveToken', {\n        token: data.token,\n        remember: this.remember\n      }); // Fetch the user.\n\n      await this.$store.dispatch('auth/fetchUser'); // Redirect home.\n\n      this.$router.push({\n        name: 'home'\n      });\n    }\n\n  }\n});\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Login.vue?./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/mini-css-extract-plugin/dist/loader.js?!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/App.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js??ref--6-0!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/App.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?./node_modules/mini-css-extract-plugin/dist/loader.js??ref--6-0!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/App.vue?vue&type=template&id=943973f0&":
/*!***********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/App.vue?vue&type=template&id=943973f0& ***!
  \***********************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return staticRenderFns; });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\n    \"div\",\n    { attrs: { id: \"vue-frontend-app\" } },\n    [\n      _c(\"div\", { staticClass: \"container\" }, [\n        _c(\"h2\", [_vm._v(_vm._s(_vm.appName) + \" App\")])\n      ]),\n      _vm._v(\" \"),\n      _c(\"router-link\", { attrs: { to: \"/\" } }, [_vm._v(\"Home\")]),\n      _vm._v(\" \"),\n      _c(\"router-link\", { attrs: { to: \"/login\" } }, [_vm._v(\"Login\")]),\n      _vm._v(\" \"),\n      _c(\"router-view\")\n    ],\n    1\n  )\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n\n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Home.vue?vue&type=template&id=0142859a&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/pages/Home.vue?vue&type=template&id=0142859a&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return staticRenderFns; });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\"div\", { staticClass: \"hello\" }, [\n    _c(\"span\", [_vm._v(_vm._s(_vm.msg))])\n  ])\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Home.vue?./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Login.vue?vue&type=template&id=0a5dcfc5&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/spa/pages/Login.vue?vue&type=template&id=0a5dcfc5& ***!
  \*******************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return staticRenderFns; });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\"div\", { staticClass: \"row\" }, [\n    _c(\"div\", { staticClass: \"col-lg-8 m-auto\" }, [\n      _c(\"div\", { staticClass: \"card\", attrs: { title: \"login\" } }, [\n        _c(\n          \"form\",\n          {\n            on: {\n              submit: function($event) {\n                $event.preventDefault()\n                return _vm.login($event)\n              },\n              keydown: function($event) {\n                return _vm.form.onKeydown($event)\n              }\n            }\n          },\n          [\n            _c(\"div\", { staticClass: \"form-group row\" }, [\n              _c(\n                \"label\",\n                { staticClass: \"col-md-3 col-form-label text-md-right\" },\n                [_vm._v(\"email\")]\n              ),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"col-md-7\" }, [\n                _c(\"input\", {\n                  directives: [\n                    {\n                      name: \"model\",\n                      rawName: \"v-model\",\n                      value: _vm.form.email,\n                      expression: \"form.email\"\n                    }\n                  ],\n                  staticClass: \"form-control\",\n                  class: { \"is-invalid\": _vm.form.errors.has(\"email\") },\n                  attrs: { type: \"email\", name: \"email\" },\n                  domProps: { value: _vm.form.email },\n                  on: {\n                    input: function($event) {\n                      if ($event.target.composing) {\n                        return\n                      }\n                      _vm.$set(_vm.form, \"email\", $event.target.value)\n                    }\n                  }\n                })\n              ])\n            ]),\n            _vm._v(\" \"),\n            _c(\"div\", { staticClass: \"form-group row\" }, [\n              _c(\n                \"label\",\n                { staticClass: \"col-md-3 col-form-label text-md-right\" },\n                [_vm._v(\"password\")]\n              ),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"col-md-7\" }, [\n                _c(\"input\", {\n                  directives: [\n                    {\n                      name: \"model\",\n                      rawName: \"v-model\",\n                      value: _vm.form.password,\n                      expression: \"form.password\"\n                    }\n                  ],\n                  staticClass: \"form-control\",\n                  class: { \"is-invalid\": _vm.form.errors.has(\"password\") },\n                  attrs: { type: \"password\", name: \"password\" },\n                  domProps: { value: _vm.form.password },\n                  on: {\n                    input: function($event) {\n                      if ($event.target.composing) {\n                        return\n                      }\n                      _vm.$set(_vm.form, \"password\", $event.target.value)\n                    }\n                  }\n                })\n              ])\n            ]),\n            _vm._v(\" \"),\n            _c(\"div\", { staticClass: \"form-group row\" }, [\n              _c(\"div\", { staticClass: \"col-md-3\" }),\n              _vm._v(\" \"),\n              _c(\n                \"div\",\n                { staticClass: \"col-md-7 d-flex\" },\n                [\n                  _c(\"input\", {\n                    directives: [\n                      {\n                        name: \"model\",\n                        rawName: \"v-model\",\n                        value: _vm.remember,\n                        expression: \"remember\"\n                      }\n                    ],\n                    attrs: { type: \"checkbox\", name: \"remember\" },\n                    domProps: {\n                      checked: Array.isArray(_vm.remember)\n                        ? _vm._i(_vm.remember, null) > -1\n                        : _vm.remember\n                    },\n                    on: {\n                      change: function($event) {\n                        var $$a = _vm.remember,\n                          $$el = $event.target,\n                          $$c = $$el.checked ? true : false\n                        if (Array.isArray($$a)) {\n                          var $$v = null,\n                            $$i = _vm._i($$a, $$v)\n                          if ($$el.checked) {\n                            $$i < 0 && (_vm.remember = $$a.concat([$$v]))\n                          } else {\n                            $$i > -1 &&\n                              (_vm.remember = $$a\n                                .slice(0, $$i)\n                                .concat($$a.slice($$i + 1)))\n                          }\n                        } else {\n                          _vm.remember = $$c\n                        }\n                      }\n                    }\n                  }),\n                  _vm._v(\"\\n              remember_me\\n\\n            \"),\n                  _c(\n                    \"router-link\",\n                    {\n                      staticClass: \"small ml-auto my-auto\",\n                      attrs: { to: { name: \"password.request\" } }\n                    },\n                    [_vm._v(\"\\n              forgot_password\\n            \")]\n                  )\n                ],\n                1\n              )\n            ]),\n            _vm._v(\" \"),\n            _c(\"div\", { staticClass: \"form-group row\" }, [\n              _c(\"div\", { staticClass: \"col-md-7 offset-md-3 d-flex\" }, [\n                _c(\"button\", { attrs: { loading: _vm.form.busy } }, [\n                  _vm._v(\"\\n              login\\n            \")\n                ])\n              ])\n            ])\n          ]\n        )\n      ])\n    ])\n  ])\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Login.vue?./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./resources/js/spa/App.vue":
/*!**********************************!*\
  !*** ./resources/js/spa/App.vue ***!
  \**********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _App_vue_vue_type_template_id_943973f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./App.vue?vue&type=template&id=943973f0& */ \"./resources/js/spa/App.vue?vue&type=template&id=943973f0&\");\n/* harmony import */ var _App_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App.vue?vue&type=script&lang=js& */ \"./resources/js/spa/App.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport *//* harmony import */ var _App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./App.vue?vue&type=style&index=0&lang=css& */ \"./resources/js/spa/App.vue?vue&type=style&index=0&lang=css&\");\n/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n\n/* normalize component */\n\nvar component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__[\"default\"])(\n  _App_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _App_vue_vue_type_template_id_943973f0___WEBPACK_IMPORTED_MODULE_0__[\"render\"],\n  _App_vue_vue_type_template_id_943973f0___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"],\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/spa/App.vue\"\n/* harmony default export */ __webpack_exports__[\"default\"] = (component.exports);\n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?");

/***/ }),

/***/ "./resources/js/spa/App.vue?vue&type=script&lang=js&":
/*!***********************************************************!*\
  !*** ./resources/js/spa/App.vue?vue&type=script&lang=js& ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib!../../../node_modules/vue-loader/lib??vue-loader-options!./App.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/App.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); \n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?");

/***/ }),

/***/ "./resources/js/spa/App.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************!*\
  !*** ./resources/js/spa/App.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_6_0_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/mini-css-extract-plugin/dist/loader.js??ref--6-0!../../../node_modules/css-loader/dist/cjs.js!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/vue-loader/lib??vue-loader-options!./App.vue?vue&type=style&index=0&lang=css& */ \"./node_modules/mini-css-extract-plugin/dist/loader.js?!./node_modules/css-loader/dist/cjs.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/App.vue?vue&type=style&index=0&lang=css&\");\n/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_6_0_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_mini_css_extract_plugin_dist_loader_js_ref_6_0_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);\n/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_mini_css_extract_plugin_dist_loader_js_ref_6_0_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_mini_css_extract_plugin_dist_loader_js_ref_6_0_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));\n /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_mini_css_extract_plugin_dist_loader_js_ref_6_0_node_modules_css_loader_dist_cjs_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); \n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?");

/***/ }),

/***/ "./resources/js/spa/App.vue?vue&type=template&id=943973f0&":
/*!*****************************************************************!*\
  !*** ./resources/js/spa/App.vue?vue&type=template&id=943973f0& ***!
  \*****************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_template_id_943973f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./App.vue?vue&type=template&id=943973f0& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/App.vue?vue&type=template&id=943973f0&\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_template_id_943973f0___WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_template_id_943973f0___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"]; });\n\n\n\n//# sourceURL=webpack:///./resources/js/spa/App.vue?");

/***/ }),

/***/ "./resources/js/spa/main.js":
/*!**********************************!*\
  !*** ./resources/js/spa/main.js ***!
  \**********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.esm.js\");\n/* harmony import */ var _App_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App.vue */ \"./resources/js/spa/App.vue\");\n/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./store */ \"./resources/js/spa/store/index.js\");\n/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./router */ \"./resources/js/spa/router/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);\ntry {\n  window.Popper = __webpack_require__(/*! popper.js */ \"./node_modules/popper.js/dist/esm/popper.js\").default;\n  window.$ = window.jQuery = __webpack_require__(/*! jquery */ \"./node_modules/jquery/dist/jquery.js\");\n\n  __webpack_require__(/*! bootstrap */ \"./node_modules/bootstrap/dist/js/bootstrap.js\");\n} catch (e) {}\n/**\n * We'll load the axios HTTP library which allows us to easily issue requests\n * to our Laravel back-end. This library automatically handles sending the\n * CSRF token as a header based on the value of the \"XSRF\" token cookie.\n */\n\n\nwindow.axios = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\nwindow.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';\n/**\n * Next we will register the CSRF Token as a common header with Axios so that\n * all outgoing HTTP requests automatically have it attached. This is just\n * a simple convenience so we don't have to attach every token manually.\n */\n\nlet token = document.head.querySelector('meta[name=\"csrf-token\"]');\n\nif (token) {\n  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;\n} else {\n  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');\n}\n\n\n\n\n\n\nvue__WEBPACK_IMPORTED_MODULE_0__[\"default\"].config.productionTip = false;\n/* eslint-disable no-new */\n\nnew vue__WEBPACK_IMPORTED_MODULE_0__[\"default\"]({\n  el: '#wpb-spa-app',\n  store: _store__WEBPACK_IMPORTED_MODULE_2__[\"default\"],\n  router: _router__WEBPACK_IMPORTED_MODULE_3__[\"default\"],\n  ..._App_vue__WEBPACK_IMPORTED_MODULE_1__[\"default\"]\n});\n\n//# sourceURL=webpack:///./resources/js/spa/main.js?");

/***/ }),

/***/ "./resources/js/spa/pages/Home.vue":
/*!*****************************************!*\
  !*** ./resources/js/spa/pages/Home.vue ***!
  \*****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Home_vue_vue_type_template_id_0142859a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=0142859a&scoped=true& */ \"./resources/js/spa/pages/Home.vue?vue&type=template&id=0142859a&scoped=true&\");\n/* harmony import */ var _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js& */ \"./resources/js/spa/pages/Home.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n\nvar component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(\n  _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _Home_vue_vue_type_template_id_0142859a_scoped_true___WEBPACK_IMPORTED_MODULE_0__[\"render\"],\n  _Home_vue_vue_type_template_id_0142859a_scoped_true___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"],\n  false,\n  null,\n  \"0142859a\",\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/spa/pages/Home.vue\"\n/* harmony default export */ __webpack_exports__[\"default\"] = (component.exports);\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Home.vue?");

/***/ }),

/***/ "./resources/js/spa/pages/Home.vue?vue&type=script&lang=js&":
/*!******************************************************************!*\
  !*** ./resources/js/spa/pages/Home.vue?vue&type=script&lang=js& ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib!../../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Home.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); \n\n//# sourceURL=webpack:///./resources/js/spa/pages/Home.vue?");

/***/ }),

/***/ "./resources/js/spa/pages/Home.vue?vue&type=template&id=0142859a&scoped=true&":
/*!************************************************************************************!*\
  !*** ./resources/js/spa/pages/Home.vue?vue&type=template&id=0142859a&scoped=true& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_0142859a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=template&id=0142859a&scoped=true& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Home.vue?vue&type=template&id=0142859a&scoped=true&\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_0142859a_scoped_true___WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_0142859a_scoped_true___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"]; });\n\n\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Home.vue?");

/***/ }),

/***/ "./resources/js/spa/pages/Login.vue":
/*!******************************************!*\
  !*** ./resources/js/spa/pages/Login.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Login_vue_vue_type_template_id_0a5dcfc5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=0a5dcfc5& */ \"./resources/js/spa/pages/Login.vue?vue&type=template&id=0a5dcfc5&\");\n/* harmony import */ var _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&lang=js& */ \"./resources/js/spa/pages/Login.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n\nvar component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(\n  _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _Login_vue_vue_type_template_id_0a5dcfc5___WEBPACK_IMPORTED_MODULE_0__[\"render\"],\n  _Login_vue_vue_type_template_id_0a5dcfc5___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"],\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/spa/pages/Login.vue\"\n/* harmony default export */ __webpack_exports__[\"default\"] = (component.exports);\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Login.vue?");

/***/ }),

/***/ "./resources/js/spa/pages/Login.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/spa/pages/Login.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Login.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); \n\n//# sourceURL=webpack:///./resources/js/spa/pages/Login.vue?");

/***/ }),

/***/ "./resources/js/spa/pages/Login.vue?vue&type=template&id=0a5dcfc5&":
/*!*************************************************************************!*\
  !*** ./resources/js/spa/pages/Login.vue?vue&type=template&id=0a5dcfc5& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_0a5dcfc5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=template&id=0a5dcfc5& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/spa/pages/Login.vue?vue&type=template&id=0a5dcfc5&\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_0a5dcfc5___WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_0a5dcfc5___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"]; });\n\n\n\n//# sourceURL=webpack:///./resources/js/spa/pages/Login.vue?");

/***/ }),

/***/ "./resources/js/spa/router/index.js":
/*!******************************************!*\
  !*** ./resources/js/spa/router/index.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.esm.js\");\n/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ \"./node_modules/vue-router/dist/vue-router.esm.js\");\n/* harmony import */ var _pages_Home_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../pages/Home.vue */ \"./resources/js/spa/pages/Home.vue\");\n/* harmony import */ var _pages_Login_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../pages/Login.vue */ \"./resources/js/spa/pages/Login.vue\");\n\n\n\n\nvue__WEBPACK_IMPORTED_MODULE_0__[\"default\"].use(vue_router__WEBPACK_IMPORTED_MODULE_1__[\"default\"]);\n/* harmony default export */ __webpack_exports__[\"default\"] = (new vue_router__WEBPACK_IMPORTED_MODULE_1__[\"default\"]({\n  routes: [{\n    path: '/',\n    name: 'Home',\n    component: _pages_Home_vue__WEBPACK_IMPORTED_MODULE_2__[\"default\"]\n  }, {\n    path: '/login',\n    name: 'Login',\n    component: _pages_Login_vue__WEBPACK_IMPORTED_MODULE_3__[\"default\"]\n  }]\n}));\n\n//# sourceURL=webpack:///./resources/js/spa/router/index.js?");

/***/ }),

/***/ "./resources/js/spa/store/index.js":
/*!*****************************************!*\
  !*** ./resources/js/spa/store/index.js ***!
  \*****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.esm.js\");\n/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ \"./node_modules/vuex/dist/vuex.esm.js\");\n\n\nvue__WEBPACK_IMPORTED_MODULE_0__[\"default\"].use(vuex__WEBPACK_IMPORTED_MODULE_1__[\"default\"]); // Load store modules dynamically.\n\nconst requireContext = __webpack_require__(\"./resources/js/spa/store/modules sync .*\\\\.js$\");\n\nconst modules = requireContext.keys().map(file => [file.replace(/(^.\\/)|(\\.js$)/g, ''), requireContext(file)]).reduce((modules, [name, module]) => {\n  if (module.namespaced === undefined) {\n    module.namespaced = true;\n  }\n\n  return { ...modules,\n    [name]: module\n  };\n}, {});\n/* harmony default export */ __webpack_exports__[\"default\"] = (new vuex__WEBPACK_IMPORTED_MODULE_1__[\"default\"].Store({\n  modules\n}));\n\n//# sourceURL=webpack:///./resources/js/spa/store/index.js?");

/***/ }),

/***/ "./resources/js/spa/store/modules sync .*\\.js$":
/*!******************************************************************!*\
  !*** ./resources/js/spa/store/modules sync nonrecursive .*\.js$ ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var map = {\n\t\"./auth.js\": \"./resources/js/spa/store/modules/auth.js\",\n\t\"./lang.js\": \"./resources/js/spa/store/modules/lang.js\",\n\t\"./upload.js\": \"./resources/js/spa/store/modules/upload.js\"\n};\n\n\nfunction webpackContext(req) {\n\tvar id = webpackContextResolve(req);\n\treturn __webpack_require__(id);\n}\nfunction webpackContextResolve(req) {\n\tif(!__webpack_require__.o(map, req)) {\n\t\tvar e = new Error(\"Cannot find module '\" + req + \"'\");\n\t\te.code = 'MODULE_NOT_FOUND';\n\t\tthrow e;\n\t}\n\treturn map[req];\n}\nwebpackContext.keys = function webpackContextKeys() {\n\treturn Object.keys(map);\n};\nwebpackContext.resolve = webpackContextResolve;\nmodule.exports = webpackContext;\nwebpackContext.id = \"./resources/js/spa/store/modules sync .*\\\\.js$\";\n\n//# sourceURL=webpack:///./resources/js/spa/store/modules_sync_nonrecursive_.*\\.js$?");

/***/ }),

/***/ "./resources/js/spa/store/modules/auth.js":
/*!************************************************!*\
  !*** ./resources/js/spa/store/modules/auth.js ***!
  \************************************************/
/*! exports provided: state, getters, mutations, actions */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"state\", function() { return state; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"getters\", function() { return getters; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"mutations\", function() { return mutations; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"actions\", function() { return actions; });\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! js-cookie */ \"./node_modules/js-cookie/src/js.cookie.js\");\n/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(js_cookie__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _mutation_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../mutation-types */ \"./resources/js/spa/store/mutation-types.js\");\n\n\n // state\n\nconst state = {\n  user: null,\n  token: js_cookie__WEBPACK_IMPORTED_MODULE_1___default.a.get('token')\n}; // getters\n\nconst getters = {\n  user: state => state.user,\n  token: state => state.token,\n  check: state => state.user !== null\n}; // mutations\n\nconst mutations = {\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"SAVE_TOKEN\"]](state, {\n    token,\n    remember\n  }) {\n    state.token = token;\n    js_cookie__WEBPACK_IMPORTED_MODULE_1___default.a.set('token', token, {\n      expires: remember ? 365 : null\n    });\n  },\n\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"FETCH_USER_SUCCESS\"]](state, {\n    user\n  }) {\n    state.user = user;\n  },\n\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"FETCH_USER_FAILURE\"]](state) {\n    state.token = null;\n    js_cookie__WEBPACK_IMPORTED_MODULE_1___default.a.remove('token');\n  },\n\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"LOGOUT\"]](state) {\n    state.user = null;\n    state.token = null;\n    js_cookie__WEBPACK_IMPORTED_MODULE_1___default.a.remove('token');\n  },\n\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"UPDATE_USER\"]](state, {\n    user\n  }) {\n    state.user = user;\n  }\n\n}; // actions\n\nconst actions = {\n  saveToken({\n    commit,\n    dispatch\n  }, payload) {\n    commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"SAVE_TOKEN\"], payload);\n  },\n\n  async fetchUser({\n    commit\n  }) {\n    try {\n      const {\n        data\n      } = await axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/user');\n      commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"FETCH_USER_SUCCESS\"], {\n        user: data\n      });\n    } catch (e) {\n      commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"FETCH_USER_FAILURE\"]);\n    }\n  },\n\n  updateUser({\n    commit\n  }, payload) {\n    commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"UPDATE_USER\"], payload);\n  },\n\n  async logout({\n    commit\n  }) {\n    try {\n      // await axios.post('/api/logout')\n      commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"FETCH_USER_SUCCESS\"], {\n        user: null,\n        token: null\n      });\n    } catch (e) {}\n\n    commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"LOGOUT\"]);\n  },\n\n  async fetchOauthUrl(ctx, {\n    provider\n  }) {\n    const {\n      data\n    } = await axios__WEBPACK_IMPORTED_MODULE_0___default.a.post(`/api/oauth/${provider}`);\n    return data.url;\n  }\n\n};\n\n//# sourceURL=webpack:///./resources/js/spa/store/modules/auth.js?");

/***/ }),

/***/ "./resources/js/spa/store/modules/lang.js":
/*!************************************************!*\
  !*** ./resources/js/spa/store/modules/lang.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// import Cookies from 'js-cookie'\n// import * as types from '../mutation-types'\n// const { locale, locales } = window.config\n// // state\n// export const state = {\n//   locale: Cookies.get('locale') || locale,\n//   locales: locales\n// }\n// // getters\n// export const getters = {\n//   locale: state => state.locale,\n//   locales: state => state.locales\n// }\n// // mutations\n// export const mutations = {\n//   [types.SET_LOCALE] (state, { locale }) {\n//     state.locale = locale\n//   }\n// }\n// // actions\n// export const actions = {\n//   setLocale ({ commit }, { locale }) {\n//     commit(types.SET_LOCALE, { locale })\n//     Cookies.set('locale', locale, { expires: 365 })\n//   }\n// }\n\n//# sourceURL=webpack:///./resources/js/spa/store/modules/lang.js?");

/***/ }),

/***/ "./resources/js/spa/store/modules/upload.js":
/*!**************************************************!*\
  !*** ./resources/js/spa/store/modules/upload.js ***!
  \**************************************************/
/*! exports provided: state, getters, mutations, actions */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"state\", function() { return state; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"getters\", function() { return getters; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"mutations\", function() { return mutations; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"actions\", function() { return actions; });\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! js-cookie */ \"./node_modules/js-cookie/src/js.cookie.js\");\n/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(js_cookie__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _mutation_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../mutation-types */ \"./resources/js/spa/store/mutation-types.js\");\n\n\n // state\n\nconst state = {\n  code: null,\n  uploader: null\n}; // getters\n\nconst getters = {\n  code: state => state.code,\n  uploader: state => state.uploader\n}; // mutations\n\nconst mutations = {\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"CODE_SAVE\"]](state, {\n    code\n  }) {\n    state.code = code;\n  },\n\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"CODE_UPDATE\"]](state, {\n    code\n  }) {\n    state.code = code;\n  },\n\n  [_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"Uploader\"]](state, {\n    uploader\n  }) {\n    state.uploader = uploader;\n  }\n\n}; // actions\n\nconst actions = {\n  saveCode({\n    commit,\n    dispatch\n  }, payload) {\n    commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"CODE_SAVE\"], payload);\n  },\n\n  updateCode({\n    commit\n  }, payload) {\n    commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"CODE_UPDATE\"], payload);\n  },\n\n  setUploader: function ({\n    commit,\n    dispatch\n  }, payload) {\n    commit(_mutation_types__WEBPACK_IMPORTED_MODULE_2__[\"Uploader\"], payload);\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/spa/store/modules/upload.js?");

/***/ }),

/***/ "./resources/js/spa/store/mutation-types.js":
/*!**************************************************!*\
  !*** ./resources/js/spa/store/mutation-types.js ***!
  \**************************************************/
/*! exports provided: LOGOUT, SAVE_TOKEN, FETCH_USER, FETCH_USER_SUCCESS, FETCH_USER_FAILURE, UPDATE_USER, SET_LOCALE, CODE_SAVE, CODE_UPDATE, Uploader */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"LOGOUT\", function() { return LOGOUT; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"SAVE_TOKEN\", function() { return SAVE_TOKEN; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"FETCH_USER\", function() { return FETCH_USER; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"FETCH_USER_SUCCESS\", function() { return FETCH_USER_SUCCESS; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"FETCH_USER_FAILURE\", function() { return FETCH_USER_FAILURE; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"UPDATE_USER\", function() { return UPDATE_USER; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"SET_LOCALE\", function() { return SET_LOCALE; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"CODE_SAVE\", function() { return CODE_SAVE; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"CODE_UPDATE\", function() { return CODE_UPDATE; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Uploader\", function() { return Uploader; });\n// auth.js\nconst LOGOUT = 'LOGOUT';\nconst SAVE_TOKEN = 'SAVE_TOKEN';\nconst FETCH_USER = 'FETCH_USER';\nconst FETCH_USER_SUCCESS = 'FETCH_USER_SUCCESS';\nconst FETCH_USER_FAILURE = 'FETCH_USER_FAILURE';\nconst UPDATE_USER = 'UPDATE_USER'; // lang.js\n\nconst SET_LOCALE = 'SET_LOCALE'; // upload.js\n\nconst CODE_SAVE = 'CODE_SAVE';\nconst CODE_UPDATE = 'CODE_UPDATE';\nconst Uploader = 'Uploader';\n\n//# sourceURL=webpack:///./resources/js/spa/store/mutation-types.js?");

/***/ })

},[["./resources/js/spa/main.js","runtime","vendors"]]]);