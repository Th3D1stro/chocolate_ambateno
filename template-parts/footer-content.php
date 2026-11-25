<?php
/**
 * Contenido del Pie de Página (Footer).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home_url  = home_url( '/' );
$direccion = get_theme_mod( 'ambateno_contacto_direccion', 'Parque Industrial Ambato, Avenida D entre las calles Tercera y Cuarta, Lote 5 Ambato, Ecuador' );
$telefono  = get_theme_mod( 'ambateno_contacto_telefono', '(+593) 99 393 1813' );
$correo    = get_theme_mod( 'ambateno_contacto_correo', 'chocolateelambatenio@gmail.com' );
$enlace_clase = 'inline-flex min-h-11 items-center text-crema/90 underline-offset-4 hover:text-crema hover:underline';

$secciones = array(
	'inicio'      => __( 'Inicio', 'chocolate-el-ambateno' ),
	'chocolate'   => __( 'Nuestro chocolate', 'chocolate-el-ambateno' ),
	'preparacion' => __( 'Preparación', 'chocolate-el-ambateno' ),
	'historia'    => __( 'Nuestra historia', 'chocolate-el-ambateno' ),
	// 'donde'       => __( 'Dónde encontrarlo', 'chocolate-el-ambateno' ),
	'contacto'    => __( 'Contacto', 'chocolate-el-ambateno' ),
);
?>
<footer class="on-dark patron-puntos-oscuro bg-burdeos text-crema">
	<div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
		
		<!-- Columna 1: Logo, descripción y redes -->
		<div class="flex flex-col gap-5">
			<a href="<?php echo esc_url( $home_url ); ?>" class="self-start rounded-md" aria-label="<?php esc_attr_e( 'El Ambateño, ir al inicio', 'chocolate-el-ambateno' ); ?>">
				<?php get_template_part('template-parts/logo',null,array('tono'  => 'claro','clase' => 'h-30 w-auto',));?>
			</a>
			<p class="max-w-xs text-pretty text-crema/90">
				<?php esc_html_e( 'Chocolate artesanal hecho en Ambato, Ecuador. Tradicional, sin azúcar y libre de gluten.', 'chocolate-el-ambateno' ); ?>
			</p>
			<?php get_template_part( 'template-parts/redes-sociales', null, array( 'tono' => 'claro' ) ); ?>
		</div>

		<!-- Columna 2: Enlaces rápidos -->
		<nav aria-labelledby="footer-enlaces">
			<h2 id="footer-enlaces" class="font-display text-lg font-semibold">
				<?php esc_html_e( 'Enlaces rápidos', 'chocolate-el-ambateno' ); ?>
			</h2>
			<ul class="mt-3 flex flex-col">
				<?php foreach ( $secciones as $id => $label ) : ?>
					<li>
						<a href="<?php echo esc_url( "{$home_url}#{$id}" ); ?>" class="<?php echo esc_attr( $enlace_clase ); ?>">
							<?php echo esc_html( $label ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<!-- Columna 3: Información -->
		<nav aria-labelledby="footer-info">
			<h2 id="footer-info" class="font-display text-lg font-semibold">
				<?php esc_html_e( 'Información', 'chocolate-el-ambateno' ); ?>
			</h2>
			<ul class="mt-3 flex flex-col">
				<li>
					<a href="<?php echo esc_url( ambateno_get_page_url( 'tienda' ) ); ?>" class="<?php echo esc_attr( $enlace_clase ); ?>">
						<?php esc_html_e( 'Tienda en línea', 'chocolate-el-ambateno' ); ?>
					</a>
				</li>
				<li>
					<button type="button" class="<?php echo esc_attr( $enlace_clase ); ?> btn-trigger-sitemap">
						<?php esc_html_e( 'Mapa del sitio', 'chocolate-el-ambateno' ); ?>
					</button>
				</li>
				<li>
					<a href="<?php echo esc_url( ambateno_get_page_url( 'terminos' ) ); ?>" class="<?php echo esc_attr( $enlace_clase ); ?>">
						<?php esc_html_e( 'Términos y condiciones', 'chocolate-el-ambateno' ); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( ambateno_get_page_url( 'privacidad' ) ); ?>" class="<?php echo esc_attr( $enlace_clase ); ?>">
						<?php esc_html_e( 'Política de privacidad', 'chocolate-el-ambateno' ); ?>
					</a>
				</li>
			</ul>
		</nav>

		<!-- Columna 4: Visítanos -->
		<div>
			<h2 class="font-display text-lg font-semibold">
				<?php esc_html_e( 'Visítanos', 'chocolate-el-ambateno' ); ?>
			</h2>
			<address class="mt-3 flex flex-col gap-2 not-italic text-crema/90">
				<span><?php echo esc_html( $direccion ); ?></span>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $telefono ) ); ?>" class="<?php echo esc_attr( $enlace_clase ); ?>">
					<?php echo esc_html( $telefono ); ?>
				</a>
				<a href="mailto:<?php echo esc_attr( $correo ); ?>" class="<?php echo esc_attr( $enlace_clase ); ?>">
					<?php echo esc_html( $correo ); ?>
				</a>
			</address>
		</div>
	</div>

	<!-- Copyright inferior -->
	<div class="border-t border-crema/15">
		<div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6 text-sm text-crema/85 sm:flex-row sm:items-center sm:justify-between sm:px-6">
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'El Ambateño · Chocolate artesanal de Ambato, Ecuador.', 'chocolate-el-ambateno' ); ?></p>
			<p><?php esc_html_e( 'Sitio de demostración: no se procesan pagos ni se envían productos reales.', 'chocolate-el-ambateno' ); ?></p>
		</div>
	</div>
</footer>
