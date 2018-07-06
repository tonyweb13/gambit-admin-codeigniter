var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.sass('app.scss');
});

elixir(function(mix) {
	mix.coffee([
			'app.coffee',
			'services/**/*.coffee',
			'directives/**/*.coffee',
			'controllers/**/*.coffee',
	]);
});

elixir(function(mix) {
	mix.coffee([
		'app.coffee',
		'services/**/*.coffee',
		'directives/**/*.coffee',
	], 'public/js/directives.js');
});

elixir(function(mix) {
	// Angular-momentjs
	mix.copy('node_modules/angular-momentjs/angular-momentjs.js', 'resources/assets/js/angular-momentjs.js');

	// Angular Route
	mix.copy('node_modules/angular-route/angular-route.js', 'resources/assets/js/angular-route.js');

	// Moment
	mix.copy('node_modules/moment/moment.js', 'resources/assets/js/moment.js');

	// Angularjs
	mix.copy('node_modules/angular/angular.js', 'resources/assets/js/angular.js');

	// Underscore
	mix.copy('node_modules/underscore/underscore.js', 'resources/assets/js/underscore.js');

	// Bootstrap js
	mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.js', 'resources/assets/js/bootstrap.js');

	// Jquery
	mix.copy('node_modules/jquery/dist/jquery.js', 'resources/assets/js/jquery.js');

	// Bootstrap Fonts
	mix.copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts');

	// Fontawesome
	mix.copy('node_modules/font-awesome/fonts', 'public/fonts');
});

elixir(function(mix) {
	mix.scripts([
		'jquery.js',
		'bootstrap.js',
	], 'public/vendor/theme.js');
});
elixir(function(mix) {
	mix.scripts([
		'underscore.js',
		'moment.js',
		'angular.js',
		'angular-momentjs.js',
		'angular-route.js',
	], 'public/vendor/vendor.js');
});

elixir(function(mix) {
	mix.version(['vendor', 'css', 'js']);
});

elixir(function(mix) {
	mix.browserSync({
		proxy: 'operator.local'
	});
});