<?php
/**
 * Generación dinámica del esquema JSON-LD LocalBusiness desde el Personalizador.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_output_jsonld() {
	if ( ! is_front_page() ) {
		return;
	}

	$nombre      = get_bloginfo( 'name' );
	$descripcion = get_theme_mod(
		'ambateno_hero_descripcion',
		'Chocolate artesanal de Ambato, Ecuador: barra tradicional de 200 g, sin azúcar y libre de gluten. Preparación, historia y puntos de venta.'
	);
	$direccion   = get_theme_mod( 'ambateno_contacto_direccion', 'Av. Cevallos 08-45 y Montalvo, Ambato, Tungurahua' );
	$telefono    = get_theme_mod( 'ambateno_contacto_telefono', '+593 3 000 0000' );
	$correo      = get_theme_mod( 'ambateno_contacto_correo', 'hola@elambateno.ec' );
	$horario     = get_theme_mod( 'ambateno_contacto_horario', 'Lunes a sábado, 09:00 a 19:00' );

	$schema = array(
		'@context'     => 'https://schema.org',
		'@type'        => 'LocalBusiness',
		'name'         => $nombre ?: 'El Ambateño',
		'description'  => $descripcion,
		'url'          => home_url( '/' ),
		'telephone'    => $telefono,
		'email'        => $correo,
		'address'      => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $direccion,
			'addressLocality' => 'Ambato',
			'addressRegion'   => 'Tungurahua',
			'addressCountry'  => 'EC',
		),
		'openingHours' => $horario,
	);

	echo "\n<!-- Schema.org LocalBusiness -->\n";
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . "</script>\n";
}
add_action( 'wp_head', 'ambateno_output_jsonld' );
