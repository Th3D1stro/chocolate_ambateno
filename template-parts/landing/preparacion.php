<?php
/**
 * Sección 3 de Portada: Preparación.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri    = get_template_directory_uri();
$subtitulo    = get_theme_mod( 'ambateno_prep_subtitulo', 'Paso a paso con nuestro chef chocolatero' );
$titulo       = get_theme_mod( 'ambateno_prep_titulo', 'Preparación' );
$descripcion  = get_theme_mod( 'ambateno_prep_descripcion', 'Así preparamos en el taller el chocolate caliente de la casa. Cuatro pasos, quince minutos y una barra de 200 g para cuatro tazas.' );
$receta_texto = get_theme_mod( 'ambateno_receta_texto', '1 barra tradicional de 200 g, 1 litro de leche, 1 rama de canela y una pizca de sal. Sirve con queso fresco para la experiencia ambateña completa.' );
$chef_img     = get_theme_mod( 'ambateno_prep_chef_imagen', $theme_uri . '/assets/img/preparacion.jpg' );
$receta_img   = get_theme_mod( 'ambateno_prep_receta_imagen', $theme_uri . '/assets/img/producto-taza.webp' );

$pasos = array(
	array(
		'titulo'      => 'Ralla o trocea el chocolate',
		'descripcion' => 'Usa 50 g por taza (un cuarto de la barra de 200 g). En trozos pequeños se funde parejo y sin grumos.',
		'icono'       => 'chef-hat',
	),
	array(
		'titulo'      => 'Calienta la leche',
		'descripcion' => 'Pon 250 ml de leche o bebida vegetal a fuego medio. Retírala justo antes de que hierva.',
		'icono'       => 'flame',
	),
	array(
		'titulo'      => 'Integra y bate',
		'descripcion' => 'Añade el chocolate y bate con molinillo de 2 a 3 minutos hasta lograr una espuma cremosa.',
		'icono'       => 'cooking-pot',
	),
	array(
		'titulo'      => 'Sirve y acompaña',
		'descripcion' => 'Sírvelo caliente con queso fresco, pan de Ambato o una rama de canela, como en casa.',
		'icono'       => 'coffee',
	),
);
?>
<section id="preparacion" aria-labelledby="titulo-preparacion" class="on-dark patron-puntos-oscuro relative bg-burdeos pb-28 pt-16 text-crema sm:pt-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6">
		<div class="reveal max-w-2xl">
			<p class="text-lg font-semibold text-oliva">
				<?php echo esc_html( $subtitulo ); ?>
			</p>
			<h2 id="titulo-preparacion" class="mt-3 text-balance font-display text-4xl font-semibold sm:text-5xl">
				<?php echo esc_html( $titulo ); ?>
			</h2>
			<p class="mt-4 text-pretty text-lg text-crema/90">
				<?php echo esc_html( $descripcion ); ?>
			</p>
		</div>

		<div class="mt-12 grid gap-12 lg:grid-cols-[1fr_1.1fr] lg:items-start">
			
			<figure class="reveal lg:sticky lg:top-36">
				<img src="<?php echo esc_url( $chef_img ); ?>" alt="<?php esc_attr_e( 'Chef chocolatero con delantal burdeos rallando una barra de chocolate en una olla de cobre con leche', 'chocolate-el-ambateno' ); ?>" width="1280" height="1024" loading="lazy" class="aspect-[5/4] w-full rounded-xl object-cover shadow-2xl shadow-tinta/40">
				<figcaption class="mt-3 flex items-center gap-2 text-sm text-crema/85">
					<?php ambateno_icon( 'chef-hat', 'h-4 w-4 text-oliva' ); ?>
					<?php esc_html_e( 'Nuestro chef chocolatero en el taller de Ambato', 'chocolate-el-ambateno' ); ?>
				</figcaption>
			</figure>

			<div>
				<!-- Línea de tiempo de pasos -->
				<ol class="relative flex flex-col gap-8 before:absolute before:bottom-6 before:left-6 before:top-6 before:w-0.5 before:bg-oliva/60">
					<?php foreach ( $pasos as $i => $paso ) : ?>
						<li class="reveal relative flex gap-5">
							<span class="relative z-10 inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-oliva font-display text-xl font-bold text-tinta ring-4 ring-burdeos">
								<span class="sr-only"><?php esc_html_e( 'Paso ', 'chocolate-el-ambateno' ); ?></span>
								<?php echo esc_html( $i + 1 ); ?>
							</span>
							<div class="flex-1 rounded-lg border border-crema/15 bg-burdeos-oscuro/60 p-5">
								<div class="flex items-center gap-3">
									<?php ambateno_icon( $paso['icono'], 'h-6 w-6 text-oliva' ); ?>
									<h3 class="font-display text-xl font-semibold">
										<?php echo esc_html( $paso['titulo'] ); ?>
									</h3>
								</div>
								<p class="mt-2 text-pretty text-crema/90">
									<?php echo esc_html( $paso['descripcion'] ); ?>
								</p>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>

				<!-- Receta destacada -->
				<article class="reveal mt-12 grid overflow-hidden rounded-xl bg-crema text-tinta shadow-2xl shadow-tinta/30 sm:grid-cols-[180px_1fr]">
					<img src="<?php echo esc_url( $receta_img ); ?>" alt="<?php esc_attr_e( 'Taza de chocolate caliente espeso con canela', 'chocolate-el-ambateno' ); ?>" width="1024" height="1024" loading="lazy" class="h-48 w-full object-cover sm:h-full">

					<div class="p-6">
						<p class="text-sm font-bold uppercase tracking-wider text-caramelo-oscuro">
							<?php esc_html_e( 'Receta destacada', 'chocolate-el-ambateno' ); ?>
						</p>
						<h3 class="mt-1 font-display text-2xl font-semibold text-burdeos">
							<?php esc_html_e( 'Chocolate caliente de la casa', 'chocolate-el-ambateno' ); ?>
						</h3>
						<ul class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-sm font-medium text-burdeos">
							<li class="inline-flex items-center gap-1.5">
								<?php ambateno_icon( 'clock', 'h-4 w-4' ); ?>
								<?php esc_html_e( '15 minutos', 'chocolate-el-ambateno' ); ?>
							</li>
							<li class="inline-flex items-center gap-1.5">
								<?php ambateno_icon( 'users', 'h-4 w-4' ); ?>
								<?php esc_html_e( '4 tazas', 'chocolate-el-ambateno' ); ?>
							</li>
						</ul>
						<p class="mt-3 text-pretty text-tinta/85">
							<?php echo esc_html( $receta_texto ); ?>
						</p>
					</div>
				</article>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/wave', null, array( 'class' => 'text-crema' ) ); ?>
</section>
