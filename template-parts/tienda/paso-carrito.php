<?php
/**
 * Paso 1 del Checkout: Revisar carrito.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="rounded-xl border border-crema-oscuro bg-white p-5 sm:p-8">
	<h2 class="font-display text-2xl font-semibold text-burdeos">
		<?php esc_html_e( 'Revisa tu carrito', 'chocolate-el-ambateno' ); ?>
	</h2>
	<p class="mt-1 text-tinta/80">
		<?php esc_html_e( 'Ajusta las cantidades o quita productos antes de continuar.', 'chocolate-el-ambateno' ); ?>
	</p>

	<p id="checkout-cart-vacio-msg" class="hidden mt-6 rounded-lg bg-crema p-4 text-tinta">
		<?php esc_html_e( 'Tu carrito está vacío. Vuelve a la tienda para añadir productos.', 'chocolate-el-ambateno' ); ?>
	</p>

	<ul id="checkout-cart-lista" class="mt-4 divide-y divide-crema-oscuro/70"></ul>

	<div class="mt-6 flex flex-col-reverse gap-3 border-t border-crema-oscuro pt-6 xs:flex-row xs:justify-between">
		<button type="button" id="btn-carrito-volver-tienda" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-5 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema">
			<?php ambateno_icon( 'arrow-left', 'h-5 w-5' ); ?>
			<?php esc_html_e( 'Seguir comprando', 'chocolate-el-ambateno' ); ?>
		</button>
		<button type="button" id="btn-carrito-continuar-envio" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta">
			<?php esc_html_e( 'Continuar al envío', 'chocolate-el-ambateno' ); ?>
			<?php ambateno_icon( 'arrow-right', 'h-5 w-5' ); ?>
		</button>
	</div>
</div>
