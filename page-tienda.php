<?php
/**
 * Template Name: Tienda
 *
 * Plantilla de la tienda interactiva y checkout en pasos.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="contenido" tabindex="-1" class="patron-puntos min-h-[70vh] bg-crema-claro outline-none">
	<p class="sr-only" aria-live="polite" id="anuncio-tienda"></p>

	<!-- Aviso de demostración siempre visible -->
	<div class="border-b border-caramelo/40 bg-crema">
		<p class="mx-auto flex max-w-7xl items-center gap-2 px-4 py-2.5 text-sm font-medium text-burdeos sm:px-6">
			<?php ambateno_icon( 'info', 'h-4 w-4 shrink-0 text-burdeos' ); ?>
			<?php esc_html_e( 'Sitio de demostración: no se procesan pagos ni se envían productos reales.', 'chocolate-el-ambateno' ); ?>
		</p>
	</div>

	<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
		<header class="flex flex-col gap-2">
			<h1 id="titulo-tienda-dinamico" tabindex="-1" class="text-balance font-display text-4xl font-semibold text-burdeos outline-none sm:text-5xl">
				<?php esc_html_e( 'Encuentra tu barra ideal en minutos', 'chocolate-el-ambateno' ); ?>
			</h1>
			<p id="subtitulo-tienda-dinamico" class="max-w-2xl text-pretty text-lg text-tinta/85">
				<?php esc_html_e( 'Chocolate artesanal de Ambato: elige, añade al carrito y finaliza tu compra en pocos pasos.', 'chocolate-el-ambateno' ); ?>
			</p>
		</header>

		<!-- Stepper de 5 pasos -->
		<div class="mt-8 rounded-xl border border-crema-oscuro bg-white/80 px-2 py-4 sm:px-6">
			<?php get_template_part( 'template-parts/tienda/stepper' ); ?>
		</div>

		<!-- Vistas de pasos del catálogo y checkout -->
		<div class="mt-8" id="contenedor-pasos-tienda">
			<!-- Plantilla de tarjeta de producto (para renderizado JS) -->
			<?php get_template_part( 'template-parts/tienda/tarjeta-producto' ); ?>

			<!-- Paso 0: Catálogo -->
			<div id="vista-paso-tienda" class="grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
				<?php get_template_part( 'template-parts/tienda/catalogo' ); ?>
				<?php get_template_part( 'template-parts/tienda/panel-carrito' ); ?>
			</div>

			<!-- Paso 1: Carrito en checkout -->
			<div id="vista-paso-carrito" class="hidden grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
				<div id="contenedor-paso-carrito">
					<?php get_template_part( 'template-parts/tienda/paso-carrito' ); ?>
				</div>
				<?php get_template_part( 'template-parts/tienda/resumen-pedido' ); ?>
			</div>

			<!-- Paso 2: Envío -->
			<div id="vista-paso-envio" class="hidden grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
				<div id="contenedor-paso-envio">
					<?php get_template_part( 'template-parts/tienda/paso-envio' ); ?>
				</div>
				<?php get_template_part( 'template-parts/tienda/resumen-pedido' ); ?>
			</div>

			<!-- Paso 3: Pago -->
			<div id="vista-paso-pago" class="hidden grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
				<div id="contenedor-paso-pago">
					<?php get_template_part( 'template-parts/tienda/paso-pago' ); ?>
				</div>
				<?php get_template_part( 'template-parts/tienda/resumen-pedido' ); ?>
			</div>

			<!-- Paso 4: Confirmación -->
			<div id="vista-paso-confirmacion" class="hidden">
				<?php get_template_part( 'template-parts/tienda/paso-confirmacion' ); ?>
			</div>
		</div>
	</div>
</main>

<!-- Modal de Vista Rápida -->
<?php get_template_part( 'template-parts/tienda/vista-rapida' ); ?>

<!-- Toast de Notificación -->
<?php get_template_part( 'template-parts/tienda/toast-aviso' ); ?>

<?php
get_footer();
