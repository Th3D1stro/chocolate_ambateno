<?php
/**
 * Enlaces e iconos SVG de Redes Sociales.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tono   = isset( $args['tono'] ) ? $args['tono'] : 'claro';
$estilo = ( 'claro' === $tono )
	? 'border-crema/40 text-crema hover:bg-crema hover:text-burdeos'
	: 'border-burdeos/30 text-burdeos hover:bg-burdeos hover:text-crema';

$redes = array(
	'Instagram' => array(
		'url'   => get_theme_mod( 'ambateno_redes_instagram', 'https://www.instagram.com/chocolateelambateno' ),
		'icono' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/>',
	),
	'Facebook'  => array(
		'url'   => get_theme_mod( 'ambateno_redes_facebook', 'https://www.facebook.com/chocolateelambateno' ),
		'icono' => '<path d="M14 21v-7h3l.5-3.5H14V8.6c0-1 .3-1.6 1.7-1.6H18V4a20 20 0 0 0-2.7-.2C12.6 3.8 11 5.4 11 8.3v2.2H8V14h3v7"/>',
	),
	'TikTok'    => array(
		'url'   => get_theme_mod( 'ambateno_redes_tiktok', 'https://tiktok.com/' ),
		'icono' => '<path d="M14 3v11.5a3.5 3.5 0 1 1-3.5-3.5M14 3c.6 2.7 2.4 4.4 5 4.8"/>',
	),
	'WhatsApp'  => array(
		'url'   => get_theme_mod( 'ambateno_redes_whatsapp', 'https://wa.me/59330000000' ),
		'icono' => '<path d="M4 20l1.3-3.9A8.5 8.5 0 1 1 8.2 19z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.3-1.8-.9-.8.8c-1-.4-1.9-1.3-2.3-2.3l.8-.8-.9-1.8z"/>',
	),
);
?>
<ul class="flex flex-wrap gap-2" aria-label="<?php esc_attr_e( 'Redes sociales', 'chocolate-el-ambateno' ); ?>">
	<?php foreach ( $redes as $nombre => $red ) : ?>
		<li>
			<a href="<?php echo esc_url( $red['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( __( '%s de El Ambateño (se abre en una pestaña nueva)', 'chocolate-el-ambateno' ), $nombre ) ); ?>" class="inline-flex h-11 w-11 items-center justify-center rounded-md border-2 transition-colors <?php echo esc_attr( $estilo ); ?>">
				<svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<?php echo $red['icono']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</svg>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
