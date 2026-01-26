"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_manufacturing_ProductionCreate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ProductionCreate',
  data: function data() {
    return {
      saving: false,
      form: {
        recipe_id: '',
        multiplier: 1,
        production_date: new Date().toISOString().split('T')[0],
        expiry_date: '',
        notes: ''
      },
      recipes: [],
      selectedRecipe: null,
      availability: null
    };
  },
  methods: {
    fetchRecipes: function fetchRecipes() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return axios.get('/dashboard/api/manufacturing/recipes?active_only=1&per_page=1000');
            case 3:
              response = _context.sent;
              _this.recipes = response.data.data;

              // Check if recipe_id was passed via query
              if (_this.$route.query.recipe_id) {
                _this.form.recipe_id = parseInt(_this.$route.query.recipe_id);
                _this.onRecipeChange();
              }
              _context.next = 11;
              break;
            case 8:
              _context.prev = 8;
              _context.t0 = _context["catch"](0);
              toastr.error('فشل تحميل الوصفات');
            case 11:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 8]]);
      }))();
    },
    onRecipeChange: function onRecipeChange() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this2.selectedRecipe = _this2.recipes.find(function (r) {
                return r.id === _this2.form.recipe_id;
              });
              if (!_this2.selectedRecipe) {
                _context2.next = 6;
                break;
              }
              _context2.next = 4;
              return _this2.checkAvailability();
            case 4:
              _context2.next = 7;
              break;
            case 6:
              _this2.availability = null;
            case 7:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    checkAvailability: function checkAvailability() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var response;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              if (_this3.form.recipe_id) {
                _context3.next = 2;
                break;
              }
              return _context3.abrupt("return");
            case 2:
              _context3.prev = 2;
              _context3.next = 5;
              return axios.get("/dashboard/api/manufacturing/recipes/".concat(_this3.form.recipe_id, "/availability"), {
                params: {
                  multiplier: _this3.form.multiplier
                }
              });
            case 5:
              response = _context3.sent;
              _this3.availability = response.data.data;
              _context3.next = 12;
              break;
            case 9:
              _context3.prev = 9;
              _context3.t0 = _context3["catch"](2);
              console.error('Failed to check availability');
            case 12:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[2, 9]]);
      }))();
    },
    formatCurrency: function formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
      });
    },
    createBatch: function createBatch() {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var response, _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _this4.saving = true;
              _context4.prev = 1;
              _context4.next = 4;
              return axios.post('/dashboard/api/manufacturing/batches', _this4.form);
            case 4:
              response = _context4.sent;
              toastr.success('تم إنشاء دفعة الإنتاج');
              _this4.$router.push({
                name: 'manufacturing.production'
              });
              _context4.next = 12;
              break;
            case 9:
              _context4.prev = 9;
              _context4.t0 = _context4["catch"](1);
              toastr.error(((_error$response = _context4.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل إنشاء الدفعة');
            case 12:
              _context4.prev = 12;
              _this4.saving = false;
              return _context4.finish(12);
            case 15:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[1, 9, 12, 15]]);
      }))();
    }
  },
  mounted: function mounted() {
    this.fetchRecipes();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=template&id=0e9885dc&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=template&id=0e9885dc& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$selectedRecipe$pr, _vm$availability;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "production-create"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center mb-4"
  }, [_vm._m(0), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-outline-secondary",
    attrs: {
      to: {
        name: "manufacturing.production"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-arrow-left me-1"
  }), _vm._v(" العودة للقائمة\n    ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "card mb-4"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_vm._m(2), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.recipe_id,
      expression: "form.recipe_id"
    }],
    staticClass: "form-select",
    attrs: {
      required: ""
    },
    on: {
      change: [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.form, "recipe_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.onRecipeChange]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("اختر الوصفة")]), _vm._v(" "), _vm._l(_vm.recipes, function (recipe) {
    var _recipe$product;
    return _c("option", {
      key: recipe.id,
      domProps: {
        value: recipe.id
      }
    }, [_vm._v("\n                    " + _vm._s(recipe.name) + " (" + _vm._s((_recipe$product = recipe.product) === null || _recipe$product === void 0 ? void 0 : _recipe$product.name) + ")\n                  ")]);
  })], 2)])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("مضاعف الدفعة")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.multiplier,
      expression: "form.multiplier"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0.1",
      step: "0.1"
    },
    domProps: {
      value: _vm.form.multiplier
    },
    on: {
      change: _vm.checkAvailability,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "multiplier", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("1 = دفعة واحدة، 2 = دفعة مضاعفة، إلخ.")])])])]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تاريخ الإنتاج")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.production_date,
      expression: "form.production_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.form.production_date
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "production_date", $event.target.value);
      }
    }
  })])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تاريخ انتهاء الصلاحية")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.expiry_date,
      expression: "form.expiry_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.form.expiry_date
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "expiry_date", $event.target.value);
      }
    }
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("ملاحظات")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.notes,
      expression: "form.notes"
    }],
    staticClass: "form-control",
    attrs: {
      rows: "3",
      placeholder: "ملاحظات إنتاج اختيارية..."
    },
    domProps: {
      value: _vm.form.notes
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "notes", $event.target.value);
      }
    }
  })])])]), _vm._v(" "), _vm.availability ? _c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header",
    "class": {
      "bg-success text-white": _vm.availability.can_produce,
      "bg-danger text-white": !_vm.availability.can_produce
    }
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_c("i", {
    staticClass: "me-2",
    "class": _vm.availability.can_produce ? "fas fa-check-circle" : "fas fa-exclamation-circle"
  }), _vm._v("\n            " + _vm._s(_vm.availability.can_produce ? "جاهز للإنتاج" : "مخزون غير كافي") + "\n          ")])]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("table", {
    staticClass: "table table-sm"
  }, [_vm._m(3), _vm._v(" "), _c("tbody", _vm._l(_vm.availability.ingredients, function (ing) {
    return _c("tr", {
      key: ing.raw_material_id
    }, [_c("td", [_vm._v(_vm._s(ing.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.required) + " " + _vm._s(ing.unit))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.available) + " " + _vm._s(ing.unit))]), _vm._v(" "), _c("td", [ing.sufficient ? _c("span", {
      staticClass: "badge bg-success"
    }, [_vm._v("متوفر")]) : _c("span", {
      staticClass: "badge bg-danger"
    }, [_vm._v("نقص: " + _vm._s(ing.shortage) + " " + _vm._s(ing.unit))])])]);
  }), 0)])])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card sticky-top",
    staticStyle: {
      top: "20px"
    }
  }, [_vm._m(4), _vm._v(" "), _vm.selectedRecipe ? _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("strong", [_vm._v("المنتج:")]), _c("br"), _vm._v("\n            " + _vm._s((_vm$selectedRecipe$pr = _vm.selectedRecipe.product) === null || _vm$selectedRecipe$pr === void 0 ? void 0 : _vm$selectedRecipe$pr.name) + "\n            "), _vm.selectedRecipe.product_variation ? _c("span", {
    staticClass: "text-muted"
  }, [_vm._v("\n              (" + _vm._s(_vm.selectedRecipe.product_variation.var_name) + ")\n            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("strong", [_vm._v("كمية الإنتاج:")]), _c("br"), _vm._v(" "), _c("span", {
    staticClass: "fs-4 text-primary"
  }, [_vm._v(_vm._s((_vm.selectedRecipe.output_quantity * _vm.form.multiplier).toFixed(2)))]), _vm._v(" وحدة\n          ")]), _vm._v(" "), _c("hr"), _vm._v(" "), _vm.availability ? _c("div", [_c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("تكلفة المواد:")]), _vm._v(" "), _c("strong", [_vm._v(_vm._s(_vm.formatCurrency(_vm.availability.estimated_material_cost)))])]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("تكلفة العمالة:")]), _vm._v(" "), _c("strong", [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedRecipe.labor_cost * _vm.form.multiplier)))])]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("التكاليف الإضافية:")]), _vm._v(" "), _c("strong", [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedRecipe.overhead_cost * _vm.form.multiplier)))])]), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("التكلفة الإجمالية:")]), _vm._v(" "), _c("strong", {
    staticClass: "text-primary"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.availability.estimated_total_cost)))])]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("span", [_vm._v("تكلفة الوحدة:")]), _vm._v(" "), _c("strong", {
    staticClass: "text-success"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.availability.estimated_unit_cost)))])])]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "card-footer"
  }, [_c("button", {
    staticClass: "btn btn-primary w-100",
    attrs: {
      type: "button",
      disabled: _vm.saving || !_vm.form.recipe_id || !((_vm$availability = _vm.availability) !== null && _vm$availability !== void 0 && _vm$availability.can_produce)
    },
    on: {
      click: _vm.createBatch
    }
  }, [_vm.saving ? _c("span", {
    staticClass: "spinner-border spinner-border-sm me-1"
  }) : _vm._e(), _vm._v("\n            إنشاء دفعة إنتاج\n          ")])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("h4", {
    staticClass: "mb-1"
  }, [_vm._v("بدء إنتاج جديد")]), _vm._v(" "), _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("اختر وصفة وأنشئ دفعة إنتاج")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("تفاصيل الإنتاج")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("الوصفة "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("المادة")]), _vm._v(" "), _c("th", [_vm._v("المطلوب")]), _vm._v(" "), _c("th", [_vm._v("المتوفر")]), _vm._v(" "), _c("th", [_vm._v("الحالة")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("ملخص الإنتاج")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ProductionCreate.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ProductionCreate.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ProductionCreate_vue_vue_type_template_id_0e9885dc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProductionCreate.vue?vue&type=template&id=0e9885dc& */ "./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=template&id=0e9885dc&");
/* harmony import */ var _ProductionCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProductionCreate.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProductionCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProductionCreate_vue_vue_type_template_id_0e9885dc___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProductionCreate_vue_vue_type_template_id_0e9885dc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/manufacturing/ProductionCreate.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductionCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=template&id=0e9885dc&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=template&id=0e9885dc& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionCreate_vue_vue_type_template_id_0e9885dc___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionCreate_vue_vue_type_template_id_0e9885dc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionCreate_vue_vue_type_template_id_0e9885dc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductionCreate.vue?vue&type=template&id=0e9885dc& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionCreate.vue?vue&type=template&id=0e9885dc&");


/***/ })

}]);