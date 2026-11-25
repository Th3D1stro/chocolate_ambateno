<?php
/**
 * Encolado de estilos y scripts.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$theme_uri     = get_template_directory_uri();

	// Google Fonts: Fraunces + Work Sans
	wp_enqueue_style(
		'ambateno-google-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// CSS principal (compilado por Tailwind CLI o fallback inicial)
	if ( file_exists( get_template_directory() . '/assets/css/main.css' ) ) {
		wp_enqueue_style(
			'ambateno-main',
			$theme_uri . '/assets/css/main.css',
			array(),
			$theme_version
		);
	}

	// style.css del tema (encabezado e info)
	wp_enqueue_style(
		'ambateno-style',
		get_stylesheet_uri(),
		array(),
		$theme_version
	);

	// Scripts Vanilla JS
	// 1. Script común (menú móvil, navbar sticky, modal mapa del sitio)
	wp_enqueue_script(
		'ambateno-main-js',
		$theme_uri . '/assets/js/main.js',
		array(),
		$theme_version,
		true
	);

	// 2. Script para la portada (scroll-spy y reveal)
	if ( is_front_page() ) {
		wp_enqueue_script(
			'ambateno-landing-js',
			$theme_uri . '/assets/js/landing.js',
			array(),
			$theme_version,
			true
		);
	}

	// 3. Script para el carrito y tienda (siempre disponible para badge del navbar)
	wp_enqueue_script(
		'ambateno-cart-js',
		$theme_uri . '/assets/js/cart.js',
		array(),
		$theme_version,
		true
	);

	// 4. Script interactivo de la tienda (catálogo, filtros, búsqueda, stepper, checkout SPA)
	if ( is_page_template( 'page-tienda.php' ) || is_page( 'tienda' ) || ( is_page() && 'tienda' === get_post_field( 'post_name', get_queried_object_id() ) ) ) {
		wp_enqueue_script(
			'ambateno-tienda-js',
			$theme_uri . '/assets/js/tienda.js',
			array( 'ambateno-cart-js' ),
			$theme_version,
			true
		);

		// Localizar productos y configuración hacia JavaScript
		$productos_data = ambateno_get_all_products_data();
		wp_localize_script(
			'ambateno-tienda-js',
			'AmbatenoTiendaData',
			array(
				'homeUrl'    => home_url( '/' ),
				'tiendaUrl'  => get_permalink(),
				'themeImgUrl'=> $theme_uri . '/assets/img/',
				'productos'  => $productos_data,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ambateno_enqueue_scripts' );

/**
 * Agrega atributos preconnect para fuentes de Google en wp_head.
 */
function ambateno_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ambateno_resource_hints', 10, 2 );
