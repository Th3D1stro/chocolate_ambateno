<?php
/**
 * Sección 1 de Portada: Hero.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri   = get_template_directory_uri();
$badge       = get_theme_mod( 'ambateno_hero_badge', 'Hecho a mano en Ambato, Ecuador' );
$titulo      = get_theme_mod( 'ambateno_hero_titulo', 'Chocolate artesanal con sabor tradicional' );
$descripcion = get_theme_mod( 'ambateno_hero_descripcion', 'Cacao fino de aroma ecuatoriano en una barra tradicional de 200 g, sin azúcar y libre de gluten, hecha para compartir en familia.' );
$hero_img    = get_theme_mod( 'ambateno_hero_imagen', $theme_uri . '/assets/img/portada.jpg' );
$btn1_texto  = get_theme_mod( 'ambateno_hero_btn1_texto', 'Ver productos' );
$btn1_url    = get_theme_mod( 'ambateno_hero_btn1_url' );
$tienda_url  = ! empty( $btn1_url ) ? $btn1_url : ambateno_get_page_url( 'tienda' );
$btn2_texto  = get_theme_mod( 'ambateno_hero_btn2_texto', 'Conoce nuestra historia' );
$btn2_url    = get_theme_mod( 'ambateno_hero_btn2_url', '#historia' );
?>
<section id="inicio" aria-labelledby="titulo-inicio" class="on-dark relative isolate flex min-h-[86vh] items-center overflow-hidden pb-20 pt-16">
	<!-- Imagen de fondo con carga prioritaria -->
	<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php esc_attr_e( 'Barra de chocolate artesanal partida junto a mazorcas y granos de cacao sobre madera', 'chocolate-el-ambateno' ); ?>" width="1792" height="1024" fetchpriority="high" class="absolute inset-0 -z-20 h-full w-full object-cover">

	<!-- Overlay burdeos: asegura > 7:1 para el texto crema sobre la foto -->
	<div class="absolute inset-0 -z-10 bg-linear-to-r from-burdeos via-burdeos/90 to-burdeos/45" aria-hidden="true"></div>

	<div class="mx-auto w-full max-w-7xl px-4 sm:px-6">
		<div class="reveal flex max-w-2xl flex-col gap-6 text-crema">
			
			<p class="inline-flex items-center gap-2 self-start rounded-md border border-crema/35 bg-burdeos-oscuro/50 px-3 py-1.5 text-sm font-medium">
				<?php ambateno_icon( 'map-pin', 'h-4 w-4 text-oliva' ); ?>
				<?php echo esc_html( $badge ); ?>
			</p>

			<h1 id="titulo-inicio" class="text-balance font-display text-4xl font-semibold leading-[1.05] sm:text-5xl lg:text-6xl xl:text-7xl">
				<?php echo esc_html( $titulo ); ?>
			</h1>

			<p class="max-w-xl text-pretty text-lg text-crema/95 sm:text-xl">
				<?php echo esc_html( $descripcion ); ?>
			</p>

			<div class="flex flex-wrap gap-2">
				<span class="inline-flex items-center gap-1 rounded-md bg-oliva px-2 py-0.5 text-xs font-semibold text-tinta"><?php esc_html_e( 'Sin azúcar', 'chocolate-el-ambateno' ); ?></span>
				<span class="inline-flex items-center gap-1 rounded-md bg-oliva px-2 py-0.5 text-xs font-semibold text-tinta"><?php esc_html_e( 'Libre de gluten', 'chocolate-el-ambateno' ); ?></span>
				<span class="inline-flex items-center gap-1 rounded-md bg-oliva px-2 py-0.5 text-xs font-semibold text-tinta">200 g</span>
			</div>

			<div class="mt-2 flex flex-col gap-3 xs:flex-row">
				<a href="<?php echo esc_url( $tienda_url ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-crema px-6 py-2.5 text-base font-semibold text-burdeos transition-colors duration-200 hover:bg-crema-claro active:bg-crema-oscuro">
					<?php echo esc_html( $btn1_texto ); ?>
					<?php ambateno_icon( 'arrow-right', 'h-5 w-5' ); ?>
				</a>
				<a href="<?php echo esc_url( $btn2_url ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-crema px-6 py-2.5 text-base font-semibold text-crema transition-colors duration-200 hover:bg-crema hover:text-burdeos">
					<?php echo esc_html( $btn2_texto ); ?>
				</a>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/wave', null, array( 'class' => 'text-crema-claro' ) ); ?>
</section>
