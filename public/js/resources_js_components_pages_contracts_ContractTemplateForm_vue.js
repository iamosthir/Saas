"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_contracts_ContractTemplateForm_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
  data: function data() {
    return {
      isEdit: false,
      templateId: null,
      saving: false,
      tinymceInstance: null,
      form: {
        name: '',
        description: '',
        footer_text: '',
        is_default: false,
        custom_fields: []
      }
    };
  },
  mounted: function mounted() {
    // Check if editing
    if (this.$route.params.id) {
      this.isEdit = true;
      this.templateId = this.$route.params.id;
      this.loadTemplate();
    } else {
      this.initTinyMCE();
    }
  },
  beforeDestroy: function beforeDestroy() {
    if (this.tinymceInstance) {
      tinymce.remove(this.tinymceInstance);
    }
  },
  methods: {
    initTinyMCE: function initTinyMCE() {
      var _this = this;
      this.$nextTick(function () {
        tinymce.init({
          target: _this.$refs.tinymceEditor,
          height: 400,
          menubar: false,
          language: 'ar',
          directionality: 'rtl',
          plugins: ['advlist', 'autolink', 'lists', 'link', 'charmap', 'preview', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'table', 'help', 'wordcount'],
          toolbar: 'undo redo | formatselect | bold italic underline | ' + 'alignleft aligncenter alignright alignjustify | ' + 'bullist numlist outdent indent | removeformat | help',
          content_style: 'body { font-family:Arial,sans-serif; font-size:14px; direction:rtl; text-align:right; }',
          setup: function setup(editor) {
            _this.tinymceInstance = editor;
            editor.on('change', function () {
              _this.form.description = editor.getContent();
            });
          }
        });
      });
    },
    loadTemplate: function loadTemplate() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return axios.get("/dashboard/api/contract-templates/".concat(_this2.templateId));
            case 3:
              response = _context.sent;
              _this2.form = {
                name: response.data.name,
                description: response.data.description || '',
                footer_text: response.data.footer_text || '',
                is_default: response.data.is_default,
                custom_fields: response.data.custom_fields.map(function (field) {
                  return _objectSpread(_objectSpread({}, field), {}, {
                    select_options_input: field.select_options ? field.select_options.join(', ') : ''
                  });
                })
              };
              _this2.$nextTick(function () {
                _this2.initTinyMCE();
              });
              _context.next = 12;
              break;
            case 8:
              _context.prev = 8;
              _context.t0 = _context["catch"](0);
              toastr.error('فشل تحميل القالب');
              console.error(_context.t0);
            case 12:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 8]]);
      }))();
    },
    autoGenerateKey: function autoGenerateKey(field, index) {
      // Convert Arabic and English labels to snake_case
      field.field_key = field.field_label.toLowerCase().replace(/\s+/g, '_').replace(/[^\w\u0621-\u064A]/g, '_').replace(/_{2,}/g, '_').replace(/^_+|_+$/g, '');
    },
    addField: function addField() {
      this.form.custom_fields.push({
        field_key: '',
        field_label: '',
        field_type: 'text',
        select_options: [],
        select_options_input: '',
        is_required: false,
        display_order: this.form.custom_fields.length
      });
    },
    removeField: function removeField(index) {
      if (confirm('هل أنت متأكد من حذف هذا الحقل؟')) {
        this.form.custom_fields.splice(index, 1);
        this.updateDisplayOrder();
      }
    },
    moveFieldUp: function moveFieldUp(index) {
      if (index > 0) {
        var field = this.form.custom_fields.splice(index, 1)[0];
        this.form.custom_fields.splice(index - 1, 0, field);
        this.updateDisplayOrder();
      }
    },
    moveFieldDown: function moveFieldDown(index) {
      if (index < this.form.custom_fields.length - 1) {
        var field = this.form.custom_fields.splice(index, 1)[0];
        this.form.custom_fields.splice(index + 1, 0, field);
        this.updateDisplayOrder();
      }
    },
    updateDisplayOrder: function updateDisplayOrder() {
      this.form.custom_fields.forEach(function (field, index) {
        field.display_order = index;
      });
    },
    updateSelectOptions: function updateSelectOptions(field) {
      if (field.select_options_input) {
        field.select_options = field.select_options_input.split(',').map(function (opt) {
          return opt.trim();
        }).filter(function (opt) {
          return opt;
        });
      } else {
        field.select_options = [];
      }
    },
    validateForm: function validateForm() {
      if (!this.form.name) {
        toastr.error('يرجى إدخال اسم القالب');
        return false;
      }
      if (!this.form.description) {
        toastr.error('يرجى إدخال وصف العقد');
        return false;
      }
      for (var i = 0; i < this.form.custom_fields.length; i++) {
        var field = this.form.custom_fields[i];
        if (!field.field_label) {
          toastr.error("\u064A\u0631\u062C\u0649 \u0625\u062F\u062E\u0627\u0644 \u0627\u0633\u0645 \u0627\u0644\u062D\u0642\u0644 \u0631\u0642\u0645 ".concat(i + 1));
          return false;
        }
        if (!field.field_key) {
          toastr.error("\u0645\u0641\u062A\u0627\u062D \u0627\u0644\u062D\u0642\u0644 \u0631\u0642\u0645 ".concat(i + 1, " \u063A\u064A\u0631 \u0635\u062D\u064A\u062D"));
          return false;
        }
        if (field.field_type === 'select' && (!field.select_options || field.select_options.length === 0)) {
          toastr.error("\u064A\u0631\u062C\u0649 \u0625\u062F\u062E\u0627\u0644 \u062E\u064A\u0627\u0631\u0627\u062A \u0644\u0644\u062D\u0642\u0644 \"".concat(field.field_label, "\""));
          return false;
        }
      }
      return true;
    },
    saveTemplate: function saveTemplate() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var payload;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              if (_this3.validateForm()) {
                _context2.next = 2;
                break;
              }
              return _context2.abrupt("return");
            case 2:
              // Update description from TinyMCE
              if (_this3.tinymceInstance) {
                _this3.form.description = _this3.tinymceInstance.getContent();
              }
              _this3.saving = true;
              _context2.prev = 4;
              payload = _objectSpread(_objectSpread({}, _this3.form), {}, {
                custom_fields: _this3.form.custom_fields.map(function (field) {
                  return {
                    field_key: field.field_key,
                    field_label: field.field_label,
                    field_type: field.field_type,
                    select_options: field.select_options || [],
                    is_required: field.is_required,
                    display_order: field.display_order
                  };
                })
              });
              if (!_this3.isEdit) {
                _context2.next = 12;
                break;
              }
              _context2.next = 9;
              return axios.put("/dashboard/api/contract-templates/".concat(_this3.templateId), payload);
            case 9:
              toastr.success('تم تحديث القالب بنجاح');
              _context2.next = 15;
              break;
            case 12:
              _context2.next = 14;
              return axios.post('/dashboard/api/contract-templates', payload);
            case 14:
              toastr.success('تم إنشاء القالب بنجاح');
            case 15:
              _this3.$router.push({
                name: 'contract-templates'
              });
              _context2.next = 22;
              break;
            case 18:
              _context2.prev = 18;
              _context2.t0 = _context2["catch"](4);
              toastr.error('فشل حفظ القالب');
              console.error(_context2.t0);
            case 22:
              _context2.prev = 22;
              _this3.saving = false;
              return _context2.finish(22);
            case 25:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[4, 18, 22, 25]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "contract-template-form"
  }, [_c("div", {
    staticClass: "page-header"
  }, [_c("h2", [_vm._v(_vm._s(_vm.isEdit ? "تعديل قالب العقد" : "إنشاء قالب عقد جديد"))]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-secondary",
    attrs: {
      to: {
        name: "contract-templates"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-arrow-right"
  }), _vm._v(" العودة\n    ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "form-container"
  }, [_c("div", {
    staticClass: "form-section"
  }, [_c("h3", [_vm._v("معلومات القالب")]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("اسم القالب *")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.name,
      expression: "form.name"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "مثال: عقد تأجير محل تجاري",
      required: ""
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
  })]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("وصف العقد (نص منسق) *")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.description,
      expression: "form.description"
    }],
    ref: "tinymceEditor",
    staticClass: "form-control tinymce-editor",
    domProps: {
      value: _vm.form.description
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "form-text"
  }, [_vm._v("استخدم المحرر لإضافة التنسيق والتعديل على نص العقد")])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("نص التذييل")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.footer_text,
      expression: "form.footer_text"
    }],
    staticClass: "form-control",
    attrs: {
      rows: "4",
      placeholder: "نص ثابت يظهر في نهاية كل عقد (مثل: شروط وأحكام، بيانات التوقيع، إلخ)"
    },
    domProps: {
      value: _vm.form.footer_text
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "footer_text", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("small", {
    staticClass: "form-text"
  }, [_vm._v("هذا النص سيظهر في نهاية جميع العقود المنشأة من هذا القالب")])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.is_default,
      expression: "form.is_default"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.form.is_default) ? _vm._i(_vm.form.is_default, null) > -1 : _vm.form.is_default
    },
    on: {
      change: function change($event) {
        var $$a = _vm.form.is_default,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.form, "is_default", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.form, "is_default", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.form, "is_default", $$c);
        }
      }
    }
  }), _vm._v("\n          تعيين كقالب افتراضي\n        ")])])]), _vm._v(" "), _c("div", {
    staticClass: "form-section"
  }, [_c("div", {
    staticClass: "section-header-row"
  }, [_c("h3", [_vm._v("الحقول المخصصة")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success btn-sm",
    on: {
      click: _vm.addField
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  }), _vm._v(" إضافة حقل\n        ")])]), _vm._v(" "), _vm.form.custom_fields.length === 0 ? _c("div", {
    staticClass: "empty-state"
  }, [_c("i", {
    staticClass: "fas fa-inbox"
  }), _vm._v(" "), _c("p", [_vm._v('لا توجد حقول مخصصة. اضغط "إضافة حقل" لإنشاء حقول جديدة.')])]) : _vm._e(), _vm._v(" "), _vm._l(_vm.form.custom_fields, function (field, index) {
    return _c("div", {
      key: index,
      staticClass: "field-builder"
    }, [_c("div", {
      staticClass: "field-number"
    }, [_vm._v(_vm._s(index + 1))]), _vm._v(" "), _c("div", {
      staticClass: "field-content"
    }, [_c("div", {
      staticClass: "field-row"
    }, [_c("div", {
      staticClass: "form-group flex-1"
    }, [_c("label", [_vm._v("اسم الحقل *")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: field.field_label,
        expression: "field.field_label"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        placeholder: "مثال: اسم الطرف الأول",
        required: ""
      },
      domProps: {
        value: field.field_label
      },
      on: {
        input: [function ($event) {
          if ($event.target.composing) return;
          _vm.$set(field, "field_label", $event.target.value);
        }, function ($event) {
          return _vm.autoGenerateKey(field, index);
        }]
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "form-group flex-1"
    }, [_c("label", [_vm._v("مفتاح الحقل")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: field.field_key,
        expression: "field.field_key"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        readonly: "",
        disabled: ""
      },
      domProps: {
        value: field.field_key
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(field, "field_key", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "form-group"
    }, [_c("label", [_vm._v("نوع الحقل *")]), _vm._v(" "), _c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: field.field_type,
        expression: "field.field_type"
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
          _vm.$set(field, "field_type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }
      }
    }, [_c("option", {
      attrs: {
        value: "text"
      }
    }, [_vm._v("نص قصير")]), _vm._v(" "), _c("option", {
      attrs: {
        value: "textarea"
      }
    }, [_vm._v("نص طويل")]), _vm._v(" "), _c("option", {
      attrs: {
        value: "number"
      }
    }, [_vm._v("رقم")]), _vm._v(" "), _c("option", {
      attrs: {
        value: "date"
      }
    }, [_vm._v("تاريخ")]), _vm._v(" "), _c("option", {
      attrs: {
        value: "select"
      }
    }, [_vm._v("قائمة منسدلة")])])])]), _vm._v(" "), field.field_type === "select" ? _c("div", {
      staticClass: "form-group"
    }, [_c("label", [_vm._v("خيارات القائمة المنسدلة (افصل بفاصلة)")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: field.select_options_input,
        expression: "field.select_options_input"
      }],
      staticClass: "form-control",
      attrs: {
        type: "text",
        placeholder: "خيار 1, خيار 2, خيار 3"
      },
      domProps: {
        value: field.select_options_input
      },
      on: {
        input: [function ($event) {
          if ($event.target.composing) return;
          _vm.$set(field, "select_options_input", $event.target.value);
        }, function ($event) {
          return _vm.updateSelectOptions(field);
        }]
      }
    })]) : _vm._e(), _vm._v(" "), _c("div", {
      staticClass: "field-actions"
    }, [_c("label", {
      staticClass: "checkbox-label"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: field.is_required,
        expression: "field.is_required"
      }],
      attrs: {
        type: "checkbox"
      },
      domProps: {
        checked: Array.isArray(field.is_required) ? _vm._i(field.is_required, null) > -1 : field.is_required
      },
      on: {
        change: function change($event) {
          var $$a = field.is_required,
            $$el = $event.target,
            $$c = $$el.checked ? true : false;
          if (Array.isArray($$a)) {
            var $$v = null,
              $$i = _vm._i($$a, $$v);
            if ($$el.checked) {
              $$i < 0 && _vm.$set(field, "is_required", $$a.concat([$$v]));
            } else {
              $$i > -1 && _vm.$set(field, "is_required", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
            }
          } else {
            _vm.$set(field, "is_required", $$c);
          }
        }
      }
    }), _vm._v("\n              حقل مطلوب\n            ")]), _vm._v(" "), _c("div", {
      staticClass: "action-buttons"
    }, [_c("button", {
      staticClass: "btn btn-sm btn-light",
      attrs: {
        disabled: index === 0,
        title: "تحريك لأعلى"
      },
      on: {
        click: function click($event) {
          return _vm.moveFieldUp(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-arrow-up"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-sm btn-light",
      attrs: {
        disabled: index === _vm.form.custom_fields.length - 1,
        title: "تحريك لأسفل"
      },
      on: {
        click: function click($event) {
          return _vm.moveFieldDown(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-arrow-down"
    })]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-sm btn-danger",
      attrs: {
        title: "حذف الحقل"
      },
      on: {
        click: function click($event) {
          return _vm.removeField(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])])])])]);
  })], 2), _vm._v(" "), _c("div", {
    staticClass: "form-actions"
  }, [_c("button", {
    staticClass: "btn btn-primary btn-lg",
    attrs: {
      disabled: _vm.saving
    },
    on: {
      click: _vm.saveTemplate
    }
  }, [_c("i", {
    staticClass: "fas fa-save"
  }), _vm._v("\n        " + _vm._s(_vm.saving ? "جاري الحفظ..." : "حفظ القالب") + "\n      ")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-secondary btn-lg",
    attrs: {
      to: {
        name: "contract-templates"
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  }), _vm._v(" إلغاء\n      ")])], 1)])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.contract-template-form[data-v-bd0f7758] {\n  padding: 20px;\n  max-width: 1200px;\n  margin: 0 auto;\n}\n.page-header[data-v-bd0f7758] {\n  display: flex;\n  justify-content: space-between;\n  align-items: center;\n  margin-bottom: 30px;\n  padding-bottom: 15px;\n  border-bottom: 2px solid #e0e0e0;\n}\n.page-header h2[data-v-bd0f7758] {\n  margin: 0;\n  color: #2c3e50;\n}\n.form-container[data-v-bd0f7758] {\n  background: white;\n  border-radius: 10px;\n  box-shadow: 0 2px 10px rgba(0,0,0,0.1);\n  padding: 30px;\n}\n.form-section[data-v-bd0f7758] {\n  margin-bottom: 40px;\n}\n.form-section h3[data-v-bd0f7758] {\n  color: #667eea;\n  margin-bottom: 20px;\n  font-size: 1.3rem;\n}\n.section-header-row[data-v-bd0f7758] {\n  display: flex;\n  justify-content: space-between;\n  align-items: center;\n  margin-bottom: 20px;\n}\n.section-header-row h3[data-v-bd0f7758] {\n  margin: 0;\n}\n.form-group[data-v-bd0f7758] {\n  margin-bottom: 20px;\n}\n.form-group label[data-v-bd0f7758] {\n  display: block;\n  margin-bottom: 8px;\n  font-weight: 600;\n  color: #2c3e50;\n}\n.form-control[data-v-bd0f7758] {\n  width: 100%;\n  padding: 10px 15px;\n  border: 1px solid #ddd;\n  border-radius: 5px;\n  font-size: 14px;\n  transition: border-color 0.3s;\n}\n.form-control[data-v-bd0f7758]:focus {\n  outline: none;\n  border-color: #667eea;\n  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);\n}\n.form-text[data-v-bd0f7758] {\n  display: block;\n  margin-top: 5px;\n  font-size: 12px;\n  color: #6c757d;\n}\n.empty-state[data-v-bd0f7758] {\n  text-align: center;\n  padding: 40px;\n  color: #95a5a6;\n}\n.empty-state i[data-v-bd0f7758] {\n  font-size: 48px;\n  margin-bottom: 15px;\n}\n.field-builder[data-v-bd0f7758] {\n  display: flex;\n  gap: 15px;\n  margin-bottom: 20px;\n  padding: 20px;\n  background: #f8f9fa;\n  border-radius: 8px;\n  border-right: 4px solid #667eea;\n}\n.field-number[data-v-bd0f7758] {\n  display: flex;\n  align-items: center;\n  justify-content: center;\n  width: 35px;\n  height: 35px;\n  background: #667eea;\n  color: white;\n  border-radius: 50%;\n  font-weight: bold;\n  flex-shrink: 0;\n}\n.field-content[data-v-bd0f7758] {\n  flex: 1;\n}\n.field-row[data-v-bd0f7758] {\n  display: flex;\n  gap: 15px;\n  margin-bottom: 15px;\n}\n.flex-1[data-v-bd0f7758] {\n  flex: 1;\n}\n.field-actions[data-v-bd0f7758] {\n  display: flex;\n  justify-content: space-between;\n  align-items: center;\n  padding-top: 10px;\n  border-top: 1px solid #dee2e6;\n}\n.checkbox-label[data-v-bd0f7758] {\n  display: flex;\n  align-items: center;\n  gap: 8px;\n  margin: 0;\n  font-weight: normal;\n}\n.action-buttons[data-v-bd0f7758] {\n  display: flex;\n  gap: 5px;\n}\n.form-actions[data-v-bd0f7758] {\n  display: flex;\n  gap: 15px;\n  justify-content: center;\n  padding-top: 30px;\n  border-top: 2px solid #e0e0e0;\n}\n.btn[data-v-bd0f7758] {\n  padding: 10px 25px;\n  border: none;\n  border-radius: 5px;\n  cursor: pointer;\n  font-size: 14px;\n  transition: all 0.3s;\n  display: inline-flex;\n  align-items: center;\n  gap: 8px;\n}\n.btn-sm[data-v-bd0f7758] {\n  padding: 5px 12px;\n  font-size: 13px;\n}\n.btn-lg[data-v-bd0f7758] {\n  padding: 12px 30px;\n  font-size: 16px;\n}\n.btn-primary[data-v-bd0f7758] {\n  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);\n  color: white;\n}\n.btn-primary[data-v-bd0f7758]:hover:not(:disabled) {\n  transform: translateY(-2px);\n  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);\n}\n.btn-primary[data-v-bd0f7758]:disabled {\n  opacity: 0.6;\n  cursor: not-allowed;\n}\n.btn-secondary[data-v-bd0f7758] {\n  background: #6c757d;\n  color: white;\n}\n.btn-secondary[data-v-bd0f7758]:hover {\n  background: #5a6268;\n}\n.btn-success[data-v-bd0f7758] {\n  background: #28a745;\n  color: white;\n}\n.btn-success[data-v-bd0f7758]:hover {\n  background: #218838;\n}\n.btn-danger[data-v-bd0f7758] {\n  background: #dc3545;\n  color: white;\n}\n.btn-danger[data-v-bd0f7758]:hover {\n  background: #c82333;\n}\n.btn-light[data-v-bd0f7758] {\n  background: #f8f9fa;\n  color: #495057;\n  border: 1px solid #dee2e6;\n}\n.btn-light[data-v-bd0f7758]:hover:not(:disabled) {\n  background: #e2e6ea;\n}\n.btn-light[data-v-bd0f7758]:disabled {\n  opacity: 0.5;\n  cursor: not-allowed;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_style_index_0_id_bd0f7758_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_style_index_0_id_bd0f7758_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_style_index_0_id_bd0f7758_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/pages/contracts/ContractTemplateForm.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/pages/contracts/ContractTemplateForm.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ContractTemplateForm_vue_vue_type_template_id_bd0f7758_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true& */ "./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true&");
/* harmony import */ var _ContractTemplateForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ContractTemplateForm.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _ContractTemplateForm_vue_vue_type_style_index_0_id_bd0f7758_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css& */ "./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ContractTemplateForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ContractTemplateForm_vue_vue_type_template_id_bd0f7758_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ContractTemplateForm_vue_vue_type_template_id_bd0f7758_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "bd0f7758",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/contracts/ContractTemplateForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContractTemplateForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_template_id_bd0f7758_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_template_id_bd0f7758_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_template_id_bd0f7758_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=template&id=bd0f7758&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css&":
/*!***********************************************************************************************************************************!*\
  !*** ./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContractTemplateForm_vue_vue_type_style_index_0_id_bd0f7758_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/contracts/ContractTemplateForm.vue?vue&type=style&index=0&id=bd0f7758&scoped=true&lang=css&");


/***/ })

}]);