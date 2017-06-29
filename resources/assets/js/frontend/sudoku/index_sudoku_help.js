try {
	let React = require('react');
} catch (e) {}

/**
 *
 */
let helpButton = React.createClass({

	/**
	 *
	 * @returns {{counter: number}}
	 */
	getInitialState: function () {
		return {
			counter: 0
		};
	},

	/**
	 *
	 */
	helpToResolve: function () {

		if (0 < this.state.counter) {

			// Give help

			this.setState({
				counter: this.state.counter--
			});
		}

		this.setState({ counter: 0 });
	},

	/**
	 *
	 * @returns {XML}
	 */
	render: function () {
		return (
			<a class="btn btn-link" onClick="{this.helpToResolve}">
				<i class="fa fa-life-ring" aria-hidden="true"></i> Help me, give
				me one number <span>( {this.state.counter} )</span>
			</a>
		);
	}

});

React.render('<helpButton />', document.getElementById('js-react-sudoku-help'));
