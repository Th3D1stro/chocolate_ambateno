<?php
/**
 * Diálogo modal con el Mapa del Sitio en 3 columnas.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home_url   = home_url( '/' );
$tienda_url = ambateno_get_page_url( 'tienda' );

$secciones_landing = array(
	'inicio'      => array( 'label' => 'Inicio', 'desc' => 'Portada y mensaje principal' ),
	'chocolate'   => array( 'label' => 'Nuestro chocolate', 'desc' => 'Presentaciones de 200 g' ),
	'preparacion' => array( 'label' => 'Preparación', 'desc' => 'Paso a paso con el chef chocolatero' ),
	'historia'    => array( 'label' => 'Nuestra historia', 'desc' => 'La marca, Ambato e INPHEC' ),
	'donde'       => array( 'label' => 'Dónde encontrarlo', 'desc' => 'Tiendas, cafeterías y canales online' ),
	'contacto'    => array( 'label' => 'Contacto', 'desc' => 'Dirección, teléfono, mapa y formulario' ),
);
?>
<div id="modal-sitemap" class="hidden fixed inset-0 z-[100] flex items-end justify-center sm:items-center sm:p-6" role="dialog" aria-modal="true" aria-labelledby="titulo-mapa-sitio">
	<!-- Backdrop -->
	<div class="modal-backdrop absolute inset-0 bg-tinta/70" aria-hidden="true"></div>

	<!-- Panel -->
	<div class="aviso-entrada relative max-h-[92vh] w-full overflow-y-auto rounded-t-xl bg-crema-claro text-tinta shadow-2xl sm:rounded-xl sm:max-w-5xl">
		<button type="button" id="btn-cerrar-sitemap" class="absolute right-3 top-3 z-10 inline-flex h-11 w-11 items-center justify-center rounded-md bg-crema-claro/90 text-burdeos transition-colors hover:bg-crema" aria-label="<?php esc_attr_e( 'Cerrar', 'chocolate-el-ambateno' ); ?>">
			<?php ambateno_icon( 'x', 'h-5 w-5' ); ?>
		</button>

		<div class="p-6 sm:p-10">
			<h2 id="titulo-mapa-sitio" class="font-display text-3xl font-semibold text-burdeos">
				<?php esc_html_e( 'Mapa del sitio', 'chocolate-el-ambateno' ); ?>
			</h2>
			<p class="mt-2 max-w-xl text-pretty text-tinta/80">
				<?php esc_html_e( 'Todas las secciones y páginas de El Ambateño en un solo lugar.', 'chocolate-el-ambateno' ); ?>
			</p>

			<div class="mt-8 grid gap-8 md:grid-cols-3">
				<!-- Columna 1: Portada -->
				<nav aria-labelledby="mapa-landing">
					<h3 id="mapa-landing" class="flex items-center gap-2 border-b-2 border-caramelo pb-2 font-display text-lg font-semibold text-burdeos">
						<?php ambateno_icon( 'home', 'h-5 w-5 text-caramelo' ); ?>
						<?php esc_html_e( 'Página principal', 'chocolate-el-ambateno' ); ?>
					</h3>
					<ul class="mt-3 flex flex-col gap-1">
						<?php foreach ( $secciones_landing as $id => $info ) : ?>
							<li>
								<a href="<?php echo esc_url( "{$home_url}#{$id}" ); ?>" class="modal-sitemap-link group -mx-2 inline-flex min-h-11 flex-col justify-center rounded-md px-2 py-1.5 transition-colors hover:bg-crema">
									<span class="font-semibold text-burdeos group-hover:underline"><?php echo esc_html( $info['label'] ); ?></span>
									<span class="text-sm text-tinta/75"><?php echo esc_html( $info['desc'] ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<!-- Columna 2: Tienda -->
				<nav aria-labelledby="mapa-tienda">
					<h3 id="mapa-tienda" class="flex items-center gap-2 border-b-2 border-caramelo pb-2 font-display text-lg font-semibold text-burdeos">
						<?php ambateno_icon( 'shopping-bag', 'h-5 w-5 text-caramelo' ); ?>
						<?php esc_html_e( 'Tienda', 'chocolate-el-ambateno' ); ?>
					</h3>
					<ul class="mt-3 flex flex-col gap-1">
						<li>
							<a href="<?php echo esc_url( $tienda_url ); ?>" class="modal-sitemap-link group -mx-2 inline-flex min-h-11 flex-col justify-center rounded-md px-2 py-1.5 transition-colors hover:bg-crema">
								<span class="font-semibold text-burdeos group-hover:underline"><?php esc_html_e( 'Catálogo de productos', 'chocolate-el-ambateno' ); ?></span>
								<span class="text-sm text-tinta/75"><?php esc_html_e( 'Barras, snacks, regalos y línea profesional', 'chocolate-el-ambateno' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( "{$tienda_url}#resumen" ); ?>" class="modal-sitemap-link group -mx-2 inline-flex min-h-11 flex-col justify-center rounded-md px-2 py-1.5 transition-colors hover:bg-crema">
								<span class="font-semibold text-burdeos group-hover:underline"><?php esc_html_e( 'Resumen del pedido', 'chocolate-el-ambateno' ); ?></span>
								<span class="text-sm text-tinta/75"><?php esc_html_e( 'Tu carrito y el botón de finalizar compra', 'chocolate-el-ambateno' ); ?></span>
							</a>
						</li>
					</ul>
				</nav>

				<!-- Columna 3: Información -->
				<nav aria-labelledby="mapa-info">
					<h3 id="mapa-info" class="flex items-center gap-2 border-b-2 border-caramelo pb-2 font-display text-lg font-semibold text-burdeos">
						<?php ambateno_icon( 'file-text', 'h-5 w-5 text-caramelo' ); ?>
						<?php esc_html_e( 'Información', 'chocolate-el-ambateno' ); ?>
					</h3>
					<ul class="mt-3 flex flex-col gap-1">
						<li>
							<a href="<?php echo esc_url( "{$home_url}#contacto" ); ?>" class="modal-sitemap-link group -mx-2 inline-flex min-h-11 flex-col justify-center rounded-md px-2 py-1.5 transition-colors hover:bg-crema">
								<span class="font-semibold text-burdeos group-hover:underline"><?php esc_html_e( 'Contacto', 'chocolate-el-ambateno' ); ?></span>
								<span class="text-sm text-tinta/75"><?php esc_html_e( 'Escríbenos o visítanos en Ambato', 'chocolate-el-ambateno' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( ambateno_get_page_url( 'terminos' ) ); ?>" class="modal-sitemap-link group -mx-2 inline-flex min-h-11 flex-col justify-center rounded-md px-2 py-1.5 transition-colors hover:bg-crema">
								<span class="font-semibold text-burdeos group-hover:underline"><?php esc_html_e( 'Términos y condiciones', 'chocolate-el-ambateno' ); ?></span>
								<span class="text-sm text-tinta/75"><?php esc_html_e( 'Condiciones de uso y de compra', 'chocolate-el-ambateno' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( ambateno_get_page_url( 'privacidad' ) ); ?>" class="modal-sitemap-link group -mx-2 inline-flex min-h-11 flex-col justify-center rounded-md px-2 py-1.5 transition-colors hover:bg-crema">
								<span class="font-semibold text-burdeos group-hover:underline"><?php esc_html_e( 'Política de privacidad', 'chocolate-el-ambateno' ); ?></span>
								<span class="text-sm text-tinta/75"><?php esc_html_e( 'Cómo tratamos tus datos', 'chocolate-el-ambateno' ); ?></span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>
