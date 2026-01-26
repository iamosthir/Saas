"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_manufacturing_RecipeList_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
  name: 'RecipeList',
  data: function data() {
    return {
      loading: false,
      recipes: [],
      products: [],
      filters: {
        product_id: '',
        active_only: ''
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1
      },
      selectedRecipe: null
    };
  },
  methods: {
    fetchRecipes: function fetchRecipes() {
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
              return axios.get('/dashboard/api/manufacturing/recipes', {
                params: params
              });
            case 6:
              response = _context.sent;
              _this.recipes = response.data.data;
              _this.pagination = response.data.pagination;
              _context.next = 14;
              break;
            case 11:
              _context.prev = 11;
              _context.t0 = _context["catch"](2);
              toastr.error('فشل تحميل الوصفات');
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
    fetchProducts: function fetchProducts() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var response;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              _context2.next = 3;
              return axios.get('/dashboard/api/product-list');
            case 3:
              response = _context2.sent;
              _this2.products = response.data.data || response.data;
              _context2.next = 10;
              break;
            case 7:
              _context2.prev = 7;
              _context2.t0 = _context2["catch"](0);
              console.error('Failed to load products');
            case 10:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[0, 7]]);
      }))();
    },
    goToPage: function goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchRecipes(page);
      }
    },
    calculateRecipeCost: function calculateRecipeCost(recipe) {
      if (!recipe.ingredients) return 0;
      return recipe.ingredients.reduce(function (sum, ing) {
        var _ing$raw_material;
        var baseQty = ing.quantity * (1 + (ing.waste_percentage || 0) / 100);
        return sum + baseQty * (((_ing$raw_material = ing.raw_material) === null || _ing$raw_material === void 0 ? void 0 : _ing$raw_material.average_price) || 0);
      }, 0);
    },
    formatCurrency: function formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
      });
    },
    viewDetails: function viewDetails(recipe) {
      this.selectedRecipe = recipe;
      $('#detailsModal').modal('show');
    },
    hideModal: function hideModal() {
      $('#detailsModal').modal('hide');
    },
    deleteRecipe: function deleteRecipe(recipe) {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var result, _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.next = 2;
              return swal.fire({
                title: 'حذف الوصفة؟',
                text: "\u0647\u0644 \u0623\u0646\u062A \u0645\u062A\u0623\u0643\u062F \u0645\u0646 \u062D\u0630\u0641 \"".concat(recipe.name, "\"\u061F"),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'نعم، احذفها',
                cancelButtonText: 'إلغاء'
              });
            case 2:
              result = _context3.sent;
              if (!result.isConfirmed) {
                _context3.next = 14;
                break;
              }
              _context3.prev = 4;
              _context3.next = 7;
              return axios["delete"]("/dashboard/api/manufacturing/recipes/".concat(recipe.id));
            case 7:
              toastr.success('تم حذف الوصفة');
              _this3.fetchRecipes(_this3.pagination.current_page);
              _context3.next = 14;
              break;
            case 11:
              _context3.prev = 11;
              _context3.t0 = _context3["catch"](4);
              toastr.error(((_error$response = _context3.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل الحذف');
            case 14:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[4, 11]]);
      }))();
    }
  },
  mounted: function mounted() {
    this.fetchRecipes();
    this.fetchProducts();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=template&id=1cfe945a&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=template&id=1cfe945a& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$selectedRecipe, _vm$selectedRecipe$pr, _vm$selectedRecipe2;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "recipe-list"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center mb-4"
  }, [_vm._m(0), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-primary",
    attrs: {
      to: {
        name: "manufacturing.recipes.create"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-plus me-1"
  }), _vm._v(" إنشاء وصفة\n    ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "card mb-4"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row g-3"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.product_id,
      expression: "filters.product_id"
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
        _vm.$set(_vm.filters, "product_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.fetchRecipes]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("جميع المنتجات")]), _vm._v(" "), _vm._l(_vm.products, function (prod) {
    return _c("option", {
      key: prod.id,
      domProps: {
        value: prod.id
      }
    }, [_vm._v(_vm._s(prod.name))]);
  })], 2)]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.filters.active_only,
      expression: "filters.active_only"
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
        _vm.$set(_vm.filters, "active_only", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.fetchRecipes]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("جميع الوصفات")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "1"
    }
  }, [_vm._v("النشطة فقط")])])])])])]), _vm._v(" "), _c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-hover"
  }, [_vm._m(1), _vm._v(" "), !_vm.loading ? _c("tbody", [_vm._l(_vm.recipes, function (recipe) {
    var _recipe$product, _recipe$ingredients;
    return _c("tr", {
      key: recipe.id
    }, [_c("td", [_c("strong", [_vm._v(_vm._s(recipe.name))])]), _vm._v(" "), _c("td", [_vm._v("\n                " + _vm._s((_recipe$product = recipe.product) === null || _recipe$product === void 0 ? void 0 : _recipe$product.name) + "\n                "), recipe.product_variation ? _c("span", {
      staticClass: "text-muted"
    }, [_vm._v("\n                  (" + _vm._s(recipe.product_variation.var_name) + ")\n                ")]) : _vm._e()]), _vm._v(" "), _c("td", [_vm._v(_vm._s(recipe.output_quantity))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(((_recipe$ingredients = recipe.ingredients) === null || _recipe$ingredients === void 0 ? void 0 : _recipe$ingredients.length) || 0) + " عنصر")]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(_vm.calculateRecipeCost(recipe))))]), _vm._v(" "), _c("td", [_c("span", {
      "class": "badge bg-" + (recipe.is_active ? "success" : "secondary")
    }, [_vm._v("\n                  " + _vm._s(recipe.is_active ? "نشط" : "غير نشط") + "\n                ")])]), _vm._v(" "), _c("td", [_c("div", {
      staticClass: "btn-group btn-group-sm"
    }, [_c("router-link", {
      staticClass: "btn btn-outline-success",
      attrs: {
        to: {
          name: "manufacturing.production.create",
          query: {
            recipe_id: recipe.id
          }
        },
        title: "بدء الإنتاج"
      }
    }, [_c("i", {
      staticClass: "fas fa-play"
    })]), _vm._v(" "), _c("router-link", {
      staticClass: "btn btn-outline-primary",
      attrs: {
        to: {
          name: "manufacturing.recipes.edit",
          params: {
            id: recipe.id
          }
        },
        title: "تعديل"
      }
    }, [_c("i", {
      staticClass: "fas fa-edit"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-outline-info",
      attrs: {
        title: "عرض التفاصيل"
      },
      on: {
        click: function click($event) {
          return _vm.viewDetails(recipe);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-eye"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-outline-danger",
      attrs: {
        title: "حذف"
      },
      on: {
        click: function click($event) {
          return _vm.deleteRecipe(recipe);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])], 1)])]);
  }), _vm._v(" "), _vm.recipes.length === 0 ? _c("tr", [_c("td", {
    staticClass: "text-center py-4 text-muted",
    attrs: {
      colspan: "7"
    }
  }, [_vm._v("\n                لم يتم العثور على وصفات. "), _c("router-link", {
    attrs: {
      to: {
        name: "manufacturing.recipes.create"
      }
    }
  }, [_vm._v("إنشاء أول وصفة")])], 1)]) : _vm._e()], 2) : _c("tbody", [_vm._m(2)])])]), _vm._v(" "), _vm.pagination.total > 0 ? _c("div", {
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
  }, [_vm._v("الوصفة: " + _vm._s((_vm$selectedRecipe = _vm.selectedRecipe) === null || _vm$selectedRecipe === void 0 ? void 0 : _vm$selectedRecipe.name))]), _vm._v(" "), _c("button", {
    staticClass: "btn-close",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  })]), _vm._v(" "), _vm.selectedRecipe ? _c("div", {
    staticClass: "modal-body"
  }, [_c("div", {
    staticClass: "row mb-3"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("strong", [_vm._v("المنتج:")]), _vm._v(" " + _vm._s((_vm$selectedRecipe$pr = _vm.selectedRecipe.product) === null || _vm$selectedRecipe$pr === void 0 ? void 0 : _vm$selectedRecipe$pr.name) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("strong", [_vm._v("كمية الإنتاج:")]), _vm._v(" " + _vm._s(_vm.selectedRecipe.output_quantity) + "\n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mb-3"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("تكلفة العمالة:")]), _vm._v(" " + _vm._s(_vm.formatCurrency(_vm.selectedRecipe.labor_cost)) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("التكاليف الإضافية:")]), _vm._v(" " + _vm._s(_vm.formatCurrency(_vm.selectedRecipe.overhead_cost)) + "\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("strong", [_vm._v("وقت التحضير:")]), _vm._v(" " + _vm._s(_vm.selectedRecipe.prep_time_minutes || "غير متاح") + " دقيقة\n            ")])]), _vm._v(" "), _c("h6", {
    staticClass: "mt-4 mb-3"
  }, [_vm._v("المكونات")]), _vm._v(" "), _c("table", {
    staticClass: "table table-sm"
  }, [_vm._m(3), _vm._v(" "), _c("tbody", _vm._l(_vm.selectedRecipe.ingredients, function (ing) {
    var _ing$raw_material, _ing$unit, _ing$raw_material2;
    return _c("tr", {
      key: ing.id
    }, [_c("td", [_vm._v(_vm._s((_ing$raw_material = ing.raw_material) === null || _ing$raw_material === void 0 ? void 0 : _ing$raw_material.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.quantity))]), _vm._v(" "), _c("td", [_vm._v(_vm._s((_ing$unit = ing.unit) === null || _ing$unit === void 0 ? void 0 : _ing$unit.symbol))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(ing.waste_percentage) + "%")]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm.formatCurrency(ing.quantity * (((_ing$raw_material2 = ing.raw_material) === null || _ing$raw_material2 === void 0 ? void 0 : _ing$raw_material2.average_price) || 0))))])]);
  }), 0), _vm._v(" "), _c("tfoot", [_c("tr", [_c("th", {
    staticClass: "text-end",
    attrs: {
      colspan: "4"
    }
  }, [_vm._v("إجمالي تكلفة المواد:")]), _vm._v(" "), _c("th", [_vm._v(_vm._s(_vm.formatCurrency(_vm.calculateRecipeCost(_vm.selectedRecipe))))])])])]), _vm._v(" "), _vm.selectedRecipe.instructions ? _c("div", {
    staticClass: "mt-3"
  }, [_c("h6", [_vm._v("التعليمات")]), _vm._v(" "), _c("p", {
    staticClass: "mb-0"
  }, [_vm._v(_vm._s(_vm.selectedRecipe.instructions))])]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-bs-dismiss": "modal"
    }
  }, [_vm._v("إغلاق")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-success",
    attrs: {
      to: {
        name: "manufacturing.production.create",
        query: {
          recipe_id: (_vm$selectedRecipe2 = _vm.selectedRecipe) === null || _vm$selectedRecipe2 === void 0 ? void 0 : _vm$selectedRecipe2.id
        }
      }
    },
    on: {
      click: _vm.hideModal
    }
  }, [_c("i", {
    staticClass: "fas fa-play me-1"
  }), _vm._v(" بدء الإنتاج\n          ")])], 1)])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("h4", {
    staticClass: "mb-1"
  }, [_vm._v("الوصفات (قائمة المواد)")]), _vm._v(" "), _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("إدارة الوصفات التي تحدد كيفية تصنيع المنتجات")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("اسم الوصفة")]), _vm._v(" "), _c("th", [_vm._v("المنتج")]), _vm._v(" "), _c("th", [_vm._v("كمية الإنتاج")]), _vm._v(" "), _c("th", [_vm._v("المكونات")]), _vm._v(" "), _c("th", [_vm._v("التكلفة المقدرة")]), _vm._v(" "), _c("th", [_vm._v("الحالة")]), _vm._v(" "), _c("th", [_vm._v("الإجراءات")])])]);
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
  return _c("thead", [_c("tr", [_c("th", [_vm._v("المادة")]), _vm._v(" "), _c("th", [_vm._v("الكمية")]), _vm._v(" "), _c("th", [_vm._v("الوحدة")]), _vm._v(" "), _c("th", [_vm._v("نسبة الهدر %")]), _vm._v(" "), _c("th", [_vm._v("التكلفة المقدرة")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/pages/manufacturing/RecipeList.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/RecipeList.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _RecipeList_vue_vue_type_template_id_1cfe945a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RecipeList.vue?vue&type=template&id=1cfe945a& */ "./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=template&id=1cfe945a&");
/* harmony import */ var _RecipeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RecipeList.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _RecipeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _RecipeList_vue_vue_type_template_id_1cfe945a___WEBPACK_IMPORTED_MODULE_0__.render,
  _RecipeList_vue_vue_type_template_id_1cfe945a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/manufacturing/RecipeList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RecipeList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=template&id=1cfe945a&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=template&id=1cfe945a& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeList_vue_vue_type_template_id_1cfe945a___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeList_vue_vue_type_template_id_1cfe945a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeList_vue_vue_type_template_id_1cfe945a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RecipeList.vue?vue&type=template&id=1cfe945a& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeList.vue?vue&type=template&id=1cfe945a&");


/***/ })

}]);