"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_manufacturing_ManufacturingDashboard_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
  name: 'ManufacturingDashboard',
  data: function data() {
    return {
      loading: true,
      stats: {
        totalMaterials: 0,
        lowStockCount: 0,
        totalRecipes: 0,
        todayProduction: 0
      },
      lowStockMaterials: [],
      recentBatches: [],
      recipes: [],
      selectedMaterial: null,
      purchaseForm: {
        quantity: '',
        unit_cost: '',
        notes: ''
      },
      purchasing: false
    };
  },
  methods: {
    fetchData: function fetchData() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _materialsRes$data$pa, lowStockRes, materialsRes, recipesRes, batchesRes, todayBatches;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this.loading = true;
              _context.prev = 1;
              _context.next = 4;
              return axios.get('/dashboard/api/manufacturing/raw-materials/low-stock');
            case 4:
              lowStockRes = _context.sent;
              _this.lowStockMaterials = lowStockRes.data.data || [];
              _this.stats.lowStockCount = _this.lowStockMaterials.length;

              // Fetch all materials count
              _context.next = 9;
              return axios.get('/dashboard/api/manufacturing/raw-materials?per_page=1');
            case 9:
              materialsRes = _context.sent;
              _this.stats.totalMaterials = ((_materialsRes$data$pa = materialsRes.data.pagination) === null || _materialsRes$data$pa === void 0 ? void 0 : _materialsRes$data$pa.total) || 0;

              // Fetch recipes
              _context.next = 13;
              return axios.get('/dashboard/api/manufacturing/recipes?active_only=1');
            case 13:
              recipesRes = _context.sent;
              _this.recipes = recipesRes.data.data || [];
              _this.stats.totalRecipes = _this.recipes.length;

              // Fetch recent batches
              _context.next = 18;
              return axios.get('/dashboard/api/manufacturing/batches?per_page=5');
            case 18:
              batchesRes = _context.sent;
              _this.recentBatches = batchesRes.data.data || [];

              // Count today's production
              todayBatches = _this.recentBatches.filter(function (b) {
                return b.status === 'completed' && new Date(b.production_date).toDateString() === new Date().toDateString();
              });
              _this.stats.todayProduction = todayBatches.reduce(function (sum, b) {
                return sum + (b.actual_quantity || 0);
              }, 0);
              _context.next = 28;
              break;
            case 24:
              _context.prev = 24;
              _context.t0 = _context["catch"](1);
              console.error('Error fetching dashboard data:', _context.t0);
              toastr.error('فشل تحميل بيانات لوحة التحكم');
            case 28:
              _context.prev = 28;
              _this.loading = false;
              return _context.finish(28);
            case 31:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[1, 24, 28, 31]]);
      }))();
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
    openPurchaseModal: function openPurchaseModal(material) {
      this.selectedMaterial = material;
      this.purchaseForm = {
        quantity: '',
        unit_cost: material.purchase_price || '',
        notes: ''
      };
      $('#purchaseModal').modal('show');
    },
    submitPurchase: function submitPurchase() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              if (!(!_this2.purchaseForm.quantity || !_this2.purchaseForm.unit_cost)) {
                _context2.next = 3;
                break;
              }
              toastr.error('الرجاء إدخال الكمية وتكلفة الوحدة');
              return _context2.abrupt("return");
            case 3:
              _this2.purchasing = true;
              _context2.prev = 4;
              _context2.next = 7;
              return axios.post("/dashboard/api/manufacturing/raw-materials/".concat(_this2.selectedMaterial.id, "/purchase"), _this2.purchaseForm);
            case 7:
              toastr.success('تم إضافة المخزون بنجاح');
              $('#purchaseModal').modal('hide');
              _this2.fetchData();
              _context2.next = 15;
              break;
            case 12:
              _context2.prev = 12;
              _context2.t0 = _context2["catch"](4);
              toastr.error(((_error$response = _context2.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل إضافة المخزون');
            case 15:
              _context2.prev = 15;
              _this2.purchasing = false;
              return _context2.finish(15);
            case 18:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[4, 12, 15, 18]]);
      }))();
    }
  },
  mounted: function mounted() {
    this.fetchData();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$selectedMaterial, _vm$selectedMaterial2, _vm$selectedMaterial3;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "manufacturing-dashboard"
  }, [_c("div", {
    staticClass: "row mb-4"
  }, [_c("div", {
    staticClass: "col-md-3"
  }, [_c("div", {
    staticClass: "card bg-primary text-white"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("المواد الخام")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.stats.totalMaterials))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-boxes fa-2x opacity-50"
  })])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-3"
  }, [_c("div", {
    staticClass: "card bg-warning text-dark"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("مخزون منخفض")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.stats.lowStockCount))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-exclamation-triangle fa-2x opacity-50"
  })])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-3"
  }, [_c("div", {
    staticClass: "card bg-info text-white"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("الوصفات النشطة")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.stats.totalRecipes))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-receipt fa-2x opacity-50"
  })])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-3"
  }, [_c("div", {
    staticClass: "card bg-success text-white"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center"
  }, [_c("div", [_c("h6", {
    staticClass: "card-title mb-0"
  }, [_vm._v("إنتاج اليوم")]), _vm._v(" "), _c("h3", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.stats.todayProduction))])]), _vm._v(" "), _c("i", {
    staticClass: "fas fa-industry fa-2x opacity-50"
  })])])])])]), _vm._v(" "), _c("div", {
    staticClass: "row mb-4"
  }, [_c("div", {
    staticClass: "col-12"
  }, [_c("div", {
    staticClass: "card"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("router-link", {
    staticClass: "btn btn-primary me-2",
    attrs: {
      to: {
        name: "manufacturing.raw-materials.create"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-plus me-1"
  }), _vm._v(" إضافة مادة خام\n          ")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-info me-2",
    attrs: {
      to: {
        name: "manufacturing.recipes.create"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-plus me-1"
  }), _vm._v(" إنشاء وصفة\n          ")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-success",
    attrs: {
      to: {
        name: "manufacturing.production.create"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-play me-1"
  }), _vm._v(" بدء الإنتاج\n          ")])], 1)])])]), _vm._v(" "), _vm.lowStockMaterials.length > 0 ? _c("div", {
    staticClass: "row mb-4"
  }, [_c("div", {
    staticClass: "col-12"
  }, [_c("div", {
    staticClass: "card border-warning"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-sm"
  }, [_vm._m(2), _vm._v(" "), _c("tbody", _vm._l(_vm.lowStockMaterials, function (material) {
    var _material$unit, _material$unit2;
    return _c("tr", {
      key: material.id
    }, [_c("td", [_vm._v(_vm._s(material.name))]), _vm._v(" "), _c("td", {
      staticClass: "text-danger"
    }, [_vm._v(_vm._s(material.current_stock) + " " + _vm._s((_material$unit = material.unit) === null || _material$unit === void 0 ? void 0 : _material$unit.symbol))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(material.min_stock_level) + " " + _vm._s((_material$unit2 = material.unit) === null || _material$unit2 === void 0 ? void 0 : _material$unit2.symbol))]), _vm._v(" "), _c("td", [_c("button", {
      staticClass: "btn btn-sm btn-success",
      on: {
        click: function click($event) {
          return _vm.openPurchaseModal(material);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-plus"
    }), _vm._v(" إضافة مخزون\n                    ")])])]);
  }), 0)])])])])])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header d-flex justify-content-between align-items-center"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("دفعات الإنتاج الأخيرة")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-sm btn-outline-primary",
    attrs: {
      to: {
        name: "manufacturing.production"
      }
    }
  }, [_vm._v("\n            عرض الكل\n          ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_vm.recentBatches.length > 0 ? _c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-sm"
  }, [_vm._m(3), _vm._v(" "), _c("tbody", _vm._l(_vm.recentBatches, function (batch) {
    var _batch$product;
    return _c("tr", {
      key: batch.id
    }, [_c("td", [_vm._v(_vm._s(batch.batch_number))]), _vm._v(" "), _c("td", [_vm._v(_vm._s((_batch$product = batch.product) === null || _batch$product === void 0 ? void 0 : _batch$product.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(batch.actual_quantity || batch.planned_quantity))]), _vm._v(" "), _c("td", [_c("span", {
      "class": "badge bg-" + _vm.getStatusColor(batch.status)
    }, [_vm._v("\n                      " + _vm._s(batch.status) + "\n                    ")])])]);
  }), 0)])]) : _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("لا توجد دفعات إنتاج حديثة")])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header d-flex justify-content-between align-items-center"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("الوصفات الشائعة")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-sm btn-outline-primary",
    attrs: {
      to: {
        name: "manufacturing.recipes"
      }
    }
  }, [_vm._v("\n            عرض الكل\n          ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_vm.recipes.length > 0 ? _c("div", {
    staticClass: "list-group list-group-flush"
  }, _vm._l(_vm.recipes.slice(0, 5), function (recipe) {
    var _recipe$product;
    return _c("div", {
      key: recipe.id,
      staticClass: "list-group-item d-flex justify-content-between align-items-center"
    }, [_c("div", [_c("h6", {
      staticClass: "mb-0"
    }, [_vm._v(_vm._s(recipe.name))]), _vm._v(" "), _c("small", {
      staticClass: "text-muted"
    }, [_vm._v(_vm._s((_recipe$product = recipe.product) === null || _recipe$product === void 0 ? void 0 : _recipe$product.name))])]), _vm._v(" "), _c("router-link", {
      staticClass: "btn btn-sm btn-outline-success",
      attrs: {
        to: {
          name: "manufacturing.production.create",
          query: {
            recipe_id: recipe.id
          }
        }
      }
    }, [_vm._v("\n                إنتاج\n              ")])], 1);
  }), 0) : _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("لم يتم إنشاء وصفات بعد")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "purchaseModal",
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
  }, [_vm._v("إضافة مخزون: " + _vm._s((_vm$selectedMaterial = _vm.selectedMaterial) === null || _vm$selectedMaterial === void 0 ? void 0 : _vm$selectedMaterial.name))]), _vm._v(" "), _c("button", {
    staticClass: "btn-close",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("الكمية (" + _vm._s((_vm$selectedMaterial2 = _vm.selectedMaterial) === null || _vm$selectedMaterial2 === void 0 ? void 0 : (_vm$selectedMaterial3 = _vm$selectedMaterial2.unit) === null || _vm$selectedMaterial3 === void 0 ? void 0 : _vm$selectedMaterial3.symbol) + ")")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.purchaseForm.quantity,
      expression: "purchaseForm.quantity"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      step: "0.01",
      min: "0"
    },
    domProps: {
      value: _vm.purchaseForm.quantity
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.purchaseForm, "quantity", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تكلفة الوحدة")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.purchaseForm.unit_cost,
      expression: "purchaseForm.unit_cost"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      step: "0.01",
      min: "0"
    },
    domProps: {
      value: _vm.purchaseForm.unit_cost
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.purchaseForm, "unit_cost", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("ملاحظات (اختياري)")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.purchaseForm.notes,
      expression: "purchaseForm.notes"
    }],
    staticClass: "form-control",
    attrs: {
      rows: "2"
    },
    domProps: {
      value: _vm.purchaseForm.notes
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.purchaseForm, "notes", $event.target.value);
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
    staticClass: "btn btn-success",
    attrs: {
      type: "button",
      disabled: _vm.purchasing
    },
    on: {
      click: _vm.submitPurchase
    }
  }, [_vm.purchasing ? _c("span", {
    staticClass: "spinner-border spinner-border-sm me-1"
  }) : _vm._e(), _vm._v("\n            إضافة مخزون\n          ")])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("إجراءات سريعة")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header bg-warning text-dark"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_c("i", {
    staticClass: "fas fa-exclamation-triangle me-2"
  }), _vm._v("تنبيهات المخزون المنخفض")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("المادة")]), _vm._v(" "), _c("th", [_vm._v("المخزون الحالي")]), _vm._v(" "), _c("th", [_vm._v("الحد الأدنى")]), _vm._v(" "), _c("th", [_vm._v("الإجراء")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("رقم الدفعة")]), _vm._v(" "), _c("th", [_vm._v("المنتج")]), _vm._v(" "), _c("th", [_vm._v("الكمية")]), _vm._v(" "), _c("th", [_vm._v("الحالة")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.manufacturing-dashboard .card[data-v-0d45ec06] {\n  border-radius: 10px;\n}\n.manufacturing-dashboard .card-header[data-v-0d45ec06] {\n  background: transparent;\n  border-bottom: 1px solid #eee;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_style_index_0_id_0d45ec06_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_style_index_0_id_0d45ec06_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_style_index_0_id_0d45ec06_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ManufacturingDashboard_vue_vue_type_template_id_0d45ec06_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true& */ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true&");
/* harmony import */ var _ManufacturingDashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ManufacturingDashboard.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=script&lang=js&");
/* harmony import */ var _ManufacturingDashboard_vue_vue_type_style_index_0_id_0d45ec06_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css& */ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ManufacturingDashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ManufacturingDashboard_vue_vue_type_template_id_0d45ec06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ManufacturingDashboard_vue_vue_type_template_id_0d45ec06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0d45ec06",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/manufacturing/ManufacturingDashboard.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ManufacturingDashboard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_template_id_0d45ec06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_template_id_0d45ec06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_template_id_0d45ec06_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=template&id=0d45ec06&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ManufacturingDashboard_vue_vue_type_style_index_0_id_0d45ec06_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/ManufacturingDashboard.vue?vue&type=style&index=0&id=0d45ec06&scoped=true&lang=css&");


/***/ })

}]);