<?php
/**
 * Resumen lateral persistente en los pasos del Checkout.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside aria-labelledby="titulo-resumen-checkout" class="rounded-xl border border-crema-oscuro bg-white p-5 shadow-lg shadow-burdeos/5 lg:sticky lg:top-36">
	<h2 id="titulo-resumen-checkout" class="border-b-2 border-burdeos pb-3 font-display text-xl font-semibold text-burdeos">
		<?php esc_html_e( 'Tu pedido', 'chocolate-el-ambateno' ); ?>
	</h2>

	<ul id="checkout-aside-lineas" class="flex flex-col gap-2 py-4 text-sm"></ul>

	<dl class="flex flex-col gap-2 border-t border-crema-oscuro pt-4 text-sm">
		<div class="flex justify-between">
			<dt class="text-tinta/85"><?php esc_html_e( 'Subtotal', 'chocolate-el-ambateno' ); ?></dt>
			<dd id="checkout-aside-subtotal">$0.00</dd>
		</div>
		<div class="flex justify-between">
			<dt class="text-tinta/85"><?php esc_html_e( 'Envío', 'chocolate-el-ambateno' ); ?></dt>
			<dd id="checkout-aside-envio"><?php esc_html_e( 'Se calcula en el paso de envío', 'chocolate-el-ambateno' ); ?></dd>
		</div>
		<div id="checkout-aside-row-iva" class="hidden flex justify-between">
			<dt class="text-tinta/85"><?php esc_html_e( 'IVA (15 %, simulado)', 'chocolate-el-ambateno' ); ?></dt>
			<dd id="checkout-aside-iva">$0.00</dd>
		</div>
		<div class="mt-1 flex justify-between border-t border-crema-oscuro pt-3 text-lg font-bold text-burdeos">
			<dt><?php esc_html_e( 'Total', 'chocolate-el-ambateno' ); ?></dt>
			<dd id="checkout-aside-total">$0.00</dd>
		</div>
	</dl>
</aside>
