
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
	
	window.$ = window.jQuery = require('jquery');
	
	require('./vendor/jquery-ui.min.js');
	
	
    require('bootstrap-sass');
	require ('bootstrap-select');
	//require('moment');
	

    // require('./vendor/material.min.js');

    // require('./vendor/perfect-scrollbar.jquery.min.js');
		
    // require('./vendor/bootstrap-datetimepicker.js');
    // require('./vendor/bootstrap-notify.js');
	// require('datatables.net');
	
	// //require('./vendor/sweetalert2.js');
	
	// require('./vendor/fullcalendar.min.js');
	// require('./vendor/chartist.min.js');
	// require('./vendor/jasny-bootstrap.min.js');
	// require('./vendor/jquery.bootstrap-wizard.js');
	// require('./vendor/jquery.select-bootstrap.js');
	// require('./vendor/jquery.sharrre.js');
	// require('./vendor/jquery.tagsinput.js');
	// require('./vendor/jquery.validate.js');
	// require('./vendor/nouislider.min.js');

	
	// require('./vendor/material-dashboard.js');
	// require('./vendor/mercosur.js');
	
	
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.Push = require('push.js');

window.axios  = require('axios');


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};


window.axios.interceptors.response.use(response => {
    // Everything fine, just pass it for further processing.
    return response;
}, error => {
    // If it is an HTTP error
    if(error.response) {
        if(error.response.status == 500 || error.response.status == 420) { // Session expired.
			//alert('LO SENTIMOS PERO OCURRIO UN ERROR INESPERADO.');2
			//window.location.reload(true);
			
            // // Set the new token as default HTTP header.
			//axios.defaults.headers.common['X-CSRF-TOKEN'] = error.response.data.newToken;
			// window.axios.defaults.headers.common = {
			// 	'X-CSRF-TOKEN': window.Laravel.csrfToken,
			// 	'X-Requested-With': 'XMLHttpRequest'
			// };
			

            // // If the user was signed in, we need to prompt for password.
            // if(app.signedIn) {
            //     return new Promise((resolve, reject) => {

            //         // Request the password from user.
            //         app.requestPassword()
            //            .then(() => {
            //                // If the user succeeds with authentication
            //                // Repeat the same request with the new token and return the response to the original requesting function.

            //                let request = error.response.config;
            //                request.headers['X-CSRF-TOKEN'] = error.response.data.newToken;

            //                axios.request(request).then(response => {
            //                    resolve(response)
            //                }, error => {
            //                    reject(error)
            //                })
            //             })
            //     });
            // }
        } else {
            // Handle other errors
        }
    }

    return Promise.reject(error);
});




// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//    // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'http://127.0.0.1:6001'
    // host: 'http://192.168.8.107:6001'
});

