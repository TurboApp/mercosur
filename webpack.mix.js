let mix = require('laravel-mix');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */



 mix.scripts([
	'resources/assets/js/vendor/material.min.js',
	'resources/assets/js/vendor/perfect-scrollbar.jquery.min.js',
	'node_modules/moment/moment.js',
    'resources/assets/js/vendor/typeahead.js',
	'resources/assets/js/vendor/bootstrap-datetimepicker.js',
	'resources/assets/js/vendor/bootstrap-notify.js',
	'node_modules/datatables.net/js/jquery.dataTables.js',
		
	'resources/assets/js/vendor/dataTables.responsive.min.js',
	'resources/assets/js/vendor/responsive.bootstrap.min.js',

	'resources/assets/js/vendor/sweetalert2.js',
	'resources/assets/js/vendor/select2.js',
	'resources/assets/js/vendor/chartist.min.js',
 	'resources/assets/js/vendor/fullcalendar.min.js',
 	'resources/assets/js/vendor/jasny-bootstrap.min.js',
 	'resources/assets/js/vendor/jquery.bootstrap-wizard.js',
 	'resources/assets/js/vendor/jquery.filer.js',
 	'resources/assets/js/vendor/jquery.sharrre.js',
	'resources/assets/js/vendor/jquery.tagsinput.js',
 	'resources/assets/js/vendor/jquery.validate.js',
 	'resources/assets/js/vendor/nouislider.min.js',
 	'resources/assets/js/vendor/material-dashboard.js',
 	'resources/assets/js/vendor/mercosur.js'
 ], 'public/js/scripts.js');

  mix.js('resources/assets/js/app.js', 'public/js');
   
mix.sass('resources/assets/sass/common.scss', 'public/css');
mix.sass('resources/assets/sass/dashboard.scss', 'public/css');
mix.sass('resources/assets/sass/mercosur.scss', 'public/css');

