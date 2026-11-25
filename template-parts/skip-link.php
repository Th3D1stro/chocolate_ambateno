<?php
/**
 * Enlace accesible "Saltar al contenido".
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[200] focus:rounded-md focus:bg-crema focus:px-4 focus:py-3 focus:font-semibold focus:text-burdeos focus:shadow-lg">
	<?php esc_html_e( 'Saltar al contenido', 'chocolate-el-ambateno' ); ?>
</a>
