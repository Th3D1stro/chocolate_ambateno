<?php
/**
 * Sección 4 de Portada: Nuestra Historia.
 *
 * NOTA: Por decisión de diseño del usuario, se omite el distintivo "Texto de ejemplo · editable".
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri    = get_template_directory_uri();
$titulo       = get_theme_mod( 'ambateno_historia_titulo', 'Nuestra historia' );
$p1           = get_theme_mod( 'ambateno_historia_p1', 'El Ambateño nació en una cocina familiar de Ambato, la tierra de las flores y las frutas, donde el chocolate de taza siempre acompañó las tardes frías de la sierra. Quisimos conservar esa receta y hacerla apta para todos: sin azúcar y libre de gluten.' );
$p2           = get_theme_mod( 'ambateno_historia_p2', 'Trabajamos de la mano de INPHEC para cuidar cada etapa del proceso, desde la selección del grano hasta el empaque. ' );
$cita         = get_theme_mod( 'ambateno_historia_cita', '“Hacemos el chocolate que nos gustaría compartir con nuestra familia.”' );
$historia_img = get_theme_mod( 'ambateno_historia_imagen', $theme_uri . '/assets/img/historia-taller.webp' );

$cifras = array(
	array(
		'valor' => '2.577 m',
		'texto' => __( 'de altitud: Ambato, donde nace cada barra', 'chocolate-el-ambateno' ),
	),
	array(
		'valor' => '100 %',
		'texto' => __( 'cacao fino de aroma ecuatoriano', 'chocolate-el-ambateno' ),
	),
	array(
		'valor' => '0 g',
		'texto' => __( 'de azúcar añadida en la línea sin azúcar', 'chocolate-el-ambateno' ),
	),
);
?>
<section id="historia" aria-labelledby="titulo-historia" class="relative bg-crema pb-28 pt-16 sm:pt-24">
	<div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
		
		<figure class="reveal relative">
			<img src="<?php echo esc_url( $historia_img ); ?>" alt="<?php esc_attr_e( 'Manos de un chocolatero templando chocolate sobre mármol en un taller de Ambato', 'chocolate-el-ambateno' ); ?>" width="1024" height="1280" loading="lazy" class="aspect-[4/5] w-full rounded-xl object-cover shadow-2xl shadow-burdeos/20">

			<div class="absolute -bottom-6 -right-2 max-w-[15rem] rounded-xl bg-burdeos p-5 text-crema shadow-xl sm:-right-6">
				<p class="font-display text-4xl font-semibold">2.577 m</p>
				<p class="mt-1 text-sm text-crema/90">
					<?php esc_html_e( 'sobre el nivel del mar, en el corazón de Tungurahua', 'chocolate-el-ambateno' ); ?>
				</p>
			</div>
		</figure>

		<div class="reveal flex flex-col gap-5">
			<h2 id="titulo-historia" class="text-balance font-display text-4xl font-semibold text-burdeos sm:text-5xl">
				<?php echo esc_html( $titulo ); ?>
			</h2>

			<p class="text-pretty text-lg text-tinta/90">
				<?php echo esc_html( $p1 ); ?>
			</p>

			<p class="text-pretty text-tinta/90">
				<?php
				// Permite enfatizar INPHEC en negrita de forma segura
				echo wp_kses_post( $p2 );
				?>
			</p>

			<blockquote class="border-l-4 border-caramelo pl-5 font-display text-2xl font-medium text-burdeos text-balance">
				<?php echo esc_html( $cita ); ?>
			</blockquote>

			<dl class="mt-4 grid gap-4 sm:grid-cols-3">
				<?php foreach ( $cifras as $c ) : ?>
					<div class="rounded-lg border border-crema-oscuro bg-crema-claro p-4">
						<dt class="sr-only"><?php echo esc_html( $c['texto'] ); ?></dt>
						<dd class="font-display text-3xl font-semibold text-caramelo-oscuro">
							<?php echo esc_html( $c['valor'] ); ?>
						</dd>
						<dd class="mt-1 text-sm text-tinta/85" aria-hidden="true">
							<?php echo esc_html( $c['texto'] ); ?>
						</dd>
					</div>
				<?php endforeach; ?>
			</dl>
		</div>
	</div>

	<?php get_template_part( 'template-parts/wave', null, array( 'class' => 'text-burdeos' ) ); ?>
</section>
