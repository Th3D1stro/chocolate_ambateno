<?php
/**
 * Diálogo modal de Vista Rápida de producto con tabla nutricional y selector de cantidad.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="modal-vista-rapida" class="hidden fixed inset-0 z-[100] flex items-end justify-center sm:items-center sm:p-6" role="dialog" aria-modal="true" aria-labelledby="titulo-vista-rapida">
	<!-- Backdrop -->
	<div class="modal-backdrop absolute inset-0 bg-tinta/70" aria-hidden="true"></div>

	<!-- Panel -->
	<div class="aviso-entrada relative max-h-[92vh] w-full overflow-y-auto rounded-t-xl bg-crema-claro text-tinta shadow-2xl sm:rounded-xl sm:max-w-5xl">
		<button type="button" id="btn-cerrar-vista-rapida" class="absolute right-3 top-3 z-10 inline-flex h-11 w-11 items-center justify-center rounded-md bg-crema-claro/90 text-burdeos transition-colors hover:bg-crema" aria-label="<?php esc_attr_e( 'Cerrar', 'chocolate-el-ambateno' ); ?>">
			<?php ambateno_icon( 'x', 'h-5 w-5' ); ?>
		</button>

		<div class="grid md:grid-cols-2">
			<!-- Imagen grande -->
			<img id="vr-img" src="" alt="" width="1024" height="1024" class="aspect-square h-full w-full bg-crema object-cover">

			<!-- Detalles -->
			<div class="flex flex-col gap-4 p-6 sm:p-8">
				<div id="vr-etiquetas" class="flex flex-wrap gap-1.5 pr-12"></div>
				
				<h2 id="titulo-vista-rapida" class="text-balance font-display text-3xl font-semibold text-burdeos"></h2>
				
				<p class="text-3xl font-bold text-caramelo-oscuro">
					<span id="vr-precio">$0.00</span>
					<span id="vr-peso" class="text-base font-medium text-tinta/75"></span>
				</p>

				<p id="vr-descripcion" class="text-pretty text-tinta/90"></p>

				<div>
					<h3 class="font-semibold text-burdeos"><?php esc_html_e( 'Ingredientes', 'chocolate-el-ambateno' ); ?></h3>
					<p id="vr-ingredientes" class="mt-1 text-sm text-tinta/85"></p>
				</div>

				<!-- Tabla nutricional -->
				<table class="w-full overflow-hidden rounded-lg border border-crema-oscuro text-sm">
					<caption class="mb-2 text-left font-semibold text-burdeos">
						<?php esc_html_e( 'Información nutricional simulada', 'chocolate-el-ambateno' ); ?> (<span id="vr-porcion-label">porción de 25 g</span>)
					</caption>
					<tbody id="vr-nutricion-body"></tbody>
				</table>

				<!-- Selector de cantidad y botón agregar -->
				<div class="mt-auto flex flex-col gap-3 pt-2 xs:flex-row">
					<div class="inline-flex items-center overflow-hidden rounded-md border-2 border-burdeos/25 bg-white">
						<button type="button" id="vr-qty-minus" class="inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema disabled:cursor-not-allowed disabled:opacity-40" aria-label="<?php esc_attr_e( 'Restar uno', 'chocolate-el-ambateno' ); ?>">
							<?php ambateno_icon( 'minus', 'h-4 w-4' ); ?>
						</button>
						<input type="number" id="vr-qty-input" inputmode="numeric" min="1" max="99" value="1" class="sin-flechas h-11 w-12 border-x border-burdeos/15 bg-transparent text-center font-semibold text-tinta" aria-label="<?php esc_attr_e( 'Cantidad', 'chocolate-el-ambateno' ); ?>">
						<button type="button" id="vr-qty-plus" class="inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema disabled:cursor-not-allowed disabled:opacity-40" aria-label="<?php esc_attr_e( 'Sumar uno', 'chocolate-el-ambateno' ); ?>">
							<?php ambateno_icon( 'plus', 'h-4 w-4' ); ?>
						</button>
					</div>

					<button type="button" id="btn-vr-agregar" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta flex-1">
						<?php ambateno_icon( 'shopping-bag', 'h-5 w-5' ); ?>
						<?php esc_html_e( 'Añadir al carrito', 'chocolate-el-ambateno' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
