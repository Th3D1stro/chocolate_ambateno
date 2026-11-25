<?php
/**
 * Archivo principal functions.php del tema Chocolate El Ambateño.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Constantes del tema
define( 'AMBATENO_VERSION', '1.1.0' );
define( 'AMBATENO_CATALOG_VERSION', '2.0.0' );
define( 'AMBATENO_DIR', get_template_directory() );
define( 'AMBATENO_URI', get_template_directory_uri() );

// Carga de módulos de inc/
require_once AMBATENO_DIR . '/inc/icons.php';
require_once AMBATENO_DIR . '/inc/setup.php';
require_once AMBATENO_DIR . '/inc/enqueue.php';
require_once AMBATENO_DIR . '/inc/customizer.php';
require_once AMBATENO_DIR . '/inc/cpt-productos.php';
require_once AMBATENO_DIR . '/inc/cpt-establecimientos.php';
require_once AMBATENO_DIR . '/inc/seo-jsonld.php';
require_once AMBATENO_DIR . '/inc/demo-importer.php';
