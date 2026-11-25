<?php
/**
 * Plantilla para página 404 (No encontrado).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="contenido" tabindex="-1" class="patron-puntos flex min-h-[70vh] flex-col items-center justify-center px-4 py-20 text-center sm:px-6">
	<div class="max-w-md rounded-xl border border-crema-oscuro bg-white/90 p-8 shadow-xl shadow-burdeos/10">
		<h1 class="font-display text-6xl font-bold text-burdeos">404</h1>
		<h2 class="mt-3 font-display text-2xl font-semibold text-tinta">
			<?php esc_html_e( 'Página no encontrada', 'chocolate-el-ambateno' ); ?>
		</h2>
		<p class="mt-3 text-pretty text-tinta/80">
			<?php esc_html_e( 'La página que buscas no existe o fue movida. Puedes volver al inicio o recorrer nuestra tienda.', 'chocolate-el-ambateno' ); ?>
		</p>
		<div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro">
				<?php ambateno_icon( 'home', 'h-5 w-5 text-crema' ); ?>
				<?php esc_html_e( 'Ir al inicio', 'chocolate-el-ambateno' ); ?>
			</a>
			<a href="<?php echo esc_url( ambateno_get_page_url( 'tienda' ) ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-5 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema">
				<?php ambateno_icon( 'shopping-bag', 'h-5 w-5 text-burdeos' ); ?>
				<?php esc_html_e( 'Ver tienda', 'chocolate-el-ambateno' ); ?>
			</a>
		</div>
	</div>
</main>

<?php
get_footer();
