<?php
/**
 * Sección 2 de Portada: Nuestro Chocolate.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri     = get_template_directory_uri();
$subtitulo     = get_theme_mod( 'ambateno_chocolate_subtitulo', 'Una barra, tres maneras de disfrutarla' );
$titulo        = get_theme_mod( 'ambateno_chocolate_titulo', 'Nuestro chocolate' );
$descripcion   = get_theme_mod( 'ambateno_chocolate_descripcion', 'Todas nuestras presentaciones pesan 200 g y nacen del mismo cacao fino de aroma, tostado lento y molido en piedra en nuestro taller de Ambato.' );
$chocolate_img = get_theme_mod( 'ambateno_chocolate_imagen', $theme_uri . '/assets/img/producto-barra.webp' );
$btn_texto     = get_theme_mod( 'ambateno_chocolate_btn_texto', 'Comprar ahora' );
$btn_url       = get_theme_mod( 'ambateno_chocolate_btn_url' );
$tienda_url    = ! empty( $btn_url ) ? $btn_url : ambateno_get_page_url( 'tienda' );

$presentaciones = array(
	array(
		'id'          => 'tradicional',
		'nombre'      => 'Tradicional',
		'descripcion' => 'La receta de siempre: cacao fino de aroma molido en piedra y moldeado a mano. Perfecto para la taza de la tarde.',
		'insignias'   => array( '200 g', 'Receta original' ),
		'icono'       => 'award',
	),
	array(
		'id'          => 'sin-gluten',
		'nombre'      => 'Libre de gluten',
		'descripcion' => 'Elaborado en una línea separada y verificada, para que nadie en la mesa se quede sin su chocolate.',
		'insignias'   => array( '200 g', 'Libre de gluten' ),
		'icono'       => 'wheat-off',
	),
	array(
		'id'          => 'sin-azucar',
		'nombre'      => 'Sin azúcar',
		'descripcion' => 'Endulzado solo con el sabor natural del cacao y un toque de stevia. Todo el carácter, cero azúcar añadida.',
		'insignias'   => array( '200 g', 'Sin azúcar' ),
		'icono'       => 'candy-off',
	),
);
?>
<section id="chocolate" aria-labelledby="titulo-chocolate" class="patron-puntos relative bg-crema-claro pb-28 pt-16 sm:pt-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6">
		<div class="grid items-center gap-10 lg:grid-cols-2">
			
			<div class="reveal flex flex-col gap-4">
				<p class="text-lg font-semibold text-caramelo">
					<?php echo esc_html( $subtitulo ); ?>
				</p>
				<h2 id="titulo-chocolate" class="text-balance font-display text-4xl font-semibold text-burdeos sm:text-5xl">
					<?php echo esc_html( $titulo ); ?>
				</h2>
				<p class="max-w-lg text-pretty text-lg text-tinta/85">
					<?php echo esc_html( $descripcion ); ?>
				</p>
				<a href="<?php echo esc_url( $tienda_url ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta mt-2 self-start">
					<?php echo esc_html( $btn_texto ); ?>
					<?php ambateno_icon( 'arrow-right', 'h-5 w-5' ); ?>
				</a>
			</div>

			<figure class="reveal relative">
				<img src="<?php echo esc_url( $chocolate_img ); ?>" alt="<?php esc_attr_e( 'Barra de chocolate El Ambateño de 200 g envuelta en papel burdeos', 'chocolate-el-ambateno' ); ?>" width="1024" height="1024" loading="lazy" class="aspect-[4/3] w-full rounded-xl object-cover shadow-xl shadow-burdeos/15">
				<figcaption class="absolute -bottom-5 left-5 rounded-md bg-burdeos px-4 py-2 font-display text-lg font-semibold text-crema shadow-lg">
					<?php esc_html_e( 'Presentación tradicional · 200 g', 'chocolate-el-ambateno' ); ?>
				</figcaption>
			</figure>
		</div>

		<!-- 3 Presentaciones -->
		<ul class="mt-20 grid gap-6 md:grid-cols-3">
			<?php foreach ( $presentaciones as $p ) : ?>
				<li class="reveal">
					<article class="flex h-full flex-col gap-4 rounded-xl border border-crema-oscuro bg-white/80 p-6 shadow-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-burdeos/10">
						<span class="inline-flex h-14 w-14 items-center justify-center rounded-lg bg-oliva-claro text-burdeos">
							<?php ambateno_icon( $p['icono'], 'h-7 w-7' ); ?>
						</span>
						<h3 class="font-display text-2xl font-semibold text-burdeos">
							<?php echo esc_html( $p['nombre'] ); ?>
						</h3>
						<p class="text-pretty text-tinta/85">
							<?php echo esc_html( $p['descripcion'] ); ?>
						</p>
						<div class="mt-auto flex flex-wrap gap-2 pt-2">
							<?php foreach ( $p['insignias'] as $insignia ) : ?>
								<span class="inline-flex items-center gap-1 rounded-md bg-oliva px-2 py-0.5 text-xs font-semibold text-tinta"><?php echo esc_html( $insignia ); ?></span>
							<?php endforeach; ?>
						</div>
					</article>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php get_template_part( 'template-parts/wave', null, array( 'class' => 'text-burdeos' ) ); ?>
</section>
