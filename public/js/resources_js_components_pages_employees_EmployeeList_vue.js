"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_employees_EmployeeList_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/employees/EmployeeList.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/employees/EmployeeList.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
  name: 'EmployeeList',
  data: function data() {
    return {
      loading: false,
      saving: false,
      employees: [],
      filters: {
        search: '',
        status: ''
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1
      },
      stats: {
        total: 0,
        active: 0,
        totalSalary: 0
      },
      editingEmployee: null,
      form: {
        full_name: '',
        phone: '',
        job_title: '',
        monthly_salary: '',
        hire_date: '',
        status: 'active',
        notes: ''
      },
      employeeModal: null,
      debounceTimer: null
    };
  },
  methods: {
    fetchEmployees: function fetchEmployees() {
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
              return axios.get('/dashboard/api/employees', {
                params: params
              });
            case 6:
              response = _context.sent;
              _this.employees = response.data.data;
              _this.pagination = response.data.pagination;
              _this.calculateStats();
              _context.next = 15;
              break;
            case 12:
              _context.prev = 12;
              _context.t0 = _context["catch"](2);
              toastr.error('فشل تحميل الموظفين');
            case 15:
              _context.prev = 15;
              _this.loading = false;
              return _context.finish(15);
            case 18:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 12, 15, 18]]);
      }))();
    },
    calculateStats: function calculateStats() {
      this.stats.total = this.pagination.total;
      this.stats.active = this.employees.filter(function (e) {
        return e.status === 'active';
      }).length;
      this.stats.totalSalary = this.employees.filter(function (e) {
        return e.status === 'active';
      }).reduce(function (sum, e) {
        return sum + parseFloat(e.monthly_salary || 0);
      }, 0);
    },
    debouncedFetch: function debouncedFetch() {
      var _this2 = this;
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(function () {
        _this2.fetchEmployees();
      }, 300);
    },
    resetFilters: function resetFilters() {
      this.filters = {
        search: '',
        status: ''
      };
      this.fetchEmployees();
    },
    goToPage: function goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchEmployees(page);
      }
    },
    formatCurrency: function formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
      });
    },
    formatDate: function formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    openModal: function openModal() {
      var employee = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.editingEmployee = employee;
      if (employee) {
        this.form = {
          full_name: employee.full_name,
          phone: employee.phone || '',
          job_title: employee.job_title,
          monthly_salary: employee.monthly_salary,
          hire_date: employee.hire_date || '',
          status: employee.status,
          notes: employee.notes || ''
        };
      } else {
        this.form = {
          full_name: '',
          phone: '',
          job_title: '',
          monthly_salary: '',
          hire_date: '',
          status: 'active',
          notes: ''
        };
      }
      this.employeeModal = new bootstrap.Modal(document.getElementById('employeeModal'));
      this.employeeModal.show();
    },
    submitForm: function submitForm() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this3.saving = true;
              _context2.prev = 1;
              if (!_this3.editingEmployee) {
                _context2.next = 8;
                break;
              }
              _context2.next = 5;
              return axios.put("/dashboard/api/employees/".concat(_this3.editingEmployee.id), _this3.form);
            case 5:
              toastr.success('تم تحديث الموظف');
              _context2.next = 11;
              break;
            case 8:
              _context2.next = 10;
              return axios.post('/dashboard/api/employees', _this3.form);
            case 10:
              toastr.success('تم إنشاء الموظف');
            case 11:
              _this3.employeeModal.hide();
              _this3.fetchEmployees(_this3.pagination.current_page);
              _context2.next = 18;
              break;
            case 15:
              _context2.prev = 15;
              _context2.t0 = _context2["catch"](1);
              toastr.error(((_error$response = _context2.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل حفظ الموظف');
            case 18:
              _context2.prev = 18;
              _this3.saving = false;
              return _context2.finish(18);
            case 21:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[1, 15, 18, 21]]);
      }))();
    },
    toggleStatus: function toggleStatus(employee) {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.prev = 0;
              _context3.next = 3;
              return axios.post("/dashboard/api/employees/".concat(employee.id, "/toggle-status"));
            case 3:
              toastr.success('تم تحديث الحالة');
              _this4.fetchEmployees(_this4.pagination.current_page);
              _context3.next = 10;
              break;
            case 7:
              _context3.prev = 7;
              _context3.t0 = _context3["catch"](0);
              toastr.error('فشل تحديث الحالة');
            case 10:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[0, 7]]);
      }))();
    },
    deleteEmployee: function deleteEmployee(employee) {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var result;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.next = 2;
              return swal.fire({
                title: 'حذف الموظف؟',
                text: "\u0647\u0644 \u0623\u0646\u062A \u0645\u062A\u0623\u0643\u062F \u0645\u0646 \u062D\u0630\u0641 \"".concat(employee.full_name, "\"\u061F"),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'نعم، احذف'
              });
            case 2:
              result = _context4.sent;
              if (!result.isConfirmed) {
                _context4.next = 14;
                break;
              }
              _context4.prev = 4;
              _context4.next = 7;
              return axios["delete"]("/dashboard/api/employees/".concat(employee.id));
            case 7:
              toastr.success('تم حذف الموظف');
              _this5.fetchEmployees(_this5.pagination.current_page);
              _context4.next = 14;
              break;
            case 11:
              _context4.prev = 11;
              _context4.t0 = _context4["catch"](4);
              toastr.error('فشل حذف الموظف');
            case 14:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[4, 11]]);
      }))();
    }
  },
  mounted: function mounted() {
    this.fetchEmployees();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/employees/EmployeeList.vue?vue&type=template&id=1d8b32cc&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/employees/EmployeeList.vue?vue&type=template&id=1d8b32cc& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "employee-list"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center mb-4"
  }, [_vm._m(0), _vm._v(" "), _c("div", [_c("router-link", {
    staticClass: "btn btn-outline-info me-2",
    attrs: {
      to: {
        name: "employees.salary-list"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-file-invoice-dollar me-1"
  }), _vm._v(" قائمة الرواتب\n      ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    on: {
      click: function click($event) {
        return _vm.openModal();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-plus me-1"
  }), _vm._v(" إضافة موظف\n      ")])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "row mb-4"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card bg-primary text-white"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("إجمالي الموظفين")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.stats.total))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-users fa-2x opacity-50"
  })])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card bg-success text-white"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("النشطون")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.stats.active))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-user-check fa-2x opacity-50"
  })])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card bg-warning text-dark"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("الرواتب الشهرية")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.stats.totalSalary)))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-money-bill-wave fa-2x opacity-50"
  })])])])])]), _vm._v(" "), _c("div", {
    staticClass: "card mb-4"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row g-3"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.search,
      expression: "filters.search"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "البحث بالاسم، الهاتف، أو المسمى الوظيفي..."
    },
    domProps: {
      value: _vm.filters.search
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.filters, "search", $event.target.value);
      }, _vm.debouncedFetch]
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
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
      }, _vm.fetchEmployees]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("جميع الموظفين")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "active"
    }
  }, [_vm._v("النشطون فقط")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "inactive"
    }
  }, [_vm._v("غير النشطين فقط")])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-2"
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
  }, [_vm._m(1), _vm._v(" "), !_vm.loading ? _c("tbody", [_vm._l(_vm.employees, function (emp) {
    return _c("tr", {
      key: emp.id
    }, [_c("td", [_c("strong", [_vm._v(_vm._s(emp.full_name))])]), _vm._v(" "), _c("td", [_vm._v(_vm._s(emp.phone || "-"))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(emp.job_title))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(emp.monthly_salary)))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(emp.hire_date ? _vm.formatDate(emp.hire_date) : "-"))]), _vm._v(" "), _c("td", [_c("span", {
      "class": "badge bg-" + (emp.status === "active" ? "success" : "secondary")
    }, [_vm._v("\n                  " + _vm._s(emp.status === "active" ? "نشط" : "غير نشط") + "\n                ")])]), _vm._v(" "), _c("td", [_c("div", {
      staticClass: "btn-group btn-group-sm"
    }, [_c("button", {
      staticClass: "btn btn-outline-primary",
      attrs: {
        title: "تعديل"
      },
      on: {
        click: function click($event) {
          return _vm.openModal(emp);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-edit"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-outline-warning",
      attrs: {
        title: emp.status === "active" ? "تعطيل" : "تفعيل"
      },
      on: {
        click: function click($event) {
          return _vm.toggleStatus(emp);
        }
      }
    }, [_c("i", {
      "class": emp.status === "active" ? "fas fa-user-slash" : "fas fa-user-check"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-outline-danger",
      attrs: {
        title: "حذف"
      },
      on: {
        click: function click($event) {
          return _vm.deleteEmployee(emp);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])])])]);
  }), _vm._v(" "), _vm.employees.length === 0 ? _c("tr", [_c("td", {
    staticClass: "text-center py-4 text-muted",
    attrs: {
      colspan: "7"
    }
  }, [_vm._v('\n                لم يتم العثور على موظفين. انقر على "إضافة موظف" للبدء.\n              ')])]) : _vm._e()], 2) : _c("tbody", [_vm._m(2)])])]), _vm._v(" "), _vm.pagination.total > 0 ? _c("div", {
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
      id: "employeeModal",
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
  }, [_vm._v(_vm._s(_vm.editingEmployee ? "تعديل موظف" : "إضافة موظف"))]), _vm._v(" "), _c("button", {
    staticClass: "btn-close",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  })]), _vm._v(" "), _c("form", {
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.submitForm.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_vm._m(3), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.full_name,
      expression: "form.full_name"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      required: ""
    },
    domProps: {
      value: _vm.form.full_name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "full_name", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("الهاتف")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.phone,
      expression: "form.phone"
    }],
    staticClass: "form-control",
    attrs: {
      type: "tel"
    },
    domProps: {
      value: _vm.form.phone
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "phone", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_vm._m(4), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.job_title,
      expression: "form.job_title"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      required: "",
      placeholder: "مثل: خباز، كاشير، مدير"
    },
    domProps: {
      value: _vm.form.job_title
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "job_title", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_vm._m(5), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.monthly_salary,
      expression: "form.monthly_salary"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      required: "",
      min: "0",
      step: "0.01"
    },
    domProps: {
      value: _vm.form.monthly_salary
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "monthly_salary", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تاريخ التوظيف")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.hire_date,
      expression: "form.hire_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.form.hire_date
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "hire_date", $event.target.value);
      }
    }
  })]), _vm._v(" "), _vm.editingEmployee ? _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("الحالة")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.status,
      expression: "form.status"
    }],
    staticClass: "form-select",
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.form, "status", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: "active"
    }
  }, [_vm._v("نشط")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "inactive"
    }
  }, [_vm._v("غير نشط")])])]) : _vm._e(), _vm._v(" "), _c("div", {
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
      rows: "2"
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
  })])]), _vm._v(" "), _c("div", {
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
      type: "submit",
      disabled: _vm.saving
    }
  }, [_vm.saving ? _c("span", {
    staticClass: "spinner-border spinner-border-sm me-1"
  }) : _vm._e(), _vm._v("\n              " + _vm._s(_vm.editingEmployee ? "تحديث" : "إنشاء") + "\n            ")])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("h4", {
    staticClass: "mb-1"
  }, [_vm._v("إدارة الموظفين")]), _vm._v(" "), _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("إدارة موظفيك ومعلوماتهم")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("الاسم")]), _vm._v(" "), _c("th", [_vm._v("الهاتف")]), _vm._v(" "), _c("th", [_vm._v("المسمى الوظيفي")]), _vm._v(" "), _c("th", [_vm._v("الراتب الشهري")]), _vm._v(" "), _c("th", [_vm._v("تاريخ التوظيف")]), _vm._v(" "), _c("th", [_vm._v("الحالة")]), _vm._v(" "), _c("th", [_vm._v("الإجراءات")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("tr", [_c("td", {
    staticClass: "text-center py-4",
    attrs: {
      colspan: "7"
    }
  }, [_c("div", {
    staticClass: "spinner-border text-primary"
  })])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("الاسم الكامل "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("المسمى الوظيفي "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("الراتب الشهري "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/pages/employees/EmployeeList.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/pages/employees/EmployeeList.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _EmployeeList_vue_vue_type_template_id_1d8b32cc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EmployeeList.vue?vue&type=template&id=1d8b32cc& */ "./resources/js/components/pages/employees/EmployeeList.vue?vue&type=template&id=1d8b32cc&");
/* harmony import */ var _EmployeeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EmployeeList.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/employees/EmployeeList.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EmployeeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EmployeeList_vue_vue_type_template_id_1d8b32cc___WEBPACK_IMPORTED_MODULE_0__.render,
  _EmployeeList_vue_vue_type_template_id_1d8b32cc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/employees/EmployeeList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/employees/EmployeeList.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/pages/employees/EmployeeList.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EmployeeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EmployeeList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/employees/EmployeeList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EmployeeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/employees/EmployeeList.vue?vue&type=template&id=1d8b32cc&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/pages/employees/EmployeeList.vue?vue&type=template&id=1d8b32cc& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EmployeeList_vue_vue_type_template_id_1d8b32cc___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EmployeeList_vue_vue_type_template_id_1d8b32cc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EmployeeList_vue_vue_type_template_id_1d8b32cc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EmployeeList.vue?vue&type=template&id=1d8b32cc& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/employees/EmployeeList.vue?vue&type=template&id=1d8b32cc&");


/***/ })

}]);