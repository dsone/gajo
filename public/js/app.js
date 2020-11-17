/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_Notify__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/Notify */ "./resources/js/components/Notify.js");

window.notify = _components_Notify__WEBPACK_IMPORTED_MODULE_0__["default"]; // Alias functions for better readability and simpler selection

window.$ = function (sel, context) {
  try {
    return !context ? document.querySelector(sel) : context.querySelector(sel);
  } catch (e) {
    return undefined;
  }
};

window.$$ = function (sel, context) {
  try {
    return !context ? document.querySelectorAll(sel) : context.querySelectorAll(sel);
  } catch (e) {
    return undefined;
  }
};

/***/ }),

/***/ "./resources/js/components/Notify.js":
/*!*******************************************!*\
  !*** ./resources/js/components/Notify.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

function ownKeys(object, enumerableOnly) {
  var keys = Object.keys(object);

  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);
    if (enumerableOnly) symbols = symbols.filter(function (sym) {
      return Object.getOwnPropertyDescriptor(object, sym).enumerable;
    });
    keys.push.apply(keys, symbols);
  }

  return keys;
}

function _objectSpread(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};

    if (i % 2) {
      ownKeys(Object(source), true).forEach(function (key) {
        _defineProperty(target, key, source[key]);
      });
    } else if (Object.getOwnPropertyDescriptors) {
      Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
    } else {
      ownKeys(Object(source)).forEach(function (key) {
        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
      });
    }
  }

  return target;
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}
/**
 * Helper class to keep track on the last displayed notification.
 * Preventing duplicates being displayed for a certain amount of time.
 * Unless another notification was displayed in the meantime.
 * Implemented with a Singleton pattern since Notify is not instantiated.
 */


var NotificationStatus = function () {
  var instance;

  function createInstance() {
    var NotificationStatus = function NotificationStatus() {
      this.lastNotify = '';
      this.threshold = undefined;
    };

    NotificationStatus.prototype.last = function (msg) {
      this.timer(msg);
      var oldValue = this.lastNotify;
      return this.lastNotify = msg, oldValue === msg;
    }; // Resets timer if necessary, or starts it


    NotificationStatus.prototype.timer = function (msg) {
      var _this = this;

      if (!this.threshold) {
        this.threshold = setTimeout(function () {
          _this.lastNotify = '';
          _this.threshold = undefined;
        }, 3000);
      } else if (msg != this.lastNotify) {
        this.threshold = clearTimeout(this.threshold);
        this.timer();
      }
    };

    return new NotificationStatus();
  }

  return {
    getInstance: function getInstance() {
      if (!instance) {
        instance = createInstance();
      }

      return instance;
    }
  };
}();

function Notify() {
  var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'title';
  var text = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'text';
  var cfg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  var status = NotificationStatus.getInstance();

  if (status.last(text)) {
    return;
  }

  var config = _objectSpread(_objectSpread({}, {
    // Title of the notification
    title: title,
    // Message content
    text: text,
    // Type of notifcation, info, warning, danger, success
    type: 'info',
    // the container holding all notification items
    notificationsContainer: document.querySelector('.notifications'),
    // Auto removing notification after this, in ms
    autoRemoveDuration: 3000,
    // fadein/-out animation time
    animationDuration: 800,
    // the template for notifications to use
    templateHTML: document.querySelector('#notification-item').innerHTML,
    // class for opening animation
    openingAnimationClass: 'fadeInDown',
    // class for closing animation
    closingAnimationClass: 'fadeOutRight',
    // close btn hover:color for info and warning
    warningInfoCloseColor: 'text-gray-500',
    // close bnt hover:color for danger and success
    dangerSuccessCloseColor: 'text-gray-200'
  }), cfg);

  var timerClose = undefined;
  var timerFadeIn = undefined;

  var _div = document.createElement('div');

  var tmpl = config.templateHTML.slice(0);
  _div.innerHTML = tmpl;
  _div = _div.firstElementChild;

  _div.classList.add('is-' + config.type, config.openingAnimationClass);

  _div.addEventListener('click', function (e) {
    if (timerClose !== undefined) {
      timerClose = clearTimeout(timerClose);
    }

    if (timerFadeIn !== undefined) {
      timerFadeIn = clearTimeout(timerFadeIn);
    }

    _div.classList.add(config.closingAnimationClass);

    setTimeout(function () {
      _div.remove();
    }, config.animationDuration + 50);
  });

  _div.addEventListener('mouseover', function (e) {
    if (timerClose !== undefined) {
      timerClose = clearTimeout(timerClose);
    }
  });

  _div.addEventListener('mouseleave', function (e) {
    timerClose = setTimeout(function () {
      _div.click();
    }, config.autoRemoveDuration);
  });

  var closeBtn = _toConsumableArray(_div.querySelectorAll('[n-close]'));

  closeBtn.forEach(function (btn) {
    btn.innerHTML = 'x';
    btn.classList.add(config.type === 'warning' || config.type === 'info' ? "group-hover:".concat(config.warningInfoCloseColor) : "group-hover:".concat(config.dangerSuccessCloseColor));
    btn.addEventListener('click', function (e) {
      _div.click();
    });
  });
  ['title', 'text'].forEach(function (key) {
    var el = _div.querySelector("[n-".concat(key, "]"));

    el && (el.innerHTML = config[key]);
  });

  var icon = _div.querySelector("[n-type-".concat(config.type, "]"));

  icon && icon.classList.remove('hidden');
  !!config.notificationsContainer && config.notificationsContainer.prepend(_div);
  timerFadeIn = setTimeout(function () {
    _div.classList.remove(config.openingAnimationClass);
  }, config.animationDuration + 50); // start timer to close automatically after 5s

  _div.dispatchEvent(new Event('mouseleave'));
} // Creating shorthands in a hacky way


var wrappedNotify = function () {
  Notify.danger = function () {
    var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'title';
    var text = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'text';
    var cfg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    return Notify(title, text, _objectSpread({
      type: 'danger'
    }, cfg));
  };

  Notify.info = function () {
    var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'title';
    var text = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'text';
    var cfg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    return Notify(title, text, _objectSpread({
      type: 'info'
    }, cfg));
  };

  Notify.success = function () {
    var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'title';
    var text = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'text';
    var cfg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    return Notify(title, text, _objectSpread({
      type: 'success'
    }, cfg));
  };

  Notify.warning = function () {
    var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'title';
    var text = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'text';
    var cfg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    return Notify(title, text, _objectSpread({
      type: 'warning'
    }, cfg));
  };

  return Notify;
}();

/* harmony default export */ __webpack_exports__["default"] = (wrappedNotify);

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/ds/projects/Gajo2/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/ds/projects/Gajo2/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });