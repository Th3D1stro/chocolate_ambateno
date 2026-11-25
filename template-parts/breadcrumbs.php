<?php
/**
 * Barra de migas de pan y botón de acceso al Mapa del Sitio.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="breadcrumb-bar" class="border-b border-crema-oscuro/70 bg-crema-claro/95 backdrop-blur">
	<div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 sm:px-6">
		<nav aria-label="<?php esc_attr_e( 'Migas de pan', 'chocolate-el-ambateno' ); ?>" class="min-w-0 overflow-x-auto">
			<ol id="breadcrumb-list" class="flex items-center gap-1 whitespace-nowrap text-sm">
				<li class="flex items-center gap-1">
					<?php if ( is_front_page() ) : ?>
						<span aria-current="page" id="miga-activa-landing" class="inline-flex min-h-11 items-center px-1 font-semibold text-tinta"><?php esc_html_e( 'Inicio', 'chocolate-el-ambateno' ); ?></span>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex min-h-11 items-center rounded px-1 font-medium text-burdeos underline-offset-4 hover:text-caramelo-oscuro hover:underline"><?php esc_html_e( 'Inicio', 'chocolate-el-ambateno' ); ?></a>
						<span class="text-caramelo" aria-hidden="true">›</span>
						<span aria-current="page" class="inline-flex min-h-11 items-center px-1 font-semibold text-tinta"><?php the_title(); ?></span>
					<?php endif; ?>
				</li>
			</ol>
		</nav>

		<button type="button" id="btn-abrir-sitemap" class="inline-flex min-h-11 shrink-0 items-center gap-1.5 rounded px-1 text-sm font-medium text-burdeos underline-offset-4 hover:text-caramelo-oscuro hover:underline">
			<?php ambateno_icon( 'map', 'h-4 w-4' ); ?>
			<span class="hidden xs:inline"><?php esc_html_e( 'Mapa del sitio', 'chocolate-el-ambateno' ); ?></span>
			<span class="xs:hidden"><?php esc_html_e( 'Mapa', 'chocolate-el-ambateno' ); ?></span>
		</button>
	</div>
</div>
