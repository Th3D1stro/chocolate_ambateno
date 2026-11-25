
<?php
/**
 * Logotipo de la marca El Ambateño (Identidad del sitio con fallback a PNG).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tono  = isset( $args['tono'] ) ? $args['tono'] : 'claro';
$color = ( 'claro' === $tono ) ? 'text-crema' : 'text-burdeos';

$logo_class = isset( $args['clase'] ) ? $args['clase'] : 'h-10 w-auto';

if ( has_custom_logo() ) {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $custom_logo    = wp_get_attachment_image_src( $custom_logo_id, 'full' );

    if ( $custom_logo ) {
        printf(
            '<img src="%s" alt="%s" width="%s" height="%s" class="%s object-contain" />',
            esc_url( $custom_logo[0] ),
            esc_attr( get_bloginfo( 'name', 'display' ) ),
            esc_attr( $custom_logo[1] ),
            esc_attr( $custom_logo[2] ),
            esc_attr( $logo_class )
        );
        return;
    }
}
?>

<span class="inline-flex items-center gap-2.5 <?php echo esc_attr( $color ); ?>">
    <img
        src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>"
        alt=""
        class="<?php echo esc_attr( $logo_class ); ?> shrink-0 object-contain"
        aria-hidden="true"
    />
</span>
