<?php
/**
 * Panel lateral del Carrito en el Catálogo.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside id="resumen" aria-labelledby="titulo-resumen" class="scroll-mt-36 rounded-xl border border-crema-oscuro bg-white p-5 shadow-lg shadow-burdeos/5 lg:sticky lg:top-36">
	<div class="flex items-baseline justify-between gap-2 border-b-2 border-burdeos pb-3">
		<h2 id="titulo-resumen" class="font-display text-2xl font-semibold text-burdeos">
			<?php esc_html_e( 'Resumen del pedido', 'chocolate-el-ambateno' ); ?>
		</h2>
		<span id="panel-cart-count" class="text-sm text-tinta/75">0 artículos</span>
	</div>

	<!-- Estado vacío: Barra sonriente en SVG -->
	<div id="panel-cart-vacio" class="flex flex-col items-center gap-3 py-8 text-center">
		<svg viewBox="0 0 120 90" class="h-24 w-32" aria-hidden="true">
			<rect x="18" y="14" width="84" height="62" rx="8" fill="var(--color-burdeos, #7a1714)"/>
			<g stroke="var(--color-burdeos-oscuro, #5c100e)" stroke-width="2">
				<path d="M46 14v62M74 14v62M18 45h84"/>
			</g>
			<circle cx="48" cy="36" r="3" fill="var(--color-crema, #f0d1bc)"/>
			<circle cx="72" cy="36" r="3" fill="var(--color-crema, #f0d1bc)"/>
			<path d="M50 52q10 9 20 0" stroke="var(--color-crema, #f0d1bc)" stroke-width="3" fill="none" stroke-linecap="round"/>
			<path d="M10 82h100" stroke="var(--color-oliva, #999f3b)" stroke-width="3" stroke-linecap="round"/>
		</svg>
		<p class="font-display text-xl font-semibold text-burdeos">
			<?php esc_html_e( 'Tu carrito está esperando', 'chocolate-el-ambateno' ); ?>
		</p>
		<p class="max-w-[16rem] text-pretty text-sm text-tinta/80">
			<?php esc_html_e( 'Añade tu primera barra y aquí verás el resumen de tu pedido.', 'chocolate-el-ambateno' ); ?>
		</p>
	</div>

	<!-- Lista de productos en el carrito -->
	<ul id="panel-cart-lista" class="hidden max-h-[42vh] divide-y divide-crema-oscuro/70 overflow-y-auto"></ul>

	<!-- Totales -->
	<dl class="mt-2 flex flex-col gap-2 border-t border-crema-oscuro pt-4">
		<div class="flex justify-between text-tinta/85">
			<dt><?php esc_html_e( 'Subtotal', 'chocolate-el-ambateno' ); ?></dt>
			<dd id="panel-cart-subtotal">$0.00</dd>
		</div>
		<div class="flex justify-between text-lg font-bold text-burdeos">
			<dt><?php esc_html_e( 'Total', 'chocolate-el-ambateno' ); ?></dt>
			<dd id="panel-cart-total">$0.00</dd>
		</div>
		<p class="text-xs text-tinta/70">
			<?php esc_html_e( 'El envío y el IVA se calculan en los siguientes pasos.', 'chocolate-el-ambateno' ); ?>
		</p>
	</dl>

	<button type="button" id="btn-finalizar-compra" disabled class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta disabled:cursor-not-allowed disabled:opacity-50 mt-4 w-full text-base">
		<?php esc_html_e( 'Finalizar compra', 'chocolate-el-ambateno' ); ?>
		<?php ambateno_icon( 'arrow-right', 'h-5 w-5' ); ?>
	</button>

	<!-- Textos de confianza -->
	<div class="mt-5 border-t border-crema-oscuro pt-4">
		<ul class="flex flex-col gap-2.5 text-sm text-tinta/85">
			<li class="flex items-start gap-2">
				<?php ambateno_icon( 'shield-check', 'mt-0.5 h-5 w-5 shrink-0 text-oliva' ); ?>
				<?php esc_html_e( 'Pagos 100% seguros', 'chocolate-el-ambateno' ); ?>
			</li>
			<li class="flex items-start gap-2">
				<?php ambateno_icon( 'truck', 'mt-0.5 h-5 w-5 shrink-0 text-oliva' ); ?>
				<?php esc_html_e( 'Envíos rápidos (hasta 48 h, según destino)', 'chocolate-el-ambateno' ); ?>
			</li>
			<li class="flex items-start gap-2">
				<?php ambateno_icon( 'mouse-pointer-click', 'mt-0.5 h-5 w-5 shrink-0 text-oliva' ); ?>
				<?php esc_html_e( 'Compra fácil: agrega al carrito y finaliza en minutos', 'chocolate-el-ambateno' ); ?>
			</li>
		</ul>
	</div>
</aside>
