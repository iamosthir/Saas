"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_manufacturing_RecipeForm_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _iterableToArrayLimit(arr, i) { var _i = null == arr ? null : "undefined" != typeof Symbol && arr[Symbol.iterator] || arr["@@iterator"]; if (null != _i) { var _s, _e, _x, _r, _arr = [], _n = !0, _d = !1; try { if (_x = (_i = _i.call(arr)).next, 0 === i) { if (Object(_i) !== _i) return; _n = !1; } else for (; !(_n = (_s = _x.call(_i)).done) && (_arr.push(_s.value), _arr.length !== i); _n = !0); } catch (err) { _d = !0, _e = err; } finally { try { if (!_n && null != _i["return"] && (_r = _i["return"](), Object(_r) !== _r)) return; } finally { if (_d) throw _e; } } return _arr; } }
function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'RecipeForm',
  data: function data() {
    return {
      isEdit: false,
      saving: false,
      form: {
        name: '',
        product_id: '',
        product_variation_id: '',
        output_quantity: 1,
        labor_cost: 0,
        overhead_cost: 0,
        prep_time_minutes: null,
        instructions: '',
        is_active: true,
        ingredients: []
      },
      products: [],
      variations: [],
      rawMaterials: [],
      units: []
    };
  },
  computed: {
    materialCost: function materialCost() {
      var _this = this;
      return this.form.ingredients.reduce(function (sum, ing) {
        var material = _this.rawMaterials.find(function (m) {
          return m.id === ing.raw_material_id;
        });
        if (!material || !ing.quantity) return sum;
        var effectiveQty = ing.quantity * (1 + (ing.waste_percentage || 0) / 100);
        return sum + effectiveQty * material.average_price;
      }, 0);
    },
    totalCost: function totalCost() {
      return this.materialCost + parseFloat(this.form.labor_cost || 0) + parseFloat(this.form.overhead_cost || 0);
    },
    unitCost: function unitCost() {
      var output = parseFloat(this.form.output_quantity) || 1;
      return this.totalCost / output;
    }
  },
  methods: {
    fetchData: function fetchData() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _yield$Promise$all, _yield$Promise$all2, productsRes, materialsRes, unitsRes;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return Promise.all([axios.get('/dashboard/api/product-list'), axios.get('/dashboard/api/manufacturing/raw-materials?per_page=1000'), axios.get('/dashboard/api/manufacturing/units')]);
            case 3:
              _yield$Promise$all = _context.sent;
              _yield$Promise$all2 = _slicedToArray(_yield$Promise$all, 3);
              productsRes = _yield$Promise$all2[0];
              materialsRes = _yield$Promise$all2[1];
              unitsRes = _yield$Promise$all2[2];
              _this2.products = productsRes.data.data || productsRes.data;
              _this2.rawMaterials = materialsRes.data.data;
              _this2.units = unitsRes.data.data;
              _context.next = 16;
              break;
            case 13:
              _context.prev = 13;
              _context.t0 = _context["catch"](0);
              toastr.error('فشل تحميل بيانات النموذج');
            case 16:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 13]]);
      }))();
    },
    fetchRecipe: function fetchRecipe(id) {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var response, recipe;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              _context2.next = 3;
              return axios.get("/dashboard/api/manufacturing/recipes/".concat(id));
            case 3:
              response = _context2.sent;
              recipe = response.data.data;
              _this3.form = {
                name: recipe.name,
                product_id: recipe.product_id,
                product_variation_id: recipe.product_variation_id || '',
                output_quantity: recipe.output_quantity,
                labor_cost: recipe.labor_cost,
                overhead_cost: recipe.overhead_cost,
                prep_time_minutes: recipe.prep_time_minutes,
                instructions: recipe.instructions || '',
                is_active: recipe.is_active,
                ingredients: recipe.ingredients.map(function (ing) {
                  return {
                    raw_material_id: ing.raw_material_id,
                    unit_id: ing.unit_id,
                    quantity: ing.quantity,
                    waste_percentage: ing.waste_percentage || 0
                  };
                })
              };
              _this3.onProductChange();
              _context2.next = 13;
              break;
            case 9:
              _context2.prev = 9;
              _context2.t0 = _context2["catch"](0);
              toastr.error('فشل تحميل الوصفة');
              _this3.$router.push({
                name: 'manufacturing.recipes'
              });
            case 13:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[0, 9]]);
      }))();
    },
    onProductChange: function onProductChange() {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var response;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _this4.variations = [];
              _this4.form.product_variation_id = '';
              if (!_this4.form.product_id) {
                _context3.next = 13;
                break;
              }
              _context3.prev = 3;
              _context3.next = 6;
              return axios.get("/dashboard/api/get-product-variations?product_id=".concat(_this4.form.product_id));
            case 6:
              response = _context3.sent;
              _this4.variations = response.data.data || response.data || [];
              _context3.next = 13;
              break;
            case 10:
              _context3.prev = 10;
              _context3.t0 = _context3["catch"](3);
              console.error('Failed to load variations');
            case 13:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[3, 10]]);
      }))();
    },
    onMaterialChange: function onMaterialChange(ingredient) {
      var material = this.rawMaterials.find(function (m) {
        return m.id === ingredient.raw_material_id;
      });
      if (material) {
        ingredient.unit_id = material.unit_id;
      }
    },
    addIngredient: function addIngredient() {
      this.form.ingredients.push({
        raw_material_id: '',
        unit_id: '',
        quantity: '',
        waste_percentage: 0
      });
    },
    removeIngredient: function removeIngredient(index) {
      this.form.ingredients.splice(index, 1);
    },
    formatCurrency: function formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
      });
    },
    submitForm: function submitForm() {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var _error$response, _error$response$data;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              if (!(_this5.form.ingredients.length === 0)) {
                _context4.next = 3;
                break;
              }
              toastr.error('الرجاء إضافة مكون واحد على الأقل');
              return _context4.abrupt("return");
            case 3:
              _this5.saving = true;
              _context4.prev = 4;
              if (!_this5.isEdit) {
                _context4.next = 11;
                break;
              }
              _context4.next = 8;
              return axios.put("/dashboard/api/manufacturing/recipes/".concat(_this5.$route.params.id), _this5.form);
            case 8:
              toastr.success('تم تحديث الوصفة بنجاح');
              _context4.next = 14;
              break;
            case 11:
              _context4.next = 13;
              return axios.post('/dashboard/api/manufacturing/recipes', _this5.form);
            case 13:
              toastr.success('تم إنشاء الوصفة بنجاح');
            case 14:
              _this5.$router.push({
                name: 'manufacturing.recipes'
              });
              _context4.next = 20;
              break;
            case 17:
              _context4.prev = 17;
              _context4.t0 = _context4["catch"](4);
              toastr.error(((_error$response = _context4.t0.response) === null || _error$response === void 0 ? void 0 : (_error$response$data = _error$response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.message) || 'فشل حفظ الوصفة');
            case 20:
              _context4.prev = 20;
              _this5.saving = false;
              return _context4.finish(20);
            case 23:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[4, 17, 20, 23]]);
      }))();
    }
  },
  mounted: function mounted() {
    this.fetchData();
    if (this.$route.params.id) {
      this.isEdit = true;
      this.fetchRecipe(this.$route.params.id);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=template&id=84f0e20e&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=template&id=84f0e20e& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "recipe-form"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between align-items-center mb-4"
  }, [_c("div", [_c("h4", {
    staticClass: "mb-1"
  }, [_vm._v(_vm._s(_vm.isEdit ? "تعديل الوصفة" : "إنشاء وصفة"))]), _vm._v(" "), _c("p", {
    staticClass: "text-muted mb-0"
  }, [_vm._v("حدد المكونات والكميات المطلوبة لإنتاج المنتج")])]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-outline-secondary",
    attrs: {
      to: {
        name: "manufacturing.recipes"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-arrow-left me-1"
  }), _vm._v(" العودة للقائمة\n    ")])], 1), _vm._v(" "), _c("form", {
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.submitForm.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "card mb-4"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.name,
      expression: "form.name"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      required: "",
      placeholder: "مثال: وصفة كعكة الشوكولاتة"
    },
    domProps: {
      value: _vm.form.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "name", $event.target.value);
      }
    }
  })])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_vm._m(2), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.output_quantity,
      expression: "form.output_quantity"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      required: "",
      min: "0.01",
      step: "0.01",
      placeholder: "كم وحدة تنتج هذه الوصفة؟"
    },
    domProps: {
      value: _vm.form.output_quantity
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "output_quantity", $event.target.value);
      }
    }
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_vm._m(3), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.product_id,
      expression: "form.product_id"
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
        _vm.$set(_vm.form, "product_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.onProductChange]
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("اختر المنتج")]), _vm._v(" "), _vm._l(_vm.products, function (prod) {
    return _c("option", {
      key: prod.id,
      domProps: {
        value: prod.id
      }
    }, [_vm._v(_vm._s(prod.name))]);
  })], 2)])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("نوع المنتج")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.product_variation_id,
      expression: "form.product_variation_id"
    }],
    staticClass: "form-select",
    attrs: {
      disabled: !_vm.variations.length
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.form, "product_variation_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("بدون نوع (المنتج الرئيسي)")]), _vm._v(" "), _vm._l(_vm.variations, function (v) {
    return _c("option", {
      key: v.id,
      domProps: {
        value: v.id
      }
    }, [_vm._v(_vm._s(v.var_name))]);
  })], 2)])])]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("تكلفة العمالة")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.labor_cost,
      expression: "form.labor_cost"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0",
      step: "0.01"
    },
    domProps: {
      value: _vm.form.labor_cost
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "labor_cost", $event.target.value);
      }
    }
  })])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("التكاليف الإضافية")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.overhead_cost,
      expression: "form.overhead_cost"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0",
      step: "0.01"
    },
    domProps: {
      value: _vm.form.overhead_cost
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "overhead_cost", $event.target.value);
      }
    }
  })])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("وقت التحضير (دقائق)")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.prep_time_minutes,
      expression: "form.prep_time_minutes"
    }],
    staticClass: "form-control",
    attrs: {
      type: "number",
      min: "0"
    },
    domProps: {
      value: _vm.form.prep_time_minutes
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "prep_time_minutes", $event.target.value);
      }
    }
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "mb-3"
  }, [_c("label", {
    staticClass: "form-label"
  }, [_vm._v("التعليمات")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.instructions,
      expression: "form.instructions"
    }],
    staticClass: "form-control",
    attrs: {
      rows: "3",
      placeholder: "تعليمات التحضير الاختيارية..."
    },
    domProps: {
      value: _vm.form.instructions
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "instructions", $event.target.value);
      }
    }
  })]), _vm._v(" "), _vm.isEdit ? _c("div", {
    staticClass: "form-check"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.is_active,
      expression: "form.is_active"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      id: "isActive"
    },
    domProps: {
      checked: Array.isArray(_vm.form.is_active) ? _vm._i(_vm.form.is_active, null) > -1 : _vm.form.is_active
    },
    on: {
      change: function change($event) {
        var $$a = _vm.form.is_active,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.form, "is_active", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.form, "is_active", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.form, "is_active", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "isActive"
    }
  }, [_vm._v("نشط")])]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "card mb-4"
  }, [_c("div", {
    staticClass: "card-header d-flex justify-content-between align-items-center"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("المكونات")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-outline-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.addIngredient
    }
  }, [_c("i", {
    staticClass: "fas fa-plus me-1"
  }), _vm._v(" إضافة مكون\n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table"
  }, [_vm._m(4), _vm._v(" "), _c("tbody", [_vm._l(_vm.form.ingredients, function (ing, index) {
    return _c("tr", {
      key: index
    }, [_c("td", [_c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: ing.raw_material_id,
        expression: "ing.raw_material_id"
      }],
      staticClass: "form-select form-select-sm",
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
          _vm.$set(ing, "raw_material_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }, function ($event) {
          return _vm.onMaterialChange(ing);
        }]
      }
    }, [_c("option", {
      attrs: {
        value: ""
      }
    }, [_vm._v("اختر المادة")]), _vm._v(" "), _vm._l(_vm.rawMaterials, function (mat) {
      var _mat$unit;
      return _c("option", {
        key: mat.id,
        domProps: {
          value: mat.id
        }
      }, [_vm._v("\n                          " + _vm._s(mat.name) + " (" + _vm._s(mat.current_stock) + " " + _vm._s((_mat$unit = mat.unit) === null || _mat$unit === void 0 ? void 0 : _mat$unit.symbol) + ")\n                        ")]);
    })], 2)]), _vm._v(" "), _c("td", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: ing.quantity,
        expression: "ing.quantity"
      }],
      staticClass: "form-control form-control-sm",
      attrs: {
        type: "number",
        min: "0.0001",
        step: "0.0001",
        required: ""
      },
      domProps: {
        value: ing.quantity
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(ing, "quantity", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("td", [_c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: ing.unit_id,
        expression: "ing.unit_id"
      }],
      staticClass: "form-select form-select-sm",
      attrs: {
        required: ""
      },
      on: {
        change: function change($event) {
          var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
            return o.selected;
          }).map(function (o) {
            var val = "_value" in o ? o._value : o.value;
            return val;
          });
          _vm.$set(ing, "unit_id", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }
      }
    }, [_c("option", {
      attrs: {
        value: ""
      }
    }, [_vm._v("الوحدة")]), _vm._v(" "), _vm._l(_vm.units, function (unit) {
      return _c("option", {
        key: unit.id,
        domProps: {
          value: unit.id
        }
      }, [_vm._v(_vm._s(unit.symbol))]);
    })], 2)]), _vm._v(" "), _c("td", [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: ing.waste_percentage,
        expression: "ing.waste_percentage"
      }],
      staticClass: "form-control form-control-sm",
      attrs: {
        type: "number",
        min: "0",
        max: "100",
        step: "0.1"
      },
      domProps: {
        value: ing.waste_percentage
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(ing, "waste_percentage", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("td", [_c("button", {
      staticClass: "btn btn-sm btn-outline-danger",
      attrs: {
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.removeIngredient(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])])]);
  }), _vm._v(" "), _vm.form.ingredients.length === 0 ? _c("tr", [_c("td", {
    staticClass: "text-center text-muted py-3",
    attrs: {
      colspan: "5"
    }
  }, [_vm._v('\n                      لم تتم إضافة مكونات. انقر على "إضافة مكون" للبدء.\n                    ')])]) : _vm._e()], 2)])])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card sticky-top",
    staticStyle: {
      top: "20px"
    }
  }, [_vm._m(5), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("تكلفة المواد:")]), _vm._v(" "), _c("strong", [_vm._v(_vm._s(_vm.formatCurrency(_vm.materialCost)))])]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("تكلفة العمالة:")]), _vm._v(" "), _c("strong", [_vm._v(_vm._s(_vm.formatCurrency(_vm.form.labor_cost || 0)))])]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("التكاليف الإضافية:")]), _vm._v(" "), _c("strong", [_vm._v(_vm._s(_vm.formatCurrency(_vm.form.overhead_cost || 0)))])]), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between mb-2"
  }, [_c("span", [_vm._v("إجمالي تكلفة الدفعة:")]), _vm._v(" "), _c("strong", {
    staticClass: "text-primary"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.totalCost)))])]), _vm._v(" "), _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("span", [_vm._v("تكلفة الوحدة:")]), _vm._v(" "), _c("strong", {
    staticClass: "text-success"
  }, [_vm._v(_vm._s(_vm.formatCurrency(_vm.unitCost)))])])]), _vm._v(" "), _c("div", {
    staticClass: "card-footer"
  }, [_c("button", {
    staticClass: "btn btn-primary w-100",
    attrs: {
      type: "submit",
      disabled: _vm.saving || _vm.form.ingredients.length === 0
    }
  }, [_vm.saving ? _c("span", {
    staticClass: "spinner-border spinner-border-sm me-1"
  }) : _vm._e(), _vm._v("\n              " + _vm._s(_vm.isEdit ? "تحديث" : "إنشاء") + " الوصفة\n            ")])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("تفاصيل الوصفة")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("اسم الوصفة "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("كمية الإنتاج "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "form-label"
  }, [_vm._v("المنتج "), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", {
    staticStyle: {
      width: "35%"
    }
  }, [_vm._v("المادة الخام")]), _vm._v(" "), _c("th", {
    staticStyle: {
      width: "20%"
    }
  }, [_vm._v("الكمية")]), _vm._v(" "), _c("th", {
    staticStyle: {
      width: "20%"
    }
  }, [_vm._v("الوحدة")]), _vm._v(" "), _c("th", {
    staticStyle: {
      width: "15%"
    }
  }, [_vm._v("نسبة الهدر %")]), _vm._v(" "), _c("th", {
    staticStyle: {
      width: "10%"
    }
  })])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "mb-0"
  }, [_vm._v("ملخص التكاليف")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/pages/manufacturing/RecipeForm.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/RecipeForm.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _RecipeForm_vue_vue_type_template_id_84f0e20e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RecipeForm.vue?vue&type=template&id=84f0e20e& */ "./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=template&id=84f0e20e&");
/* harmony import */ var _RecipeForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RecipeForm.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _RecipeForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _RecipeForm_vue_vue_type_template_id_84f0e20e___WEBPACK_IMPORTED_MODULE_0__.render,
  _RecipeForm_vue_vue_type_template_id_84f0e20e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/manufacturing/RecipeForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RecipeForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=template&id=84f0e20e&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=template&id=84f0e20e& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeForm_vue_vue_type_template_id_84f0e20e___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeForm_vue_vue_type_template_id_84f0e20e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_RecipeForm_vue_vue_type_template_id_84f0e20e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RecipeForm.vue?vue&type=template&id=84f0e20e& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/manufacturing/RecipeForm.vue?vue&type=template&id=84f0e20e&");


/***/ })

}]);