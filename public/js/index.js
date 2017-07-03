/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports) {

(function ($, W, D) {

	_sudoku = {
		/**
   *
   */
		setup: function setup() {
			_sudoku.init_tooltip();
			_sudoku.init_form_validation();
		},
		/**
   *
   */
		init_tooltip: function init_tooltip() {
			$('[data-toggle="tooltip"]').tooltip();
		},
		/**
   *
   */
		init_form_validation: function init_form_validation() {
			_sudoku.validate_grid.bind_button();
		}
	};

	_sudoku.validate_grid = {
		/**
   *
   */
		bind_button: function bind_button() {
			$('#js-sudoku-submit-sudoku-check-solution').click(function () {
				_sudoku.validate_grid.validate_grid();
			});
		},
		/**
   *
   */
		validate_grid: function validate_grid() {

			var isSolved = true;

			$('#js-sudoku_grid').find('input[type="text"][name^="sudoku_column"]').each(function () {

				console.log($(this).attr('name') + ' ' + $(this).val());
				console.log($(this).attr('name') + ' ' + $(this).data('solution'));

				if (Number($(this).val()) !== Number($(this).data('solution'))) {
					isSolved = false;
					return;
				}
			});

			if (isSolved) {
				_sudoku.validate_grid.display_success_message();
			} else {
				_sudoku.validate_grid.display_error_message();
			}
		},
		/**
   *
   */
		display_success_message: function display_success_message() {

			var success_message = $("#js-react-sudoku-success_message");

			success_message.show();

			window.setTimeout(function () {
				success_message.hide();
			}, 8000);
		},
		/**
   *
   */
		display_error_message: function display_error_message() {

			var error_message = $("#js-react-sudoku-error_message");

			error_message.show();

			window.setTimeout(function () {
				error_message.hide();
			}, 8000);
		}
	};

	/**
  * Execute when document ready
  */
	$(D).bind('APP_READY', function () {
		_sudoku.setup();
	});
})(jQuery, window, document);

/***/ }),

/***/ 7:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(1);


/***/ })

/******/ });