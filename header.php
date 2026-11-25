<?php
/**
 * Cabecera principal del tema Chocolate El Ambateño.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#7a1714">
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.svg' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-crema-claro text-tinta antialiased' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/skip-link' ); ?>
<?php get_template_part( 'template-parts/navbar' ); ?>
