<?php
/**
 * Configuración inicial, soportes del tema y navegación con fallback.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_setup() {
	load_theme_textdomain( 'chocolate-el-ambateno', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 48,
			'width'       => 200,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Ubicación de menú registrada
	register_nav_menus(
		array(
			'menu-principal' => __( 'Menú Principal (Navbar)', 'chocolate-el-ambateno' ),
			'menu-footer'    => __( 'Menú del Pie de Página', 'chocolate-el-ambateno' ),
		)
	);
}
add_action( 'after_setup_theme', 'ambateno_setup' );

/**
 * Menú de respaldo por defecto con las anclas de la portada.
 */
function ambateno_fallback_menu_principal() {
	$is_landing = is_front_page();
	$home_url   = home_url( '/' );

	$secciones = array(
		'inicio'      => __( 'Inicio', 'chocolate-el-ambateno' ),
		'chocolate'   => __( 'Nuestro chocolate', 'chocolate-el-ambateno' ),
		'preparacion' => __( 'Preparación', 'chocolate-el-ambateno' ),
		'historia'    => __( 'Nuestra historia', 'chocolate-el-ambateno' ),
		// 'donde'    => __( 'Dónde encontrarlo', 'chocolate-el-ambateno' ), // Oculto de la interfaz visual
		'contacto'    => __( 'Contacto', 'chocolate-el-ambateno' ),
	);

	echo '<ul class="flex items-center gap-1">';
	foreach ( $secciones as $id => $label ) {
		$href = $is_landing ? "#{$id}" : "{$home_url}#{$id}";
		printf(
			'<li><a href="%s" data-seccion-id="%s" class="nav-link inline-flex min-h-11 items-center rounded-md px-3 py-2 text-[0.95rem] font-medium text-crema transition-colors hover:bg-burdeos-claro">%s</a></li>',
			esc_url( $href ),
			esc_attr( $id ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Filtro para agregar clases a los enlaces de menú personalizados si el usuario asigna un menú en WP.
 */
function ambateno_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'menu-principal' === $args->theme_location ) {
		$class = 'nav-link inline-flex min-h-11 items-center rounded-md px-3 py-2 text-[0.95rem] font-medium text-crema transition-colors hover:bg-burdeos-claro';
		$atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' ' . $class : $class;
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'ambateno_nav_menu_link_attributes', 10, 3 );

/**
 * Obtiene la URL canónica de una página por su slug de forma resiliente.
 * Soporta enlaces permanentes amigables (/tienda/) y estructura simple (?page_id=X).
 *
 * @param string $slug Slug de la página (ej: 'tienda', 'terminos', 'privacidad').
 * @return string URL completa y sanitizada.
 */
function ambateno_get_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . trim( $slug, '/' ) . '/' );
}
