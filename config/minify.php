<?php

return [
	//config
	'combine' => false,

	// css files
	'css' => [
		'min_path' => 'css/main.min.css',
		'files' => [
			'vendors/jquery-ui/jquery-ui.min.css',
			'vendors/fontawesome/css/all.min.css',
			'vendors/bootstrap/css/bootstrap.min.css',
			'vendors/owlcarousel/assets/owl.carousel.min.css',
			'vendors/owlcarousel/assets/owl.theme.default.min.css',
			'vendors/smartmenus/css/sm-core-css.css',
			'vendors/smartmenus/css/sm-simple/sm-simple.css',
			'vendors/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css',
			'stylesheets/app.css',
		],
	],

	//js file
	'js' => [
		'min_path' => 'js/main.min.js',
		'files' => [
			'vendors/jquery-2.2.4.min.js',
			'vendors/jquery-ui/jquery-ui.min.js',
			'vendors/popper.min.js',
			'vendors/jquery.easing.min.js',
			'vendors/bootstrap/js/bootstrap.min.js',
			'vendors/owlcarousel/owl.carousel.min.js',
			'vendors/smartmenus/jquery.smartmenus.min.js',
			'vendors/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.js',
			'js/lozad.min.js',
			'js/custom.js',
		],
	],
];