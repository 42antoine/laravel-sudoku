(function ($, W, D) {

	_sudoku = {
		/**
		 *
		 */
		setup: function () {
			_sudoku.init_tooltip();
			_sudoku.init_form_validation();
		},
		/**
		 *
		 */
		init_tooltip: function () {
			$('[data-toggle="tooltip"]').tooltip();
		},
		/**
		 *
		 */
		init_form_validation: function () {
			_sudoku.validate_grid.bind_button();
		}
	};

	_sudoku.validate_grid = {
		/**
		 *
		 */
		bind_button: function () {
			$('#js-sudoku-submit-sudoku-check-solution')
				.click(function () {
					_sudoku.validate_grid.validate_grid();
				});
		},
		/**
		 *
		 */
		validate_grid: function () {

			var isSolved = true;

			$('#js-sudoku_grid')
				.find('input[type="text"][name^="sudoky_column"]')
				.each(function () {
					if ($(this).val() !== $(this).data()) {
						_sudoku.validate_grid.display_error_message();
						isSolved = false;
						return;
					}
				});

			if (isSolved) {
				_sudoku.validate_grid.display_success_message();
			}
		},
		/**
		 *
		 */
		display_success_message: function () {

			var success_message = $("#js-react-sudoku-success_message");

			success_message.show();

			window
				.setTimeout(
					function () {
						success_message
							.fadeTo(200, 0)
							.slideUp(500, function () {
								$(this).hide();
							});
					},
					8000
				);
		},
		/**
		 *
		 */
		display_error_message: function () {

			var error_message = $("#js-react-sudoku-error_message");

			error_message.show();

			window
				.setTimeout(
					function () {
						error_message
							.fadeTo(200, 0)
							.slideUp(500, function () {
								$(this).hide();
							});
					},
					8000
				);
		}
	};

	/**
	 * Execute when document ready
	 */
	$(D).bind('APP_READY', function () {
		_sudoku.setup();
	});

})(jQuery, window, document);
