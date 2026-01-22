"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_pos_PosSettings_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'PosSettings',
  data: function data() {
    return {
      loading: true,
      saving: false,
      settings: {
        tax_rate: 0,
        costing_method: 'average',
        allow_negative_stock: false,
        show_stock_warning: true,
        receipt_header: '',
        receipt_footer: 'Thank you for your purchase!',
        print_receipt_auto: true,
        receipt_size: '80mm',
        require_customer: false,
        payment_methods: ['cash', 'card', 'wallet', 'bank_transfer'],
        keyboard_shortcuts: {}
      },
      allPaymentMethods: [{
        value: 'cash',
        label: 'Cash',
        icon: 'fas fa-money-bill-wave'
      }, {
        value: 'card',
        label: 'Card',
        icon: 'fas fa-credit-card'
      }, {
        value: 'wallet',
        label: 'Wallet',
        icon: 'fas fa-wallet'
      }, {
        value: 'bank_transfer',
        label: 'Bank Transfer',
        icon: 'fas fa-university'
      }],
      defaultShortcuts: {
        'F1': 'focus_search',
        'F2': 'new_cart',
        'F3': 'switch_cart',
        'F4': 'park_sale',
        'F5': 'view_parked',
        'F8': 'apply_discount',
        'F9': 'select_customer',
        'F10': 'open_payment',
        'F12': 'quick_cash',
        'Esc': 'cancel',
        'Delete': 'remove_item'
      }
    };
  },
  methods: {
    loadSettings: function loadSettings() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response, data, _this$$toast;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/pos/settings');
            case 3:
              response = _context.sent;
              data = response.data.data;
              _this.settings = {
                tax_rate: parseFloat(data.tax_rate) || 0,
                costing_method: data.costing_method || 'average',
                allow_negative_stock: data.allow_negative_stock || false,
                show_stock_warning: data.show_stock_warning !== false,
                receipt_header: data.receipt_header || '',
                receipt_footer: data.receipt_footer || 'Thank you for your purchase!',
                print_receipt_auto: data.print_receipt_auto !== false,
                receipt_size: data.receipt_size || '80mm',
                require_customer: data.require_customer || false,
                payment_methods: data.payment_methods || ['cash', 'card', 'wallet', 'bank_transfer'],
                keyboard_shortcuts: data.keyboard_shortcuts || {}
              };
              _context.next = 12;
              break;
            case 8:
              _context.prev = 8;
              _context.t0 = _context["catch"](0);
              console.error('Failed to load settings:', _context.t0);
              (_this$$toast = _this.$toast) === null || _this$$toast === void 0 ? void 0 : _this$$toast.error('Failed to load settings');
            case 12:
              _context.prev = 12;
              _this.loading = false;
              return _context.finish(12);
            case 15:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 8, 12, 15]]);
      }))();
    },
    saveSettings: function saveSettings() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var _this2$$toast, _this2$$toast2;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this2.saving = true;
              _context2.prev = 1;
              _context2.next = 4;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().put('/dashboard/api/pos/settings', _this2.settings);
            case 4:
              (_this2$$toast = _this2.$toast) === null || _this2$$toast === void 0 ? void 0 : _this2$$toast.success('Settings saved successfully');
              _context2.next = 11;
              break;
            case 7:
              _context2.prev = 7;
              _context2.t0 = _context2["catch"](1);
              console.error('Failed to save settings:', _context2.t0);
              (_this2$$toast2 = _this2.$toast) === null || _this2$$toast2 === void 0 ? void 0 : _this2$$toast2.error('Failed to save settings');
            case 11:
              _context2.prev = 11;
              _this2.saving = false;
              return _context2.finish(11);
            case 14:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[1, 7, 11, 14]]);
      }))();
    },
    resetSettings: function resetSettings() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var _this3$$toast, response, _this3$$toast2;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              if (confirm('Reset all settings to defaults?')) {
                _context3.next = 2;
                break;
              }
              return _context3.abrupt("return");
            case 2:
              _this3.saving = true;
              _context3.prev = 3;
              _context3.next = 6;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post('/dashboard/api/pos/settings/reset');
            case 6:
              response = _context3.sent;
              _this3.settings = response.data.data;
              (_this3$$toast = _this3.$toast) === null || _this3$$toast === void 0 ? void 0 : _this3$$toast.success('Settings reset to defaults');
              _context3.next = 15;
              break;
            case 11:
              _context3.prev = 11;
              _context3.t0 = _context3["catch"](3);
              console.error('Failed to reset settings:', _context3.t0);
              (_this3$$toast2 = _this3.$toast) === null || _this3$$toast2 === void 0 ? void 0 : _this3$$toast2.error('Failed to reset settings');
            case 15:
              _context3.prev = 15;
              _this3.saving = false;
              return _context3.finish(15);
            case 18:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[3, 11, 15, 18]]);
      }))();
    },
    formatAction: function formatAction(action) {
      var labels = {
        focus_search: 'Focus product search',
        new_cart: 'Create new cart',
        switch_cart: 'Switch to next cart',
        park_sale: 'Park current sale',
        view_parked: 'View parked sales',
        apply_discount: 'Apply discount',
        select_customer: 'Select customer',
        open_payment: 'Open payment modal',
        quick_cash: 'Quick cash payment',
        cancel: 'Cancel / Close',
        remove_item: 'Remove selected item'
      };
      return labels[action] || action;
    }
  },
  mounted: function mounted() {
    this.loadSettings();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "pos-settings-page"
  }, [_c("div", {
    staticClass: "page-header"
  }, [_vm._m(0), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-outline-primary",
    attrs: {
      to: "/dashboard/pos"
    }
  }, [_c("i", {
    staticClass: "fas fa-arrow-left"
  }), _vm._v(" Back to POS\n        ")])], 1), _vm._v(" "), !_vm.loading ? _c("div", {
    staticClass: "settings-container"
  }, [_c("div", {
    staticClass: "settings-card"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Tax Rate (%)")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.settings.tax_rate,
      expression: "settings.tax_rate",
      modifiers: {
        number: true
      }
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0",
      max: "100",
      step: "0.01"
    },
    domProps: {
      value: _vm.settings.tax_rate
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settings, "tax_rate", _vm._n($event.target.value));
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Applied to all sales. Set to 0 for no tax.")])])]), _vm._v(" "), _c("div", {
    staticClass: "settings-card"
  }, [_vm._m(2), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Costing Method")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.costing_method,
      expression: "settings.costing_method"
    }],
    staticClass: "form-control",
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.settings, "costing_method", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: "average"
    }
  }, [_vm._v("Average Cost")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "fifo"
    }
  }, [_vm._v("FIFO (First In, First Out)")])]), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Method used to calculate cost of goods sold.")])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "checkbox-label"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.allow_negative_stock,
      expression: "settings.allow_negative_stock"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.settings.allow_negative_stock) ? _vm._i(_vm.settings.allow_negative_stock, null) > -1 : _vm.settings.allow_negative_stock
    },
    on: {
      change: function change($event) {
        var $$a = _vm.settings.allow_negative_stock,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.settings, "allow_negative_stock", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.settings, "allow_negative_stock", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.settings, "allow_negative_stock", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("span", [_vm._v("Allow Negative Stock")])]), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Allow sales even when stock is insufficient.")])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "checkbox-label"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.show_stock_warning,
      expression: "settings.show_stock_warning"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.settings.show_stock_warning) ? _vm._i(_vm.settings.show_stock_warning, null) > -1 : _vm.settings.show_stock_warning
    },
    on: {
      change: function change($event) {
        var $$a = _vm.settings.show_stock_warning,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.settings, "show_stock_warning", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.settings, "show_stock_warning", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.settings, "show_stock_warning", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("span", [_vm._v("Show Low Stock Warning")])]), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Display warning when product stock is low.")])])]), _vm._v(" "), _c("div", {
    staticClass: "settings-card"
  }, [_vm._m(3), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Receipt Header")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.receipt_header,
      expression: "settings.receipt_header"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Store name or custom header"
    },
    domProps: {
      value: _vm.settings.receipt_header
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settings, "receipt_header", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Receipt Footer")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.receipt_footer,
      expression: "settings.receipt_footer"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Thank you message"
    },
    domProps: {
      value: _vm.settings.receipt_footer
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settings, "receipt_footer", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("Receipt Size")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.receipt_size,
      expression: "settings.receipt_size"
    }],
    staticClass: "form-control",
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.settings, "receipt_size", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: "58mm"
    }
  }, [_vm._v("58mm (Small)")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "80mm"
    }
  }, [_vm._v("80mm (Standard)")])])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "checkbox-label"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.print_receipt_auto,
      expression: "settings.print_receipt_auto"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.settings.print_receipt_auto) ? _vm._i(_vm.settings.print_receipt_auto, null) > -1 : _vm.settings.print_receipt_auto
    },
    on: {
      change: function change($event) {
        var $$a = _vm.settings.print_receipt_auto,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.settings, "print_receipt_auto", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.settings, "print_receipt_auto", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.settings, "print_receipt_auto", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("span", [_vm._v("Auto-Print Receipt")])]), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Automatically print receipt after sale completion.")])])]), _vm._v(" "), _c("div", {
    staticClass: "settings-card"
  }, [_vm._m(4), _vm._v(" "), _c("div", {
    staticClass: "payment-methods-grid"
  }, _vm._l(_vm.allPaymentMethods, function (method) {
    return _c("label", {
      key: method.value,
      staticClass: "payment-method-option"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.settings.payment_methods,
        expression: "settings.payment_methods"
      }],
      attrs: {
        type: "checkbox"
      },
      domProps: {
        value: method.value,
        checked: Array.isArray(_vm.settings.payment_methods) ? _vm._i(_vm.settings.payment_methods, method.value) > -1 : _vm.settings.payment_methods
      },
      on: {
        change: function change($event) {
          var $$a = _vm.settings.payment_methods,
            $$el = $event.target,
            $$c = $$el.checked ? true : false;
          if (Array.isArray($$a)) {
            var $$v = method.value,
              $$i = _vm._i($$a, $$v);
            if ($$el.checked) {
              $$i < 0 && _vm.$set(_vm.settings, "payment_methods", $$a.concat([$$v]));
            } else {
              $$i > -1 && _vm.$set(_vm.settings, "payment_methods", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
            }
          } else {
            _vm.$set(_vm.settings, "payment_methods", $$c);
          }
        }
      }
    }), _vm._v(" "), _c("span", {
      staticClass: "method-box"
    }, [_c("i", {
      "class": method.icon
    }), _vm._v(" "), _c("span", [_vm._v(_vm._s(method.label))])])]);
  }), 0)]), _vm._v(" "), _c("div", {
    staticClass: "settings-card"
  }, [_vm._m(5), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "checkbox-label"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settings.require_customer,
      expression: "settings.require_customer"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.settings.require_customer) ? _vm._i(_vm.settings.require_customer, null) > -1 : _vm.settings.require_customer
    },
    on: {
      change: function change($event) {
        var $$a = _vm.settings.require_customer,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.settings, "require_customer", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.settings, "require_customer", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.settings, "require_customer", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("span", [_vm._v("Require Customer Selection")])]), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Customer must be selected before completing sale.")])])]), _vm._v(" "), _c("div", {
    staticClass: "settings-card"
  }, [_vm._m(6), _vm._v(" "), _c("div", {
    staticClass: "shortcuts-table"
  }, _vm._l(_vm.defaultShortcuts, function (action, key) {
    return _c("div", {
      key: key,
      staticClass: "shortcut-row"
    }, [_c("span", {
      staticClass: "shortcut-key"
    }, [_vm._v(_vm._s(key))]), _vm._v(" "), _c("span", {
      staticClass: "shortcut-action"
    }, [_vm._v(_vm._s(_vm.formatAction(action)))])]);
  }), 0), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("Keyboard shortcuts cannot be customized at this time.")])]), _vm._v(" "), _c("div", {
    staticClass: "settings-actions"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      disabled: _vm.saving
    },
    on: {
      click: _vm.resetSettings
    }
  }, [_c("i", {
    staticClass: "fas fa-undo"
  }), _vm._v(" Reset to Defaults\n            ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      disabled: _vm.saving
    },
    on: {
      click: _vm.saveSettings
    }
  }, [_c("i", {
    staticClass: "fas fa-save"
  }), _vm._v(" " + _vm._s(_vm.saving ? "Saving..." : "Save Settings") + "\n            ")])])]) : _c("div", {
    staticClass: "loading-state"
  }, [_c("i", {
    staticClass: "fas fa-spinner fa-spin"
  }), _vm._v(" Loading settings...\n    ")])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h2", [_c("i", {
    staticClass: "fas fa-cog"
  }), _vm._v(" POS Settings")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h4", [_c("i", {
    staticClass: "fas fa-percent"
  }), _vm._v(" Tax Settings")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h4", [_c("i", {
    staticClass: "fas fa-boxes"
  }), _vm._v(" Inventory Settings")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h4", [_c("i", {
    staticClass: "fas fa-receipt"
  }), _vm._v(" Receipt Settings")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h4", [_c("i", {
    staticClass: "fas fa-credit-card"
  }), _vm._v(" Payment Methods")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h4", [_c("i", {
    staticClass: "fas fa-sliders-h"
  }), _vm._v(" General Settings")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h4", [_c("i", {
    staticClass: "fas fa-keyboard"
  }), _vm._v(" Keyboard Shortcuts")]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.pos-settings-page[data-v-7e9f8d94] {\n    padding: 20px;\n    max-width: 800px;\n    margin: 0 auto;\n}\n.page-header[data-v-7e9f8d94] {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    margin-bottom: 30px;\n}\n.page-header h2[data-v-7e9f8d94] {\n    margin: 0;\n}\n.settings-container[data-v-7e9f8d94] {\n    display: flex;\n    flex-direction: column;\n    gap: 20px;\n}\n.settings-card[data-v-7e9f8d94] {\n    background: white;\n    border-radius: 12px;\n    padding: 20px;\n    box-shadow: 0 2px 8px rgba(0,0,0,0.05);\n}\n.settings-card h4[data-v-7e9f8d94] {\n    margin: 0 0 20px 0;\n    padding-bottom: 10px;\n    border-bottom: 1px solid #e0e0e0;\n    color: #333;\n}\n.settings-card h4 i[data-v-7e9f8d94] {\n    margin-right: 10px;\n    color: #2196f3;\n}\n.form-group[data-v-7e9f8d94] {\n    margin-bottom: 20px;\n}\n.form-group[data-v-7e9f8d94]:last-child {\n    margin-bottom: 0;\n}\n.form-group label[data-v-7e9f8d94] {\n    display: block;\n    margin-bottom: 8px;\n    font-weight: 500;\n}\n.form-control[data-v-7e9f8d94] {\n    width: 100%;\n    padding: 10px 15px;\n    border: 1px solid #ddd;\n    border-radius: 8px;\n    font-size: 14px;\n}\n.form-control[data-v-7e9f8d94]:focus {\n    outline: none;\n    border-color: #2196f3;\n}\n.checkbox-label[data-v-7e9f8d94] {\n    display: flex;\n    align-items: center;\n    gap: 10px;\n    cursor: pointer;\n    font-weight: normal !important;\n}\n.checkbox-label input[type=\"checkbox\"][data-v-7e9f8d94] {\n    width: 18px;\n    height: 18px;\n    cursor: pointer;\n    flex-shrink: 0;\n}\n.text-muted[data-v-7e9f8d94] {\n    display: block;\n    margin-top: 5px;\n    font-size: 12px;\n    color: #888;\n}\n\n/* Payment Methods Grid */\n.payment-methods-grid[data-v-7e9f8d94] {\n    display: grid;\n    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));\n    gap: 10px;\n}\n.payment-method-option[data-v-7e9f8d94] {\n    cursor: pointer;\n}\n.payment-method-option input[data-v-7e9f8d94] {\n    display: none;\n}\n.method-box[data-v-7e9f8d94] {\n    display: flex;\n    flex-direction: column;\n    align-items: center;\n    padding: 15px;\n    border: 2px solid #e0e0e0;\n    border-radius: 8px;\n    transition: all 0.2s;\n}\n.payment-method-option input:checked + .method-box[data-v-7e9f8d94] {\n    border-color: #2196f3;\n    background: #e3f2fd;\n}\n.method-box i[data-v-7e9f8d94] {\n    font-size: 24px;\n    margin-bottom: 8px;\n    color: #666;\n}\n.payment-method-option input:checked + .method-box i[data-v-7e9f8d94] {\n    color: #2196f3;\n}\n\n/* Shortcuts Table */\n.shortcuts-table[data-v-7e9f8d94] {\n    display: grid;\n    gap: 10px;\n}\n.shortcut-row[data-v-7e9f8d94] {\n    display: flex;\n    align-items: center;\n    gap: 15px;\n    padding: 10px;\n    background: #f5f5f5;\n    border-radius: 8px;\n}\n.shortcut-key[data-v-7e9f8d94] {\n    display: inline-block;\n    padding: 5px 12px;\n    background: white;\n    border: 1px solid #ddd;\n    border-radius: 4px;\n    font-family: monospace;\n    font-weight: 600;\n    min-width: 60px;\n    text-align: center;\n}\n.shortcut-action[data-v-7e9f8d94] {\n    color: #666;\n}\n\n/* Actions */\n.settings-actions[data-v-7e9f8d94] {\n    display: flex;\n    justify-content: flex-end;\n    gap: 10px;\n    padding-top: 20px;\n    border-top: 1px solid #e0e0e0;\n}\n\n/* Loading */\n.loading-state[data-v-7e9f8d94] {\n    text-align: center;\n    padding: 60px;\n    color: #888;\n}\n.loading-state i[data-v-7e9f8d94] {\n    font-size: 32px;\n    margin-bottom: 10px;\n}\n\n/* ============================================\n   MOBILE RESPONSIVE STYLES\n============================================ */\n\n/* Tablet and below */\n@media (max-width: 768px) {\n.pos-settings-page[data-v-7e9f8d94] {\n        padding: 15px;\n}\n.page-header[data-v-7e9f8d94] {\n        flex-direction: column;\n        gap: 15px;\n        align-items: flex-start;\n}\n.page-header h2[data-v-7e9f8d94] {\n        font-size: 20px;\n}\n.page-header .btn[data-v-7e9f8d94] {\n        width: 100%;\n        justify-content: center;\n        min-height: 44px;\n}\n.settings-card[data-v-7e9f8d94] {\n        padding: 15px;\n}\n.settings-card h4[data-v-7e9f8d94] {\n        font-size: 16px;\n}\n.payment-methods-grid[data-v-7e9f8d94] {\n        grid-template-columns: repeat(2, 1fr);\n}\n.settings-actions[data-v-7e9f8d94] {\n        flex-direction: column-reverse;\n}\n.settings-actions .btn[data-v-7e9f8d94] {\n        width: 100%;\n        min-height: 48px;\n}\n}\n\n/* Mobile phones */\n@media (max-width: 480px) {\n.pos-settings-page[data-v-7e9f8d94] {\n        padding: 10px;\n        max-width: 100%;\n}\n.page-header h2[data-v-7e9f8d94] {\n        font-size: 18px;\n}\n.page-header h2 i[data-v-7e9f8d94] {\n        font-size: 16px;\n}\n.settings-container[data-v-7e9f8d94] {\n        gap: 15px;\n}\n.settings-card[data-v-7e9f8d94] {\n        padding: 12px;\n        border-radius: 8px;\n}\n.settings-card h4[data-v-7e9f8d94] {\n        font-size: 15px;\n        margin-bottom: 15px;\n}\n.settings-card h4 i[data-v-7e9f8d94] {\n        margin-right: 8px;\n}\n.form-group[data-v-7e9f8d94] {\n        margin-bottom: 15px;\n}\n.form-group label[data-v-7e9f8d94] {\n        font-size: 14px;\n}\n.form-control[data-v-7e9f8d94] {\n        padding: 12px;\n        font-size: 16px; /* Prevents zoom on iOS */\n}\n.checkbox-label[data-v-7e9f8d94] {\n        font-size: 14px;\n}\n.checkbox-label input[type=\"checkbox\"][data-v-7e9f8d94] {\n        width: 20px;\n        height: 20px;\n}\n.text-muted[data-v-7e9f8d94] {\n        font-size: 11px;\n}\n\n    /* Payment Methods - Single column on small screens */\n.payment-methods-grid[data-v-7e9f8d94] {\n        grid-template-columns: 1fr;\n        gap: 12px;\n}\n.method-box[data-v-7e9f8d94] {\n        flex-direction: row;\n        justify-content: flex-start;\n        gap: 12px;\n        padding: 12px;\n}\n.method-box i[data-v-7e9f8d94] {\n        font-size: 20px;\n        margin-bottom: 0;\n}\n\n    /* Shortcuts - Better mobile layout */\n.shortcuts-table[data-v-7e9f8d94] {\n        gap: 8px;\n}\n.shortcut-row[data-v-7e9f8d94] {\n        flex-direction: column;\n        align-items: flex-start;\n        gap: 8px;\n        padding: 12px;\n}\n.shortcut-key[data-v-7e9f8d94] {\n        padding: 6px 12px;\n        font-size: 13px;\n        min-width: auto;\n}\n.shortcut-action[data-v-7e9f8d94] {\n        font-size: 13px;\n        padding-left: 0;\n}\n\n    /* Action buttons */\n.settings-actions[data-v-7e9f8d94] {\n        padding-top: 15px;\n        gap: 10px;\n}\n.settings-actions .btn[data-v-7e9f8d94] {\n        font-size: 15px;\n        padding: 14px 20px;\n}\n}\n\n/* Very small phones */\n@media (max-width: 360px) {\n.pos-settings-page[data-v-7e9f8d94] {\n        padding: 8px;\n}\n.page-header h2[data-v-7e9f8d94] {\n        font-size: 16px;\n}\n.settings-card[data-v-7e9f8d94] {\n        padding: 10px;\n}\n.settings-card h4[data-v-7e9f8d94] {\n        font-size: 14px;\n}\n.form-control[data-v-7e9f8d94] {\n        padding: 10px;\n        font-size: 14px;\n}\n.method-box[data-v-7e9f8d94] {\n        padding: 10px;\n}\n}\n\n/* Landscape mode for tablets */\n@media (max-width: 1024px) and (orientation: landscape) {\n.payment-methods-grid[data-v-7e9f8d94] {\n        grid-template-columns: repeat(4, 1fr);\n}\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_style_index_0_id_7e9f8d94_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_style_index_0_id_7e9f8d94_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_style_index_0_id_7e9f8d94_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/pages/pos/PosSettings.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSettings.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PosSettings_vue_vue_type_template_id_7e9f8d94_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true& */ "./resources/js/components/pages/pos/PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true&");
/* harmony import */ var _PosSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PosSettings.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/pos/PosSettings.vue?vue&type=script&lang=js&");
/* harmony import */ var _PosSettings_vue_vue_type_style_index_0_id_7e9f8d94_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css& */ "./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PosSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PosSettings_vue_vue_type_template_id_7e9f8d94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PosSettings_vue_vue_type_template_id_7e9f8d94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "7e9f8d94",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/pos/PosSettings.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/pos/PosSettings.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSettings.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSettings.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/pos/PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_template_id_7e9f8d94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_template_id_7e9f8d94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_template_id_7e9f8d94_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=template&id=7e9f8d94&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSettings_vue_vue_type_style_index_0_id_7e9f8d94_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSettings.vue?vue&type=style&index=0&id=7e9f8d94&scoped=true&lang=css&");


/***/ })

}]);