/*
 * Naja.js
 * 2.2.0
 *
 * by Jiří Pudil <https://jiripudil.cz>
 */
(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.naja = factory());
})(this, (function () { 'use strict';

	var commonjsGlobal = typeof globalThis !== 'undefined' ? globalThis : typeof window !== 'undefined' ? window : typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : {};

	(function (factory) {
	  factory();
	}((function () {
	  function _classCallCheck(instance, Constructor) {
	    if (!(instance instanceof Constructor)) {
	      throw new TypeError("Cannot call a class as a function");
	    }
	  }

	  function _defineProperties(target, props) {
	    for (var i = 0; i < props.length; i++) {
	      var descriptor = props[i];
	      descriptor.enumerable = descriptor.enumerable || false;
	      descriptor.configurable = true;
	      if ("value" in descriptor) descriptor.writable = true;
	      Object.defineProperty(target, descriptor.key, descriptor);
	    }
	  }

	  function _createClass(Constructor, protoProps, staticProps) {
	    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
	    if (staticProps) _defineProperties(Constructor, staticProps);
	    return Constructor;
	  }

	  function _inherits(subClass, superClass) {
	    if (typeof superClass !== "function" && superClass !== null) {
	      throw new TypeError("Super expression must either be null or a function");
	    }

	    subClass.prototype = Object.create(superClass && superClass.prototype, {
	      constructor: {
	        value: subClass,
	        writable: true,
	        configurable: true
	      }
	    });
	    if (superClass) _setPrototypeOf(subClass, superClass);
	  }

	  function _getPrototypeOf(o) {
	    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
	      return o.__proto__ || Object.getPrototypeOf(o);
	    };
	    return _getPrototypeOf(o);
	  }

	  function _setPrototypeOf(o, p) {
	    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
	      o.__proto__ = p;
	      return o;
	    };

	    return _setPrototypeOf(o, p);
	  }

	  function _isNativeReflectConstruct() {
	    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
	    if (Reflect.construct.sham) return false;
	    if (typeof Proxy === "function") return true;

	    try {
	      Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
	      return true;
	    } catch (e) {
	      return false;
	    }
	  }

	  function _assertThisInitialized(self) {
	    if (self === void 0) {
	      throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
	    }

	    return self;
	  }

	  function _possibleConstructorReturn(self, call) {
	    if (call && (typeof call === "object" || typeof call === "function")) {
	      return call;
	    }

	    return _assertThisInitialized(self);
	  }

	  function _createSuper(Derived) {
	    var hasNativeReflectConstruct = _isNativeReflectConstruct();

	    return function _createSuperInternal() {
	      var Super = _getPrototypeOf(Derived),
	          result;

	      if (hasNativeReflectConstruct) {
	        var NewTarget = _getPrototypeOf(this).constructor;

	        result = Reflect.construct(Super, arguments, NewTarget);
	      } else {
	        result = Super.apply(this, arguments);
	      }

	      return _possibleConstructorReturn(this, result);
	    };
	  }

	  function _superPropBase(object, property) {
	    while (!Object.prototype.hasOwnProperty.call(object, property)) {
	      object = _getPrototypeOf(object);
	      if (object === null) break;
	    }

	    return object;
	  }

	  function _get(target, property, receiver) {
	    if (typeof Reflect !== "undefined" && Reflect.get) {
	      _get = Reflect.get;
	    } else {
	      _get = function _get(target, property, receiver) {
	        var base = _superPropBase(target, property);

	        if (!base) return;
	        var desc = Object.getOwnPropertyDescriptor(base, property);

	        if (desc.get) {
	          return desc.get.call(receiver);
	        }

	        return desc.value;
	      };
	    }

	    return _get(target, property, receiver || target);
	  }

	  var Emitter = /*#__PURE__*/function () {
	    function Emitter() {
	      _classCallCheck(this, Emitter);

	      Object.defineProperty(this, 'listeners', {
	        value: {},
	        writable: true,
	        configurable: true
	      });
	    }

	    _createClass(Emitter, [{
	      key: "addEventListener",
	      value: function addEventListener(type, callback, options) {
	        if (!(type in this.listeners)) {
	          this.listeners[type] = [];
	        }

	        this.listeners[type].push({
	          callback: callback,
	          options: options
	        });
	      }
	    }, {
	      key: "removeEventListener",
	      value: function removeEventListener(type, callback) {
	        if (!(type in this.listeners)) {
	          return;
	        }

	        var stack = this.listeners[type];

	        for (var i = 0, l = stack.length; i < l; i++) {
	          if (stack[i].callback === callback) {
	            stack.splice(i, 1);
	            return;
	          }
	        }
	      }
	    }, {
	      key: "dispatchEvent",
	      value: function dispatchEvent(event) {
	        if (!(event.type in this.listeners)) {
	          return;
	        }

	        var stack = this.listeners[event.type];
	        var stackToCall = stack.slice();

	        for (var i = 0, l = stackToCall.length; i < l; i++) {
	          var listener = stackToCall[i];

	          try {
	            listener.callback.call(this, event);
	          } catch (e) {
	            Promise.resolve().then(function () {
	              throw e;
	            });
	          }

	          if (listener.options && listener.options.once) {
	            this.removeEventListener(event.type, listener.callback);
	          }
	        }

	        return !event.defaultPrevented;
	      }
	    }]);

	    return Emitter;
	  }();

	  var AbortSignal = /*#__PURE__*/function (_Emitter) {
	    _inherits(AbortSignal, _Emitter);

	    var _super = _createSuper(AbortSignal);

	    function AbortSignal() {
	      var _this;

	      _classCallCheck(this, AbortSignal);

	      _this = _super.call(this); // Some versions of babel does not transpile super() correctly for IE <= 10, if the parent
	      // constructor has failed to run, then "this.listeners" will still be undefined and then we call
	      // the parent constructor directly instead as a workaround. For general details, see babel bug:
	      // https://github.com/babel/babel/issues/3041
	      // This hack was added as a fix for the issue described here:
	      // https://github.com/Financial-Times/polyfill-library/pull/59#issuecomment-477558042

	      if (!_this.listeners) {
	        Emitter.call(_assertThisInitialized(_this));
	      } // Compared to assignment, Object.defineProperty makes properties non-enumerable by default and
	      // we want Object.keys(new AbortController().signal) to be [] for compat with the native impl


	      Object.defineProperty(_assertThisInitialized(_this), 'aborted', {
	        value: false,
	        writable: true,
	        configurable: true
	      });
	      Object.defineProperty(_assertThisInitialized(_this), 'onabort', {
	        value: null,
	        writable: true,
	        configurable: true
	      });
	      return _this;
	    }

	    _createClass(AbortSignal, [{
	      key: "toString",
	      value: function toString() {
	        return '[object AbortSignal]';
	      }
	    }, {
	      key: "dispatchEvent",
	      value: function dispatchEvent(event) {
	        if (event.type === 'abort') {
	          this.aborted = true;

	          if (typeof this.onabort === 'function') {
	            this.onabort.call(this, event);
	          }
	        }

	        _get(_getPrototypeOf(AbortSignal.prototype), "dispatchEvent", this).call(this, event);
	      }
	    }]);

	    return AbortSignal;
	  }(Emitter);
	  var AbortController = /*#__PURE__*/function () {
	    function AbortController() {
	      _classCallCheck(this, AbortController);

	      // Compared to assignment, Object.defineProperty makes properties non-enumerable by default and
	      // we want Object.keys(new AbortController()) to be [] for compat with the native impl
	      Object.defineProperty(this, 'signal', {
	        value: new AbortSignal(),
	        writable: true,
	        configurable: true
	      });
	    }

	    _createClass(AbortController, [{
	      key: "abort",
	      value: function abort() {
	        var event;

	        try {
	          event = new Event('abort');
	        } catch (e) {
	          if (typeof document !== 'undefined') {
	            if (!document.createEvent) {
	              // For Internet Explorer 8:
	              event = document.createEventObject();
	              event.type = 'abort';
	            } else {
	              // For Internet Explorer 11:
	              event = document.createEvent('Event');
	              event.initEvent('abort', false, false);
	            }
	          } else {
	            // Fallback where document isn't available:
	            event = {
	              type: 'abort',
	              bubbles: false,
	              cancelable: false
	            };
	          }
	        }

	        this.signal.dispatchEvent(event);
	      }
	    }, {
	      key: "toString",
	      value: function toString() {
	        return '[object AbortController]';
	      }
	    }]);

	    return AbortController;
	  }();

	  if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
	    // These are necessary to make sure that we get correct output for:
	    // Object.prototype.toString.call(new AbortController())
	    AbortController.prototype[Symbol.toStringTag] = 'AbortController';
	    AbortSignal.prototype[Symbol.toStringTag] = 'AbortSignal';
	  }

	  function polyfillNeeded(self) {
	    if (self.__FORCE_INSTALL_ABORTCONTROLLER_POLYFILL) {
	      console.log('__FORCE_INSTALL_ABORTCONTROLLER_POLYFILL=true is set, will force install polyfill');
	      return true;
	    } // Note that the "unfetch" minimal fetch polyfill defines fetch() without
	    // defining window.Request, and this polyfill need to work on top of unfetch
	    // so the below feature detection needs the !self.AbortController part.
	    // The Request.prototype check is also needed because Safari versions 11.1.2
	    // up to and including 12.1.x has a window.AbortController present but still
	    // does NOT correctly implement abortable fetch:
	    // https://bugs.webkit.org/show_bug.cgi?id=174980#c2


	    return typeof self.Request === 'function' && !self.Request.prototype.hasOwnProperty('signal') || !self.AbortController;
	  }

	  /**
	   * Note: the "fetch.Request" default value is available for fetch imported from
	   * the "node-fetch" package and not in browsers. This is OK since browsers
	   * will be importing umd-polyfill.js from that path "self" is passed the
	   * decorator so the default value will not be used (because browsers that define
	   * fetch also has Request). One quirky setup where self.fetch exists but
	   * self.Request does not is when the "unfetch" minimal fetch polyfill is used
	   * on top of IE11; for this case the browser will try to use the fetch.Request
	   * default value which in turn will be undefined but then then "if (Request)"
	   * will ensure that you get a patched fetch but still no Request (as expected).
	   * @param {fetch, Request = fetch.Request}
	   * @returns {fetch: abortableFetch, Request: AbortableRequest}
	   */

	  function abortableFetchDecorator(patchTargets) {
	    if ('function' === typeof patchTargets) {
	      patchTargets = {
	        fetch: patchTargets
	      };
	    }

	    var _patchTargets = patchTargets,
	        fetch = _patchTargets.fetch,
	        _patchTargets$Request = _patchTargets.Request,
	        NativeRequest = _patchTargets$Request === void 0 ? fetch.Request : _patchTargets$Request,
	        NativeAbortController = _patchTargets.AbortController,
	        _patchTargets$__FORCE = _patchTargets.__FORCE_INSTALL_ABORTCONTROLLER_POLYFILL,
	        __FORCE_INSTALL_ABORTCONTROLLER_POLYFILL = _patchTargets$__FORCE === void 0 ? false : _patchTargets$__FORCE;

	    if (!polyfillNeeded({
	      fetch: fetch,
	      Request: NativeRequest,
	      AbortController: NativeAbortController,
	      __FORCE_INSTALL_ABORTCONTROLLER_POLYFILL: __FORCE_INSTALL_ABORTCONTROLLER_POLYFILL
	    })) {
	      return {
	        fetch: fetch,
	        Request: Request
	      };
	    }

	    var Request = NativeRequest; // Note that the "unfetch" minimal fetch polyfill defines fetch() without
	    // defining window.Request, and this polyfill need to work on top of unfetch
	    // hence we only patch it if it's available. Also we don't patch it if signal
	    // is already available on the Request prototype because in this case support
	    // is present and the patching below can cause a crash since it assigns to
	    // request.signal which is technically a read-only property. This latter error
	    // happens when you run the main5.js node-fetch example in the repo
	    // "abortcontroller-polyfill-examples". The exact error is:
	    //   request.signal = init.signal;
	    //   ^
	    // TypeError: Cannot set property signal of #<Request> which has only a getter

	    if (Request && !Request.prototype.hasOwnProperty('signal') || __FORCE_INSTALL_ABORTCONTROLLER_POLYFILL) {
	      Request = function Request(input, init) {
	        var signal;

	        if (init && init.signal) {
	          signal = init.signal; // Never pass init.signal to the native Request implementation when the polyfill has
	          // been installed because if we're running on top of a browser with a
	          // working native AbortController (i.e. the polyfill was installed due to
	          // __FORCE_INSTALL_ABORTCONTROLLER_POLYFILL being set), then passing our
	          // fake AbortSignal to the native fetch will trigger:
	          // TypeError: Failed to construct 'Request': member signal is not of type AbortSignal.

	          delete init.signal;
	        }

	        var request = new NativeRequest(input, init);

	        if (signal) {
	          Object.defineProperty(request, 'signal', {
	            writable: false,
	            enumerable: false,
	            configurable: true,
	            value: signal
	          });
	        }

	        return request;
	      };

	      Request.prototype = NativeRequest.prototype;
	    }

	    var realFetch = fetch;

	    var abortableFetch = function abortableFetch(input, init) {
	      var signal = Request && Request.prototype.isPrototypeOf(input) ? input.signal : init ? init.signal : undefined;

	      if (signal) {
	        var abortError;

	        try {
	          abortError = new DOMException('Aborted', 'AbortError');
	        } catch (err) {
	          // IE 11 does not support calling the DOMException constructor, use a
	          // regular error object on it instead.
	          abortError = new Error('Aborted');
	          abortError.name = 'AbortError';
	        } // Return early if already aborted, thus avoiding making an HTTP request


	        if (signal.aborted) {
	          return Promise.reject(abortError);
	        } // Turn an event into a promise, reject it once `abort` is dispatched


	        var cancellation = new Promise(function (_, reject) {
	          signal.addEventListener('abort', function () {
	            return reject(abortError);
	          }, {
	            once: true
	          });
	        });

	        if (init && init.signal) {
	          // Never pass .signal to the native implementation when the polyfill has
	          // been installed because if we're running on top of a browser with a
	          // working native AbortController (i.e. the polyfill was installed due to
	          // __FORCE_INSTALL_ABORTCONTROLLER_POLYFILL being set), then passing our
	          // fake AbortSignal to the native fetch will trigger:
	          // TypeError: Failed to execute 'fetch' on 'Window': member signal is not of type AbortSignal.
	          delete init.signal;
	        } // Return the fastest promise (don't need to wait for request to finish)


	        return Promise.race([cancellation, realFetch(input, init)]);
	      }

	      return realFetch(input, init);
	    };

	    return {
	      fetch: abortableFetch,
	      Request: Request
	    };
	  }

	  (function (self) {

	    if (!polyfillNeeded(self)) {
	      return;
	    }

	    if (!self.fetch) {
	      console.warn('fetch() is not available, cannot install abortcontroller-polyfill');
	      return;
	    }

	    var _abortableFetch = abortableFetchDecorator(self),
	        fetch = _abortableFetch.fetch,
	        Request = _abortableFetch.Request;

	    self.fetch = fetch;
	    self.Request = Request;
	    Object.defineProperty(self, 'AbortController', {
	      writable: true,
	      enumerable: false,
	      configurable: true,
	      value: AbortController
	    });
	    Object.defineProperty(self, 'AbortSignal', {
	      writable: true,
	      enumerable: false,
	      configurable: true,
	      value: AbortSignal
	    });
	  })(typeof self !== 'undefined' ? self : commonjsGlobal);

	})));

	/**
	 * Assert a condition.
	 * @param condition The condition that it should satisfy.
	 * @param message The error message.
	 * @param args The arguments for replacing placeholders in the message.
	 */
	function assertType(condition, message, ...args) {
	  if (!condition) {
	    throw new TypeError(format(message, args));
	  }
	}
	/**
	 * Convert a text and arguments to one string.
	 * @param message The formating text
	 * @param args The arguments.
	 */


	function format(message, args) {
	  let i = 0;
	  return message.replace(/%[os]/gu, () => anyToString(args[i++]));
	}
	/**
	 * Convert a value to a string representation.
	 * @param x The value to get the string representation.
	 */


	function anyToString(x) {
	  if (typeof x !== "object" || x === null) {
	    return String(x);
	  }

	  return Object.prototype.toString.call(x);
	}

	let currentErrorHandler;
	/**
	 * Print a error message.
	 * @param maybeError The error object.
	 */


	function reportError(maybeError) {
	  try {
	    const error = maybeError instanceof Error ? maybeError : new Error(anyToString(maybeError)); // Call the user-defined error handler if exists.

	    if (currentErrorHandler) ; // Dispatch an `error` event if this is on a browser.


	    if (typeof dispatchEvent === "function" && typeof ErrorEvent === "function") {
	      dispatchEvent(new ErrorEvent("error", {
	        error,
	        message: error.message
	      }));
	    } // Emit an `uncaughtException` event if this is on Node.js.
	    //istanbul ignore else
	    else if (typeof process !== "undefined" && typeof process.emit === "function") {
	      process.emit("uncaughtException", error);
	      return;
	    } // Otherwise, print the error.


	    console.error(error);
	  } catch (_a) {// ignore.
	  }
	}
	/**
	 * The global object.
	 */
	//istanbul ignore next


	const Global = typeof window !== "undefined" ? window : typeof self !== "undefined" ? self : typeof global !== "undefined" ? global : typeof globalThis !== "undefined" ? globalThis : undefined;
	let currentWarnHandler;
	/**
	 * The warning information.
	 */


	class Warning {
	  constructor(code, message) {
	    this.code = code;
	    this.message = message;
	  }
	  /**
	   * Report this warning.
	   * @param args The arguments of the warning.
	   */


	  warn(...args) {
	    var _a;

	    try {
	      // Call the user-defined warning handler if exists.
	      if (currentWarnHandler) ; // Otherwise, print the warning.


	      const stack = ((_a = new Error().stack) !== null && _a !== void 0 ? _a : "").replace(/^(?:.+?\n){2}/gu, "\n");
	      console.warn(this.message, ...args, stack);
	    } catch (_b) {// Ignore.
	    }
	  }

	}

	const InitEventWasCalledWhileDispatching = new Warning("W01", "Unable to initialize event under dispatching.");
	const FalsyWasAssignedToCancelBubble = new Warning("W02", "Assigning any falsy value to 'cancelBubble' property has no effect.");
	const TruthyWasAssignedToReturnValue = new Warning("W03", "Assigning any truthy value to 'returnValue' property has no effect.");
	const NonCancelableEventWasCanceled = new Warning("W04", "Unable to preventDefault on non-cancelable events.");
	const CanceledInPassiveListener = new Warning("W05", "Unable to preventDefault inside passive event listener invocation.");
	const EventListenerWasDuplicated = new Warning("W06", "An event listener wasn't added because it has been added already: %o, %o");
	const OptionWasIgnored = new Warning("W07", "The %o option value was abandoned because the event listener wasn't added as duplicated.");
	const InvalidEventListener = new Warning("W08", "The 'callback' argument must be a function or an object that has 'handleEvent' method: %o");
	new Warning("W09", "Event attribute handler must be a function: %o");
	/*eslint-disable class-methods-use-this */

	/**
	 * An implementation of `Event` interface, that wraps a given event object.
	 * `EventTarget` shim can control the internal state of this `Event` objects.
	 * @see https://dom.spec.whatwg.org/#event
	 */

	class Event$1 {
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-none
	   */
	  static get NONE() {
	    return NONE;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-capturing_phase
	   */


	  static get CAPTURING_PHASE() {
	    return CAPTURING_PHASE;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-at_target
	   */


	  static get AT_TARGET() {
	    return AT_TARGET;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-bubbling_phase
	   */


	  static get BUBBLING_PHASE() {
	    return BUBBLING_PHASE;
	  }
	  /**
	   * Initialize this event instance.
	   * @param type The type of this event.
	   * @param eventInitDict Options to initialize.
	   * @see https://dom.spec.whatwg.org/#dom-event-event
	   */


	  constructor(type, eventInitDict) {
	    Object.defineProperty(this, "isTrusted", {
	      value: false,
	      enumerable: true
	    });
	    const opts = eventInitDict !== null && eventInitDict !== void 0 ? eventInitDict : {};
	    internalDataMap.set(this, {
	      type: String(type),
	      bubbles: Boolean(opts.bubbles),
	      cancelable: Boolean(opts.cancelable),
	      composed: Boolean(opts.composed),
	      target: null,
	      currentTarget: null,
	      stopPropagationFlag: false,
	      stopImmediatePropagationFlag: false,
	      canceledFlag: false,
	      inPassiveListenerFlag: false,
	      dispatchFlag: false,
	      timeStamp: Date.now()
	    });
	  }
	  /**
	   * The type of this event.
	   * @see https://dom.spec.whatwg.org/#dom-event-type
	   */


	  get type() {
	    return $(this).type;
	  }
	  /**
	   * The event target of the current dispatching.
	   * @see https://dom.spec.whatwg.org/#dom-event-target
	   */


	  get target() {
	    return $(this).target;
	  }
	  /**
	   * The event target of the current dispatching.
	   * @deprecated Use the `target` property instead.
	   * @see https://dom.spec.whatwg.org/#dom-event-srcelement
	   */


	  get srcElement() {
	    return $(this).target;
	  }
	  /**
	   * The event target of the current dispatching.
	   * @see https://dom.spec.whatwg.org/#dom-event-currenttarget
	   */


	  get currentTarget() {
	    return $(this).currentTarget;
	  }
	  /**
	   * The event target of the current dispatching.
	   * This doesn't support node tree.
	   * @see https://dom.spec.whatwg.org/#dom-event-composedpath
	   */


	  composedPath() {
	    const currentTarget = $(this).currentTarget;

	    if (currentTarget) {
	      return [currentTarget];
	    }

	    return [];
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-none
	   */


	  get NONE() {
	    return NONE;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-capturing_phase
	   */


	  get CAPTURING_PHASE() {
	    return CAPTURING_PHASE;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-at_target
	   */


	  get AT_TARGET() {
	    return AT_TARGET;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-bubbling_phase
	   */


	  get BUBBLING_PHASE() {
	    return BUBBLING_PHASE;
	  }
	  /**
	   * The current event phase.
	   * @see https://dom.spec.whatwg.org/#dom-event-eventphase
	   */


	  get eventPhase() {
	    return $(this).dispatchFlag ? 2 : 0;
	  }
	  /**
	   * Stop event bubbling.
	   * Because this shim doesn't support node tree, this merely changes the `cancelBubble` property value.
	   * @see https://dom.spec.whatwg.org/#dom-event-stoppropagation
	   */


	  stopPropagation() {
	    $(this).stopPropagationFlag = true;
	  }
	  /**
	   * `true` if event bubbling was stopped.
	   * @deprecated
	   * @see https://dom.spec.whatwg.org/#dom-event-cancelbubble
	   */


	  get cancelBubble() {
	    return $(this).stopPropagationFlag;
	  }
	  /**
	   * Stop event bubbling if `true` is set.
	   * @deprecated Use the `stopPropagation()` method instead.
	   * @see https://dom.spec.whatwg.org/#dom-event-cancelbubble
	   */


	  set cancelBubble(value) {
	    if (value) {
	      $(this).stopPropagationFlag = true;
	    } else {
	      FalsyWasAssignedToCancelBubble.warn();
	    }
	  }
	  /**
	   * Stop event bubbling and subsequent event listener callings.
	   * @see https://dom.spec.whatwg.org/#dom-event-stopimmediatepropagation
	   */


	  stopImmediatePropagation() {
	    const data = $(this);
	    data.stopPropagationFlag = data.stopImmediatePropagationFlag = true;
	  }
	  /**
	   * `true` if this event will bubble.
	   * @see https://dom.spec.whatwg.org/#dom-event-bubbles
	   */


	  get bubbles() {
	    return $(this).bubbles;
	  }
	  /**
	   * `true` if this event can be canceled by the `preventDefault()` method.
	   * @see https://dom.spec.whatwg.org/#dom-event-cancelable
	   */


	  get cancelable() {
	    return $(this).cancelable;
	  }
	  /**
	   * `true` if the default behavior will act.
	   * @deprecated Use the `defaultPrevented` proeprty instead.
	   * @see https://dom.spec.whatwg.org/#dom-event-returnvalue
	   */


	  get returnValue() {
	    return !$(this).canceledFlag;
	  }
	  /**
	   * Cancel the default behavior if `false` is set.
	   * @deprecated Use the `preventDefault()` method instead.
	   * @see https://dom.spec.whatwg.org/#dom-event-returnvalue
	   */


	  set returnValue(value) {
	    if (!value) {
	      setCancelFlag($(this));
	    } else {
	      TruthyWasAssignedToReturnValue.warn();
	    }
	  }
	  /**
	   * Cancel the default behavior.
	   * @see https://dom.spec.whatwg.org/#dom-event-preventdefault
	   */


	  preventDefault() {
	    setCancelFlag($(this));
	  }
	  /**
	   * `true` if the default behavior was canceled.
	   * @see https://dom.spec.whatwg.org/#dom-event-defaultprevented
	   */


	  get defaultPrevented() {
	    return $(this).canceledFlag;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-composed
	   */


	  get composed() {
	    return $(this).composed;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-istrusted
	   */
	  //istanbul ignore next


	  get isTrusted() {
	    return false;
	  }
	  /**
	   * @see https://dom.spec.whatwg.org/#dom-event-timestamp
	   */


	  get timeStamp() {
	    return $(this).timeStamp;
	  }
	  /**
	   * @deprecated Don't use this method. The constructor did initialization.
	   */


	  initEvent(type, bubbles = false, cancelable = false) {
	    const data = $(this);

	    if (data.dispatchFlag) {
	      InitEventWasCalledWhileDispatching.warn();
	      return;
	    }

	    internalDataMap.set(this, { ...data,
	      type: String(type),
	      bubbles: Boolean(bubbles),
	      cancelable: Boolean(cancelable),
	      target: null,
	      currentTarget: null,
	      stopPropagationFlag: false,
	      stopImmediatePropagationFlag: false,
	      canceledFlag: false
	    });
	  }

	} //------------------------------------------------------------------------------
	// Helpers
	//------------------------------------------------------------------------------


	const NONE = 0;
	const CAPTURING_PHASE = 1;
	const AT_TARGET = 2;
	const BUBBLING_PHASE = 3;
	/**
	 * Private data for event wrappers.
	 */

	const internalDataMap = new WeakMap();
	/**
	 * Get private data.
	 * @param event The event object to get private data.
	 * @param name The variable name to report.
	 * @returns The private data of the event.
	 */

	function $(event, name = "this") {
	  const retv = internalDataMap.get(event);
	  assertType(retv != null, "'%s' must be an object that Event constructor created, but got another one: %o", name, event);
	  return retv;
	}
	/**
	 * https://dom.spec.whatwg.org/#set-the-canceled-flag
	 * @param data private data.
	 */


	function setCancelFlag(data) {
	  if (data.inPassiveListenerFlag) {
	    CanceledInPassiveListener.warn();
	    return;
	  }

	  if (!data.cancelable) {
	    NonCancelableEventWasCanceled.warn();
	    return;
	  }

	  data.canceledFlag = true;
	} // Set enumerable


	Object.defineProperty(Event$1, "NONE", {
	  enumerable: true
	});
	Object.defineProperty(Event$1, "CAPTURING_PHASE", {
	  enumerable: true
	});
	Object.defineProperty(Event$1, "AT_TARGET", {
	  enumerable: true
	});
	Object.defineProperty(Event$1, "BUBBLING_PHASE", {
	  enumerable: true
	});
	const keys = Object.getOwnPropertyNames(Event$1.prototype);

	for (let i = 0; i < keys.length; ++i) {
	  if (keys[i] === "constructor") {
	    continue;
	  }

	  Object.defineProperty(Event$1.prototype, keys[i], {
	    enumerable: true
	  });
	} // Ensure `event instanceof window.Event` is `true`.


	if (typeof Global !== "undefined" && typeof Global.Event !== "undefined") {
	  Object.setPrototypeOf(Event$1.prototype, Global.Event.prototype);
	}
	/**
	 * Create a new InvalidStateError instance.
	 * @param message The error message.
	 */


	function createInvalidStateError(message) {
	  if (Global.DOMException) {
	    return new Global.DOMException(message, "InvalidStateError");
	  }

	  if (DOMException$1 == null) {
	    DOMException$1 = class DOMException extends Error {
	      constructor(msg) {
	        super(msg);

	        if (Error.captureStackTrace) {
	          Error.captureStackTrace(this, DOMException);
	        }
	      } // eslint-disable-next-line class-methods-use-this


	      get code() {
	        return 11;
	      } // eslint-disable-next-line class-methods-use-this


	      get name() {
	        return "InvalidStateError";
	      }

	    };
	    Object.defineProperties(DOMException$1.prototype, {
	      code: {
	        enumerable: true
	      },
	      name: {
	        enumerable: true
	      }
	    });
	    defineErrorCodeProperties(DOMException$1);
	    defineErrorCodeProperties(DOMException$1.prototype);
	  }

	  return new DOMException$1(message);
	} //------------------------------------------------------------------------------
	// Helpers
	//------------------------------------------------------------------------------


	let DOMException$1;
	const ErrorCodeMap = {
	  INDEX_SIZE_ERR: 1,
	  DOMSTRING_SIZE_ERR: 2,
	  HIERARCHY_REQUEST_ERR: 3,
	  WRONG_DOCUMENT_ERR: 4,
	  INVALID_CHARACTER_ERR: 5,
	  NO_DATA_ALLOWED_ERR: 6,
	  NO_MODIFICATION_ALLOWED_ERR: 7,
	  NOT_FOUND_ERR: 8,
	  NOT_SUPPORTED_ERR: 9,
	  INUSE_ATTRIBUTE_ERR: 10,
	  INVALID_STATE_ERR: 11,
	  SYNTAX_ERR: 12,
	  INVALID_MODIFICATION_ERR: 13,
	  NAMESPACE_ERR: 14,
	  INVALID_ACCESS_ERR: 15,
	  VALIDATION_ERR: 16,
	  TYPE_MISMATCH_ERR: 17,
	  SECURITY_ERR: 18,
	  NETWORK_ERR: 19,
	  ABORT_ERR: 20,
	  URL_MISMATCH_ERR: 21,
	  QUOTA_EXCEEDED_ERR: 22,
	  TIMEOUT_ERR: 23,
	  INVALID_NODE_TYPE_ERR: 24,
	  DATA_CLONE_ERR: 25
	};

	function defineErrorCodeProperties(obj) {
	  const keys = Object.keys(ErrorCodeMap);

	  for (let i = 0; i < keys.length; ++i) {
	    const key = keys[i];
	    const value = ErrorCodeMap[key];
	    Object.defineProperty(obj, key, {
	      get() {
	        return value;
	      },

	      configurable: true,
	      enumerable: true
	    });
	  }
	}
	/**
	 * An implementation of `Event` interface, that wraps a given event object.
	 * This class controls the internal state of `Event`.
	 * @see https://dom.spec.whatwg.org/#interface-event
	 */


	class EventWrapper extends Event$1 {
	  /**
	   * Wrap a given event object to control states.
	   * @param event The event-like object to wrap.
	   */
	  static wrap(event) {
	    return new (getWrapperClassOf(event))(event);
	  }

	  constructor(event) {
	    super(event.type, {
	      bubbles: event.bubbles,
	      cancelable: event.cancelable,
	      composed: event.composed
	    });

	    if (event.cancelBubble) {
	      super.stopPropagation();
	    }

	    if (event.defaultPrevented) {
	      super.preventDefault();
	    }

	    internalDataMap$1.set(this, {
	      original: event
	    }); // Define accessors

	    const keys = Object.keys(event);

	    for (let i = 0; i < keys.length; ++i) {
	      const key = keys[i];

	      if (!(key in this)) {
	        Object.defineProperty(this, key, defineRedirectDescriptor(event, key));
	      }
	    }
	  }

	  stopPropagation() {
	    super.stopPropagation();
	    const {
	      original
	    } = $$1(this);

	    if ("stopPropagation" in original) {
	      original.stopPropagation();
	    }
	  }

	  get cancelBubble() {
	    return super.cancelBubble;
	  }

	  set cancelBubble(value) {
	    super.cancelBubble = value;
	    const {
	      original
	    } = $$1(this);

	    if ("cancelBubble" in original) {
	      original.cancelBubble = value;
	    }
	  }

	  stopImmediatePropagation() {
	    super.stopImmediatePropagation();
	    const {
	      original
	    } = $$1(this);

	    if ("stopImmediatePropagation" in original) {
	      original.stopImmediatePropagation();
	    }
	  }

	  get returnValue() {
	    return super.returnValue;
	  }

	  set returnValue(value) {
	    super.returnValue = value;
	    const {
	      original
	    } = $$1(this);

	    if ("returnValue" in original) {
	      original.returnValue = value;
	    }
	  }

	  preventDefault() {
	    super.preventDefault();
	    const {
	      original
	    } = $$1(this);

	    if ("preventDefault" in original) {
	      original.preventDefault();
	    }
	  }

	  get timeStamp() {
	    const {
	      original
	    } = $$1(this);

	    if ("timeStamp" in original) {
	      return original.timeStamp;
	    }

	    return super.timeStamp;
	  }

	}
	/**
	 * Private data for event wrappers.
	 */


	const internalDataMap$1 = new WeakMap();
	/**
	 * Get private data.
	 * @param event The event object to get private data.
	 * @returns The private data of the event.
	 */

	function $$1(event) {
	  const retv = internalDataMap$1.get(event);
	  assertType(retv != null, "'this' is expected an Event object, but got", event);
	  return retv;
	}
	/**
	 * Cache for wrapper classes.
	 * @type {WeakMap<Object, Function>}
	 * @private
	 */


	const wrapperClassCache = new WeakMap(); // Make association for wrappers.

	wrapperClassCache.set(Object.prototype, EventWrapper);

	if (typeof Global !== "undefined" && typeof Global.Event !== "undefined") {
	  wrapperClassCache.set(Global.Event.prototype, EventWrapper);
	}
	/**
	 * Get the wrapper class of a given prototype.
	 * @param originalEvent The event object to wrap.
	 */


	function getWrapperClassOf(originalEvent) {
	  const prototype = Object.getPrototypeOf(originalEvent);

	  if (prototype == null) {
	    return EventWrapper;
	  }

	  let wrapper = wrapperClassCache.get(prototype);

	  if (wrapper == null) {
	    wrapper = defineWrapper(getWrapperClassOf(prototype), prototype);
	    wrapperClassCache.set(prototype, wrapper);
	  }

	  return wrapper;
	}
	/**
	 * Define new wrapper class.
	 * @param BaseEventWrapper The base wrapper class.
	 * @param originalPrototype The prototype of the original event.
	 */


	function defineWrapper(BaseEventWrapper, originalPrototype) {
	  class CustomEventWrapper extends BaseEventWrapper {}

	  const keys = Object.keys(originalPrototype);

	  for (let i = 0; i < keys.length; ++i) {
	    Object.defineProperty(CustomEventWrapper.prototype, keys[i], defineRedirectDescriptor(originalPrototype, keys[i]));
	  }

	  return CustomEventWrapper;
	}
	/**
	 * Get the property descriptor to redirect a given property.
	 */


	function defineRedirectDescriptor(obj, key) {
	  const d = Object.getOwnPropertyDescriptor(obj, key);
	  return {
	    get() {
	      const original = $$1(this).original;
	      const value = original[key];

	      if (typeof value === "function") {
	        return value.bind(original);
	      }

	      return value;
	    },

	    set(value) {
	      const original = $$1(this).original;
	      original[key] = value;
	    },

	    configurable: d.configurable,
	    enumerable: d.enumerable
	  };
	}
	/**
	 * Create a new listener.
	 * @param callback The callback function.
	 * @param capture The capture flag.
	 * @param passive The passive flag.
	 * @param once The once flag.
	 * @param signal The abort signal.
	 * @param signalListener The abort event listener for the abort signal.
	 */


	function createListener(callback, capture, passive, once, signal, signalListener) {
	  return {
	    callback,
	    flags: (capture ? 1
	    /* Capture */
	    : 0) | (passive ? 2
	    /* Passive */
	    : 0) | (once ? 4
	    /* Once */
	    : 0),
	    signal,
	    signalListener
	  };
	}
	/**
	 * Set the `removed` flag to the given listener.
	 * @param listener The listener to check.
	 */


	function setRemoved(listener) {
	  listener.flags |= 8
	  /* Removed */
	  ;
	}
	/**
	 * Check if the given listener has the `capture` flag or not.
	 * @param listener The listener to check.
	 */


	function isCapture(listener) {
	  return (listener.flags & 1
	  /* Capture */
	  ) === 1
	  /* Capture */
	  ;
	}
	/**
	 * Check if the given listener has the `passive` flag or not.
	 * @param listener The listener to check.
	 */


	function isPassive(listener) {
	  return (listener.flags & 2
	  /* Passive */
	  ) === 2
	  /* Passive */
	  ;
	}
	/**
	 * Check if the given listener has the `once` flag or not.
	 * @param listener The listener to check.
	 */


	function isOnce(listener) {
	  return (listener.flags & 4
	  /* Once */
	  ) === 4
	  /* Once */
	  ;
	}
	/**
	 * Check if the given listener has the `removed` flag or not.
	 * @param listener The listener to check.
	 */


	function isRemoved(listener) {
	  return (listener.flags & 8
	  /* Removed */
	  ) === 8
	  /* Removed */
	  ;
	}
	/**
	 * Call an event listener.
	 * @param listener The listener to call.
	 * @param target The event target object for `thisArg`.
	 * @param event The event object for the first argument.
	 * @param attribute `true` if this callback is an event attribute handler.
	 */


	function invokeCallback({
	  callback
	}, target, event) {
	  try {
	    if (typeof callback === "function") {
	      callback.call(target, event);
	    } else if (typeof callback.handleEvent === "function") {
	      callback.handleEvent(event);
	    }
	  } catch (thrownError) {
	    reportError(thrownError);
	  }
	}
	/**
	 * Find the index of given listener.
	 * This returns `-1` if not found.
	 * @param list The listener list.
	 * @param callback The callback function to find.
	 * @param capture The capture flag to find.
	 */


	function findIndexOfListener({
	  listeners
	}, callback, capture) {
	  for (let i = 0; i < listeners.length; ++i) {
	    if (listeners[i].callback === callback && isCapture(listeners[i]) === capture) {
	      return i;
	    }
	  }

	  return -1;
	}
	/**
	 * Add the given listener.
	 * Does copy-on-write if needed.
	 * @param list The listener list.
	 * @param callback The callback function.
	 * @param capture The capture flag.
	 * @param passive The passive flag.
	 * @param once The once flag.
	 * @param signal The abort signal.
	 */


	function addListener(list, callback, capture, passive, once, signal) {
	  let signalListener;

	  if (signal) {
	    signalListener = removeListener.bind(null, list, callback, capture);
	    signal.addEventListener("abort", signalListener);
	  }

	  const listener = createListener(callback, capture, passive, once, signal, signalListener);

	  if (list.cow) {
	    list.cow = false;
	    list.listeners = [...list.listeners, listener];
	  } else {
	    list.listeners.push(listener);
	  }

	  return listener;
	}
	/**
	 * Remove a listener.
	 * @param list The listener list.
	 * @param callback The callback function to find.
	 * @param capture The capture flag to find.
	 * @returns `true` if it mutated the list directly.
	 */


	function removeListener(list, callback, capture) {
	  const index = findIndexOfListener(list, callback, capture);

	  if (index !== -1) {
	    return removeListenerAt(list, index);
	  }

	  return false;
	}
	/**
	 * Remove a listener.
	 * @param list The listener list.
	 * @param index The index of the target listener.
	 * @param disableCow Disable copy-on-write if true.
	 * @returns `true` if it mutated the `listeners` array directly.
	 */


	function removeListenerAt(list, index, disableCow = false) {
	  const listener = list.listeners[index]; // Set the removed flag.

	  setRemoved(listener); // Dispose the abort signal listener if exists.

	  if (listener.signal) {
	    listener.signal.removeEventListener("abort", listener.signalListener);
	  } // Remove it from the array.


	  if (list.cow && !disableCow) {
	    list.cow = false;
	    list.listeners = list.listeners.filter((_, i) => i !== index);
	    return false;
	  }

	  list.listeners.splice(index, 1);
	  return true;
	}
	/**
	 * Create a new `ListenerListMap` object.
	 */


	function createListenerListMap() {
	  return Object.create(null);
	}
	/**
	 * Get the listener list of the given type.
	 * If the listener list has not been initialized, initialize and return it.
	 * @param listenerMap The listener list map.
	 * @param type The event type to get.
	 */


	function ensureListenerList(listenerMap, type) {
	  var _a;

	  return (_a = listenerMap[type]) !== null && _a !== void 0 ? _a : listenerMap[type] = {
	    attrCallback: undefined,
	    attrListener: undefined,
	    cow: false,
	    listeners: []
	  };
	}
	/**
	 * An implementation of the `EventTarget` interface.
	 * @see https://dom.spec.whatwg.org/#eventtarget
	 */


	class EventTarget$1 {
	  /**
	   * Initialize this instance.
	   */
	  constructor() {
	    internalDataMap$2.set(this, createListenerListMap());
	  } // Implementation


	  addEventListener(type0, callback0, options0) {
	    const listenerMap = $$2(this);
	    const {
	      callback,
	      capture,
	      once,
	      passive,
	      signal,
	      type
	    } = normalizeAddOptions(type0, callback0, options0);

	    if (callback == null || (signal === null || signal === void 0 ? void 0 : signal.aborted)) {
	      return;
	    }

	    const list = ensureListenerList(listenerMap, type); // Find existing listener.

	    const i = findIndexOfListener(list, callback, capture);

	    if (i !== -1) {
	      warnDuplicate(list.listeners[i], passive, once, signal);
	      return;
	    } // Add the new listener.


	    addListener(list, callback, capture, passive, once, signal);
	  } // Implementation


	  removeEventListener(type0, callback0, options0) {
	    const listenerMap = $$2(this);
	    const {
	      callback,
	      capture,
	      type
	    } = normalizeOptions(type0, callback0, options0);
	    const list = listenerMap[type];

	    if (callback != null && list) {
	      removeListener(list, callback, capture);
	    }
	  } // Implementation


	  dispatchEvent(e) {
	    const list = $$2(this)[String(e.type)];

	    if (list == null) {
	      return true;
	    }

	    const event = e instanceof Event$1 ? e : EventWrapper.wrap(e);
	    const eventData = $(event, "event");

	    if (eventData.dispatchFlag) {
	      throw createInvalidStateError("This event has been in dispatching.");
	    }

	    eventData.dispatchFlag = true;
	    eventData.target = eventData.currentTarget = this;

	    if (!eventData.stopPropagationFlag) {
	      const {
	        cow,
	        listeners
	      } = list; // Set copy-on-write flag.

	      list.cow = true; // Call listeners.

	      for (let i = 0; i < listeners.length; ++i) {
	        const listener = listeners[i]; // Skip if removed.

	        if (isRemoved(listener)) {
	          continue;
	        } // Remove this listener if has the `once` flag.


	        if (isOnce(listener) && removeListenerAt(list, i, !cow)) {
	          // Because this listener was removed, the next index is the
	          // same as the current value.
	          i -= 1;
	        } // Call this listener with the `passive` flag.


	        eventData.inPassiveListenerFlag = isPassive(listener);
	        invokeCallback(listener, this, event);
	        eventData.inPassiveListenerFlag = false; // Stop if the `event.stopImmediatePropagation()` method was called.

	        if (eventData.stopImmediatePropagationFlag) {
	          break;
	        }
	      } // Restore copy-on-write flag.


	      if (!cow) {
	        list.cow = false;
	      }
	    }

	    eventData.target = null;
	    eventData.currentTarget = null;
	    eventData.stopImmediatePropagationFlag = false;
	    eventData.stopPropagationFlag = false;
	    eventData.dispatchFlag = false;
	    return !eventData.canceledFlag;
	  }

	}
	/**
	 * Internal data.
	 */


	const internalDataMap$2 = new WeakMap();
	/**
	 * Get private data.
	 * @param target The event target object to get private data.
	 * @param name The variable name to report.
	 * @returns The private data of the event.
	 */

	function $$2(target, name = "this") {
	  const retv = internalDataMap$2.get(target);
	  assertType(retv != null, "'%s' must be an object that EventTarget constructor created, but got another one: %o", name, target);
	  return retv;
	}
	/**
	 * Normalize options.
	 * @param options The options to normalize.
	 */


	function normalizeAddOptions(type, callback, options) {
	  var _a;

	  assertCallback(callback);

	  if (typeof options === "object" && options !== null) {
	    return {
	      type: String(type),
	      callback: callback !== null && callback !== void 0 ? callback : undefined,
	      capture: Boolean(options.capture),
	      passive: Boolean(options.passive),
	      once: Boolean(options.once),
	      signal: (_a = options.signal) !== null && _a !== void 0 ? _a : undefined
	    };
	  }

	  return {
	    type: String(type),
	    callback: callback !== null && callback !== void 0 ? callback : undefined,
	    capture: Boolean(options),
	    passive: false,
	    once: false,
	    signal: undefined
	  };
	}
	/**
	 * Normalize options.
	 * @param options The options to normalize.
	 */


	function normalizeOptions(type, callback, options) {
	  assertCallback(callback);

	  if (typeof options === "object" && options !== null) {
	    return {
	      type: String(type),
	      callback: callback !== null && callback !== void 0 ? callback : undefined,
	      capture: Boolean(options.capture)
	    };
	  }

	  return {
	    type: String(type),
	    callback: callback !== null && callback !== void 0 ? callback : undefined,
	    capture: Boolean(options)
	  };
	}
	/**
	 * Assert the type of 'callback' argument.
	 * @param callback The callback to check.
	 */


	function assertCallback(callback) {
	  if (typeof callback === "function" || typeof callback === "object" && callback !== null && typeof callback.handleEvent === "function") {
	    return;
	  }

	  if (callback == null || typeof callback === "object") {
	    InvalidEventListener.warn(callback);
	    return;
	  }

	  throw new TypeError(format(InvalidEventListener.message, [callback]));
	}
	/**
	 * Print warning for duplicated.
	 * @param listener The current listener that is duplicated.
	 * @param passive The passive flag of the new duplicated listener.
	 * @param once The once flag of the new duplicated listener.
	 * @param signal The signal object of the new duplicated listener.
	 */


	function warnDuplicate(listener, passive, once, signal) {
	  EventListenerWasDuplicated.warn(isCapture(listener) ? "capture" : "bubble", listener.callback);

	  if (isPassive(listener) !== passive) {
	    OptionWasIgnored.warn("passive");
	  }

	  if (isOnce(listener) !== once) {
	    OptionWasIgnored.warn("once");
	  }

	  if (listener.signal !== signal) {
	    OptionWasIgnored.warn("signal");
	  }
	} // Set enumerable


	const keys$1 = Object.getOwnPropertyNames(EventTarget$1.prototype);

	for (let i = 0; i < keys$1.length; ++i) {
	  if (keys$1[i] === "constructor") {
	    continue;
	  }

	  Object.defineProperty(EventTarget$1.prototype, keys$1[i], {
	    enumerable: true
	  });
	} // Ensure `eventTarget instanceof window.EventTarget` is `true`.


	if (typeof Global !== "undefined" && typeof Global.EventTarget !== "undefined") {
	  Object.setPrototypeOf(EventTarget$1.prototype, Global.EventTarget.prototype);
	}

	// https://bugs.webkit.org/show_bug.cgi?id=174980

	try {
	  new window.EventTarget();
	} catch (error) {
	  window.EventTarget = EventTarget$1;
	}

	// ready
	const onDomReady = (callback) => {
	    if (document.readyState === 'loading') {
	        document.addEventListener('DOMContentLoaded', callback);
	    }
	    else {
	        callback();
	    }
	};
	// assert
	class AssertionError extends Error {
	}
	const assert = (condition, description) => {
	    if (!condition) {
	        const message = `Assertion failed${description !== undefined ? `: ${description}` : '.'}`;
	        throw new AssertionError(message);
	    }
	};

	class UIHandler extends EventTarget {
	    constructor(naja) {
	        super();
	        this.naja = naja;
	        this.selector = '.ajax';
	        this.allowedOrigins = [window.location.origin];
	        this.handler = this.handleUI.bind(this);
	        naja.addEventListener('init', this.initialize.bind(this));
	    }
	    initialize() {
	        onDomReady(() => this.bindUI(window.document.body));
	        this.naja.snippetHandler.addEventListener('afterUpdate', (event) => {
	            const { snippet } = event.detail;
	            this.bindUI(snippet);
	        });
	    }
	    bindUI(element) {
	        const selectors = [
	            `a${this.selector}`,
	            `input[type="submit"]${this.selector}`,
	            `input[type="image"]${this.selector}`,
	            `button[type="submit"]${this.selector}`,
	            `form${this.selector} input[type="submit"]`,
	            `form${this.selector} input[type="image"]`,
	            `form${this.selector} button[type="submit"]`,
	        ].join(', ');
	        const bindElement = (element) => {
	            element.removeEventListener('click', this.handler);
	            element.addEventListener('click', this.handler);
	        };
	        const elements = element.querySelectorAll(selectors);
	        for (let i = 0; i < elements.length; i++) {
	            bindElement(elements.item(i));
	        }
	        if (element.matches(selectors)) {
	            bindElement(element);
	        }
	        const bindForm = (form) => {
	            form.removeEventListener('submit', this.handler);
	            form.addEventListener('submit', this.handler);
	        };
	        if (element.matches(`form${this.selector}`)) {
	            bindForm(element);
	        }
	        const forms = element.querySelectorAll(`form${this.selector}`);
	        for (let i = 0; i < forms.length; i++) {
	            bindForm(forms.item(i));
	        }
	    }
	    handleUI(event) {
	        const mouseEvent = event;
	        if (mouseEvent.altKey || mouseEvent.ctrlKey || mouseEvent.shiftKey || mouseEvent.metaKey || mouseEvent.button) {
	            return;
	        }
	        const element = event.currentTarget;
	        const options = {};
	        const ignoreErrors = () => {
	            // don't reject the promise in case of an error as developers have no way of handling the rejection
	            // in this situation; errors should be handled in `naja.addEventListener('error', errorHandler)`
	        };
	        if (event.type === 'submit') {
	            this.submitForm(element, options, event).catch(ignoreErrors);
	        }
	        else if (event.type === 'click') {
	            this.clickElement(element, options, mouseEvent).catch(ignoreErrors);
	        }
	    }
	    async clickElement(element, options = {}, event) {
	        var _a, _b, _c, _d, _e, _f;
	        let method = 'GET', url = '', data;
	        if (!this.dispatchEvent(new CustomEvent('interaction', { cancelable: true, detail: { element, originalEvent: event, options } }))) {
	            event === null || event === void 0 ? void 0 : event.preventDefault();
	            return {};
	        }
	        if (element.tagName === 'A') {
	            assert(element instanceof HTMLAnchorElement);
	            method = 'GET';
	            url = element.href;
	            data = null;
	        }
	        else if (element.tagName === 'INPUT' || element.tagName === 'BUTTON') {
	            assert(element instanceof HTMLInputElement || element instanceof HTMLButtonElement);
	            const { form } = element;
	            // eslint-disable-next-line no-nested-ternary,no-extra-parens
	            method = (_d = (_b = (_a = element.getAttribute('formmethod')) === null || _a === void 0 ? void 0 : _a.toUpperCase()) !== null && _b !== void 0 ? _b : (_c = form === null || form === void 0 ? void 0 : form.getAttribute('method')) === null || _c === void 0 ? void 0 : _c.toUpperCase()) !== null && _d !== void 0 ? _d : 'GET';
	            url = (_f = (_e = element.getAttribute('formaction')) !== null && _e !== void 0 ? _e : form === null || form === void 0 ? void 0 : form.getAttribute('action')) !== null && _f !== void 0 ? _f : window.location.pathname + window.location.search;
	            data = new FormData(form !== null && form !== void 0 ? form : undefined);
	            if (element.type === 'submit' && element.name !== '') {
	                data.append(element.name, element.value || '');
	            }
	            else if (element.type === 'image') {
	                const coords = element.getBoundingClientRect();
	                const prefix = element.name !== '' ? `${element.name}.` : '';
	                data.append(`${prefix}x`, Math.max(0, Math.floor(event !== undefined ? event.pageX - coords.left : 0)));
	                data.append(`${prefix}y`, Math.max(0, Math.floor(event !== undefined ? event.pageY - coords.top : 0)));
	            }
	        }
	        if (!this.isUrlAllowed(url)) {
	            throw new Error(`Cannot dispatch async request, URL is not allowed: ${url}`);
	        }
	        event === null || event === void 0 ? void 0 : event.preventDefault();
	        return this.naja.makeRequest(method, url, data, options);
	    }
	    async submitForm(form, options = {}, event) {
	        var _a, _b, _c;
	        if (!this.dispatchEvent(new CustomEvent('interaction', { cancelable: true, detail: { element: form, originalEvent: event, options } }))) {
	            event === null || event === void 0 ? void 0 : event.preventDefault();
	            return {};
	        }
	        const method = (_b = (_a = form.getAttribute('method')) === null || _a === void 0 ? void 0 : _a.toUpperCase()) !== null && _b !== void 0 ? _b : 'GET';
	        const url = (_c = form.getAttribute('action')) !== null && _c !== void 0 ? _c : window.location.pathname + window.location.search;
	        const data = new FormData(form);
	        if (!this.isUrlAllowed(url)) {
	            throw new Error(`Cannot dispatch async request, URL is not allowed: ${url}`);
	        }
	        event === null || event === void 0 ? void 0 : event.preventDefault();
	        return this.naja.makeRequest(method, url, data, options);
	    }
	    isUrlAllowed(url) {
	        const urlObject = new URL(url, location.href);
	        // ignore non-URL URIs (javascript:, data:, mailto:, ...)
	        if (urlObject.origin === 'null') {
	            return false;
	        }
	        return this.allowedOrigins.includes(urlObject.origin);
	    }
	}

	class FormsHandler {
	    constructor(naja) {
	        this.naja = naja;
	        naja.addEventListener('init', this.initialize.bind(this));
	        naja.uiHandler.addEventListener('interaction', this.processForm.bind(this));
	    }
	    initialize() {
	        onDomReady(() => this.initForms(window.document.body));
	        this.naja.snippetHandler.addEventListener('afterUpdate', (event) => {
	            const { snippet } = event.detail;
	            this.initForms(snippet);
	        });
	    }
	    initForms(element) {
	        const netteForms = this.netteForms || window.Nette;
	        if (netteForms) {
	            if (element.tagName === 'form') {
	                netteForms.initForm(element);
	            }
	            const forms = element.querySelectorAll('form');
	            for (let i = 0; i < forms.length; i++) {
	                netteForms.initForm(forms.item(i));
	            }
	        }
	    }
	    processForm(event) {
	        const { element, originalEvent } = event.detail;
	        const inputElement = element;
	        if (inputElement.form !== undefined && inputElement.form !== null) {
	            inputElement.form['nette-submittedBy'] = element;
	        }
	        const netteForms = this.netteForms || window.Nette;
	        if ((element.tagName === 'FORM' || element.form) && netteForms && !netteForms.validateForm(element)) {
	            if (originalEvent) {
	                originalEvent.stopImmediatePropagation();
	                originalEvent.preventDefault();
	            }
	            event.preventDefault();
	        }
	    }
	}

	class RedirectHandler extends EventTarget {
	    constructor(naja) {
	        super();
	        this.naja = naja;
	        naja.uiHandler.addEventListener('interaction', (event) => {
	            var _a, _b, _c;
	            const { element, options } = event.detail;
	            if (!element) {
	                return;
	            }
	            if (element.hasAttribute('data-naja-force-redirect') || ((_a = element.form) === null || _a === void 0 ? void 0 : _a.hasAttribute('data-naja-force-redirect'))) {
	                const value = (_b = element.getAttribute('data-naja-force-redirect')) !== null && _b !== void 0 ? _b : (_c = element.form) === null || _c === void 0 ? void 0 : _c.getAttribute('data-naja-force-redirect');
	                options.forceRedirect = value !== 'off';
	            }
	        });
	        naja.addEventListener('success', (event) => {
	            var _a;
	            const { payload, options } = event.detail;
	            if (payload.redirect) {
	                this.makeRedirect(payload.redirect, (_a = options.forceRedirect) !== null && _a !== void 0 ? _a : false, options);
	                event.stopImmediatePropagation();
	            }
	        });
	        this.locationAdapter = {
	            assign: (url) => window.location.assign(url),
	        };
	    }
	    makeRedirect(url, force, options = {}) {
	        if (url instanceof URL) {
	            url = url.href;
	        }
	        let isHardRedirect = force || !this.naja.uiHandler.isUrlAllowed(url);
	        const canRedirect = this.dispatchEvent(new CustomEvent('redirect', {
	            cancelable: true,
	            detail: {
	                url,
	                isHardRedirect,
	                setHardRedirect(value) {
	                    isHardRedirect = !!value;
	                },
	                options,
	            },
	        }));
	        if (!canRedirect) {
	            return;
	        }
	        if (isHardRedirect) {
	            this.locationAdapter.assign(url);
	        }
	        else {
	            this.naja.makeRequest('GET', url, null, options);
	        }
	    }
	}

	class SnippetHandler extends EventTarget {
	    constructor(naja) {
	        super();
	        this.naja = naja;
	        this.op = {
	            replace: (snippet, content) => {
	                snippet.innerHTML = content;
	            },
	            prepend: (snippet, content) => snippet.insertAdjacentHTML('afterbegin', content),
	            append: (snippet, content) => snippet.insertAdjacentHTML('beforeend', content),
	        };
	        naja.addEventListener('success', (event) => {
	            const { options, payload } = event.detail;
	            if (payload.snippets) {
	                this.updateSnippets(payload.snippets, false, options);
	            }
	        });
	    }
	    static findSnippets(predicate) {
	        var _a;
	        const result = {};
	        const snippets = window.document.querySelectorAll('[id^="snippet-"]');
	        for (let i = 0; i < snippets.length; i++) {
	            const snippet = snippets.item(i);
	            if ((_a = predicate === null || predicate === void 0 ? void 0 : predicate(snippet)) !== null && _a !== void 0 ? _a : true) {
	                result[snippet.id] = snippet.innerHTML;
	            }
	        }
	        return result;
	    }
	    updateSnippets(snippets, fromCache = false, options = {}) {
	        Object.keys(snippets).forEach((id) => {
	            const snippet = document.getElementById(id);
	            if (snippet) {
	                this.updateSnippet(snippet, snippets[id], fromCache, options);
	            }
	        });
	    }
	    updateSnippet(snippet, content, fromCache, options) {
	        let operation = this.op.replace;
	        if ((snippet.hasAttribute('data-naja-snippet-prepend') || snippet.hasAttribute('data-ajax-prepend')) && !fromCache) {
	            operation = this.op.prepend;
	        }
	        else if ((snippet.hasAttribute('data-naja-snippet-append') || snippet.hasAttribute('data-ajax-append')) && !fromCache) {
	            operation = this.op.append;
	        }
	        const canUpdate = this.dispatchEvent(new CustomEvent('beforeUpdate', {
	            cancelable: true,
	            detail: {
	                snippet,
	                content,
	                fromCache,
	                operation,
	                changeOperation(value) {
	                    operation = value;
	                },
	                options,
	            },
	        }));
	        if (!canUpdate) {
	            return;
	        }
	        if (snippet.tagName.toLowerCase() === 'title') {
	            document.title = content;
	        }
	        else {
	            operation(snippet, content);
	        }
	        this.dispatchEvent(new CustomEvent('afterUpdate', {
	            cancelable: true,
	            detail: {
	                snippet,
	                content,
	                fromCache,
	                operation,
	                options,
	            },
	        }));
	    }
	}

	class HistoryHandler extends EventTarget {
	    constructor(naja) {
	        super();
	        this.naja = naja;
	        this.href = null;
	        this.popStateHandler = this.handlePopState.bind(this);
	        naja.addEventListener('init', this.initialize.bind(this));
	        naja.addEventListener('before', this.saveUrl.bind(this));
	        naja.addEventListener('success', this.pushNewState.bind(this));
	        naja.uiHandler.addEventListener('interaction', this.configureMode.bind(this));
	        this.historyAdapter = {
	            replaceState: (state, title, url) => window.history.replaceState(state, title, url),
	            pushState: (state, title, url) => window.history.pushState(state, title, url),
	        };
	    }
	    set uiCache(value) {
	        console.warn('Naja: HistoryHandler.uiCache is deprecated, use options.snippetCache instead.');
	        this.naja.defaultOptions.snippetCache = value;
	    }
	    initialize(event) {
	        const { defaultOptions } = event.detail;
	        window.addEventListener('popstate', this.popStateHandler);
	        onDomReady(() => this.historyAdapter.replaceState(this.buildState(window.location.href, defaultOptions), window.document.title, window.location.href));
	    }
	    handlePopState(event) {
	        const { state } = event;
	        if (!state) {
	            return;
	        }
	        const options = this.naja.prepareOptions();
	        this.dispatchEvent(new CustomEvent('restoreState', { detail: { state, options } }));
	    }
	    saveUrl(event) {
	        const { url } = event.detail;
	        this.href = url;
	    }
	    configureMode(event) {
	        var _a, _b, _c;
	        const { element, options } = event.detail;
	        // propagate mode to options
	        if (!element) {
	            return;
	        }
	        if (element.hasAttribute('data-naja-history') || ((_a = element.form) === null || _a === void 0 ? void 0 : _a.hasAttribute('data-naja-history'))) {
	            const value = (_b = element.getAttribute('data-naja-history')) !== null && _b !== void 0 ? _b : (_c = element.form) === null || _c === void 0 ? void 0 : _c.getAttribute('data-naja-history');
	            options.history = HistoryHandler.normalizeMode(value);
	        }
	    }
	    static normalizeMode(mode) {
	        if (mode === 'off' || mode === false) {
	            return false;
	        }
	        else if (mode === 'replace') {
	            return 'replace';
	        }
	        return true;
	    }
	    pushNewState(event) {
	        const { payload, options } = event.detail;
	        const mode = HistoryHandler.normalizeMode(options.history);
	        if (mode === false) {
	            return;
	        }
	        if (payload.postGet && payload.url) {
	            this.href = payload.url;
	        }
	        const method = mode === 'replace' ? 'replaceState' : 'pushState';
	        this.historyAdapter[method](this.buildState(this.href, options), window.document.title, this.href);
	        this.href = null;
	    }
	    buildState(href, options) {
	        const state = { href };
	        this.dispatchEvent(new CustomEvent('buildState', { detail: { state, options } }));
	        return state;
	    }
	}

	class SnippetCache extends EventTarget {
	    constructor(naja) {
	        super();
	        this.naja = naja;
	        this.storages = {
	            off: new OffCacheStorage(naja),
	            history: new HistoryCacheStorage(),
	            session: new SessionCacheStorage(),
	        };
	        naja.uiHandler.addEventListener('interaction', this.configureCache.bind(this));
	        naja.historyHandler.addEventListener('buildState', this.buildHistoryState.bind(this));
	        naja.historyHandler.addEventListener('restoreState', this.restoreHistoryState.bind(this));
	    }
	    resolveStorage(option) {
	        let storageType;
	        if (option === true || option === undefined) {
	            storageType = 'history';
	        }
	        else if (option === false) {
	            storageType = 'off';
	        }
	        else {
	            storageType = option;
	        }
	        return this.storages[storageType];
	    }
	    configureCache(event) {
	        var _a, _b, _c, _d, _e, _f, _g;
	        const { element, options } = event.detail;
	        if (!element) {
	            return;
	        }
	        if (element.hasAttribute('data-naja-snippet-cache') || ((_a = element.form) === null || _a === void 0 ? void 0 : _a.hasAttribute('data-naja-snippet-cache'))
	            || element.hasAttribute('data-naja-history-cache') || ((_b = element.form) === null || _b === void 0 ? void 0 : _b.hasAttribute('data-naja-history-cache'))) {
	            const value = (_f = (_e = (_c = element.getAttribute('data-naja-snippet-cache')) !== null && _c !== void 0 ? _c : (_d = element.form) === null || _d === void 0 ? void 0 : _d.getAttribute('data-naja-snippet-cache')) !== null && _e !== void 0 ? _e : element.getAttribute('data-naja-history-cache')) !== null && _f !== void 0 ? _f : (_g = element.form) === null || _g === void 0 ? void 0 : _g.getAttribute('data-naja-history-cache');
	            options.snippetCache = value;
	        }
	    }
	    buildHistoryState(event) {
	        const { state, options } = event.detail;
	        if ('historyUiCache' in options) {
	            console.warn('Naja: options.historyUiCache is deprecated, use options.snippetCache instead.');
	            options.snippetCache = options.historyUiCache;
	        }
	        const snippets = SnippetHandler.findSnippets((snippet) => !snippet.hasAttribute('data-naja-history-nocache')
	            && !snippet.hasAttribute('data-history-nocache')
	            && (!snippet.hasAttribute('data-naja-snippet-cache')
	                || snippet.getAttribute('data-naja-snippet-cache') !== 'off'));
	        if (!this.dispatchEvent(new CustomEvent('store', { cancelable: true, detail: { snippets, state, options } }))) {
	            return;
	        }
	        const storage = this.resolveStorage(options.snippetCache);
	        state.snippets = {
	            storage: storage.type,
	            key: storage.store(snippets),
	        };
	    }
	    restoreHistoryState(event) {
	        const { state, options } = event.detail;
	        if (state.snippets === undefined) {
	            return;
	        }
	        options.snippetCache = state.snippets.storage;
	        if (!this.dispatchEvent(new CustomEvent('fetch', { cancelable: true, detail: { state, options } }))) {
	            return;
	        }
	        const storage = this.resolveStorage(options.snippetCache);
	        const snippets = storage.fetch(state.snippets.key, state, options);
	        if (snippets === null) {
	            return;
	        }
	        if (!this.dispatchEvent(new CustomEvent('restore', { cancelable: true, detail: { snippets, state, options } }))) {
	            return;
	        }
	        this.naja.snippetHandler.updateSnippets(snippets, true, options);
	        this.naja.scriptLoader.loadScripts(snippets);
	    }
	}
	class OffCacheStorage {
	    constructor(naja) {
	        this.naja = naja;
	        this.type = 'off';
	    } // eslint-disable-line no-empty-function
	    store() {
	        return null;
	    }
	    fetch(key, state, options) {
	        this.naja.makeRequest('GET', state.href, null, Object.assign(Object.assign({}, options), { history: false, snippetCache: false }));
	        return null;
	    }
	}
	class HistoryCacheStorage {
	    constructor() {
	        this.type = 'history';
	    }
	    store(data) {
	        return data;
	    }
	    fetch(key) {
	        return key;
	    }
	}
	class SessionCacheStorage {
	    constructor() {
	        this.type = 'session';
	    }
	    store(data) {
	        const key = Math.random().toString(36).substr(2, 6);
	        window.sessionStorage.setItem(key, JSON.stringify(data));
	        return key;
	    }
	    fetch(key) {
	        const data = window.sessionStorage.getItem(key);
	        if (data === null) {
	            return null;
	        }
	        return JSON.parse(data);
	    }
	}

	class ScriptLoader {
	    constructor(naja) {
	        this.loadedScripts = new Set();
	        naja.addEventListener('success', (event) => {
	            const { payload } = event.detail;
	            if (payload.snippets) {
	                this.loadScripts(payload.snippets);
	            }
	        });
	    }
	    loadScripts(snippets) {
	        Object.keys(snippets).forEach((id) => {
	            const content = snippets[id];
	            if (!/<script/i.test(content)) {
	                return;
	            }
	            const el = window.document.createElement('div');
	            el.innerHTML = content;
	            const scripts = el.querySelectorAll('script');
	            for (let i = 0; i < scripts.length; i++) {
	                const script = scripts.item(i);
	                const scriptId = script.getAttribute('data-naja-script-id');
	                if (scriptId !== null && scriptId !== '' && this.loadedScripts.has(scriptId)) {
	                    continue;
	                }
	                const scriptEl = window.document.createElement('script');
	                scriptEl.innerHTML = script.innerHTML;
	                if (script.hasAttributes()) {
	                    const attrs = script.attributes;
	                    for (let j = 0; j < attrs.length; j++) {
	                        const attrName = attrs[j].name;
	                        scriptEl.setAttribute(attrName, attrs[j].value);
	                    }
	                }
	                window.document.head.appendChild(scriptEl)
	                    .parentNode.removeChild(scriptEl);
	                if (scriptId !== null && scriptId !== '') {
	                    this.loadedScripts.add(scriptId);
	                }
	            }
	        });
	    }
	}

	class Naja extends EventTarget {
	    constructor(uiHandler, redirectHandler, snippetHandler, formsHandler, historyHandler, snippetCache, scriptLoader) {
	        super();
	        this.VERSION = 2;
	        this.initialized = false;
	        this.extensions = [];
	        this.defaultOptions = {};
	        this.uiHandler = new (uiHandler !== null && uiHandler !== void 0 ? uiHandler : UIHandler)(this);
	        this.redirectHandler = new (redirectHandler !== null && redirectHandler !== void 0 ? redirectHandler : RedirectHandler)(this);
	        this.snippetHandler = new (snippetHandler !== null && snippetHandler !== void 0 ? snippetHandler : SnippetHandler)(this);
	        this.formsHandler = new (formsHandler !== null && formsHandler !== void 0 ? formsHandler : FormsHandler)(this);
	        this.historyHandler = new (historyHandler !== null && historyHandler !== void 0 ? historyHandler : HistoryHandler)(this);
	        this.snippetCache = new (snippetCache !== null && snippetCache !== void 0 ? snippetCache : SnippetCache)(this);
	        this.scriptLoader = new (scriptLoader !== null && scriptLoader !== void 0 ? scriptLoader : ScriptLoader)(this);
	    }
	    registerExtension(extension) {
	        if (this.initialized) {
	            extension.initialize(this);
	        }
	        this.extensions.push(extension);
	    }
	    initialize(defaultOptions = {}) {
	        if (this.initialized) {
	            throw new Error('Cannot initialize Naja, it is already initialized.');
	        }
	        this.defaultOptions = this.prepareOptions(defaultOptions);
	        this.extensions.forEach((extension) => extension.initialize(this));
	        this.dispatchEvent(new CustomEvent('init', { detail: { defaultOptions: this.defaultOptions } }));
	        this.initialized = true;
	    }
	    prepareOptions(options) {
	        return Object.assign(Object.assign(Object.assign({}, this.defaultOptions), options), { fetch: Object.assign(Object.assign({}, this.defaultOptions.fetch), options === null || options === void 0 ? void 0 : options.fetch) });
	    }
	    async makeRequest(method, url, data = null, options = {}) {
	        // normalize url to instanceof URL
	        if (typeof url === 'string') {
	            url = new URL(url, location.href);
	        }
	        options = this.prepareOptions(options);
	        const headers = new Headers(options.fetch.headers || {});
	        const body = this.transformData(url, method, data);
	        const abortController = new AbortController();
	        const request = new Request(url.toString(), Object.assign(Object.assign({ credentials: 'same-origin' }, options.fetch), { method,
	            headers,
	            body, signal: abortController.signal }));
	        // impersonate XHR so that Nette can detect isAjax()
	        request.headers.set('X-Requested-With', 'XMLHttpRequest');
	        // hint the server that Naja expects response to be JSON
	        request.headers.set('Accept', 'application/json');
	        if (!this.dispatchEvent(new CustomEvent('before', { cancelable: true, detail: { request, method, url: url.toString(), data, options } }))) {
	            return {};
	        }
	        const promise = window.fetch(request);
	        this.dispatchEvent(new CustomEvent('start', { detail: { request, promise, abortController, options } }));
	        let response, payload;
	        try {
	            response = await promise;
	            if (!response.ok) {
	                throw new HttpError(response);
	            }
	            payload = await response.json();
	        }
	        catch (error) {
	            if (error.name === 'AbortError') {
	                this.dispatchEvent(new CustomEvent('abort', { detail: { request, error, options } }));
	                this.dispatchEvent(new CustomEvent('complete', { detail: { request, response, payload: undefined, error, options } }));
	                return {};
	            }
	            this.dispatchEvent(new CustomEvent('error', { detail: { request, response, error, options } }));
	            this.dispatchEvent(new CustomEvent('complete', { detail: { request, response, payload: undefined, error, options } }));
	            throw error;
	        }
	        this.dispatchEvent(new CustomEvent('success', { detail: { request, response, payload, options } }));
	        this.dispatchEvent(new CustomEvent('complete', { detail: { request, response, payload, error: undefined, options } }));
	        return payload;
	    }
	    appendToQueryString(searchParams, key, value) {
	        if (value === null || value === undefined) {
	            return;
	        }
	        if (Array.isArray(value) || Object.getPrototypeOf(value) === Object.prototype) {
	            for (const [subkey, subvalue] of Object.entries(value)) {
	                this.appendToQueryString(searchParams, `${key}[${subkey}]`, subvalue);
	            }
	        }
	        else {
	            searchParams.append(key, String(value));
	        }
	    }
	    transformData(url, method, data) {
	        const isGet = ['GET', 'HEAD'].includes(method.toUpperCase());
	        // sending a form via GET -> serialize FormData into URL and return empty request body
	        if (isGet && data instanceof FormData) {
	            for (const [key, value] of data) {
	                if (value !== null && value !== undefined) {
	                    url.searchParams.append(key, String(value));
	                }
	            }
	            return null;
	        }
	        // sending a POJO -> serialize it recursively into URLSearchParams
	        const isDataPojo = data !== null && Object.getPrototypeOf(data) === Object.prototype;
	        if (isDataPojo || Array.isArray(data)) {
	            // for GET requests, append values to URL and return empty request body
	            // otherwise build `new URLSearchParams()` to act as the request body
	            const transformedData = isGet ? url.searchParams : new URLSearchParams();
	            for (const [key, value] of Object.entries(data)) {
	                this.appendToQueryString(transformedData, key, value);
	            }
	            return isGet
	                ? null
	                : transformedData;
	        }
	        return data;
	    }
	}
	class HttpError extends Error {
	    constructor(response) {
	        const message = `HTTP ${response.status}: ${response.statusText}`;
	        super(message);
	        this.name = this.constructor.name;
	        this.stack = new Error(message).stack;
	        this.response = response;
	    }
	}

	class AbortExtension {
	    constructor() {
	        this.abortable = true;
	        this.abortController = null;
	    }
	    initialize(naja) {
	        naja.uiHandler.addEventListener('interaction', this.checkAbortable.bind(this));
	        naja.addEventListener('init', this.onInitialize.bind(this));
	        naja.addEventListener('before', this.checkAbortable.bind(this));
	        naja.addEventListener('start', this.saveAbortController.bind(this));
	        naja.addEventListener('complete', this.clearAbortController.bind(this));
	    }
	    onInitialize() {
	        document.addEventListener('keydown', (event) => {
	            if (this.abortController !== null
	                && event.key === 'Escape'
	                && !(event.ctrlKey || event.shiftKey || event.altKey || event.metaKey)
	                && this.abortable) {
	                this.abortController.abort();
	                this.abortController = null;
	            }
	        });
	    }
	    checkAbortable(event) {
	        var _a, _b;
	        const { options } = event.detail;
	        this.abortable = 'element' in event.detail
	            ? ((_a = event.detail.element.getAttribute('data-naja-abort')) !== null && _a !== void 0 ? _a : (_b = event.detail.element.form) === null || _b === void 0 ? void 0 : _b.getAttribute('data-naja-abort')) !== 'off' // eslint-disable-line no-extra-parens
	            : options.abort !== false;
	        // propagate to options if called in interaction event
	        options.abort = this.abortable;
	    }
	    saveAbortController(event) {
	        const { abortController } = event.detail;
	        this.abortController = abortController;
	    }
	    clearAbortController() {
	        this.abortController = null;
	        this.abortable = true;
	    }
	}

	class UniqueExtension {
	    constructor() {
	        this.abortControllers = new Map();
	    }
	    initialize(naja) {
	        naja.uiHandler.addEventListener('interaction', this.checkUniqueness.bind(this));
	        naja.addEventListener('start', this.abortPreviousRequest.bind(this));
	        naja.addEventListener('complete', this.clearRequest.bind(this));
	    }
	    checkUniqueness(event) {
	        var _a, _b;
	        const { element, options } = event.detail;
	        const unique = (_a = element.getAttribute('data-naja-unique')) !== null && _a !== void 0 ? _a : (_b = element.form) === null || _b === void 0 ? void 0 : _b.getAttribute('data-naja-unique');
	        options.unique = unique === 'off' ? false : unique !== null && unique !== void 0 ? unique : 'default';
	    }
	    abortPreviousRequest(event) {
	        var _a, _b, _c;
	        const { abortController, options } = event.detail;
	        if (options.unique !== false) {
	            (_b = this.abortControllers.get((_a = options.unique) !== null && _a !== void 0 ? _a : 'default')) === null || _b === void 0 ? void 0 : _b.abort();
	            this.abortControllers.set((_c = options.unique) !== null && _c !== void 0 ? _c : 'default', abortController);
	        }
	    }
	    clearRequest(event) {
	        var _a;
	        const { request, options } = event.detail;
	        if (!request.signal.aborted && options.unique !== false) {
	            this.abortControllers.delete((_a = options.unique) !== null && _a !== void 0 ? _a : 'default');
	        }
	    }
	}

	const naja = new Naja();
	naja.registerExtension(new AbortExtension());
	naja.registerExtension(new UniqueExtension());
	naja.Naja = Naja;
	naja.HttpError = HttpError;

	return naja;

}));
//# sourceMappingURL=Naja.js.map
