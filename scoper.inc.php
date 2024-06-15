<?php
/**
 * PHP-Scoper configuration file.
 *
 * @link      https://github.com/googleforcreators/web-stories-wp
 *
 * @copyright 2020 Google LLC
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 */

declare(strict_types = 1);

use Isolated\Symfony\Component\Finder\Finder;

/**
 * Get the excluded symbols.
 * @param string $proj Use 'wordpress', 'wp-cli', or 'woocommerce'.
 * @param string $type Use 'classes', 'functions', or 'constants'.
 */
function excluded_symbols_for(string $proj, string $type): array
{
	$ext = '.php';
	if( $proj === 'wordpress' ) {
		$ext = '.json';
	}
	$dir = __DIR__.'/php-scoper/excludes/'. $proj .'/';
	$patterns = [];
	
	if( $type === 'functions' ) {
		$patters[] = $dir.'*-functions' . $ext;
	}else if( $type === 'classes' ) {
		$patterns[] = $dir.'*-classes' . $ext;
		$patterns[] = $dir.'*-interfaces' . $ext;
		$patterns[] = $dir.'*-traits' . $ext;
	}elseif( $type === 'constants' ) {
		$patterns[] = $dir.'*-constants' . $ext;
	}

	$excluded = array();
	foreach( $patterns as $pattern ) {
		$files = glob($pattern);
		foreach( $files as $file ) {
			if($ext === '.json') {
				$arr = json_decode(file_get_contents($file),true);
				$excluded = array_merge($excluded, $arr);
			}else{
				$arr = include $file;
				$excluded = array_merge($excluded, $arr);
			}
		}
	}
	return $excluded;
}

function excluded_symbols(string $type): array
{
	$projs = ['wordpress', 'wp-cli', 'woocommerce'];
	$excluded = [];
	foreach( $projs as $proj ) {
		$excluded = array_merge($excluded, excluded_symbols_for($proj, $type));
	}
	return $excluded;
}

return [
	'prefix'            => 'WP_Scoper_Demo',

	// See: https://github.com/humbug/php-scoper#finders-and-paths.
	'finders'           => [
		// Main AMP PHP Library.
		// Finder::create()
		// 	->files()
		// 	->ignoreVCS( true )
		// 	->ignoreDotFiles( true )
		// 	->name( '*.php' )
		// 	->name( 'class-amp-base-sanitizer.php' )
		// 	->notName(
		// 		[
		// 			// 'amp.php',
		// 			// 'amp-enabled-classic-editor-toggle.php',
		// 			// 'amp-frontend-actions.php',
		// 			// 'amp-helper-functions.php',
		// 			// 'amp-paired-browsing.php',
		// 			// 'amp-post-template-functions.php',
		// 			// 'class-amp-autoloader.php',
		// 			// 'class-amp-comment-walker.php',
		// 			// 'class-amp-content.php',
		// 			// 'class-amp-html-utils.php',
		// 			// 'class-amp-http.php',
		// 			// 'class-amp-post-template.php',
		// 			// 'class-amp-post-type-support.php',
		// 			// 'class-amp-service-worker.php',
		// 			// 'class-amp-theme-support.php',
		// 			// 'class-amp-validated-url-post-type.php',
		// 			// 'class-amp-validation-callback-wrapper.php',
		// 			// 'deprecated.php',
		// 			// 'reader-template-loader.php',
		// 		]
		// 	)
		// 	->exclude(
		// 		[
		// 			'bin',
		// 			'vendor',
		// 			'tests',
		// 		]
        //     ),

		// // Symfony mbstring polyfill.
		// Finder::create()
		// 	->files()
		// 	->ignoreVCS( true )
		// 	->ignoreDotFiles( true )
		// 	->name( '/\.*.php8?/' )
		// 	->in( 'vendor/symfony/polyfill-mbstring/Resources' )
		// 	->append(
		// 		[
		// 			'vendor/symfony/polyfill-mbstring/Mbstring.php',
		// 			'vendor/symfony/polyfill-mbstring/composer.json',
		// 		]
		// 	),

		// // Main composer.json file so that we can build a classmap.
		// Finder::create()
		// 	->append( [ 'composer.json' ] ),
	],

	// See: https://github.com/humbug/php-scoper#patchers.
	'patchers'          => [],

	// See https://github.com/humbug/php-scoper#whitelist.
	'whitelist'         => [],

	'exclude-classes'   => excluded_symbols('classes'),

	'exclude-functions' => array_merge(
		excluded_symbols('functions'),
		[
			'version_compare',
			'defined',
			'define',
			'sprintf',
			'printf',
			'implode',
			'explode',
			'json_encode',
			'json_decode',
			'array_merge',
			'array_merge_recursive',
			'array_keys',
			'array_values',
			'ob_start',
			'ob_get_clean',
			'is_string',
			'is_array',
			'is_object',
			'is_numeric',
			'is_bool',
			'is_null',
			'is_int',
			'is_float',
			'preg_match',
			'time',
        ]
	),

	'exclude-constants' => array_merge(
		excluded_symbols('constants'),
		[]
	),
];