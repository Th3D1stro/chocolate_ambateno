<?php
/**
 * Plantilla general para páginas de contenido y legales (Términos, Privacidad).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="contenido" tabindex="-1" class="patron-puntos bg-crema-claro outline-none">
	<article class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
		<p class="inline-flex rounded-md border-2 border-dashed border-caramelo px-3 py-1 text-sm font-semibold text-caramelo-oscuro">
			<?php esc_html_e( 'Texto de ejemplo · reemplazar por el documento legal real', 'chocolate-el-ambateno' ); ?>
		</p>
		<h1 class="mt-4 text-balance font-display text-4xl font-semibold text-burdeos sm:text-5xl">
			<?php the_title(); ?>
		</h1>
		<div class="mt-8 flex flex-col gap-6 text-pretty text-lg leading-relaxed text-tinta/90 [&_h2]:font-display [&_h2]:text-2xl [&_h2]:font-semibold [&_h2]:text-burdeos">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
	</article>
</main>

<?php
get_footer();
