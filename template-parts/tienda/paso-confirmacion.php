<?php
/**
 * Paso 4 del Checkout: Confirmación de compra exitosa.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="mx-auto max-w-3xl overflow-hidden rounded-xl border border-crema-oscuro bg-white shadow-xl shadow-burdeos/10">
	<!-- Encabezado de celebración -->
	<div class="on-dark patron-puntos-oscuro bg-burdeos px-6 py-10 text-center text-crema sm:px-10">
		<span class="inline-flex text-oliva">
			<?php ambateno_icon( 'check-circle-2', 'mx-auto h-16 w-16' ); ?>
		</span>
		<h2 class="mt-4 font-display text-4xl font-semibold">
			<?php esc_html_e( '¡Compra realizada!', 'chocolate-el-ambateno' ); ?>
		</h2>
		<p id="confirmacion-saludo" class="mt-2 text-crema/90">
			<?php esc_html_e( 'Gracias. Tu pedido simulado fue registrado.', 'chocolate-el-ambateno' ); ?>
		</p>
		<p class="mt-5 inline-flex flex-col rounded-lg bg-crema px-5 py-3 text-burdeos">
			<span class="text-xs font-semibold uppercase tracking-wider">
				<?php esc_html_e( 'Número de pedido', 'chocolate-el-ambateno' ); ?>
			</span>
			<span id="confirmacion-numero" class="font-display text-2xl font-bold">
				AMB-2026-00000
			</span>
		</p>
	</div>

	<!-- Contenido del resumen -->
	<div class="flex flex-col gap-6 p-6 sm:p-10">
		<div class="flex items-start gap-3 rounded-lg bg-oliva-claro p-4 text-tinta">
			<?php ambateno_icon( 'calendar-clock', 'mt-0.5 h-6 w-6 shrink-0 text-burdeos' ); ?>
			<div>
				<p id="confirmacion-entrega-tiempo" class="font-semibold text-burdeos">
					<?php esc_html_e( 'Entrega estimada: 3 a 5 días hábiles', 'chocolate-el-ambateno' ); ?>
				</p>
				<p id="confirmacion-detalles-envio" class="text-sm">
					Envío estándar · Pago: Tarjeta de crédito/débito
				</p>
			</div>
		</div>

		<div>
			<h3 class="font-display text-xl font-semibold text-burdeos">
				<?php esc_html_e( 'Resumen del pedido', 'chocolate-el-ambateno' ); ?>
			</h3>
			<ul id="confirmacion-lineas-lista" class="mt-3 flex flex-col gap-2 text-sm"></ul>

			<dl class="mt-4 flex flex-col gap-1.5 border-t border-crema-oscuro pt-4 text-sm">
				<div class="flex justify-between">
					<dt><?php esc_html_e( 'Subtotal', 'chocolate-el-ambateno' ); ?></dt>
					<dd id="confirmacion-subtotal">$0.00</dd>
				</div>
				<div class="flex justify-between">
					<dt><?php esc_html_e( 'Envío', 'chocolate-el-ambateno' ); ?></dt>
					<dd id="confirmacion-envio">$0.00</dd>
				</div>
				<div class="flex justify-between">
					<dt><?php esc_html_e( 'IVA (15 %, simulado)', 'chocolate-el-ambateno' ); ?></dt>
					<dd id="confirmacion-iva">$0.00</dd>
				</div>
				<div class="flex justify-between pt-2 text-lg font-bold text-burdeos">
					<dt><?php esc_html_e( 'Total', 'chocolate-el-ambateno' ); ?></dt>
					<dd id="confirmacion-total">$0.00</dd>
				</div>
			</dl>
		</div>

		<div class="flex flex-col gap-3 xs:flex-row">
			<button type="button" id="btn-confirmacion-seguir" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta flex-1">
				<?php ambateno_icon( 'shopping-bag', 'h-5 w-5' ); ?>
				<?php esc_html_e( 'Seguir comprando', 'chocolate-el-ambateno' ); ?>
			</button>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-5 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema flex-1">
				<?php ambateno_icon( 'home', 'h-5 w-5' ); ?>
				<?php esc_html_e( 'Volver al inicio', 'chocolate-el-ambateno' ); ?>
			</a>
		</div>
	</div>
</div>
