"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_pos_PosSalesHistory_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************/
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
  name: 'PosSalesHistory',
  data: function data() {
    return {
      loading: true,
      sales: [],
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 20,
        total: 0
      },
      filters: {
        status: '',
        from_date: '',
        to_date: ''
      },
      summary: {
        total_sales: 0,
        revenue_by_currency: {},
        average_by_currency: {},
        total_items: 0
      },
      showDetailModal: false,
      selectedSale: null,
      isMobileView: false
    };
  },
  computed: {
    isMobile: function isMobile() {
      return this.isMobileView;
    }
  },
  methods: {
    loadSales: function loadSales() {
      var _arguments = arguments,
        _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page, params, response, data;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
              _this.loading = true;
              _context.prev = 2;
              // Build params, excluding empty filter values
              params = {
                page: page,
                per_page: _this.pagination.per_page
              }; // Only add filters if they have values
              if (_this.filters.status) {
                params.status = _this.filters.status;
              }
              if (_this.filters.from_date) {
                params.from_date = _this.filters.from_date;
              }
              if (_this.filters.to_date) {
                params.to_date = _this.filters.to_date;
              }
              _context.next = 9;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/pos/sales', {
                params: params
              });
            case 9:
              response = _context.sent;
              data = response.data.data;
              _this.sales = data.data || [];
              _this.pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                per_page: data.per_page,
                total: data.total
              };
              _this.calculateSummary();
              _context.next = 19;
              break;
            case 16:
              _context.prev = 16;
              _context.t0 = _context["catch"](2);
              console.error('Failed to load sales:', _context.t0);
            case 19:
              _context.prev = 19;
              _this.loading = false;
              return _context.finish(19);
            case 22:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 16, 19, 22]]);
      }))();
    },
    calculateSummary: function calculateSummary() {
      var completedSales = this.sales.filter(function (s) {
        return s.status === 'completed';
      });
      var revenueMap = {};
      var countMap = {};
      completedSales.forEach(function (s) {
        var cur = (s.currency || 'IQD').toUpperCase();
        var amount = parseFloat(s.total_amount || 0);
        revenueMap[cur] = (revenueMap[cur] || 0) + amount;
        countMap[cur] = (countMap[cur] || 0) + 1;
      });
      var averageMap = {};
      for (var cur in revenueMap) {
        averageMap[cur] = revenueMap[cur] / countMap[cur];
      }
      this.summary = {
        total_sales: completedSales.length,
        revenue_by_currency: revenueMap,
        average_by_currency: averageMap,
        total_items: completedSales.reduce(function (sum, s) {
          var _s$items;
          return sum + (((_s$items = s.items) === null || _s$items === void 0 ? void 0 : _s$items.length) || 0);
        }, 0)
      };
    },
    goToPage: function goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.loadSales(page);
      }
    },
    clearFilters: function clearFilters() {
      this.filters = {
        status: '',
        from_date: '',
        to_date: ''
      };
      this.loadSales();
    },
    viewSale: function viewSale(sale) {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var response;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              _context2.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get("/dashboard/api/pos/sales/".concat(sale.id));
            case 3:
              response = _context2.sent;
              _this2.selectedSale = response.data.data;
              _this2.showDetailModal = true;
              _context2.next = 11;
              break;
            case 8:
              _context2.prev = 8;
              _context2.t0 = _context2["catch"](0);
              console.error('Failed to load sale details:', _context2.t0);
            case 11:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[0, 8]]);
      }))();
    },
    printReceipt: function printReceipt(sale) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var response, printWindow;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.prev = 0;
              _context3.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get("/dashboard/api/pos/print/".concat(sale.id, "/html"), {
                responseType: 'text'
              });
            case 3:
              response = _context3.sent;
              printWindow = window.open('', '_blank');
              printWindow.document.write(response.data);
              printWindow.document.close();
              printWindow.print();
              _context3.next = 13;
              break;
            case 10:
              _context3.prev = 10;
              _context3.t0 = _context3["catch"](0);
              console.error('Failed to print receipt:', _context3.t0);
            case 13:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[0, 10]]);
      }))();
    },
    formatCurrency: function formatCurrency(amount) {
      var value = amount || 0;
      var hasDecimals = value % 1 !== 0;
      var formattedNumber = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: hasDecimals ? 1 : 0,
        maximumFractionDigits: hasDecimals ? 2 : 0
      }).format(value);

      // Get currency from window.currency (set globally in master.blade.php)
      var currency = window.currencyName || 'IQD';
      return "".concat(formattedNumber, " ").concat(currency);
    },
    formatDate: function formatDate(dateString) {
      if (!dateString) return '-';
      return new Date(dateString).toLocaleDateString();
    },
    formatDateTime: function formatDateTime(dateString) {
      if (!dateString) return '-';
      return new Date(dateString).toLocaleString();
    },
    getMethodLabel: function getMethodLabel(method) {
      var labels = {
        cash: 'نقدي',
        card: 'بطاقة',
        wallet: 'محفظة',
        bank_transfer: 'تحويل بنكي'
      };
      return labels[method] || method;
    },
    checkMobileView: function checkMobileView() {
      this.isMobileView = window.innerWidth <= 480;
    }
  },
  mounted: function mounted() {
    // Load all sales without date filter
    this.loadSales();

    // Check mobile view on mount and window resize
    this.checkMobileView();
    window.addEventListener('resize', this.checkMobileView);
  },
  beforeUnmount: function beforeUnmount() {
    window.removeEventListener('resize', this.checkMobileView);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$selectedSale, _vm$selectedSale$paym;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "pos-history-page"
  }, [_c("div", {
    staticClass: "page-header"
  }, [_vm._m(0), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-primary",
    attrs: {
      to: "/dashboard/pos"
    }
  }, [_c("i", {
    staticClass: "fas fa-cash-register"
  }), _vm._v(" فتح نقطة البيع\n        ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "filters-card"
  }, [_c("div", {
    staticClass: "filters-row"
  }, [_c("div", {
    staticClass: "filter-group"
  }, [_c("label", [_vm._v("الحالة")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.status,
      expression: "filters.status"
    }],
    staticClass: "form-control",
    on: {
      change: [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.filters, "status", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.loadSales]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("جميع الحالات")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "completed"
    }
  }, [_vm._v("مكتملة")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "voided"
    }
  }, [_vm._v("ملغاة")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "parked"
    }
  }, [_vm._v("مؤجلة")])])]), _vm._v(" "), _c("div", {
    staticClass: "filter-group"
  }, [_c("label", [_vm._v("من تاريخ")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.from_date,
      expression: "filters.from_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.filters.from_date
    },
    on: {
      change: _vm.loadSales,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.filters, "from_date", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "filter-group"
  }, [_c("label", [_vm._v("إلى تاريخ")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.to_date,
      expression: "filters.to_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.filters.to_date
    },
    on: {
      change: _vm.loadSales,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.filters, "to_date", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "filter-group"
  }, [_c("label", [_vm._v(" ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-secondary",
    on: {
      click: _vm.clearFilters
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  }), _vm._v(" مسح\n                ")])])])]), _vm._v(" "), !_vm.loading ? _c("div", {
    staticClass: "summary-cards"
  }, [_c("div", {
    staticClass: "summary-card"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "summary-info"
  }, [_c("div", {
    staticClass: "summary-value"
  }, [_vm._v(_vm._s(_vm.summary.total_sales))]), _vm._v(" "), _c("div", {
    staticClass: "summary-label"
  }, [_vm._v("إجمالي المبيعات")])])]), _vm._v(" "), _c("div", {
    staticClass: "summary-card"
  }, [_vm._m(2), _vm._v(" "), _c("div", {
    staticClass: "summary-info"
  }, [_c("div", {
    staticClass: "summary-label"
  }, [_vm._v("إجمالي الإيرادات")]), _vm._v(" "), Object.keys(_vm.summary.revenue_by_currency).length ? _vm._l(_vm.summary.revenue_by_currency, function (amount, currency) {
    return _c("div", {
      key: currency,
      staticClass: "summary-value summary-currency-row"
    }, [_vm._v("\n                        " + _vm._s(amount.toLocaleString("en-US", {
      minimumFractionDigits: amount % 1 ? 2 : 0,
      maximumFractionDigits: 2
    })) + "\n                        "), _c("span", {
      staticClass: "currency-tag"
    }, [_vm._v(_vm._s(currency))])]);
  }) : _c("div", {
    staticClass: "summary-value"
  }, [_vm._v("0")])], 2)]), _vm._v(" "), _c("div", {
    staticClass: "summary-card"
  }, [_vm._m(3), _vm._v(" "), _c("div", {
    staticClass: "summary-info"
  }, [_c("div", {
    staticClass: "summary-value"
  }, [_vm._v(_vm._s(_vm.summary.total_items))]), _vm._v(" "), _c("div", {
    staticClass: "summary-label"
  }, [_vm._v("الأصناف المباعة")])])]), _vm._v(" "), _c("div", {
    staticClass: "summary-card"
  }, [_vm._m(4), _vm._v(" "), _c("div", {
    staticClass: "summary-info"
  }, [_c("div", {
    staticClass: "summary-label"
  }, [_vm._v("متوسط البيع")]), _vm._v(" "), Object.keys(_vm.summary.average_by_currency).length ? _vm._l(_vm.summary.average_by_currency, function (amount, currency) {
    return _c("div", {
      key: currency,
      staticClass: "summary-value summary-currency-row"
    }, [_vm._v("\n                        " + _vm._s(amount.toLocaleString("en-US", {
      minimumFractionDigits: amount % 1 ? 2 : 0,
      maximumFractionDigits: 2
    })) + "\n                        "), _c("span", {
      staticClass: "currency-tag"
    }, [_vm._v(_vm._s(currency))])]);
  }) : _c("div", {
    staticClass: "summary-value"
  }, [_vm._v("0")])], 2)])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "sales-table-card"
  }, [_vm.loading ? _c("div", {
    staticClass: "loading-state"
  }, [_c("i", {
    staticClass: "fas fa-spinner fa-spin"
  }), _vm._v(" جاري تحميل المبيعات...\n        ")]) : _vm.sales.length === 0 ? _c("div", {
    staticClass: "empty-state"
  }, [_c("i", {
    staticClass: "fas fa-receipt"
  }), _vm._v(" "), _c("p", [_vm._v("لم يتم العثور على مبيعات")])]) : !_vm.isMobile ? _c("table", {
    staticClass: "sales-table"
  }, [_vm._m(5), _vm._v(" "), _c("tbody", _vm._l(_vm.sales, function (sale) {
    var _sale$customer, _sale$items;
    return _c("tr", {
      key: sale.id,
      on: {
        click: function click($event) {
          return _vm.viewSale(sale);
        }
      }
    }, [_c("td", {
      staticClass: "sale-number"
    }, [_vm._v(_vm._s(sale.sale_number))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatDate(sale.created_at)))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(((_sale$customer = sale.customer) === null || _sale$customer === void 0 ? void 0 : _sale$customer.customer_name) || "-"))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(((_sale$items = sale.items) === null || _sale$items === void 0 ? void 0 : _sale$items.length) || 0))]), _vm._v(" "), _c("td", {
      staticClass: "sale-total"
    }, [_vm._v(_vm._s(_vm.formatCurrency(sale.total_amount)))]), _vm._v(" "), _c("td", [_c("span", {
      staticClass: "status-badge",
      "class": sale.status
    }, [_vm._v("\n                            " + _vm._s(sale.status) + "\n                        ")])]), _vm._v(" "), _c("td", {
      staticClass: "actions"
    }, [_c("button", {
      staticClass: "btn-action",
      attrs: {
        title: "عرض"
      },
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.viewSale(sale);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-eye"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn-action",
      attrs: {
        title: "طباعة"
      },
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.printReceipt(sale);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-print"
    })])])]);
  }), 0)]) : _c("div", {
    staticClass: "sales-cards-mobile"
  }, _vm._l(_vm.sales, function (sale) {
    var _sale$customer2, _sale$items2;
    return _c("div", {
      key: sale.id,
      staticClass: "sale-card-mobile",
      on: {
        click: function click($event) {
          return _vm.viewSale(sale);
        }
      }
    }, [_c("div", {
      staticClass: "sale-card-header"
    }, [_c("span", {
      staticClass: "sale-number-mobile"
    }, [_vm._v(_vm._s(sale.sale_number))]), _vm._v(" "), _c("span", {
      staticClass: "status-badge",
      "class": sale.status
    }, [_vm._v("\n                        " + _vm._s(sale.status) + "\n                    ")])]), _vm._v(" "), _c("div", {
      staticClass: "sale-card-body"
    }, [_c("div", {
      staticClass: "sale-card-row"
    }, [_c("span", {
      staticClass: "label"
    }, [_vm._v("التاريخ:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatDate(sale.created_at)))])]), _vm._v(" "), _c("div", {
      staticClass: "sale-card-row"
    }, [_c("span", {
      staticClass: "label"
    }, [_vm._v("العميل:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(((_sale$customer2 = sale.customer) === null || _sale$customer2 === void 0 ? void 0 : _sale$customer2.customer_name) || "-"))])]), _vm._v(" "), _c("div", {
      staticClass: "sale-card-row"
    }, [_c("span", {
      staticClass: "label"
    }, [_vm._v("الأصناف:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(((_sale$items2 = sale.items) === null || _sale$items2 === void 0 ? void 0 : _sale$items2.length) || 0))])]), _vm._v(" "), _c("div", {
      staticClass: "sale-card-row total-row-mobile"
    }, [_c("span", {
      staticClass: "label"
    }, [_vm._v("الإجمالي:")]), _vm._v(" "), _c("span", {
      staticClass: "sale-total-mobile"
    }, [_vm._v(_vm._s(_vm.formatCurrency(sale.total_amount)))])])]), _vm._v(" "), _c("div", {
      staticClass: "sale-card-actions"
    }, [_c("button", {
      staticClass: "btn-action-mobile",
      attrs: {
        title: "عرض"
      },
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.viewSale(sale);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-eye"
    }), _vm._v(" عرض\n                    ")]), _vm._v(" "), _c("button", {
      staticClass: "btn-action-mobile",
      attrs: {
        title: "طباعة"
      },
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.printReceipt(sale);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-print"
    }), _vm._v(" طباعة\n                    ")])])]);
  }), 0), _vm._v(" "), _vm.pagination.last_page > 1 ? _c("div", {
    staticClass: "pagination"
  }, [_c("button", {
    staticClass: "page-btn",
    attrs: {
      disabled: _vm.pagination.current_page <= 1
    },
    on: {
      click: function click($event) {
        return _vm.goToPage(_vm.pagination.current_page - 1);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-chevron-left"
  })]), _vm._v(" "), _c("span", {
    staticClass: "page-info"
  }, [_vm._v("\n                صفحة " + _vm._s(_vm.pagination.current_page) + " من " + _vm._s(_vm.pagination.last_page) + "\n            ")]), _vm._v(" "), _c("button", {
    staticClass: "page-btn",
    attrs: {
      disabled: _vm.pagination.current_page >= _vm.pagination.last_page
    },
    on: {
      click: function click($event) {
        return _vm.goToPage(_vm.pagination.current_page + 1);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-chevron-right"
  })])]) : _vm._e()]), _vm._v(" "), _vm.showDetailModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        _vm.showDetailModal = false;
      }
    }
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v("تفاصيل البيع - " + _vm._s((_vm$selectedSale = _vm.selectedSale) === null || _vm$selectedSale === void 0 ? void 0 : _vm$selectedSale.sale_number))]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: function click($event) {
        _vm.showDetailModal = false;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _vm.selectedSale ? _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "detail-section"
  }, [_c("div", {
    staticClass: "detail-row"
  }, [_c("span", [_vm._v("التاريخ:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatDateTime(_vm.selectedSale.created_at)))])]), _vm._v(" "), _c("div", {
    staticClass: "detail-row"
  }, [_c("span", [_vm._v("الحالة:")]), _vm._v(" "), _c("span", {
    staticClass: "status-badge",
    "class": _vm.selectedSale.status
  }, [_vm._v("\n                            " + _vm._s(_vm.selectedSale.status) + "\n                        ")])]), _vm._v(" "), _vm.selectedSale.customer ? _c("div", {
    staticClass: "detail-row"
  }, [_c("span", [_vm._v("العميل:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.selectedSale.customer.customer_name))])]) : _vm._e(), _vm._v(" "), _vm.selectedSale.created_by ? _c("div", {
    staticClass: "detail-row"
  }, [_c("span", [_vm._v("الكاشير:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.selectedSale.created_by.name))])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "items-section"
  }, [_c("h6", [_vm._v("الأصناف")]), _vm._v(" "), !_vm.isMobile ? _c("table", {
    staticClass: "items-table"
  }, [_vm._m(6), _vm._v(" "), _c("tbody", _vm._l(_vm.selectedSale.items, function (item) {
    return _c("tr", {
      key: item.id
    }, [_c("td", [_vm._v("\n                                    " + _vm._s(item.product_name) + "\n                                    "), item.variation_name ? _c("span", {
      staticClass: "variation"
    }, [_vm._v("\n                                        (" + _vm._s(item.variation_name) + ")\n                                    ")]) : _vm._e()]), _vm._v(" "), _c("td", [_vm._v(_vm._s(item.quantity))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(item.unit_price)))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(item.line_total)))])]);
  }), 0)]) : _c("div", {
    staticClass: "items-cards-mobile"
  }, _vm._l(_vm.selectedSale.items, function (item) {
    return _c("div", {
      key: item.id,
      staticClass: "item-card-mobile"
    }, [_c("div", {
      staticClass: "item-name-mobile"
    }, [_vm._v("\n                                " + _vm._s(item.product_name) + "\n                                "), item.variation_name ? _c("span", {
      staticClass: "variation"
    }, [_vm._v("\n                                    (" + _vm._s(item.variation_name) + ")\n                                ")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "item-details-mobile"
    }, [_c("span", [_vm._v("الكمية: " + _vm._s(item.quantity))]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(item.unit_price)))]), _vm._v(" "), _c("span", {
      staticClass: "item-total-mobile"
    }, [_vm._v(_vm._s(_vm.formatCurrency(item.line_total)))])])]);
  }), 0)]), _vm._v(" "), _c("div", {
    staticClass: "totals-section"
  }, [_c("div", {
    staticClass: "total-row"
  }, [_c("span", [_vm._v("المجموع الفرعي:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedSale.subtotal)))])]), _vm._v(" "), _vm.selectedSale.discount_value > 0 ? _c("div", {
    staticClass: "total-row"
  }, [_c("span", [_vm._v("الخصم:")]), _vm._v(" "), _c("span", {
    staticClass: "text-success"
  }, [_vm._v("-" + _vm._s(_vm.formatCurrency(_vm.selectedSale.discount_value)))])]) : _vm._e(), _vm._v(" "), _vm.selectedSale.tax_amount > 0 ? _c("div", {
    staticClass: "total-row"
  }, [_c("span", [_vm._v("الضريبة (" + _vm._s(_vm.selectedSale.tax_rate) + "%):")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedSale.tax_amount)))])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "total-row grand-total"
  }, [_c("span", [_vm._v("الإجمالي:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedSale.total_amount)))])])]), _vm._v(" "), (_vm$selectedSale$paym = _vm.selectedSale.payments) !== null && _vm$selectedSale$paym !== void 0 && _vm$selectedSale$paym.length ? _c("div", {
    staticClass: "payments-section"
  }, [_c("h6", [_vm._v("المدفوعات")]), _vm._v(" "), _vm._l(_vm.selectedSale.payments, function (payment) {
    return _c("div", {
      key: payment.id,
      staticClass: "payment-row"
    }, [_c("span", [_vm._v(_vm._s(_vm.getMethodLabel(payment.payment_method)))]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(payment.amount)))])]);
  }), _vm._v(" "), _vm.selectedSale.change_amount > 0 ? _c("div", {
    staticClass: "payment-row"
  }, [_c("span", [_vm._v("الباقي:")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedSale.change_amount)))])]) : _vm._e()], 2) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    on: {
      click: function click($event) {
        return _vm.printReceipt(_vm.selectedSale);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-print"
  }), _vm._v(" طباعة الإيصال\n                ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    on: {
      click: function click($event) {
        _vm.showDetailModal = false;
      }
    }
  }, [_vm._v("\n                    إغلاق\n                ")])])])]) : _vm._e()]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("h2", [_c("i", {
    staticClass: "fas fa-history"
  }), _vm._v(" سجل مبيعات نقطة البيع")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "summary-icon"
  }, [_c("i", {
    staticClass: "fas fa-shopping-cart"
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "summary-icon revenue"
  }, [_c("i", {
    staticClass: "fas fa-dollar-sign"
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "summary-icon items"
  }, [_c("i", {
    staticClass: "fas fa-box"
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "summary-icon avg"
  }, [_c("i", {
    staticClass: "fas fa-chart-line"
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("رقم البيع")]), _vm._v(" "), _c("th", [_vm._v("التاريخ")]), _vm._v(" "), _c("th", [_vm._v("العميل")]), _vm._v(" "), _c("th", [_vm._v("الأصناف")]), _vm._v(" "), _c("th", [_vm._v("الإجمالي")]), _vm._v(" "), _c("th", [_vm._v("الحالة")]), _vm._v(" "), _c("th", [_vm._v("الإجراءات")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("المنتج")]), _vm._v(" "), _c("th", [_vm._v("الكمية")]), _vm._v(" "), _c("th", [_vm._v("السعر")]), _vm._v(" "), _c("th", [_vm._v("الإجمالي")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.summary-currency-row[data-v-a8766a0a] {\n    display: flex;\n    align-items: baseline;\n    gap: 4px;\n    line-height: 1.4;\n}\n.currency-tag[data-v-a8766a0a] {\n    font-size: 11px;\n    font-weight: 600;\n    opacity: 0.7;\n    letter-spacing: 0.5px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_style_index_0_id_a8766a0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_style_index_0_id_a8766a0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_style_index_0_id_a8766a0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/pages/pos/PosSalesHistory.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSalesHistory.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PosSalesHistory_vue_vue_type_template_id_a8766a0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true& */ "./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true&");
/* harmony import */ var _PosSalesHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PosSalesHistory.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=script&lang=js&");
/* harmony import */ var _PosSalesHistory_vue_vue_type_style_index_0_id_a8766a0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css& */ "./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PosSalesHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PosSalesHistory_vue_vue_type_template_id_a8766a0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PosSalesHistory_vue_vue_type_template_id_a8766a0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "a8766a0a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/pos/PosSalesHistory.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSalesHistory.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_template_id_a8766a0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_template_id_a8766a0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_template_id_a8766a0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=template&id=a8766a0a&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosSalesHistory_vue_vue_type_style_index_0_id_a8766a0a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosSalesHistory.vue?vue&type=style&index=0&id=a8766a0a&scoped=true&lang=css&");


/***/ })

}]);