/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * Next we will register the CSRF Token as a common header with jQuery AJAX
 * so that all outgoing HTTP requests automatically have it attached. This is
 * just a simple convenience so we don't have to attach every token manually.
 */

let environment = $('meta[name="environment"]').attr('content');
let token = $('meta[name="csrf-token"]').attr('content');

if (token) {
	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token } });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
