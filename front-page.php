<?php
/**
 * Portada estática del sitio (Landing page de una sola página).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="contenido" tabindex="-1" class="outline-none">
	<?php get_template_part( 'template-parts/landing/hero' ); ?>
	<?php get_template_part( 'template-parts/landing/chocolate' ); ?>
	<?php get_template_part( 'template-parts/landing/preparacion' ); ?>
	<?php get_template_part( 'template-parts/landing/historia' ); ?>
	<?php // get_template_part( 'template-parts/landing/donde' ); // Oculto de la interfaz manteniendo datos intactos ?>
	<?php get_template_part( 'template-parts/landing/contacto' ); ?>
</main>

<?php
get_footer();
