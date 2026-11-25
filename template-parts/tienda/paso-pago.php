<?php
/**
 * Paso 3 del Checkout: Métodos de pago y confirmación final.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form id="form-paso-pago" noValidate class="flex flex-col gap-6">
	<fieldset class="rounded-xl border border-crema-oscuro bg-white p-5 sm:p-8">
		<legend class="sr-only"><?php esc_html_e( 'Método de pago', 'chocolate-el-ambateno' ); ?></legend>
		<h2 class="font-display text-2xl font-semibold text-burdeos">
			<?php esc_html_e( 'Método de pago', 'chocolate-el-ambateno' ); ?>
		</h2>

		<!-- Radios de pago -->
		<div class="mt-4 grid gap-3 md:grid-cols-3">
			<label class="label-metodo-pago flex min-h-16 cursor-pointer items-center gap-3 rounded-lg border-2 p-4 transition-colors border-burdeos bg-crema">
				<input type="radio" name="metodo_pago" value="tarjeta" checked class="h-5 w-5 accent-burdeos" />
				<?php ambateno_icon( 'credit-card', 'h-6 w-6 shrink-0 text-caramelo' ); ?>
				<span class="font-semibold text-burdeos"><?php esc_html_e( 'Tarjeta de crédito/débito', 'chocolate-el-ambateno' ); ?></span>
			</label>

			<label class="label-metodo-pago flex min-h-16 cursor-pointer items-center gap-3 rounded-lg border-2 p-4 transition-colors border-crema-oscuro hover:border-burdeos/60">
				<input type="radio" name="metodo_pago" value="transferencia" class="h-5 w-5 accent-burdeos" />
				<?php ambateno_icon( 'landmark', 'h-6 w-6 shrink-0 text-caramelo' ); ?>
				<span class="font-semibold text-burdeos"><?php esc_html_e( 'Transferencia bancaria', 'chocolate-el-ambateno' ); ?></span>
			</label>

			<label class="label-metodo-pago flex min-h-16 cursor-pointer items-center gap-3 rounded-lg border-2 p-4 transition-colors border-crema-oscuro hover:border-burdeos/60">
				<input type="radio" name="metodo_pago" value="contraentrega" class="h-5 w-5 accent-burdeos" />
				<?php ambateno_icon( 'banknote', 'h-6 w-6 shrink-0 text-caramelo' ); ?>
				<span class="font-semibold text-burdeos"><?php esc_html_e( 'Pago contra entrega', 'chocolate-el-ambateno' ); ?></span>
			</label>
		</div>

		<!-- Contenedor dinámico según el método elegido -->
		<div class="mt-6">
			<!-- Opción 1: Tarjeta -->
			<div id="pago-panel-tarjeta" class="flex flex-col gap-4">
				<p class="rounded-lg border-2 border-dashed border-caramelo bg-crema-claro p-3 text-sm text-tinta">
					<strong class="text-burdeos"><?php esc_html_e( 'No uses una tarjeta real.', 'chocolate-el-ambateno' ); ?></strong>
					<?php esc_html_e( 'Número de prueba: 4111 1111 1111 1111, vencimiento 12/30, CVV 123.', 'chocolate-el-ambateno' ); ?>
				</p>

				<div class="grid gap-5 md:grid-cols-2">
					<div class="flex flex-col gap-1.5">
						<label for="tarjeta-titular" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Titular de la tarjeta', 'chocolate-el-ambateno' ); ?></label>
						<input id="tarjeta-titular" autocomplete="off" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="tarjeta-titular-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'Escribe el nombre como aparece en la tarjeta.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<div class="flex flex-col gap-1.5">
						<label for="tarjeta-numero" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Número de tarjeta (prueba)', 'chocolate-el-ambateno' ); ?></label>
						<input id="tarjeta-numero" inputmode="numeric" maxlength="19" placeholder="0000 0000 0000 0000" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="tarjeta-numero-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'El número de prueba debe tener 16 dígitos.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<div class="flex flex-col gap-1.5">
						<label for="tarjeta-vencimiento" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Vencimiento (MM/AA)', 'chocolate-el-ambateno' ); ?></label>
						<input id="tarjeta-vencimiento" inputmode="numeric" maxlength="5" placeholder="MM/AA" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="tarjeta-vencimiento-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'Usa el formato MM/AA.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<div class="flex flex-col gap-1.5">
						<label for="tarjeta-cvv" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'CVV', 'chocolate-el-ambateno' ); ?></label>
						<input id="tarjeta-cvv" inputmode="numeric" maxlength="4" placeholder="123" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="tarjeta-cvv-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'El CVV tiene 3 o 4 dígitos.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>
				</div>
			</div>

			<!-- Opción 2: Transferencia -->
			<div id="pago-panel-transferencia" class="hidden rounded-lg bg-crema p-5 text-tinta">
				<p class="font-semibold text-burdeos"><?php esc_html_e( 'Datos para la transferencia (ficticios)', 'chocolate-el-ambateno' ); ?></p>
				<dl class="mt-3 grid gap-x-6 gap-y-2 text-sm sm:grid-cols-[auto_1fr]">
					<dt class="font-medium"><?php esc_html_e( 'Banco', 'chocolate-el-ambateno' ); ?></dt>
					<dd><?php esc_html_e( 'Banco Demo del Ecuador', 'chocolate-el-ambateno' ); ?></dd>
					<dt class="font-medium"><?php esc_html_e( 'Cuenta corriente', 'chocolate-el-ambateno' ); ?></dt>
					<dd>0000-123456-7</dd>
					<dt class="font-medium"><?php esc_html_e( 'Titular', 'chocolate-el-ambateno' ); ?></dt>
					<dd><?php esc_html_e( 'El Ambateño Chocolates (demo)', 'chocolate-el-ambateno' ); ?></dd>
					<dt class="font-medium"><?php esc_html_e( 'RUC', 'chocolate-el-ambateno' ); ?></dt>
					<dd>1800000000001</dd>
				</dl>
				<p class="mt-3 text-sm">
					<?php esc_html_e( 'Envía el comprobante a hola@elambateno.ec con tu número de pedido.', 'chocolate-el-ambateno' ); ?>
				</p>
			</div>

			<!-- Opción 3: Contra entrega -->
			<div id="pago-panel-contraentrega" class="hidden rounded-lg bg-crema p-5 text-tinta">
				<p>
					<?php esc_html_e( 'Pagas en efectivo al recibir tu pedido. Ten el valor exacto listo: ', 'chocolate-el-ambateno' ); ?>
					<strong class="total-contraentrega text-burdeos">$0.00</strong>.
				</p>
			</div>
		</div>
	</fieldset>

	<!-- Resumen final con IVA -->
	<section aria-labelledby="titulo-resumen-final" class="rounded-xl border-2 border-burdeos bg-crema-claro p-5 sm:p-8">
		<h2 id="titulo-resumen-final" class="font-display text-xl font-semibold text-burdeos">
			<?php esc_html_e( 'Resumen final', 'chocolate-el-ambateno' ); ?>
		</h2>
		<dl class="mt-3 flex flex-col gap-2">
			<div class="flex justify-between">
				<dt><?php esc_html_e( 'Subtotal', 'chocolate-el-ambateno' ); ?></dt>
				<dd id="pago-subtotal">$0.00</dd>
			</div>
			<div class="flex justify-between">
				<dt><?php esc_html_e( 'Envío', 'chocolate-el-ambateno' ); ?></dt>
				<dd id="pago-envio">$0.00</dd>
			</div>
			<div class="flex justify-between">
				<dt><?php esc_html_e( 'IVA (15 %, simulado)', 'chocolate-el-ambateno' ); ?></dt>
				<dd id="pago-iva">$0.00</dd>
			</div>
			<div class="flex justify-between border-t border-crema-oscuro pt-3 text-xl font-bold text-burdeos">
				<dt><?php esc_html_e( 'Total a pagar', 'chocolate-el-ambateno' ); ?></dt>
				<dd id="pago-total">$0.00</dd>
			</div>
		</dl>
	</section>

	<div class="flex flex-col-reverse gap-3 xs:flex-row xs:justify-between">
		<button type="button" id="btn-pago-volver-envio" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-5 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema">
			<?php ambateno_icon( 'arrow-left', 'h-5 w-5' ); ?>
			<?php esc_html_e( 'Volver al envío', 'chocolate-el-ambateno' ); ?>
		</button>
		<button type="submit" id="btn-pago-pagar" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta">
			<?php ambateno_icon( 'lock', 'h-5 w-5' ); ?>
			<span id="btn-pago-pagar-texto"><?php esc_html_e( 'Pagar', 'chocolate-el-ambateno' ); ?></span>
		</button>
	</div>
</form>
