"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_pos_PosMain_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'PosMain',
  data: function data() {
    return {
      // Online status
      isOnline: navigator.onLine,
      // Settings
      settings: {
        tax_rate: 0,
        payment_methods: ['cash', 'card', 'wallet', 'bank_transfer']
      },
      // Products
      products: [],
      searchQuery: '',
      loading: false,
      searchTimeout: null,
      // Selected product for variation
      selectedProduct: null,
      showVariationModal: false,
      // Multi-cart support
      carts: [this.createEmptyCart()],
      currentCartIndex: 0,
      // Cart item selection
      selectedItemIndex: -1,
      // Customer
      showCustomerModal: false,
      customerSearch: '',
      customers: [],
      newCustomer: {
        customer_name: '',
        phone1: ''
      },
      // Discount
      showDiscountModal: false,
      discountTarget: 'sale',
      // 'sale' or 'item'
      discountItemIndex: -1,
      discountForm: {
        type: 'percentage',
        amount: 0
      },
      // Payment
      showPaymentModal: false,
      selectedPaymentMethod: 'cash',
      paymentAmount: 0,
      paymentReference: '',
      payments: [],
      // Parked sales
      showParkedModal: false,
      parkedSales: [],
      // Completed sale
      showReceiptModal: false,
      completedSale: null
    };
  },
  computed: {
    currentCart: function currentCart() {
      return this.carts[this.currentCartIndex];
    },
    parkedSalesCount: function parkedSalesCount() {
      return this.parkedSales.length;
    },
    availablePaymentMethods: function availablePaymentMethods() {
      var _this = this;
      var methods = [{
        value: 'cash',
        label: 'نقدي',
        icon: 'fas fa-money-bill-wave'
      }, {
        value: 'card',
        label: 'بطاقة',
        icon: 'fas fa-credit-card'
      }, {
        value: 'wallet',
        label: 'محفظة',
        icon: 'fas fa-wallet'
      }, {
        value: 'bank_transfer',
        label: 'تحويل بنكي',
        icon: 'fas fa-university'
      }];
      return methods.filter(function (m) {
        var _this$settings$paymen;
        return (_this$settings$paymen = _this.settings.payment_methods) === null || _this$settings$paymen === void 0 ? void 0 : _this$settings$paymen.includes(m.value);
      });
    },
    totalPaid: function totalPaid() {
      return this.payments.reduce(function (sum, p) {
        return sum + p.amount;
      }, 0);
    },
    remainingAmount: function remainingAmount() {
      return Math.max(0, this.currentCart.total_amount - this.totalPaid);
    },
    changeAmount: function changeAmount() {
      if (this.totalPaid <= this.currentCart.total_amount) return 0;
      return this.totalPaid - this.currentCart.total_amount;
    },
    isFullyPaid: function isFullyPaid() {
      return this.totalPaid >= this.currentCart.total_amount;
    },
    canCompleteSale: function canCompleteSale() {
      return this.payments.length > 0 && this.totalPaid >= this.currentCart.total_amount;
    },
    quickAmounts: function quickAmounts() {
      var total = this.remainingAmount > 0 ? this.remainingAmount : this.currentCart.total_amount;
      var amounts = [total];
      var denominations = [5, 10, 20, 50, 100, 200, 500, 1000];
      for (var _i = 0, _denominations = denominations; _i < _denominations.length; _i++) {
        var denom = _denominations[_i];
        if (denom > total && amounts.length < 6) {
          amounts.push(denom);
        }
      }
      return _toConsumableArray(new Set(amounts)).slice(0, 6);
    }
  },
  methods: {
    createEmptyCart: function createEmptyCart() {
      return {
        id: null,
        customer: null,
        items: [],
        subtotal: 0,
        discount_type: null,
        discount_amount: 0,
        discount_value: 0,
        tax_rate: 0,
        tax_amount: 0,
        total_amount: 0
      };
    },
    formatCurrency: function formatCurrency(amount) {
      return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(amount || 0);
    },
    // Initialize
    initialize: function initialize() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response, drafts;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/pos/initialize');
            case 3:
              response = _context.sent;
              _this2.settings = response.data.data.settings;
              _this2.parkedSales = response.data.data.parked_sales || [];

              // Load draft sales as carts
              drafts = response.data.data.draft_sales || [];
              if (drafts.length > 0) {
                _this2.carts = drafts.map(function (draft) {
                  return _this2.saleToCart(draft);
                });
              }

              // Fetch products on load
              _context.next = 10;
              return _this2.fetchAllProducts();
            case 10:
              _context.next = 15;
              break;
            case 12:
              _context.prev = 12;
              _context.t0 = _context["catch"](0);
              console.error('Failed to initialize POS:', _context.t0);
            case 15:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 12]]);
      }))();
    },
    saleToCart: function saleToCart(sale) {
      return {
        id: sale.id,
        customer: sale.customer,
        items: sale.items || [],
        subtotal: parseFloat(sale.subtotal) || 0,
        discount_type: sale.discount_type,
        discount_amount: parseFloat(sale.discount_amount) || 0,
        discount_value: parseFloat(sale.discount_value) || 0,
        tax_rate: parseFloat(sale.tax_rate) || 0,
        tax_amount: parseFloat(sale.tax_amount) || 0,
        total_amount: parseFloat(sale.total_amount) || 0
      };
    },
    // Fetch all products
    fetchAllProducts: function fetchAllProducts() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var response;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this3.loading = true;
              _context2.prev = 1;
              _context2.next = 4;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/get-product-list', {
                params: {
                  page: 1
                }
              });
            case 4:
              response = _context2.sent;
              // Extract products from paginated response
              _this3.products = response.data.data || [];
              _context2.next = 11;
              break;
            case 8:
              _context2.prev = 8;
              _context2.t0 = _context2["catch"](1);
              console.error('Failed to fetch products:', _context2.t0);
            case 11:
              _context2.prev = 11;
              _this3.loading = false;
              return _context2.finish(11);
            case 14:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[1, 8, 11, 14]]);
      }))();
    },
    // Product search
    searchProducts: function searchProducts() {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              clearTimeout(_this4.searchTimeout);
              if (!(!_this4.searchQuery || _this4.searchQuery.length < 1)) {
                _context4.next = 4;
                break;
              }
              _this4.fetchAllProducts();
              return _context4.abrupt("return");
            case 4:
              _this4.searchTimeout = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
                var response;
                return _regeneratorRuntime().wrap(function _callee3$(_context3) {
                  while (1) switch (_context3.prev = _context3.next) {
                    case 0:
                      _this4.loading = true;
                      _context3.prev = 1;
                      _context3.next = 4;
                      return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/get-product-list', {
                        params: {
                          search: _this4.searchQuery,
                          page: 1
                        }
                      });
                    case 4:
                      response = _context3.sent;
                      _this4.products = response.data.data || [];
                      _context3.next = 12;
                      break;
                    case 8:
                      _context3.prev = 8;
                      _context3.t0 = _context3["catch"](1);
                      console.error('Search error:', _context3.t0);
                      _this4.products = [];
                    case 12:
                      _context3.prev = 12;
                      _this4.loading = false;
                      return _context3.finish(12);
                    case 15:
                    case "end":
                      return _context3.stop();
                  }
                }, _callee3, null, [[1, 8, 12, 15]]);
              })), 300);
            case 5:
            case "end":
              return _context4.stop();
          }
        }, _callee4);
      }))();
    },
    handleSearchEnter: function handleSearchEnter() {
      if (this.products.length === 1) {
        this.selectProduct(this.products[0]);
      }
    },
    clearSearch: function clearSearch() {
      var _this$$refs$searchInp;
      this.searchQuery = '';
      this.products = [];
      (_this$$refs$searchInp = this.$refs.searchInput) === null || _this$$refs$searchInp === void 0 ? void 0 : _this$$refs$searchInp.focus();
    },
    // Product selection
    selectProduct: function selectProduct(product) {
      // Check if product has variations (using variation or variations property)
      var variations = product.variation || product.variations || [];
      if (variations && variations.length > 0) {
        this.selectedProduct = _objectSpread(_objectSpread({}, product), {}, {
          variations: variations
        });
        this.showVariationModal = true;
      } else {
        this.addToCart(product, null);
      }
    },
    addVariationToCart: function addVariationToCart(variation) {
      if (variation.quantity <= 0) {
        var _this$$toast;
        (_this$$toast = this.$toast) === null || _this$$toast === void 0 ? void 0 : _this$$toast.warning('Out of stock');
        return;
      }
      this.addToCart(this.selectedProduct, variation);
      this.showVariationModal = false;
      this.selectedProduct = null;
    },
    addToCart: function addToCart(product, variation) {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
        var item, existingIndex;
        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
          while (1) switch (_context5.prev = _context5.next) {
            case 0:
              item = {
                product_id: product.id,
                product_variation_id: (variation === null || variation === void 0 ? void 0 : variation.id) || null,
                product_name: product.name,
                variation_name: (variation === null || variation === void 0 ? void 0 : variation.var_name) || null,
                unit_price: (variation === null || variation === void 0 ? void 0 : variation.price) || product.sell_price,
                quantity: 1
              }; // Check if item already in cart
              existingIndex = _this5.currentCart.items.findIndex(function (i) {
                return i.product_id === item.product_id && i.product_variation_id === item.product_variation_id;
              });
              if (existingIndex >= 0) {
                _this5.currentCart.items[existingIndex].quantity++;
                _this5.updateItemTotal(existingIndex);
              } else {
                item.line_total = item.unit_price * item.quantity;
                _this5.currentCart.items.push(item);
              }
              _this5.recalculateCart();
              _this5.clearSearch();

              // Sync with backend if cart has ID
              if (!_this5.currentCart.id) {
                _context5.next = 8;
                break;
              }
              _context5.next = 8;
              return _this5.syncCartToBackend();
            case 8:
            case "end":
              return _context5.stop();
          }
        }, _callee5);
      }))();
    },
    // Cart operations
    increaseQty: function increaseQty(index) {
      this.currentCart.items[index].quantity++;
      this.updateItemTotal(index);
      this.recalculateCart();
    },
    decreaseQty: function decreaseQty(index) {
      if (this.currentCart.items[index].quantity > 1) {
        this.currentCart.items[index].quantity--;
        this.updateItemTotal(index);
        this.recalculateCart();
      }
    },
    updateQty: function updateQty(index, value) {
      var qty = parseInt(value) || 1;
      this.currentCart.items[index].quantity = Math.max(1, qty);
      this.updateItemTotal(index);
      this.recalculateCart();
    },
    updateItemTotal: function updateItemTotal(index) {
      var item = this.currentCart.items[index];
      var subtotal = item.unit_price * item.quantity;
      var discount = 0;
      if (item.discount_type === 'percentage') {
        discount = subtotal * item.discount_amount / 100;
      } else if (item.discount_type === 'fixed') {
        discount = item.discount_amount || 0;
      }
      item.discount_value = discount;
      item.line_total = subtotal - discount;
    },
    removeItem: function removeItem(index) {
      this.currentCart.items.splice(index, 1);
      this.selectedItemIndex = -1;
      this.recalculateCart();
    },
    selectItem: function selectItem(index) {
      this.selectedItemIndex = this.selectedItemIndex === index ? -1 : index;
    },
    recalculateCart: function recalculateCart() {
      var cart = this.currentCart;

      // Subtotal
      cart.subtotal = cart.items.reduce(function (sum, item) {
        return sum + item.line_total;
      }, 0);

      // Sale discount
      if (cart.discount_type === 'percentage') {
        cart.discount_value = cart.subtotal * cart.discount_amount / 100;
      } else if (cart.discount_type === 'fixed') {
        cart.discount_value = cart.discount_amount || 0;
      } else {
        cart.discount_value = 0;
      }

      // Tax
      var taxableAmount = cart.subtotal - cart.discount_value;
      cart.tax_rate = this.settings.tax_rate || 0;
      cart.tax_amount = taxableAmount * cart.tax_rate / 100;

      // Total
      cart.total_amount = taxableAmount + cart.tax_amount;
    },
    // Multi-cart
    newCart: function newCart() {
      this.carts.push(this.createEmptyCart());
      this.currentCartIndex = this.carts.length - 1;
    },
    switchCart: function switchCart(index) {
      this.currentCartIndex = index;
      this.selectedItemIndex = -1;
    },
    closeCart: function closeCart(index) {
      if (this.carts.length <= 1) return;
      this.carts.splice(index, 1);
      if (this.currentCartIndex >= this.carts.length) {
        this.currentCartIndex = this.carts.length - 1;
      }
    },
    // Customer
    searchCustomers: function searchCustomers() {
      var _this6 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var response;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              if (!(!_this6.customerSearch || _this6.customerSearch.length < 2)) {
                _context6.next = 3;
                break;
              }
              _this6.customers = [];
              return _context6.abrupt("return");
            case 3:
              _context6.prev = 3;
              _context6.next = 6;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/pos/customers', {
                params: {
                  q: _this6.customerSearch
                }
              });
            case 6:
              response = _context6.sent;
              _this6.customers = response.data.data || [];
              _context6.next = 13;
              break;
            case 10:
              _context6.prev = 10;
              _context6.t0 = _context6["catch"](3);
              console.error('Customer search error:', _context6.t0);
            case 13:
            case "end":
              return _context6.stop();
          }
        }, _callee6, null, [[3, 10]]);
      }))();
    },
    selectCustomer: function selectCustomer(customer) {
      this.currentCart.customer = customer;
      this.showCustomerModal = false;
      this.customerSearch = '';
      this.customers = [];
    },
    createCustomer: function createCustomer() {
      var _this7 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee7() {
        var _this7$$toast, response, _this7$$toast2;
        return _regeneratorRuntime().wrap(function _callee7$(_context7) {
          while (1) switch (_context7.prev = _context7.next) {
            case 0:
              if (!(!_this7.newCustomer.customer_name || !_this7.newCustomer.phone1)) {
                _context7.next = 3;
                break;
              }
              (_this7$$toast = _this7.$toast) === null || _this7$$toast === void 0 ? void 0 : _this7$$toast.error('الاسم والهاتف مطلوبان');
              return _context7.abrupt("return");
            case 3:
              _context7.prev = 3;
              _context7.next = 6;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post('/dashboard/api/pos/customers', _this7.newCustomer);
            case 6:
              response = _context7.sent;
              _this7.selectCustomer(response.data.data);
              _this7.newCustomer = {
                customer_name: '',
                phone1: ''
              };
              _context7.next = 14;
              break;
            case 11:
              _context7.prev = 11;
              _context7.t0 = _context7["catch"](3);
              (_this7$$toast2 = _this7.$toast) === null || _this7$$toast2 === void 0 ? void 0 : _this7$$toast2.error('فشل إنشاء العميل');
            case 14:
            case "end":
              return _context7.stop();
          }
        }, _callee7, null, [[3, 11]]);
      }))();
    },
    clearCustomer: function clearCustomer() {
      this.currentCart.customer = null;
    },
    // Discount
    openItemDiscount: function openItemDiscount(index) {
      this.discountTarget = 'item';
      this.discountItemIndex = index;
      var item = this.currentCart.items[index];
      this.discountForm.type = item.discount_type || 'percentage';
      this.discountForm.amount = item.discount_amount || 0;
      this.showDiscountModal = true;
    },
    openSaleDiscount: function openSaleDiscount() {
      this.discountTarget = 'sale';
      this.discountForm.type = this.currentCart.discount_type || 'percentage';
      this.discountForm.amount = this.currentCart.discount_amount || 0;
      this.showDiscountModal = true;
    },
    applyDiscount: function applyDiscount() {
      if (this.discountTarget === 'item') {
        var item = this.currentCart.items[this.discountItemIndex];
        item.discount_type = this.discountForm.type;
        item.discount_amount = parseFloat(this.discountForm.amount) || 0;
        this.updateItemTotal(this.discountItemIndex);
      } else {
        this.currentCart.discount_type = this.discountForm.type;
        this.currentCart.discount_amount = parseFloat(this.discountForm.amount) || 0;
      }
      this.recalculateCart();
      this.showDiscountModal = false;
    },
    clearDiscount: function clearDiscount() {
      if (this.discountTarget === 'item') {
        var item = this.currentCart.items[this.discountItemIndex];
        item.discount_type = null;
        item.discount_amount = 0;
        this.updateItemTotal(this.discountItemIndex);
      } else {
        this.currentCart.discount_type = null;
        this.currentCart.discount_amount = 0;
      }
      this.recalculateCart();
      this.showDiscountModal = false;
    },
    // Payment
    openPayment: function openPayment() {
      var _this8 = this;
      this.payments = [];
      this.selectedPaymentMethod = 'cash';
      this.paymentAmount = this.currentCart.total_amount;
      this.paymentReference = '';
      this.showPaymentModal = true;
      this.$nextTick(function () {
        var _this8$$refs$paymentI;
        (_this8$$refs$paymentI = _this8.$refs.paymentInput) === null || _this8$$refs$paymentI === void 0 ? void 0 : _this8$$refs$paymentI.focus();
      });
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
    addPayment: function addPayment() {
      if (!this.paymentAmount || this.paymentAmount <= 0) return;
      this.payments.push({
        payment_method: this.selectedPaymentMethod,
        amount: this.paymentAmount,
        tendered_amount: this.selectedPaymentMethod === 'cash' ? this.paymentAmount : null,
        reference_number: this.paymentReference || null
      });
      this.paymentAmount = Math.max(0, this.remainingAmount);
      this.paymentReference = '';
    },
    removePayment: function removePayment(index) {
      this.payments.splice(index, 1);
    },
    completeSale: function completeSale() {
      var _this9 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
        var saleId, _this9$currentCart$cu, createRes, response, _this9$$toast, _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee8$(_context8) {
          while (1) switch (_context8.prev = _context8.next) {
            case 0:
              if (_this9.canCompleteSale) {
                _context8.next = 2;
                break;
              }
              return _context8.abrupt("return");
            case 2:
              _context8.prev = 2;
              // Create sale if not exists
              saleId = _this9.currentCart.id;
              if (saleId) {
                _context8.next = 9;
                break;
              }
              _context8.next = 7;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post('/dashboard/api/pos/sales', {
                customer_id: (_this9$currentCart$cu = _this9.currentCart.customer) === null || _this9$currentCart$cu === void 0 ? void 0 : _this9$currentCart$cu.id,
                items: _this9.currentCart.items
              });
            case 7:
              createRes = _context8.sent;
              saleId = createRes.data.data.id;
            case 9:
              if (!_this9.currentCart.discount_type) {
                _context8.next = 12;
                break;
              }
              _context8.next = 12;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().put("/dashboard/api/pos/sales/".concat(saleId), {
                discount_type: _this9.currentCart.discount_type,
                discount_amount: _this9.currentCart.discount_amount
              });
            case 12:
              _context8.next = 14;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post("/dashboard/api/pos/sales/".concat(saleId, "/complete"), {
                payments: _this9.payments
              });
            case 14:
              response = _context8.sent;
              _this9.completedSale = response.data.data;
              _this9.showPaymentModal = false;
              _this9.showReceiptModal = true;

              // Print if auto-print enabled
              if (_this9.settings.print_receipt_auto) {
                _this9.printReceipt();
              }
              _context8.next = 25;
              break;
            case 21:
              _context8.prev = 21;
              _context8.t0 = _context8["catch"](2);
              console.error('Failed to complete sale:', _context8.t0);
              (_this9$$toast = _this9.$toast) === null || _this9$$toast === void 0 ? void 0 : _this9$$toast.error(((_error$response = _context8.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل إتمام البيع');
            case 25:
            case "end":
              return _context8.stop();
          }
        }, _callee8, null, [[2, 21]]);
      }))();
    },
    // Park sale
    parkSale: function parkSale() {
      var _this10 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee9() {
        var _this10$$toast, saleId, _this10$currentCart$c, createRes, _this10$$toast2;
        return _regeneratorRuntime().wrap(function _callee9$(_context9) {
          while (1) switch (_context9.prev = _context9.next) {
            case 0:
              if (!(_this10.currentCart.items.length === 0)) {
                _context9.next = 2;
                break;
              }
              return _context9.abrupt("return");
            case 2:
              _context9.prev = 2;
              saleId = _this10.currentCart.id;
              if (saleId) {
                _context9.next = 9;
                break;
              }
              _context9.next = 7;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post('/dashboard/api/pos/sales', {
                customer_id: (_this10$currentCart$c = _this10.currentCart.customer) === null || _this10$currentCart$c === void 0 ? void 0 : _this10$currentCart$c.id,
                items: _this10.currentCart.items
              });
            case 7:
              createRes = _context9.sent;
              saleId = createRes.data.data.id;
            case 9:
              _context9.next = 11;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post("/dashboard/api/pos/sales/".concat(saleId, "/park"), {
                park_name: "Cart ".concat(_this10.currentCartIndex + 1)
              });
            case 11:
              _context9.next = 13;
              return _this10.loadParkedSales();
            case 13:
              // Reset current cart
              _this10.carts[_this10.currentCartIndex] = _this10.createEmptyCart();
              (_this10$$toast = _this10.$toast) === null || _this10$$toast === void 0 ? void 0 : _this10$$toast.success('تم تأجيل البيع');
              _context9.next = 21;
              break;
            case 17:
              _context9.prev = 17;
              _context9.t0 = _context9["catch"](2);
              console.error('Failed to park sale:', _context9.t0);
              (_this10$$toast2 = _this10.$toast) === null || _this10$$toast2 === void 0 ? void 0 : _this10$$toast2.error('فشل تأجيل البيع');
            case 21:
            case "end":
              return _context9.stop();
          }
        }, _callee9, null, [[2, 17]]);
      }))();
    },
    loadParkedSales: function loadParkedSales() {
      var _this11 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee10() {
        var response;
        return _regeneratorRuntime().wrap(function _callee10$(_context10) {
          while (1) switch (_context10.prev = _context10.next) {
            case 0:
              _context10.prev = 0;
              _context10.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get('/dashboard/api/pos/sales/parked');
            case 3:
              response = _context10.sent;
              _this11.parkedSales = response.data.data || [];
              _context10.next = 10;
              break;
            case 7:
              _context10.prev = 7;
              _context10.t0 = _context10["catch"](0);
              console.error('Failed to load parked sales:', _context10.t0);
            case 10:
            case "end":
              return _context10.stop();
          }
        }, _callee10, null, [[0, 7]]);
      }))();
    },
    showParkedSales: function showParkedSales() {
      this.loadParkedSales();
      this.showParkedModal = true;
    },
    resumeSale: function resumeSale(sale) {
      var _this12 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee11() {
        var _this12$$toast;
        return _regeneratorRuntime().wrap(function _callee11$(_context11) {
          while (1) switch (_context11.prev = _context11.next) {
            case 0:
              _context11.prev = 0;
              _context11.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().post("/dashboard/api/pos/sales/".concat(sale.id, "/unpark"));
            case 3:
              // Load into cart
              _this12.carts[_this12.currentCartIndex] = _this12.saleToCart(sale);

              // Remove from parked list
              _context11.next = 6;
              return _this12.loadParkedSales();
            case 6:
              _this12.showParkedModal = false;
              _context11.next = 13;
              break;
            case 9:
              _context11.prev = 9;
              _context11.t0 = _context11["catch"](0);
              console.error('Failed to resume sale:', _context11.t0);
              (_this12$$toast = _this12.$toast) === null || _this12$$toast === void 0 ? void 0 : _this12$$toast.error('فشل استعادة البيع');
            case 13:
            case "end":
              return _context11.stop();
          }
        }, _callee11, null, [[0, 9]]);
      }))();
    },
    deleteParkedSale: function deleteParkedSale(saleId) {
      var _this13 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee12() {
        return _regeneratorRuntime().wrap(function _callee12$(_context12) {
          while (1) switch (_context12.prev = _context12.next) {
            case 0:
              if (confirm('حذف هذا البيع المؤجل؟')) {
                _context12.next = 2;
                break;
              }
              return _context12.abrupt("return");
            case 2:
              _context12.prev = 2;
              _context12.next = 5;
              return axios__WEBPACK_IMPORTED_MODULE_0___default()["delete"]("/dashboard/api/pos/sales/".concat(saleId));
            case 5:
              _context12.next = 7;
              return _this13.loadParkedSales();
            case 7:
              _context12.next = 12;
              break;
            case 9:
              _context12.prev = 9;
              _context12.t0 = _context12["catch"](2);
              console.error('Failed to delete parked sale:', _context12.t0);
            case 12:
            case "end":
              return _context12.stop();
          }
        }, _callee12, null, [[2, 9]]);
      }))();
    },
    // Receipt
    printReceipt: function printReceipt() {
      var _this14 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee13() {
        var response, printWindow;
        return _regeneratorRuntime().wrap(function _callee13$(_context13) {
          while (1) switch (_context13.prev = _context13.next) {
            case 0:
              if (_this14.completedSale) {
                _context13.next = 2;
                break;
              }
              return _context13.abrupt("return");
            case 2:
              _context13.prev = 2;
              _context13.next = 5;
              return axios__WEBPACK_IMPORTED_MODULE_0___default().get("/dashboard/api/pos/print/".concat(_this14.completedSale.id, "/html"), {
                responseType: 'text'
              });
            case 5:
              response = _context13.sent;
              printWindow = window.open('', '_blank');
              printWindow.document.write(response.data);
              printWindow.document.close();
              printWindow.print();
              _context13.next = 15;
              break;
            case 12:
              _context13.prev = 12;
              _context13.t0 = _context13["catch"](2);
              console.error('Failed to print receipt:', _context13.t0);
            case 15:
            case "end":
              return _context13.stop();
          }
        }, _callee13, null, [[2, 12]]);
      }))();
    },
    closeReceipt: function closeReceipt() {
      var _this$$refs$searchInp2;
      this.showReceiptModal = false;
      this.completedSale = null;

      // Reset cart
      this.carts[this.currentCartIndex] = this.createEmptyCart();
      this.payments = [];

      // Focus search
      (_this$$refs$searchInp2 = this.$refs.searchInput) === null || _this$$refs$searchInp2 === void 0 ? void 0 : _this$$refs$searchInp2.focus();
    },
    // Sync
    syncCartToBackend: function syncCartToBackend() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee14() {
        return _regeneratorRuntime().wrap(function _callee14$(_context14) {
          while (1) switch (_context14.prev = _context14.next) {
            case 0:
            case "end":
              return _context14.stop();
          }
        }, _callee14);
      }))();
    } // Implementation for syncing cart changes
    ,
    // Keyboard shortcuts
    handleKeydown: function handleKeydown(e) {
      var _this$$refs$searchInp3;
      // Don't handle if in input
      if (['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
        if (e.key === 'Escape') {
          e.target.blur();
        }
        return;
      }
      switch (e.key) {
        case 'F1':
          e.preventDefault();
          (_this$$refs$searchInp3 = this.$refs.searchInput) === null || _this$$refs$searchInp3 === void 0 ? void 0 : _this$$refs$searchInp3.focus();
          break;
        case 'F2':
          e.preventDefault();
          this.newCart();
          break;
        case 'F3':
          e.preventDefault();
          this.switchCart((this.currentCartIndex + 1) % this.carts.length);
          break;
        case 'F4':
          e.preventDefault();
          this.parkSale();
          break;
        case 'F5':
          e.preventDefault();
          this.showParkedSales();
          break;
        case 'F8':
          e.preventDefault();
          this.openSaleDiscount();
          break;
        case 'F9':
          e.preventDefault();
          this.showCustomerModal = true;
          break;
        case 'F10':
          e.preventDefault();
          if (this.currentCart.items.length > 0) {
            this.openPayment();
          }
          break;
        case 'F12':
          e.preventDefault();
          if (this.showPaymentModal && this.canCompleteSale) {
            this.completeSale();
          } else if (this.currentCart.items.length > 0) {
            // Quick cash payment
            this.payments = [{
              payment_method: 'cash',
              amount: this.currentCart.total_amount,
              tendered_amount: this.currentCart.total_amount
            }];
            this.completeSale();
          }
          break;
        case 'Delete':
          e.preventDefault();
          if (this.selectedItemIndex >= 0) {
            this.removeItem(this.selectedItemIndex);
          }
          break;
        case 'Escape':
          this.showVariationModal = false;
          this.showCustomerModal = false;
          this.showDiscountModal = false;
          this.showPaymentModal = false;
          this.showParkedModal = false;
          break;
      }
    }
  },
  mounted: function mounted() {
    var _this15 = this,
      _this$$refs$searchInp4;
    this.initialize();

    // Online/offline detection
    window.addEventListener('online', function () {
      _this15.isOnline = true;
    });
    window.addEventListener('offline', function () {
      _this15.isOnline = false;
    });

    // Focus search on mount
    (_this$$refs$searchInp4 = this.$refs.searchInput) === null || _this$$refs$searchInp4 === void 0 ? void 0 : _this$$refs$searchInp4.focus();
  },
  beforeDestroy: function beforeDestroy() {
    window.removeEventListener('online', function () {});
    window.removeEventListener('offline', function () {});
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=template&id=dfc60568&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=template&id=dfc60568&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$completedSale, _vm$completedSale2, _vm$completedSale3, _vm$completedSale4;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "pos-container",
    on: {
      keydown: _vm.handleKeydown
    }
  }, [!_vm.isOnline ? _c("div", {
    staticClass: "offline-banner"
  }, [_c("i", {
    staticClass: "fas fa-wifi-slash"
  }), _vm._v(" وضع عدم الاتصال - سيتم مزامنة المبيعات عند الاتصال\n    ")]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "pos-topbar"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "pos-topbar-center"
  }, [_c("div", {
    staticClass: "cart-tabs"
  }, [_vm._l(_vm.carts, function (cart, index) {
    return _c("div", {
      key: cart.id || index,
      staticClass: "cart-tab",
      "class": {
        active: _vm.currentCartIndex === index
      },
      on: {
        click: function click($event) {
          return _vm.switchCart(index);
        }
      }
    }, [_c("span", [_vm._v("سلة " + _vm._s(index + 1))]), _vm._v(" "), cart.items.length ? _c("span", {
      staticClass: "item-count"
    }, [_vm._v(_vm._s(cart.items.length))]) : _vm._e(), _vm._v(" "), _vm.carts.length > 1 ? _c("button", {
      staticClass: "close-cart",
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.closeCart(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-times"
    })]) : _vm._e()]);
  }), _vm._v(" "), _c("button", {
    staticClass: "new-cart-btn",
    attrs: {
      title: "سلة جديدة (F2)"
    },
    on: {
      click: _vm.newCart
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  })])], 2)]), _vm._v(" "), _c("div", {
    staticClass: "pos-topbar-right"
  }, [_c("button", {
    staticClass: "btn btn-outline-secondary btn-sm",
    attrs: {
      title: "المبيعات المؤجلة (F5)"
    },
    on: {
      click: _vm.showParkedSales
    }
  }, [_c("i", {
    staticClass: "fas fa-pause-circle"
  }), _vm._v(" "), _vm.parkedSalesCount > 0 ? _c("span", {
    staticClass: "badge"
  }, [_vm._v(_vm._s(_vm.parkedSalesCount))]) : _vm._e()]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-outline-secondary btn-sm",
    attrs: {
      to: "/dashboard/pos/history"
    }
  }, [_c("i", {
    staticClass: "fas fa-history"
  })]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-outline-secondary btn-sm",
    attrs: {
      to: "/dashboard/pos/settings"
    }
  }, [_c("i", {
    staticClass: "fas fa-cog"
  })])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "pos-main"
  }, [_c("div", {
    staticClass: "pos-products"
  }, [_c("div", {
    staticClass: "search-section"
  }, [_c("div", {
    staticClass: "search-input-wrapper"
  }, [_c("i", {
    staticClass: "fas fa-search"
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.searchQuery,
      expression: "searchQuery"
    }],
    ref: "searchInput",
    staticClass: "search-input",
    attrs: {
      type: "text",
      placeholder: "البحث عن المنتجات أو مسح الباركود (F1)"
    },
    domProps: {
      value: _vm.searchQuery
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.searchQuery = $event.target.value;
      }, _vm.searchProducts],
      keydown: function keydown($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        return _vm.handleSearchEnter.apply(null, arguments);
      }
    }
  }), _vm._v(" "), _vm.searchQuery ? _c("button", {
    staticClass: "clear-search",
    on: {
      click: _vm.clearSearch
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "product-grid"
  }, [_vm.loading ? _c("div", {
    staticClass: "loading-state"
  }, [_c("i", {
    staticClass: "fas fa-spinner fa-spin"
  }), _vm._v(" جاري التحميل...\n                ")]) : _vm.products.length === 0 && _vm.searchQuery ? _c("div", {
    staticClass: "empty-state"
  }, [_c("i", {
    staticClass: "fas fa-search"
  }), _vm._v(" "), _c("p", [_vm._v("لم يتم العثور على منتجات")])]) : _vm.products.length === 0 ? _c("div", {
    staticClass: "empty-state"
  }, [_c("i", {
    staticClass: "fas fa-box-open"
  }), _vm._v(" "), _c("p", [_vm._v("ابحث عن المنتجات أو امسح الباركود")])]) : _vm._l(_vm.products, function (product) {
    return _c("div", {
      key: product.id,
      staticClass: "product-card",
      on: {
        click: function click($event) {
          return _vm.selectProduct(product);
        }
      }
    }, [_c("div", {
      staticClass: "product-image"
    }, [product.image ? _c("img", {
      attrs: {
        src: "/uploads/products/" + product.image,
        alt: product.name
      }
    }) : _c("i", {
      staticClass: "fas fa-box"
    })]), _vm._v(" "), _c("div", {
      staticClass: "product-info"
    }, [_c("div", {
      staticClass: "product-name",
      attrs: {
        title: product.name
      }
    }, [_vm._v(_vm._s(product.name))]), _vm._v(" "), _c("div", {
      staticClass: "product-price"
    }, [_vm._v(_vm._s(_vm.formatCurrency(product.sell_price)))]), _vm._v(" "), _c("div", {
      staticClass: "product-stock",
      "class": {
        "low-stock": product.total_stock < 10
      }
    }, [_c("i", {
      staticClass: "fas fa-box"
    }), _vm._v(" " + _vm._s(product.total_stock) + "\n                        ")])])]);
  })], 2)]), _vm._v(" "), _c("div", {
    staticClass: "pos-cart"
  }, [_c("div", {
    staticClass: "customer-section"
  }, [_vm.currentCart.customer ? _c("div", {
    staticClass: "selected-customer"
  }, [_c("i", {
    staticClass: "fas fa-user"
  }), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.currentCart.customer.customer_name))]), _vm._v(" "), _c("button", {
    staticClass: "btn-clear",
    on: {
      click: _vm.clearCustomer
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]) : _c("button", {
    staticClass: "select-customer-btn",
    on: {
      click: function click($event) {
        _vm.showCustomerModal = true;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-user-plus"
  }), _vm._v(" اختر عميل (F9)\n                ")])]), _vm._v(" "), _c("div", {
    staticClass: "cart-items"
  }, [_vm.currentCart.items.length === 0 ? _c("div", {
    staticClass: "empty-cart"
  }, [_c("i", {
    staticClass: "fas fa-shopping-cart"
  }), _vm._v(" "), _c("p", [_vm._v("السلة فارغة")]), _vm._v(" "), _c("small", [_vm._v("ابحث عن المنتجات لإضافتها")])]) : _vm._l(_vm.currentCart.items, function (item, index) {
    return _c("div", {
      key: item.id || index,
      staticClass: "cart-item",
      "class": {
        selected: _vm.selectedItemIndex === index
      },
      on: {
        click: function click($event) {
          return _vm.selectItem(index);
        }
      }
    }, [_c("div", {
      staticClass: "item-info"
    }, [_c("div", {
      staticClass: "item-name"
    }, [_vm._v("\n                            " + _vm._s(item.product_name) + "\n                            "), item.variation_name ? _c("span", {
      staticClass: "variation"
    }, [_vm._v("(" + _vm._s(item.variation_name) + ")")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "item-price"
    }, [_vm._v(_vm._s(_vm.formatCurrency(item.unit_price)))])]), _vm._v(" "), _c("div", {
      staticClass: "item-controls"
    }, [_c("button", {
      staticClass: "qty-btn",
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.decreaseQty(index);
        }
      }
    }, [_vm._v("-")]), _vm._v(" "), _c("input", {
      staticClass: "qty-input",
      attrs: {
        type: "number",
        min: "1"
      },
      domProps: {
        value: item.quantity
      },
      on: {
        change: function change($event) {
          return _vm.updateQty(index, $event.target.value);
        },
        click: function click($event) {
          $event.stopPropagation();
        }
      }
    }), _vm._v(" "), _c("button", {
      staticClass: "qty-btn",
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.increaseQty(index);
        }
      }
    }, [_vm._v("+")])]), _vm._v(" "), _c("div", {
      staticClass: "item-total"
    }, [_vm._v(_vm._s(_vm.formatCurrency(item.line_total)))]), _vm._v(" "), _c("div", {
      staticClass: "item-actions"
    }, [_c("button", {
      staticClass: "btn-discount",
      attrs: {
        title: "خصم"
      },
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.openItemDiscount(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-percent"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn-remove",
      attrs: {
        title: "حذف"
      },
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.removeItem(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])])]);
  })], 2), _vm._v(" "), _c("div", {
    staticClass: "cart-summary"
  }, [_c("div", {
    staticClass: "summary-row"
  }, [_c("span", [_vm._v("المجموع الفرعي")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.currentCart.subtotal)))])]), _vm._v(" "), _vm.currentCart.discount_value > 0 ? _c("div", {
    staticClass: "summary-row discount"
  }, [_c("span", [_vm._v("\n                        الخصم\n                        "), _c("button", {
    staticClass: "btn-edit-discount",
    on: {
      click: _vm.openSaleDiscount
    }
  }, [_c("i", {
    staticClass: "fas fa-edit"
  })])]), _vm._v(" "), _c("span", [_vm._v("-" + _vm._s(_vm.formatCurrency(_vm.currentCart.discount_value)))])]) : _c("div", {
    staticClass: "summary-row"
  }, [_c("button", {
    staticClass: "add-discount-btn",
    on: {
      click: _vm.openSaleDiscount
    }
  }, [_c("i", {
    staticClass: "fas fa-percent"
  }), _vm._v(" إضافة خصم (F8)\n                    ")])]), _vm._v(" "), _vm.settings.tax_rate > 0 ? _c("div", {
    staticClass: "summary-row tax"
  }, [_c("span", [_vm._v("الضريبة (" + _vm._s(_vm.settings.tax_rate) + "%)")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.currentCart.tax_amount)))])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "summary-row total"
  }, [_c("span", [_vm._v("الإجمالي")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.currentCart.total_amount)))])])]), _vm._v(" "), _c("div", {
    staticClass: "cart-actions"
  }, [_c("button", {
    staticClass: "btn btn-secondary btn-park",
    attrs: {
      disabled: _vm.currentCart.items.length === 0
    },
    on: {
      click: _vm.parkSale
    }
  }, [_c("i", {
    staticClass: "fas fa-pause"
  }), _vm._v(" تأجيل (F4)\n                ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary btn-pay",
    attrs: {
      disabled: _vm.currentCart.items.length === 0
    },
    on: {
      click: _vm.openPayment
    }
  }, [_c("i", {
    staticClass: "fas fa-money-bill"
  }), _vm._v(" دفع (F10)\n                ")])])])]), _vm._v(" "), _vm.showVariationModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        _vm.showVariationModal = false;
      }
    }
  }, [_c("div", {
    staticClass: "modal-content variation-modal"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v("اختر النوع")]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: function click($event) {
        _vm.showVariationModal = false;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "variations-grid"
  }, _vm._l(_vm.selectedProduct.variations, function (variation) {
    return _c("div", {
      key: variation.id,
      staticClass: "variation-card",
      "class": {
        "out-of-stock": variation.quantity <= 0
      },
      on: {
        click: function click($event) {
          return _vm.addVariationToCart(variation);
        }
      }
    }, [_c("div", {
      staticClass: "variation-name"
    }, [_vm._v(_vm._s(variation.var_name))]), _vm._v(" "), _c("div", {
      staticClass: "variation-price"
    }, [_vm._v(_vm._s(_vm.formatCurrency(variation.price)))]), _vm._v(" "), _c("div", {
      staticClass: "variation-stock"
    }, [_vm._v("المخزون: " + _vm._s(variation.quantity))])]);
  }), 0)])])]) : _vm._e(), _vm._v(" "), _vm.showCustomerModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        _vm.showCustomerModal = false;
      }
    }
  }, [_c("div", {
    staticClass: "modal-content customer-modal"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v("اختر أو أنشئ عميل")]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: function click($event) {
        _vm.showCustomerModal = false;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "customer-search"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.customerSearch,
      expression: "customerSearch"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "البحث بالاسم أو الهاتف..."
    },
    domProps: {
      value: _vm.customerSearch
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.customerSearch = $event.target.value;
      }, _vm.searchCustomers]
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "customer-list"
  }, _vm._l(_vm.customers, function (customer) {
    return _c("div", {
      key: customer.id,
      staticClass: "customer-item",
      on: {
        click: function click($event) {
          return _vm.selectCustomer(customer);
        }
      }
    }, [_c("div", {
      staticClass: "customer-name"
    }, [_vm._v(_vm._s(customer.customer_name))]), _vm._v(" "), _c("div", {
      staticClass: "customer-phone"
    }, [_vm._v(_vm._s(customer.phone1))])]);
  }), 0), _vm._v(" "), !_vm.customers.length && _vm.customerSearch ? _c("div", {
    staticClass: "create-customer-form"
  }, [_c("p", {
    staticClass: "text-muted"
  }, [_vm._v("لم يتم العثور على عميل. إنشاء جديد؟")]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.newCustomer.customer_name,
      expression: "newCustomer.customer_name"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "اسم العميل"
    },
    domProps: {
      value: _vm.newCustomer.customer_name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.newCustomer, "customer_name", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.newCustomer.phone1,
      expression: "newCustomer.phone1"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "رقم الهاتف"
    },
    domProps: {
      value: _vm.newCustomer.phone1
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.newCustomer, "phone1", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    on: {
      click: _vm.createCustomer
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  }), _vm._v(" إنشاء عميل\n                    ")])]) : _vm._e()])])]) : _vm._e(), _vm._v(" "), _vm.showDiscountModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        _vm.showDiscountModal = false;
      }
    }
  }, [_c("div", {
    staticClass: "modal-content discount-modal"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v(_vm._s(_vm.discountTarget === "sale" ? "خصم البيع" : "خصم الصنف"))]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: function click($event) {
        _vm.showDiscountModal = false;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "discount-type-toggle"
  }, [_c("button", {
    "class": {
      active: _vm.discountForm.type === "percentage"
    },
    on: {
      click: function click($event) {
        _vm.discountForm.type = "percentage";
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-percent"
  }), _vm._v(" نسبة مئوية\n                    ")]), _vm._v(" "), _c("button", {
    "class": {
      active: _vm.discountForm.type === "fixed"
    },
    on: {
      click: function click($event) {
        _vm.discountForm.type = "fixed";
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-dollar-sign"
  }), _vm._v(" مبلغ ثابت\n                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "discount-input"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.discountForm.amount,
      expression: "discountForm.amount"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      placeholder: _vm.discountForm.type === "percentage" ? "أدخل النسبة %" : "أدخل المبلغ",
      min: "0"
    },
    domProps: {
      value: _vm.discountForm.amount
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.discountForm, "amount", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "discount-actions"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    on: {
      click: _vm.clearDiscount
    }
  }, [_vm._v("مسح")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    on: {
      click: _vm.applyDiscount
    }
  }, [_vm._v("تطبيق")])])])])]) : _vm._e(), _vm._v(" "), _vm.showPaymentModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        _vm.showPaymentModal = false;
      }
    }
  }, [_c("div", {
    staticClass: "modal-content payment-modal"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v("الدفع")]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: function click($event) {
        _vm.showPaymentModal = false;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "payment-summary"
  }, [_c("div", {
    staticClass: "total-due"
  }, [_c("span", [_vm._v("الإجمالي المستحق")]), _vm._v(" "), _c("span", {
    staticClass: "amount"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.currentCart.total_amount)))])]), _vm._v(" "), _vm.payments.length > 0 ? _c("div", {
    staticClass: "paid-so-far"
  }, [_c("span", [_vm._v("المدفوع")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(_vm.totalPaid)))])]) : _vm._e(), _vm._v(" "), _vm.remainingAmount > 0 ? _c("div", {
    staticClass: "remaining"
  }, [_c("span", [_vm._v("المتبقي")]), _vm._v(" "), _c("span", {
    staticClass: "amount"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.remainingAmount)))])]) : _vm._e(), _vm._v(" "), _vm.changeAmount > 0 ? _c("div", {
    staticClass: "change"
  }, [_c("span", [_vm._v("الباقي")]), _vm._v(" "), _c("span", {
    staticClass: "amount text-success"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.changeAmount)))])]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "payment-methods"
  }, _vm._l(_vm.availablePaymentMethods, function (method) {
    return _c("button", {
      key: method.value,
      staticClass: "payment-method-btn",
      "class": {
        active: _vm.selectedPaymentMethod === method.value
      },
      on: {
        click: function click($event) {
          _vm.selectedPaymentMethod = method.value;
        }
      }
    }, [_c("i", {
      "class": method.icon
    }), _vm._v(" "), _c("span", [_vm._v(_vm._s(method.label))])]);
  }), 0), _vm._v(" "), _c("div", {
    staticClass: "payment-input"
  }, [_c("label", [_vm._v("المبلغ")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.paymentAmount,
      expression: "paymentAmount",
      modifiers: {
        number: true
      }
    }],
    ref: "paymentInput",
    staticClass: "form-control amount-input",
    attrs: {
      type: "number",
      placeholder: _vm.remainingAmount
    },
    domProps: {
      value: _vm.paymentAmount
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.paymentAmount = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  })]), _vm._v(" "), _vm.selectedPaymentMethod === "cash" ? _c("div", {
    staticClass: "quick-amounts"
  }, _vm._l(_vm.quickAmounts, function (amount) {
    return _c("button", {
      key: amount,
      staticClass: "quick-amount-btn",
      on: {
        click: function click($event) {
          _vm.paymentAmount = amount;
        }
      }
    }, [_vm._v("\n                        " + _vm._s(_vm.formatCurrency(amount)) + "\n                    ")]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.selectedPaymentMethod !== "cash" ? _c("div", {
    staticClass: "reference-input"
  }, [_c("label", [_vm._v("رقم المرجع (اختياري)")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.paymentReference,
      expression: "paymentReference"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "كود التفويض، رقم التحويل..."
    },
    domProps: {
      value: _vm.paymentReference
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.paymentReference = $event.target.value;
      }
    }
  })]) : _vm._e(), _vm._v(" "), _vm.payments.length > 0 ? _c("div", {
    staticClass: "payments-list"
  }, [_c("h6", [_vm._v("المدفوعات")]), _vm._v(" "), _vm._l(_vm.payments, function (payment, index) {
    return _c("div", {
      key: index,
      staticClass: "payment-item"
    }, [_c("span", [_vm._v(_vm._s(_vm.getMethodLabel(payment.payment_method)))]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm.formatCurrency(payment.amount)))]), _vm._v(" "), _c("button", {
      staticClass: "btn-remove-payment",
      on: {
        click: function click($event) {
          return _vm.removePayment(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-times"
    })])]);
  })], 2) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "payment-actions"
  }, [!_vm.isFullyPaid ? _c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      disabled: !_vm.paymentAmount || _vm.paymentAmount <= 0
    },
    on: {
      click: _vm.addPayment
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  }), _vm._v(" إضافة دفعة\n                    ")]) : _vm._e(), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary btn-complete",
    attrs: {
      disabled: !_vm.canCompleteSale
    },
    on: {
      click: _vm.completeSale
    }
  }, [_c("i", {
    staticClass: "fas fa-check"
  }), _vm._v("\n                        " + _vm._s(_vm.isFullyPaid ? "إتمام البيع (F12)" : "إتمام بدفعات مقسمة") + "\n                    ")])])])])]) : _vm._e(), _vm._v(" "), _vm.showParkedModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        _vm.showParkedModal = false;
      }
    }
  }, [_c("div", {
    staticClass: "modal-content parked-modal"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v("المبيعات المؤجلة")]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: function click($event) {
        _vm.showParkedModal = false;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_vm.parkedSales.length === 0 ? _c("div", {
    staticClass: "empty-state"
  }, [_c("i", {
    staticClass: "fas fa-pause-circle"
  }), _vm._v(" "), _c("p", [_vm._v("لا توجد مبيعات مؤجلة")])]) : _c("div", {
    staticClass: "parked-sales-list"
  }, _vm._l(_vm.parkedSales, function (sale) {
    return _c("div", {
      key: sale.id,
      staticClass: "parked-sale-item",
      on: {
        click: function click($event) {
          return _vm.resumeSale(sale);
        }
      }
    }, [_c("div", {
      staticClass: "sale-info"
    }, [_c("div", {
      staticClass: "sale-number"
    }, [_vm._v(_vm._s(sale.sale_number))]), _vm._v(" "), sale.park_name ? _c("div", {
      staticClass: "sale-name"
    }, [_vm._v(_vm._s(sale.park_name))]) : _vm._e(), _vm._v(" "), sale.customer ? _c("div", {
      staticClass: "sale-customer"
    }, [_c("i", {
      staticClass: "fas fa-user"
    }), _vm._v(" " + _vm._s(sale.customer.customer_name) + "\n                            ")]) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "sale-details"
    }, [_c("div", {
      staticClass: "items-count"
    }, [_vm._v(_vm._s(sale.items.length) + " صنف")]), _vm._v(" "), _c("div", {
      staticClass: "sale-total"
    }, [_vm._v(_vm._s(_vm.formatCurrency(sale.total_amount)))])]), _vm._v(" "), _c("button", {
      staticClass: "btn-delete-parked",
      on: {
        click: function click($event) {
          $event.stopPropagation();
          return _vm.deleteParkedSale(sale.id);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])]);
  }), 0)])])]) : _vm._e(), _vm._v(" "), _vm.showReceiptModal ? _c("div", {
    staticClass: "modal-overlay",
    on: {
      click: function click($event) {
        if ($event.target !== $event.currentTarget) return null;
        return _vm.closeReceipt.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "modal-content receipt-modal"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", [_vm._v("تم البيع بنجاح")]), _vm._v(" "), _c("button", {
    staticClass: "close-btn",
    on: {
      click: _vm.closeReceipt
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "receipt-info"
  }, [_c("p", [_vm._v("البيع #" + _vm._s((_vm$completedSale = _vm.completedSale) === null || _vm$completedSale === void 0 ? void 0 : _vm$completedSale.sale_number))]), _vm._v(" "), _c("p", {
    staticClass: "total"
  }, [_vm._v(_vm._s(_vm.formatCurrency((_vm$completedSale2 = _vm.completedSale) === null || _vm$completedSale2 === void 0 ? void 0 : _vm$completedSale2.total_amount)))]), _vm._v(" "), ((_vm$completedSale3 = _vm.completedSale) === null || _vm$completedSale3 === void 0 ? void 0 : _vm$completedSale3.change_amount) > 0 ? _c("p", {
    staticClass: "change"
  }, [_vm._v("\n                        الباقي: " + _vm._s(_vm.formatCurrency((_vm$completedSale4 = _vm.completedSale) === null || _vm$completedSale4 === void 0 ? void 0 : _vm$completedSale4.change_amount)) + "\n                    ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "receipt-actions"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    on: {
      click: _vm.printReceipt
    }
  }, [_c("i", {
    staticClass: "fas fa-print"
  }), _vm._v(" طباعة الإيصال\n                    ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    on: {
      click: _vm.closeReceipt
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  }), _vm._v(" بيع جديد\n                    ")])])])])]) : _vm._e()]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "pos-topbar-left"
  }, [_c("h4", [_c("i", {
    staticClass: "fas fa-cash-register"
  }), _vm._v(" نقطة البيع")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "success-icon"
  }, [_c("i", {
    staticClass: "fas fa-check-circle"
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.pos-container[data-v-dfc60568] {\n    height: 100vh;\n    display: flex;\n    flex-direction: column;\n    background: #f5f7fa;\n    overflow: hidden;\n}\n.offline-banner[data-v-dfc60568] {\n    background: #ff9800;\n    color: white;\n    padding: 8px;\n    text-align: center;\n    font-size: 14px;\n}\n.pos-topbar[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    justify-content: space-between;\n    padding: 10px 20px;\n    background: white;\n    border-bottom: 1px solid #e0e0e0;\n    gap: 20px;\n}\n.pos-topbar h4[data-v-dfc60568] {\n    margin: 0;\n    font-size: 18px;\n}\n.cart-tabs[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    gap: 5px;\n}\n.cart-tab[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    gap: 8px;\n    padding: 8px 16px;\n    background: #f0f0f0;\n    border-radius: 20px;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.cart-tab.active[data-v-dfc60568] {\n    background: #2196f3;\n    color: white;\n}\n.cart-tab .item-count[data-v-dfc60568] {\n    background: rgba(0,0,0,0.1);\n    padding: 2px 8px;\n    border-radius: 10px;\n    font-size: 12px;\n}\n.cart-tab .close-cart[data-v-dfc60568] {\n    background: none;\n    border: none;\n    padding: 2px;\n    cursor: pointer;\n    opacity: 0.6;\n}\n.new-cart-btn[data-v-dfc60568] {\n    width: 36px;\n    height: 36px;\n    border-radius: 50%;\n    border: 2px dashed #ccc;\n    background: none;\n    cursor: pointer;\n    display: flex;\n    align-items: center;\n    justify-content: center;\n}\n.pos-topbar-right[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n}\n.pos-topbar-right .badge[data-v-dfc60568] {\n    background: #f44336;\n    color: white;\n    border-radius: 10px;\n    padding: 2px 6px;\n    font-size: 10px;\n    margin-left: 5px;\n}\n.pos-main[data-v-dfc60568] {\n    flex: 1;\n    display: flex;\n    overflow: hidden;\n}\n.pos-products[data-v-dfc60568] {\n    flex: 1;\n    display: flex;\n    flex-direction: column;\n    padding: 20px;\n    overflow: hidden;\n}\n.search-section[data-v-dfc60568] {\n    margin-bottom: 20px;\n}\n.search-input-wrapper[data-v-dfc60568] {\n    position: relative;\n    display: flex;\n    align-items: center;\n}\n.search-input-wrapper i[data-v-dfc60568] {\n    position: absolute;\n    left: 15px;\n    color: #888;\n}\n.search-input[data-v-dfc60568] {\n    width: 100%;\n    padding: 15px 45px;\n    border: 2px solid #e0e0e0;\n    border-radius: 10px;\n    font-size: 16px;\n    transition: border-color 0.2s;\n}\n.search-input[data-v-dfc60568]:focus {\n    outline: none;\n    border-color: #2196f3;\n}\n.clear-search[data-v-dfc60568] {\n    position: absolute;\n    right: 15px;\n    background: none;\n    border: none;\n    cursor: pointer;\n    color: #888;\n}\n.product-grid[data-v-dfc60568] {\n    flex: 1;\n    display: grid;\n    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));\n    gap: 20px;\n    overflow-y: auto;\n    padding-right: 10px;\n    align-content: start;\n}\n.loading-state[data-v-dfc60568], .empty-state[data-v-dfc60568] {\n    grid-column: 1 / -1;\n    text-align: center;\n    padding: 40px;\n    color: #888;\n}\n.empty-state i[data-v-dfc60568] {\n    font-size: 48px;\n    margin-bottom: 10px;\n    opacity: 0.5;\n}\n.product-card[data-v-dfc60568] {\n    background: white;\n    border-radius: 12px;\n    cursor: pointer;\n    transition: all 0.3s ease;\n    box-shadow: 0 2px 8px rgba(0,0,0,0.08);\n    display: flex;\n    flex-direction: column;\n    height: 100%;\n    overflow: hidden;\n}\n.product-card[data-v-dfc60568]:hover {\n    transform: translateY(-4px);\n    box-shadow: 0 8px 24px rgba(33, 150, 243, 0.2);\n}\n.product-image[data-v-dfc60568] {\n    width: 100%;\n    height: 160px;\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);\n    overflow: hidden;\n    position: relative;\n}\n.product-image img[data-v-dfc60568] {\n    width: 100%;\n    height: 100%;\n    -o-object-fit: cover;\n       object-fit: cover;\n    transition: transform 0.3s ease;\n}\n.product-card:hover .product-image img[data-v-dfc60568] {\n    transform: scale(1.05);\n}\n.product-image i[data-v-dfc60568] {\n    font-size: 48px;\n    color: #cbd5e0;\n}\n.product-info[data-v-dfc60568] {\n    padding: 15px;\n    display: flex;\n    flex-direction: column;\n    gap: 8px;\n    flex: 1;\n}\n.product-name[data-v-dfc60568] {\n    font-weight: 600;\n    font-size: 14px;\n    line-height: 1.4;\n    color: #2d3748;\n    display: -webkit-box;\n    -webkit-line-clamp: 2;\n    line-clamp: 2;\n    -webkit-box-orient: vertical;\n    overflow: hidden;\n    min-height: 40px;\n}\n.product-price[data-v-dfc60568] {\n    color: #2196f3;\n    font-weight: 700;\n    font-size: 18px;\n    margin-top: auto;\n}\n.product-stock[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    gap: 6px;\n    font-size: 13px;\n    color: #4caf50;\n    font-weight: 600;\n}\n.product-stock i[data-v-dfc60568] {\n    font-size: 14px;\n}\n.product-stock.low-stock[data-v-dfc60568] {\n    color: #f44336;\n}\n\n/* Cart */\n.pos-cart[data-v-dfc60568] {\n    width: 400px;\n    background: white;\n    display: flex;\n    flex-direction: column;\n    border-left: 1px solid #e0e0e0;\n}\n.customer-section[data-v-dfc60568] {\n    padding: 15px;\n    border-bottom: 1px solid #e0e0e0;\n}\n.selected-customer[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    gap: 10px;\n    padding: 10px 15px;\n    background: #e3f2fd;\n    border-radius: 8px;\n}\n.selected-customer .btn-clear[data-v-dfc60568] {\n    margin-left: auto;\n    background: none;\n    border: none;\n    cursor: pointer;\n    color: #888;\n}\n.select-customer-btn[data-v-dfc60568] {\n    width: 100%;\n    padding: 12px;\n    border: 2px dashed #ccc;\n    border-radius: 8px;\n    background: none;\n    cursor: pointer;\n    color: #666;\n    transition: all 0.2s;\n}\n.select-customer-btn[data-v-dfc60568]:hover {\n    border-color: #2196f3;\n    color: #2196f3;\n}\n.cart-items[data-v-dfc60568] {\n    flex: 1;\n    overflow-y: auto;\n    padding: 15px;\n}\n.empty-cart[data-v-dfc60568] {\n    text-align: center;\n    padding: 40px 20px;\n    color: #888;\n}\n.empty-cart i[data-v-dfc60568] {\n    font-size: 48px;\n    opacity: 0.3;\n    margin-bottom: 10px;\n}\n.cart-item[data-v-dfc60568] {\n    display: grid;\n    grid-template-columns: 1fr auto auto auto;\n    gap: 10px;\n    align-items: center;\n    padding: 12px;\n    background: #f9f9f9;\n    border-radius: 8px;\n    margin-bottom: 10px;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.cart-item.selected[data-v-dfc60568] {\n    background: #e3f2fd;\n    border: 1px solid #2196f3;\n}\n.item-name[data-v-dfc60568] {\n    font-weight: 500;\n    font-size: 14px;\n}\n.item-name .variation[data-v-dfc60568] {\n    font-weight: 400;\n    color: #888;\n    font-size: 12px;\n}\n.item-price[data-v-dfc60568] {\n    font-size: 12px;\n    color: #666;\n}\n.item-controls[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    gap: 5px;\n}\n.qty-btn[data-v-dfc60568] {\n    width: 28px;\n    height: 28px;\n    border: 1px solid #ddd;\n    background: white;\n    border-radius: 4px;\n    cursor: pointer;\n    font-size: 16px;\n}\n.qty-input[data-v-dfc60568] {\n    width: 40px;\n    text-align: center;\n    border: 1px solid #ddd;\n    border-radius: 4px;\n    padding: 4px;\n}\n.item-total[data-v-dfc60568] {\n    font-weight: 600;\n    min-width: 70px;\n    text-align: right;\n}\n.item-actions[data-v-dfc60568] {\n    display: flex;\n    gap: 5px;\n}\n.btn-discount[data-v-dfc60568], .btn-remove[data-v-dfc60568] {\n    width: 28px;\n    height: 28px;\n    border: none;\n    border-radius: 4px;\n    cursor: pointer;\n    font-size: 12px;\n}\n.btn-discount[data-v-dfc60568] {\n    background: #fff3e0;\n    color: #ff9800;\n}\n.btn-remove[data-v-dfc60568] {\n    background: #ffebee;\n    color: #f44336;\n}\n\n/* Cart Summary */\n.cart-summary[data-v-dfc60568] {\n    padding: 15px;\n    border-top: 1px solid #e0e0e0;\n    background: #fafafa;\n}\n.summary-row[data-v-dfc60568] {\n    display: flex;\n    justify-content: space-between;\n    padding: 8px 0;\n}\n.summary-row.discount[data-v-dfc60568] {\n    color: #4caf50;\n}\n.summary-row.tax[data-v-dfc60568] {\n    color: #888;\n    font-size: 14px;\n}\n.summary-row.total[data-v-dfc60568] {\n    font-size: 20px;\n    font-weight: 700;\n    border-top: 2px solid #e0e0e0;\n    margin-top: 10px;\n    padding-top: 15px;\n}\n.add-discount-btn[data-v-dfc60568] {\n    background: none;\n    border: none;\n    color: #2196f3;\n    cursor: pointer;\n    font-size: 14px;\n}\n.btn-edit-discount[data-v-dfc60568] {\n    background: none;\n    border: none;\n    color: inherit;\n    cursor: pointer;\n    padding: 0 5px;\n}\n\n/* Cart Actions */\n.cart-actions[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n    padding: 15px;\n    border-top: 1px solid #e0e0e0;\n}\n.btn-park[data-v-dfc60568] {\n    flex: 1;\n}\n.btn-pay[data-v-dfc60568] {\n    flex: 2;\n    font-size: 18px;\n    padding: 15px;\n}\n\n/* Modals */\n.modal-overlay[data-v-dfc60568] {\n    position: fixed;\n    top: 0;\n    left: 0;\n    right: 0;\n    bottom: 0;\n    background: rgba(0,0,0,0.5);\n    display: flex;\n    align-items: center;\n    justify-content: center;\n    z-index: 1000;\n}\n.modal-content[data-v-dfc60568] {\n    background: white;\n    border-radius: 12px;\n    width: 90%;\n    max-width: 500px;\n    max-height: 90vh;\n    overflow: hidden;\n    display: flex;\n    flex-direction: column;\n}\n.modal-header[data-v-dfc60568] {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    padding: 15px 20px;\n    border-bottom: 1px solid #e0e0e0;\n}\n.modal-header h5[data-v-dfc60568] {\n    margin: 0;\n}\n.close-btn[data-v-dfc60568] {\n    background: none;\n    border: none;\n    font-size: 20px;\n    cursor: pointer;\n    color: #888;\n}\n.modal-body[data-v-dfc60568] {\n    padding: 20px;\n    overflow-y: auto;\n}\n\n/* Variation Modal */\n.variations-grid[data-v-dfc60568] {\n    display: grid;\n    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));\n    gap: 10px;\n}\n.variation-card[data-v-dfc60568] {\n    padding: 15px;\n    border: 2px solid #e0e0e0;\n    border-radius: 8px;\n    text-align: center;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.variation-card[data-v-dfc60568]:hover {\n    border-color: #2196f3;\n}\n.variation-card.out-of-stock[data-v-dfc60568] {\n    opacity: 0.5;\n    cursor: not-allowed;\n}\n.variation-name[data-v-dfc60568] {\n    font-weight: 600;\n    margin-bottom: 5px;\n}\n.variation-price[data-v-dfc60568] {\n    color: #2196f3;\n    font-weight: 700;\n}\n.variation-stock[data-v-dfc60568] {\n    font-size: 12px;\n    color: #888;\n}\n\n/* Customer Modal */\n.customer-search[data-v-dfc60568] {\n    margin-bottom: 15px;\n}\n.customer-list[data-v-dfc60568] {\n    max-height: 200px;\n    overflow-y: auto;\n}\n.customer-item[data-v-dfc60568] {\n    padding: 12px;\n    border: 1px solid #e0e0e0;\n    border-radius: 8px;\n    margin-bottom: 8px;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.customer-item[data-v-dfc60568]:hover {\n    background: #f5f5f5;\n}\n.customer-name[data-v-dfc60568] {\n    font-weight: 600;\n}\n.customer-phone[data-v-dfc60568] {\n    color: #888;\n    font-size: 14px;\n}\n.create-customer-form[data-v-dfc60568] {\n    margin-top: 20px;\n    padding-top: 20px;\n    border-top: 1px solid #e0e0e0;\n}\n.form-group[data-v-dfc60568] {\n    margin-bottom: 10px;\n}\n\n/* Discount Modal */\n.discount-type-toggle[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n    margin-bottom: 20px;\n}\n.discount-type-toggle button[data-v-dfc60568] {\n    flex: 1;\n    padding: 12px;\n    border: 2px solid #e0e0e0;\n    background: white;\n    border-radius: 8px;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.discount-type-toggle button.active[data-v-dfc60568] {\n    border-color: #2196f3;\n    background: #e3f2fd;\n}\n.discount-input[data-v-dfc60568] {\n    margin-bottom: 20px;\n}\n.discount-actions[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n    justify-content: flex-end;\n}\n\n/* Payment Modal */\n.payment-modal[data-v-dfc60568] {\n    max-width: 600px;\n}\n.payment-summary[data-v-dfc60568] {\n    background: #f5f5f5;\n    padding: 20px;\n    border-radius: 8px;\n    margin-bottom: 20px;\n}\n.total-due[data-v-dfc60568], .remaining[data-v-dfc60568] {\n    display: flex;\n    justify-content: space-between;\n    font-size: 18px;\n    margin-bottom: 10px;\n}\n.total-due .amount[data-v-dfc60568], .remaining .amount[data-v-dfc60568] {\n    font-weight: 700;\n}\n.paid-so-far[data-v-dfc60568], .change[data-v-dfc60568] {\n    display: flex;\n    justify-content: space-between;\n    font-size: 14px;\n    color: #666;\n}\n.change .amount[data-v-dfc60568] {\n    font-weight: 600;\n}\n.payment-methods[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n    margin-bottom: 20px;\n    flex-wrap: wrap;\n}\n.payment-method-btn[data-v-dfc60568] {\n    flex: 1;\n    min-width: 100px;\n    padding: 15px;\n    border: 2px solid #e0e0e0;\n    background: white;\n    border-radius: 8px;\n    cursor: pointer;\n    text-align: center;\n    transition: all 0.2s;\n}\n.payment-method-btn.active[data-v-dfc60568] {\n    border-color: #2196f3;\n    background: #e3f2fd;\n}\n.payment-method-btn i[data-v-dfc60568] {\n    display: block;\n    font-size: 24px;\n    margin-bottom: 5px;\n}\n.payment-input[data-v-dfc60568] {\n    margin-bottom: 15px;\n}\n.payment-input label[data-v-dfc60568] {\n    display: block;\n    margin-bottom: 5px;\n    font-weight: 500;\n}\n.amount-input[data-v-dfc60568] {\n    font-size: 24px;\n    text-align: center;\n    padding: 15px;\n}\n.quick-amounts[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n    flex-wrap: wrap;\n    margin-bottom: 20px;\n}\n.quick-amount-btn[data-v-dfc60568] {\n    padding: 10px 20px;\n    border: 1px solid #e0e0e0;\n    background: white;\n    border-radius: 20px;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.quick-amount-btn[data-v-dfc60568]:hover {\n    background: #f5f5f5;\n}\n.reference-input[data-v-dfc60568] {\n    margin-bottom: 20px;\n}\n.payments-list[data-v-dfc60568] {\n    margin-bottom: 20px;\n    padding: 15px;\n    background: #f9f9f9;\n    border-radius: 8px;\n}\n.payments-list h6[data-v-dfc60568] {\n    margin-bottom: 10px;\n}\n.payment-item[data-v-dfc60568] {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    padding: 8px 0;\n    border-bottom: 1px solid #e0e0e0;\n}\n.payment-item[data-v-dfc60568]:last-child {\n    border-bottom: none;\n}\n.btn-remove-payment[data-v-dfc60568] {\n    background: none;\n    border: none;\n    color: #f44336;\n    cursor: pointer;\n}\n.payment-actions[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n}\n.btn-complete[data-v-dfc60568] {\n    flex: 1;\n    padding: 15px;\n    font-size: 16px;\n}\n\n/* Parked Sales Modal */\n.parked-sales-list[data-v-dfc60568] {\n    max-height: 400px;\n    overflow-y: auto;\n}\n.parked-sale-item[data-v-dfc60568] {\n    display: flex;\n    align-items: center;\n    gap: 15px;\n    padding: 15px;\n    border: 1px solid #e0e0e0;\n    border-radius: 8px;\n    margin-bottom: 10px;\n    cursor: pointer;\n    transition: all 0.2s;\n}\n.parked-sale-item[data-v-dfc60568]:hover {\n    background: #f5f5f5;\n}\n.sale-info[data-v-dfc60568] {\n    flex: 1;\n}\n.sale-number[data-v-dfc60568] {\n    font-weight: 600;\n}\n.sale-name[data-v-dfc60568] {\n    font-size: 14px;\n    color: #666;\n}\n.sale-customer[data-v-dfc60568] {\n    font-size: 12px;\n    color: #888;\n}\n.sale-details[data-v-dfc60568] {\n    text-align: right;\n}\n.items-count[data-v-dfc60568] {\n    font-size: 12px;\n    color: #888;\n}\n.sale-total[data-v-dfc60568] {\n    font-weight: 700;\n    color: #2196f3;\n}\n.btn-delete-parked[data-v-dfc60568] {\n    background: none;\n    border: none;\n    color: #f44336;\n    cursor: pointer;\n    padding: 10px;\n}\n\n/* Receipt Modal */\n.receipt-modal[data-v-dfc60568] {\n    max-width: 400px;\n    text-align: center;\n}\n.success-icon[data-v-dfc60568] {\n    font-size: 64px;\n    color: #4caf50;\n    margin-bottom: 20px;\n}\n.receipt-info[data-v-dfc60568] {\n    margin-bottom: 20px;\n}\n.receipt-info .total[data-v-dfc60568] {\n    font-size: 32px;\n    font-weight: 700;\n}\n.receipt-info .change[data-v-dfc60568] {\n    font-size: 18px;\n    color: #4caf50;\n}\n.receipt-actions[data-v-dfc60568] {\n    display: flex;\n    gap: 10px;\n}\n.receipt-actions button[data-v-dfc60568] {\n    flex: 1;\n}\n\n/* ============================================\n   MOBILE RESPONSIVE STYLES\n============================================ */\n\n/* Tablet and below */\n@media (max-width: 768px) {\n.pos-topbar[data-v-dfc60568] {\n        padding: 10px;\n        flex-wrap: wrap;\n        gap: 10px;\n}\n.pos-topbar h4[data-v-dfc60568] {\n        font-size: 16px;\n}\n.pos-topbar-left[data-v-dfc60568] {\n        flex: 1;\n        min-width: 150px;\n}\n.pos-topbar-center[data-v-dfc60568] {\n        order: 3;\n        width: 100%;\n}\n.cart-tabs[data-v-dfc60568] {\n        width: 100%;\n        overflow-x: auto;\n        padding-bottom: 5px;\n}\n.cart-tab[data-v-dfc60568] {\n        padding: 6px 12px;\n        font-size: 14px;\n}\n.pos-topbar-right[data-v-dfc60568] {\n        gap: 5px;\n}\n.pos-topbar-right .btn[data-v-dfc60568] {\n        padding: 6px 10px;\n        font-size: 12px;\n}\n\n    /* Stack products and cart vertically */\n.pos-main[data-v-dfc60568] {\n        flex-direction: column;\n}\n.pos-products[data-v-dfc60568] {\n        height: 50vh;\n        padding: 10px;\n}\n.pos-cart[data-v-dfc60568] {\n        width: 100%;\n        height: 50vh;\n        border-left: none;\n        border-top: 2px solid #e0e0e0;\n}\n\n    /* Adjust product grid for mobile */\n.product-grid[data-v-dfc60568] {\n        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));\n        gap: 12px;\n}\n.product-image[data-v-dfc60568] {\n        height: 120px;\n}\n.product-info[data-v-dfc60568] {\n        padding: 12px;\n}\n.product-name[data-v-dfc60568] {\n        font-size: 13px;\n        min-height: 36px;\n}\n.product-price[data-v-dfc60568] {\n        font-size: 16px;\n}\n.product-stock[data-v-dfc60568] {\n        font-size: 12px;\n}\n\n    /* Cart adjustments */\n.cart-items[data-v-dfc60568] {\n        padding: 10px;\n}\n.cart-item[data-v-dfc60568] {\n        grid-template-columns: 1fr auto;\n        grid-template-rows: auto auto;\n        gap: 8px;\n        padding: 10px;\n}\n.item-info[data-v-dfc60568] {\n        grid-column: 1 / 2;\n        grid-row: 1 / 2;\n}\n.item-controls[data-v-dfc60568] {\n        grid-column: 1 / 2;\n        grid-row: 2 / 3;\n}\n.item-total[data-v-dfc60568] {\n        grid-column: 2 / 3;\n        grid-row: 1 / 2;\n}\n.item-actions[data-v-dfc60568] {\n        grid-column: 2 / 3;\n        grid-row: 2 / 3;\n        justify-content: flex-end;\n}\n.cart-summary[data-v-dfc60568] {\n        padding: 10px;\n}\n.summary-row.total[data-v-dfc60568] {\n        font-size: 18px;\n}\n.cart-actions[data-v-dfc60568] {\n        padding: 10px;\n        gap: 8px;\n}\n.btn-pay[data-v-dfc60568] {\n        font-size: 16px;\n        padding: 12px;\n}\n\n    /* Modal adjustments */\n.modal-content[data-v-dfc60568] {\n        width: 95%;\n        max-height: 95vh;\n}\n.modal-body[data-v-dfc60568] {\n        padding: 15px;\n}\n.payment-modal[data-v-dfc60568] {\n        max-width: 95%;\n}\n.payment-method-btn[data-v-dfc60568] {\n        min-width: 80px;\n        padding: 12px 8px;\n        font-size: 12px;\n}\n.payment-method-btn i[data-v-dfc60568] {\n        font-size: 20px;\n}\n.amount-input[data-v-dfc60568] {\n        font-size: 20px;\n        padding: 12px;\n}\n.quick-amounts[data-v-dfc60568] {\n        gap: 8px;\n}\n.quick-amount-btn[data-v-dfc60568] {\n        padding: 8px 16px;\n        font-size: 14px;\n}\n.variations-grid[data-v-dfc60568] {\n        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));\n}\n.variation-card[data-v-dfc60568] {\n        padding: 12px;\n}\n}\n\n/* Mobile phones */\n@media (max-width: 480px) {\n.pos-topbar h4[data-v-dfc60568] {\n        font-size: 14px;\n}\n.pos-topbar h4 i[data-v-dfc60568] {\n        display: none;\n}\n.cart-tab[data-v-dfc60568] {\n        padding: 5px 10px;\n        font-size: 12px;\n}\n.new-cart-btn[data-v-dfc60568] {\n        width: 32px;\n        height: 32px;\n}\n.pos-topbar-right .btn span[data-v-dfc60568] {\n        display: none;\n}\n\n    /* Adjust product grid for small phones */\n.product-grid[data-v-dfc60568] {\n        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));\n        gap: 10px;\n}\n.product-image[data-v-dfc60568] {\n        height: 100px;\n}\n.product-image i[data-v-dfc60568] {\n        font-size: 36px;\n}\n.product-info[data-v-dfc60568] {\n        padding: 10px;\n}\n.product-name[data-v-dfc60568] {\n        font-size: 12px;\n        min-height: 34px;\n}\n.product-price[data-v-dfc60568] {\n        font-size: 14px;\n}\n.product-stock[data-v-dfc60568] {\n        font-size: 11px;\n}\n.search-input[data-v-dfc60568] {\n        padding: 12px 40px;\n        font-size: 14px;\n}\n\n    /* Compact cart */\n.customer-section[data-v-dfc60568] {\n        padding: 10px;\n}\n.cart-item[data-v-dfc60568] {\n        padding: 8px;\n        font-size: 13px;\n}\n.item-name[data-v-dfc60568] {\n        font-size: 13px;\n}\n.item-name .variation[data-v-dfc60568] {\n        font-size: 11px;\n}\n.item-price[data-v-dfc60568] {\n        font-size: 11px;\n}\n.qty-btn[data-v-dfc60568] {\n        width: 26px;\n        height: 26px;\n        font-size: 14px;\n}\n.qty-input[data-v-dfc60568] {\n        width: 36px;\n        font-size: 14px;\n}\n.item-total[data-v-dfc60568] {\n        font-size: 14px;\n        min-width: 60px;\n}\n.btn-discount[data-v-dfc60568], .btn-remove[data-v-dfc60568] {\n        width: 26px;\n        height: 26px;\n        font-size: 11px;\n}\n.summary-row[data-v-dfc60568] {\n        padding: 6px 0;\n        font-size: 14px;\n}\n.summary-row.total[data-v-dfc60568] {\n        font-size: 16px;\n}\n.cart-actions[data-v-dfc60568] {\n        gap: 6px;\n        padding: 8px;\n}\n.btn-park[data-v-dfc60568] {\n        font-size: 13px;\n        padding: 10px 8px;\n}\n.btn-pay[data-v-dfc60568] {\n        font-size: 14px;\n        padding: 10px;\n}\n\n    /* Full screen modals on mobile */\n.modal-content[data-v-dfc60568] {\n        width: 100%;\n        max-width: 100%;\n        height: 100vh;\n        max-height: 100vh;\n        border-radius: 0;\n}\n.modal-header[data-v-dfc60568] {\n        padding: 12px 15px;\n}\n.modal-header h5[data-v-dfc60568] {\n        font-size: 16px;\n}\n.payment-methods[data-v-dfc60568] {\n        gap: 8px;\n}\n.payment-method-btn[data-v-dfc60568] {\n        min-width: 70px;\n        padding: 10px 6px;\n        font-size: 11px;\n}\n.payment-method-btn i[data-v-dfc60568] {\n        font-size: 18px;\n}\n.payment-method-btn span[data-v-dfc60568] {\n        font-size: 10px;\n}\n.amount-input[data-v-dfc60568] {\n        font-size: 18px;\n        padding: 10px;\n}\n.quick-amount-btn[data-v-dfc60568] {\n        padding: 8px 12px;\n        font-size: 12px;\n}\n.btn-complete[data-v-dfc60568] {\n        padding: 12px;\n        font-size: 14px;\n}\n.variations-grid[data-v-dfc60568] {\n        grid-template-columns: repeat(2, 1fr);\n}\n.variation-card[data-v-dfc60568] {\n        padding: 10px;\n        font-size: 13px;\n}\n.variation-name[data-v-dfc60568] {\n        font-size: 13px;\n}\n.variation-price[data-v-dfc60568] {\n        font-size: 14px;\n}\n.customer-item[data-v-dfc60568] {\n        padding: 10px;\n}\n.customer-name[data-v-dfc60568] {\n        font-size: 14px;\n}\n.customer-phone[data-v-dfc60568] {\n        font-size: 12px;\n}\n.receipt-info .total[data-v-dfc60568] {\n        font-size: 24px;\n}\n.receipt-info .change[data-v-dfc60568] {\n        font-size: 16px;\n}\n.success-icon[data-v-dfc60568] {\n        font-size: 48px;\n}\n\n    /* Parked sales */\n.parked-sale-item[data-v-dfc60568] {\n        padding: 12px;\n        gap: 10px;\n}\n.sale-number[data-v-dfc60568] {\n        font-size: 14px;\n}\n.sale-name[data-v-dfc60568] {\n        font-size: 12px;\n}\n.sale-total[data-v-dfc60568] {\n        font-size: 14px;\n}\n}\n\n/* Landscape orientation for phones */\n@media (max-width: 768px) and (orientation: landscape) {\n.pos-main[data-v-dfc60568] {\n        flex-direction: row;\n}\n.pos-products[data-v-dfc60568] {\n        height: auto;\n        width: 60%;\n}\n.pos-cart[data-v-dfc60568] {\n        height: auto;\n        width: 40%;\n        border-left: 2px solid #e0e0e0;\n        border-top: none;\n}\n}\n\n/* Small height screens (landscape phones) */\n@media (max-height: 500px) {\n.pos-topbar[data-v-dfc60568] {\n        padding: 5px 10px;\n}\n.cart-tab[data-v-dfc60568] {\n        padding: 4px 8px;\n}\n.search-section[data-v-dfc60568] {\n        margin-bottom: 10px;\n}\n.search-input[data-v-dfc60568] {\n        padding: 10px 40px;\n}\n.product-image[data-v-dfc60568] {\n        height: 40px;\n}\n.cart-actions[data-v-dfc60568] {\n        padding: 6px;\n}\n.btn-pay[data-v-dfc60568] {\n        padding: 8px;\n        font-size: 13px;\n}\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_style_index_0_id_dfc60568_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_style_index_0_id_dfc60568_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_style_index_0_id_dfc60568_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/pages/pos/PosMain.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/pages/pos/PosMain.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PosMain_vue_vue_type_template_id_dfc60568_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PosMain.vue?vue&type=template&id=dfc60568&scoped=true& */ "./resources/js/components/pages/pos/PosMain.vue?vue&type=template&id=dfc60568&scoped=true&");
/* harmony import */ var _PosMain_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PosMain.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/pos/PosMain.vue?vue&type=script&lang=js&");
/* harmony import */ var _PosMain_vue_vue_type_style_index_0_id_dfc60568_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css& */ "./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PosMain_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PosMain_vue_vue_type_template_id_dfc60568_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PosMain_vue_vue_type_template_id_dfc60568_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "dfc60568",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/pos/PosMain.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/pos/PosMain.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosMain.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosMain.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/pos/PosMain.vue?vue&type=template&id=dfc60568&scoped=true&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosMain.vue?vue&type=template&id=dfc60568&scoped=true& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_template_id_dfc60568_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_template_id_dfc60568_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_template_id_dfc60568_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosMain.vue?vue&type=template&id=dfc60568&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=template&id=dfc60568&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PosMain_vue_vue_type_style_index_0_id_dfc60568_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/pos/PosMain.vue?vue&type=style&index=0&id=dfc60568&scoped=true&lang=css&");


/***/ })

}]);