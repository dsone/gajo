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
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Notify; });
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

function Notify(title, message, type, duration) {
  var status = NotificationStatus.getInstance();

  if (status.last(message)) {
    return;
  }

  duration = Math.max(900, duration || 3000); // <900 might be problematic due to the animations

  var timerClose = undefined; // notification container, holding all elements

  var tile = document.createElement('div');
  tile.classList.add('notification', 'notification-item', 'is-' + type, 'animated', 'fast', 'fadeInDown', 'group');
  tile.addEventListener('click', function (e) {
    if (timerClose !== undefined) {
      timerClose = clearTimeout(timerClose);
    }

    if (timerFadeIn !== undefined) {
      timerFadeIn = clearTimeout(timerFadeIn);
    }

    tile.classList.add('fadeOutRight');
    setTimeout(function () {
      tile.remove();
    }, 900);
  });
  tile.addEventListener('mouseover', function (e) {
    if (timerClose !== undefined) {
      timerClose = clearTimeout(timerClose);
    }
  });
  tile.addEventListener('mouseleave', function (e) {
    timerClose = setTimeout(function () {
      tile.click();
    }, duration);
  }); // The button to prematurely close the notification;

  var btn = document.createElement('button');
  btn.classList.add('n-remove', type === 'warning' || type === 'info' ? 'group-hover:text-gray-500' : 'group-hover:text-gray-200');
  btn.innerHTML = 'x';
  btn.addEventListener('click', function (e) {
    tile.click();
  });
  tile.appendChild(btn); // Title for the notification

  var header = document.createElement('h3');
  header.classList.add('n-title');
  header.innerText = title;
  tile.appendChild(header); // Text node, aka message

  var text = document.createElement('div');
  text.classList.add('n-text');
  text.innerHTML = message;
  tile.appendChild(text); // Add it to global notification container

  document.querySelector('.notifications').prepend(tile);
  var timerFadeIn = setTimeout(function () {
    tile.classList.remove('fadeInDown');
  }, 900); // animation runs for 800ms (due to .fast), but rendering might need a ms more to prevent "jumping" of element
  // start timer to close automatically after 5s by triggering mouseleave event

  tile.dispatchEvent(new Event('mouseleave'));
}

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