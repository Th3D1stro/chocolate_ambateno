<?php
/**
 * Plantilla fallback principal requerida por WordPress.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="contenido" tabindex="-1" class="patron-puntos min-h-[60vh] px-4 py-16 sm:px-6">
	<div class="mx-auto max-w-4xl">
		<?php if ( have_posts() ) : ?>
			<div class="flex flex-col gap-8">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'rounded-xl border border-crema-oscuro bg-white/90 p-6 shadow-sm' ); ?>>
						<h2 class="font-display text-3xl font-semibold text-burdeos">
							<a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
						</h2>
						<div class="mt-4 text-pretty text-tinta/85">
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<p class="text-center font-display text-xl text-tinta">
				<?php esc_html_e( 'No se encontraron contenidos.', 'chocolate-el-ambateno' ); ?>
			</p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
