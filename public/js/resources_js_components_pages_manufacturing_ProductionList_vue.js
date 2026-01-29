"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_manufacturing_ProductionList_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ProductionList',
  data: function data() {
    return {
      loading: false,
      batches: [],
      filters: {
        status: '',
        date_from: '',
        date_to: ''
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1
      },
      selectedBatch: null,
      completeForm: {
        actual_quantity: '',
        actual_ingredients: {}
      },
      completing: false,
      editForm: {
        production_date: '',
        expiry_date: '',
        labor_cost: 0,
        overhead_cost: 0,
        notes: ''
      },
      editing: false
    };
  },
  methods: {
    fetchBatches: function fetchBatches() {
      var _arguments = arguments,
        _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page, params, response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
              _this.loading = true;
              _context.prev = 2;
              params = _objectSpread({
                page: page,
                per_page: _this.pagination.per_page
              }, _this.filters);
              _context.next = 6;
              return axios.get('/dashboard/api/manufacturing/batches', {
                params: params
              });
            case 6:
              response = _context.sent;
              _this.batches = response.data.data;
              _this.pagination = response.data.pagination;
              _context.next = 14;
              break;
            case 11:
              _context.prev = 11;
              _context.t0 = _context["catch"](2);
              toastr.error('فشل تحميل دفعات الإنتاج');
            case 14:
              _context.prev = 14;
              _this.loading = false;
              return _context.finish(14);
            case 17:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 11, 14, 17]]);
      }))();
    },
    goToPage: function goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchBatches(page);
      }
    },
    resetFilters: function resetFilters() {
      this.filters = {
        status: '',
        date_from: '',
        date_to: ''
      };
      this.fetchBatches();
    },
    getStatusColor: function getStatusColor(status) {
      var colors = {
        draft: 'secondary',
        in_progress: 'primary',
        completed: 'success',
        cancelled: 'danger'
      };
      return colors[status] || 'secondary';
    },
    formatStatus: function formatStatus(status) {
      return status.replace('_', ' ').replace(/\b\w/g, function (l) {
        return l.toUpperCase();
      });
    },
    formatDate: function formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    formatCurrency: function formatCurrency(value) {
      var amount = parseFloat(value || 0);
      // Check if the value has decimal places
      var hasDecimals = amount % 1 !== 0;
      var formattedNumber = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: hasDecimals ? 1 : 0,
        maximumFractionDigits: hasDecimals ? 2 : 0
      }).format(amount);

      // Get currency from window.currency (set globally in master.blade.php)
      var currency = window.currency || 'IQD';
      return "".concat(formattedNumber, " ").concat(currency);
    },
    startBatch: function startBatch(batch) {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var result, _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.next = 2;
              return swal.fire({
                title: 'بدء الإنتاج؟',
                text: 'سيتم وضع علامة على الدفعة كقيد التنفيذ.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ابدأ',
                cancelButtonText: 'إلغاء'
              });
            case 2:
              result = _context2.sent;
              if (!result.isConfirmed) {
                _context2.next = 14;
                break;
              }
              _context2.prev = 4;
              _context2.next = 7;
              return axios.post("/dashboard/api/manufacturing/batches/".concat(batch.id, "/start"));
            case 7:
              toastr.success('تم بدء الإنتاج');
              _this2.fetchBatches(_this2.pagination.current_page);
              _context2.next = 14;
              break;
            case 11:
              _context2.prev = 11;
              _context2.t0 = _context2["catch"](4);
              toastr.error(((_error$response = _context2.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل بدء الإنتاج');
            case 14:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[4, 11]]);
      }))();
    },
    openCompleteModal: function openCompleteModal(batch) {
      this.selectedBatch = batch;
      this.completeForm = {
        actual_quantity: batch.planned_quantity,
        actual_ingredients: {}
      };
      $('#completeModal').modal('show');
    },
    submitComplete: function submitComplete() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var _error$response2, _error$response2$data;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              if (_this3.completeForm.actual_quantity) {
                _context3.next = 3;
                break;
              }
              toastr.error('الرجاء إدخال الكمية الفعلية');
              return _context3.abrupt("return");
            case 3:
              _this3.completing = true;
              _context3.prev = 4;
              _context3.next = 7;
              return axios.post("/dashboard/api/manufacturing/batches/".concat(_this3.selectedBatch.id, "/complete"), _this3.completeForm);
            case 7:
              toastr.success('تم إكمال الإنتاج');
              $('#completeModal').modal('hide');
              _this3.fetchBatches(_this3.pagination.current_page);
              _context3.next = 15;
              break;
            case 12:
              _context3.prev = 12;
              _context3.t0 = _context3["catch"](4);
              toastr.error(((_error$response2 = _context3.t0.response) === null || _error$response2 === void 0 ? void 0 : (_error$response2$data = _error$response2.data) === null || _error$response2$data === void 0 ? void 0 : _error$response2$data.message) || 'فشل إكمال الإنتاج');
            case 15:
              _context3.prev = 15;
              _this3.completing = false;
              return _context3.finish(15);
            case 18:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[4, 12, 15, 18]]);
      }))();
    },
    viewDetails: function viewDetails(batch) {
      this.selectedBatch = batch;
      $('#detailsModal').modal('show');
    },
    cancelBatch: function cancelBatch(batch) {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var result, _error$response3, _error$response3$data;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.next = 2;
              return swal.fire({
                title: 'إلغاء الإنتاج؟',
                text: 'هل أنت متأكد من إلغاء هذه الدفعة؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'نعم، ألغها',
                cancelButtonText: 'إلغاء',
                input: 'text',
                inputLabel: 'السبب (اختياري)'
              });
            case 2:
              result = _context4.sent;
              if (!result.isConfirmed) {
                _context4.next = 14;
                break;
              }
              _context4.prev = 4;
              _context4.next = 7;
              return axios.post("/dashboard/api/manufacturing/batches/".concat(batch.id, "/cancel"), {
                reason: result.value
              });
            case 7:
              toastr.success('تم إلغاء الإنتاج');
              _this4.fetchBatches(_this4.pagination.current_page);
              _context4.next = 14;
              break;
            case 11:
              _context4.prev = 11;
              _context4.t0 = _context4["catch"](4);
              toastr.error(((_error$response3 = _context4.t0.response) === null || _error$response3 === void 0 ? void 0 : (_error$response3$data = _error$response3.data) === null || _error$response3$data === void 0 ? void 0 : _error$response3$data.message) || 'فشل الإلغاء');
            case 14:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[4, 11]]);
      }))();
    },
    openEditModal: function openEditModal(batch) {
      this.selectedBatch = batch;
      this.editForm = {
        production_date: batch.production_date,
        expiry_date: batch.expiry_date || '',
        labor_cost: batch.labor_cost || 0,
        overhead_cost: batch.overhead_cost || 0,
        notes: batch.notes || ''
      };
      $('#editModal').modal('show');
    },
    submitEdit: function submitEdit() {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
        var _error$response4, _error$response4$data;
        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
          while (1) switch (_context5.prev = _context5.next) {
            case 0:
              _this5.editing = true;
              _context5.prev = 1;
              _context5.next = 4;
              return axios.put("/dashboard/api/manufacturing/batches/".concat(_this5.selectedBatch.id), _this5.editForm);
            case 4:
              toastr.success('تم تحديث الإنتاج بنجاح');
              $('#editModal').modal('hide');
              _this5.fetchBatches(_this5.pagination.current_page);
              _context5.next = 12;
              break;
            case 9:
              _context5.prev = 9;
              _context5.t0 = _context5["catch"](1);
              toastr.error(((_error$response4 = _context5.t0.response) === null || _error$response4 === void 0 ? void 0 : (_error$response4$data = _error$response4.data) === null || _error$response4$data === void 0 ? void 0 : _error$response4$data.message) || 'فشل تحديث الإنتاج');
            case 12:
              _context5.prev = 12;
              _this5.editing = false;
              return _context5.finish(12);
            case 15:
            case "end":
              return _context5.stop();
          }
        }, _callee5, null, [[1, 9, 12, 15]]);
      }))();
    },
    cloneBatch: function cloneBatch(batch) {
      var _this6 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var result, _error$response5, _error$response5$data;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              _context6.next = 2;
              return swal.fire({
                title: 'استنساخ الدفعة؟',
                text: 'سيتم إنشاء دفعة جديدة بنفس المواصفات وتعيينها كمكتملة',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'استنساخ',
                cancelButtonText: 'إلغاء'
              });
            case 2:
              result = _context6.sent;
              if (!result.isConfirmed) {
                _context6.next = 14;
                break;
              }
              _context6.prev = 4;
              _context6.next = 7;
              return axios.post("/dashboard/api/manufacturing/batches/".concat(batch.id, "/clone"));
            case 7:
              toastr.success('تم استنساخ الدفعة بنجاح');
              _this6.fetchBatches(_this6.pagination.current_page);
              _context6.next = 14;
              break;
            case 11:
              _context6.prev = 11;
              _context6.t0 = _context6["catch"](4);
              toastr.error(((_error$response5 = _context6.t0.response) === null || _error$response5 === void 0 ? void 0 : (_error$response5$data = _error$response5.data) === null || _error$response5$data === void 0 ? void 0 : _error$response5$data.message) || 'فشل استنساخ الدفعة');
            case 14:
            case "end":
              return _context6.stop();
          }
        }, _callee6, null, [[4, 11]]);
      }))();
    }
  },
  mounted: function mounted() {
    this.fetchBatches();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=template&id=f76f3304&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=template&id=f76f3304& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$selectedBatch, _vm$selectedBatch2, _vm$selectedBatch3, _vm$selectedBatch$pro;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "production-list"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center mb-4"
  }, [_vm._m(0), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-primary",
    attrs: {
      to: {
        name: "manufacturing.production.create"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-plus me-1"
  }), _vm._v(" إنتاج جديد\n    ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "card mb-4"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row g-3"
  }, [_c("div", {
    staticClass: "col-md-3"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.status,
      expression: "filters.status"
    }],
    staticClass: "form-select",
    on: {
      change: [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.filters, "status", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.fetchBatches]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("جميع الحالات")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "draft"
    }
  }, [_vm._v("مسودة")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "in_progress"
    }
  }, [_vm._v("قيد التنفيذ")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "completed"
    }
  }, [_vm._v("مكتمل")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "cancelled"
    }
  }, [_vm._v("ملغي")])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-3"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.date_from,
      expression: "filters.date_from"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date",
      placeholder: "من تاريخ"
    },
    domProps: {
      value: _vm.filters.date_from
    },
    on: {
      change: _vm.fetchBatches,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.filters, "date_from", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "col-md-3"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.date_to,
      expression: "filters.date_to"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date",
      placeholder: "إلى تاريخ"
    },
    domProps: {
      value: _vm.filters.date_to
    },
    on: {
      change: _vm.fetchBatches,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.filters, "date_to", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "col-md-3"
  }, [_c("button", {
    staticClass: "btn btn-outline-secondary w-100",
    on: {
      click: _vm.resetFilters
    }
  }, [_c("i", {
    staticClass: "fas fa-redo me-1"
  }), _vm._v(" إعادة تعيين\n          ")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-hover"
  }, [_vm._m(1), _vm._v(" "), !_vm.loading ? _c("tbody", [_vm._l(_vm.batches, function (batch) {
    var _batch$product, _batch$recipe;
    return _c("tr", {
      key: batch.id
    }, [_c("td", [_c("strong", [_vm._v(_vm._s(batch.batch_number))])]), _vm._v(" "), _c("td", [_vm._v("\n                " + _vm._s((_batch$product = batch.product) === null || _batch$product === void 0 ? void 0 : _batch$product.name) + "\n                "), batch.product_variation ? _c("span", {
      staticClass: "text-muted"
    }, [_vm._v("\n                  (" + _vm._s(batch.product_variation.var_name) + ")\n                ")]) : _vm._e()]), _vm._v(" "), _c("td", [_vm._v(_vm._s((_batch$recipe = batch.recipe) === null || _batch$recipe === void 0 ? void 0 : _batch$recipe.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatDate(batch.production_date)))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(batch.planned_quantity))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(batch.actual_quantity || "-"))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(batch.total_cost)))]), _vm._v(" "), _c("td", [_c("span", {
      "class": "badge bg-" + _vm.getStatusColor(batch.status)
    }, [_vm._v("\n                  " + _vm._s(_vm.formatStatus(batch.status)) + "\n                ")])]), _vm._v(" "), _c("td", [_c("div", {
      staticClass: "btn-group btn-group-sm"
    }, [batch.status === "draft" ? _c("button", {
      staticClass: "btn btn-outline-primary",
      attrs: {
        title: "بدء الإنتاج"
      },
      on: {
        click: function click($event) {
          return _vm.startBatch(batch);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-play"
    })]) : _vm._e(), _vm._v(" "), ["draft", "in_progress"].includes(batch.status) ? _c("button", {
      staticClass: "btn btn-outline-success",
      attrs: {
        title: "إكمال"
      },
      on: {
        click: function click($event) {
          return _vm.openCompleteModal(batch);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-check"
    })]) : _vm._e(), _vm._v(" "), _c("button", {
      staticClass: "btn btn-outline-info",
      attrs: {
        title: "عرض التفاصيل"
      },
      on: {
        click: function click($event) {
          return _vm.viewDetails(batch);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-eye"
    })]), _vm._v(" "), batch.status === "completed" ? _c("button", {
      staticClass: "btn btn-outline-secondary",
      attrs: {
        title: "استنساخ"
      },
      on: {
        click: function click($event) {
          return _vm.cloneBatch(batch);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-copy"
    })]) : _vm._e(), _vm._v(" "), ["draft", "in_progress", "completed"].includes(batch.status) ? _c("button", {
      staticClass: "btn btn-outline-warning",
      attrs: {
        title: "تعديل"
      },
      on: {
        click: function click($event) {
          return _vm.openEditModal(batch);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-edit"
    })]) : _vm._e(), _vm._v(" "), ["draft", "in_progress"].includes(batch.status) ? _c("button", {
      staticClass: "btn btn-outline-danger",
      attrs: {
        title: "إلغاء"
      },
      on: {
        click: function click($event) {
          return _vm.cancelBatch(batch);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-times"
    })]) : _vm._e()])])]);
  }), _vm._v(" "), _vm.batches.length === 0 ? _c("tr", [_c("td", {
    staticClass: "text-center py-4 text-muted",
    attrs: {
      colspan: "9"
    }
  }, [_vm._v("\n                لم يتم العثور على دفعات إنتاج. "), _c("router-link", {
    attrs: {
      to: {
        name: "manufacturing.production.create"
      }
    }
  }, [_vm._v("ابدأ إنتاجك الأول")])], 1)]) : _vm._e()], 2) : _c("tbody", [_vm._m(2)])])]), _vm._v(" "), _vm.pagination.total > 0 ? _c("div", {
    staticClass: "d-flex justify-content-between align-items-center mt-3"
  }, [_c("div", {
    staticClass: "text-muted"
  }, [_vm._v("\n          عرض " + _vm._s((_vm.pagination.current_page - 1) * _vm.pagination.per_page + 1) + " - " + _vm._s(Math.min(_vm.pagination.current_page * _vm.pagination.per_page, _vm.pagination.total)) + " من " + _vm._s(_vm.pagination.total) + "\n        ")]), _vm._v(" "), _c("nav", [_c("ul", {
    staticClass: "pagination pagination-sm mb-0"
  }, [_c("li", {
    staticClass: "page-item",
    "class": {
      disabled: _vm.pagination.current_page === 1
    }
  }, [_c("a", {
    staticClass: "page-link",
    attrs: {
      href: "#"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.goToPage(_vm.pagination.current_page - 1);
      }
    }
  }, [_vm._v("السابق")])]), _vm._v(" "), _c("li", {
    staticClass: "page-item",
    "class": {
      disabled: _vm.pagination.current_page === _vm.pagination.last_page
    }
  }, [_c("a", {
    staticClass: "page-link",
    attrs: {
      href: "#"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.goToPage(_vm.pagination.current_page + 1);
      }
    }
  }, [_vm._v("التالي")])])])])]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "completeModal",
      tabindex: "-1"
    }
  }, [_c("div", {
    staticClass: "modal-dialog modal-lg"
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title"
  }, [_vm._v("إكمال الإنتاج: " + _vm._s((_vm$selectedBatch = _vm.selectedBatch) === null || _vm$selectedBatch === void 0 ? void 0 : _vm$selectedBatch.batch_number))]), _vm._v(" "), _c("button", {
    staticClass: "btn-close",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  })]), _vm._v(" "), _vm.selectedBatch ? _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_vm._m(3), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.completeForm.actual_quantity,
      expression: "completeForm.actual_quantity"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0",
      step: "0.01"
    },
    domProps: {
      value: _vm.completeForm.actual_quantity
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.completeForm, "actual_quantity", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "text-muted"
  }, [_vm._v("المخطط: " + _vm._s(_vm.selectedBatch.planned_quantity))])]), _vm._v(" "), _c("h6", {
    staticClass: "mb-3"
  }, [_vm._v("الاستخدام الفعلي للمكونات")]), _vm._v(" "), _c("p", {
    staticClass: "text-muted small"
  }, [_vm._v("اترك فارغاً لاستخدام الكميات المطلوبة")]), _vm._v(" "), _c("table", {
    staticClass: "table table-sm"
  }, [_vm._m(4), _vm._v(" "), _c("tbody", _vm._l(_vm.selectedBatch.ingredients, function (ing) {
    var _ing$raw_material, _ing$unit;
    return _c("tr", {
      key: ing.id
    }, [_c("td", [_vm._v(_vm._s((_ing$raw_material = ing.raw_material) === null || _ing$raw_material === void 0 ? void 0 : _ing$raw_material.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.required_quantity) + " " + _vm._s((_ing$unit = ing.unit) === null || _ing$unit === void 0 ? void 0 : _ing$unit.symbol))]), _vm._v(" "), _c("td", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.completeForm.actual_ingredients[ing.raw_material_id],
        expression: "completeForm.actual_ingredients[ing.raw_material_id]"
      }],
      staticClass: "form-control form-control-sm",
      attrs: {
        type: "number",
        min: "0",
        step: "0.0001",
        placeholder: ing.required_quantity
      },
      domProps: {
        value: _vm.completeForm.actual_ingredients[ing.raw_material_id]
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(_vm.completeForm.actual_ingredients, ing.raw_material_id, $event.target.value);
        }
      }
    })])]);
  }), 0)])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  }, [_vm._v("إلغاء")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "button",
      disabled: _vm.completing
    },
    on: {
      click: _vm.submitComplete
    }
  }, [_vm.completing ? _c("span", {
    staticClass: "spinner-border spinner-border-sm me-1"
  }) : _vm._e(), _vm._v("\n            إكمال الإنتاج\n          ")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "editModal",
      tabindex: "-1"
    }
  }, [_c("div", {
    staticClass: "modal-dialog"
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title"
  }, [_vm._v("تعديل الإنتاج: " + _vm._s((_vm$selectedBatch2 = _vm.selectedBatch) === null || _vm$selectedBatch2 === void 0 ? void 0 : _vm$selectedBatch2.batch_number))]), _vm._v(" "), _c("button", {
    staticClass: "btn-close",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  })]), _vm._v(" "), _vm.selectedBatch ? _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تاريخ الإنتاج")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.editForm.production_date,
      expression: "editForm.production_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.editForm.production_date
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.editForm, "production_date", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تاريخ انتهاء الصلاحية")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.editForm.expiry_date,
      expression: "editForm.expiry_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.editForm.expiry_date
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.editForm, "expiry_date", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تكلفة العمالة")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.editForm.labor_cost,
      expression: "editForm.labor_cost"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0",
      step: "0.01"
    },
    domProps: {
      value: _vm.editForm.labor_cost
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.editForm, "labor_cost", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("التكاليف الإضافية")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.editForm.overhead_cost,
      expression: "editForm.overhead_cost"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0",
      step: "0.01"
    },
    domProps: {
      value: _vm.editForm.overhead_cost
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.editForm, "overhead_cost", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("ملاحظات")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.editForm.notes,
      expression: "editForm.notes"
    }],
    staticClass: "form-control",
    attrs: {
      rows: "3"
    },
    domProps: {
      value: _vm.editForm.notes
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.editForm, "notes", $event.target.value);
      }
    }
  })])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  }, [_vm._v("إلغاء")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button",
      disabled: _vm.editing
    },
    on: {
      click: _vm.submitEdit
    }
  }, [_vm.editing ? _c("span", {
    staticClass: "spinner-border spinner-border-sm me-1"
  }) : _vm._e(), _vm._v("\n            حفظ التغييرات\n          ")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "detailsModal",
      tabindex: "-1"
    }
  }, [_c("div", {
    staticClass: "modal-dialog modal-lg"
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title"
  }, [_vm._v("الدفعة: " + _vm._s((_vm$selectedBatch3 = _vm.selectedBatch) === null || _vm$selectedBatch3 === void 0 ? void 0 : _vm$selectedBatch3.batch_number))]), _vm._v(" "), _c("button", {
    staticClass: "btn-close",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  })]), _vm._v(" "), _vm.selectedBatch ? _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "row mb-3"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("المنتج:")]), _c("br"), _vm._v("\n              " + _vm._s((_vm$selectedBatch$pro = _vm.selectedBatch.product) === null || _vm$selectedBatch$pro === void 0 ? void 0 : _vm$selectedBatch$pro.name) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("الحالة:")]), _c("br"), _vm._v(" "), _c("span", {
    "class": "badge bg-" + _vm.getStatusColor(_vm.selectedBatch.status)
  }, [_vm._v("\n                " + _vm._s(_vm.formatStatus(_vm.selectedBatch.status)) + "\n              ")])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("تاريخ الإنتاج:")]), _c("br"), _vm._v("\n              " + _vm._s(_vm.formatDate(_vm.selectedBatch.production_date)) + "\n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mb-3"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("الكمية المخططة:")]), _c("br"), _vm._v("\n              " + _vm._s(_vm.selectedBatch.planned_quantity) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("الكمية الفعلية:")]), _c("br"), _vm._v("\n              " + _vm._s(_vm.selectedBatch.actual_quantity || "-") + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("تكلفة الوحدة:")]), _c("br"), _vm._v("\n              " + _vm._s(_vm.formatCurrency(_vm.selectedBatch.unit_cost)) + "\n            ")])]), _vm._v(" "), _c("h6", {
    staticClass: "mt-4 mb-3"
  }, [_vm._v("تفصيل التكاليف")]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("تكلفة المواد:")]), _vm._v(" " + _vm._s(_vm.formatCurrency(_vm.selectedBatch.material_cost)) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("تكلفة العمالة:")]), _vm._v(" " + _vm._s(_vm.formatCurrency(_vm.selectedBatch.labor_cost)) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("التكاليف الإضافية:")]), _vm._v(" " + _vm._s(_vm.formatCurrency(_vm.selectedBatch.overhead_cost)) + "\n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "mt-2"
  }, [_c("strong", [_vm._v("التكلفة الإجمالية:")]), _vm._v(" "), _c("span", {
    staticClass: "text-primary fs-5"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.selectedBatch.total_cost)))])]), _vm._v(" "), _c("h6", {
    staticClass: "mt-4 mb-3"
  }, [_vm._v("المكونات المستخدمة")]), _vm._v(" "), _c("table", {
    staticClass: "table table-sm"
  }, [_vm._m(5), _vm._v(" "), _c("tbody", _vm._l(_vm.selectedBatch.ingredients, function (ing) {
    var _ing$raw_material2, _ing$unit2, _ing$unit3;
    return _c("tr", {
      key: ing.id
    }, [_c("td", [_vm._v(_vm._s((_ing$raw_material2 = ing.raw_material) === null || _ing$raw_material2 === void 0 ? void 0 : _ing$raw_material2.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.required_quantity) + " " + _vm._s((_ing$unit2 = ing.unit) === null || _ing$unit2 === void 0 ? void 0 : _ing$unit2.symbol))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.actual_quantity || "-") + " " + _vm._s((_ing$unit3 = ing.unit) === null || _ing$unit3 === void 0 ? void 0 : _ing$unit3.symbol))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(ing.total_cost)))])]);
  }), 0)]), _vm._v(" "), _vm.selectedBatch.notes ? _c("div", {
    staticClass: "mt-3"
  }, [_c("h6", [_vm._v("ملاحظات")]), _vm._v(" "), _c("p", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.selectedBatch.notes))])]) : _vm._e()]) : _vm._e()])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("h4", {
    staticClass: "mb-1"
  }, [_vm._v("دفعات الإنتاج")]), _vm._v(" "), _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("إدارة وتتبع عمليات الإنتاج الخاصة بك")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("رقم الدفعة")]), _vm._v(" "), _c("th", [_vm._v("المنتج")]), _vm._v(" "), _c("th", [_vm._v("الوصفة")]), _vm._v(" "), _c("th", [_vm._v("التاريخ")]), _vm._v(" "), _c("th", [_vm._v("المخطط")]), _vm._v(" "), _c("th", [_vm._v("الفعلي")]), _vm._v(" "), _c("th", [_vm._v("التكلفة الإجمالية")]), _vm._v(" "), _c("th", [_vm._v("الحالة")]), _vm._v(" "), _c("th", [_vm._v("الإجراءات")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("tr", [_c("td", {
    staticClass: "text-center py-4",
    attrs: {
      colspan: "9"
    }
  }, [_c("div", {
    staticClass: "spinner-border text-primary"
  })])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("كمية الإنتاج الفعلية "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("المادة")]), _vm._v(" "), _c("th", [_vm._v("المطلوب")]), _vm._v(" "), _c("th", [_vm._v("المستخدم فعلياً")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("المادة")]), _vm._v(" "), _c("th", [_vm._v("المطلوب")]), _vm._v(" "), _c("th", [_vm._v("الفعلي")]), _vm._v(" "), _c("th", [_vm._v("التكلفة")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ProductionList.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ProductionList.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ProductionList_vue_vue_type_template_id_f76f3304___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProductionList.vue?vue&type=template&id=f76f3304& */ "./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=template&id=f76f3304&");
/* harmony import */ var _ProductionList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProductionList.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProductionList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProductionList_vue_vue_type_template_id_f76f3304___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProductionList_vue_vue_type_template_id_f76f3304___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/manufacturing/ProductionList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductionList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=template&id=f76f3304&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=template&id=f76f3304& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionList_vue_vue_type_template_id_f76f3304___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionList_vue_vue_type_template_id_f76f3304___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductionList_vue_vue_type_template_id_f76f3304___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductionList.vue?vue&type=template&id=f76f3304& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ProductionList.vue?vue&type=template&id=f76f3304&");


/***/ })

}]);