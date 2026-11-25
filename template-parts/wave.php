<?php
/**
 * Onda divisoria curva en SVG para transiciones entre secciones.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$class = isset( $args['class'] ) ? $args['class'] : '';
?>
<svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="pointer-events-none absolute inset-x-0 bottom-0 block h-10 w-full sm:h-16 <?php echo esc_attr( $class ); ?>" aria-hidden="true">
	<path d="M0,42 C240,82 480,4 720,32 C960,60 1200,12 1440,40 L1440,80 L0,80 Z" fill="currentColor"/>
</svg>
