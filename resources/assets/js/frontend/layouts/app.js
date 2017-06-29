
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*
 * Sudoku App
 */
(function ($, W, D) {

	/**
	 * Execute when document ready
	 */
	$(D).ready(function () {
		$(D).trigger('APP_READY');
	});

})(jQuery, window, document);
