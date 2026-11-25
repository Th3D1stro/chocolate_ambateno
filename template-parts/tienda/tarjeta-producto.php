<?php
/**
 * Plantilla de tarjeta de producto.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<template id="tmpl-tarjeta-producto">
	<li class="h-full">
		<article class="group flex h-full flex-col overflow-hidden rounded-xl border border-crema-oscuro bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-burdeos/10">
			<button type="button" class="btn-ver-producto relative block aspect-square overflow-hidden bg-crema w-full text-left">
				<img src="" alt="" width="1024" height="1024" loading="lazy" class="producto-img h-full w-full object-cover transition duration-500 group-hover:scale-105">
				<span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-md bg-crema-claro px-2.5 py-1 text-sm font-semibold text-burdeos shadow">
					<?php ambateno_icon( 'eye', 'h-4 w-4' ); ?>
					<?php esc_html_e( 'Vista rápida', 'chocolate-el-ambateno' ); ?>
				</span>
			</button>

			<div class="flex flex-1 flex-col gap-3 p-5">
				<div class="producto-etiquetas flex flex-wrap gap-1.5"></div>
				<h3 class="producto-nombre font-display text-xl font-semibold leading-snug text-burdeos"></h3>
				<p class="producto-desc line-clamp-2 text-pretty text-sm text-tinta/80"></p>
				
				<div class="mt-auto flex items-baseline justify-between border-t border-crema-oscuro/60 pt-3">
					<p class="font-display text-2xl font-bold text-caramelo-oscuro">
						<span class="producto-precio"></span>
						<span class="producto-peso text-xs font-medium text-tinta/75"></span>
					</p>
				</div>

				<div class="flex items-center gap-2 pt-1">
					<div class="inline-flex items-center overflow-hidden rounded-md border-2 border-burdeos/25 bg-white">
						<button type="button" class="btn-qty-minus inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema disabled:cursor-not-allowed disabled:opacity-40" aria-label="<?php esc_attr_e( 'Restar uno', 'chocolate-el-ambateno' ); ?>">
							<?php ambateno_icon( 'minus', 'h-4 w-4' ); ?>
						</button>
						<input type="number" inputmode="numeric" min="1" max="99" value="1" class="input-qty sin-flechas h-11 w-12 border-x border-burdeos/15 bg-transparent text-center font-semibold text-tinta" aria-label="<?php esc_attr_e( 'Cantidad', 'chocolate-el-ambateno' ); ?>">
						<button type="button" class="btn-qty-plus inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema disabled:cursor-not-allowed disabled:opacity-40" aria-label="<?php esc_attr_e( 'Sumar uno', 'chocolate-el-ambateno' ); ?>">
							<?php ambateno_icon( 'plus', 'h-4 w-4' ); ?>
						</button>
					</div>

					<button type="button" class="btn-agregar-producto inline-flex min-h-11 flex-1 items-center justify-center gap-2 rounded-md bg-burdeos px-4 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta">
						<?php ambateno_icon( 'shopping-bag', 'h-5 w-5' ); ?>
						<span class="text-sm sm:text-base"><?php esc_html_e( 'Añadir', 'chocolate-el-ambateno' ); ?></span>
					</button>
				</div>
			</div>
		</article>
	</li>
</template>
