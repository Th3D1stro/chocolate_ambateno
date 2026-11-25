<?php
/**
 * Sección 5 de Portada: Dónde encontrarlo.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$subtitulo       = get_theme_mod( 'ambateno_donde_subtitulo', 'Tiendas, cafeterías y canales online' );
$titulo          = get_theme_mod( 'ambateno_donde_titulo', 'Dónde encontrarlo' );
$establecimientos = ambateno_get_establecimientos();

$tipos = array(
	'todos'     => __( 'Todos', 'chocolate-el-ambateno' ),
	'fisica'    => __( 'Tienda física', 'chocolate-el-ambateno' ),
	'cafeteria' => __( 'Cafetería', 'chocolate-el-ambateno' ),
	'online'    => __( 'Online', 'chocolate-el-ambateno' ),
);

$etiquetas_tipo = array(
	'fisica'    => __( 'Tienda física', 'chocolate-el-ambateno' ),
	'cafeteria' => __( 'Cafetería', 'chocolate-el-ambateno' ),
	'online'    => __( 'Online', 'chocolate-el-ambateno' ),
);
?>
<section id="donde" aria-labelledby="titulo-donde" class="on-dark relative bg-burdeos pb-28 pt-16 text-crema sm:pt-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6">
		<div class="reveal flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
			<div class="max-w-2xl">
				<p class="text-lg font-semibold text-oliva">
					<?php echo esc_html( $subtitulo ); ?>
				</p>
				<h2 id="titulo-donde" class="mt-3 text-balance font-display text-4xl font-semibold sm:text-5xl">
					<?php echo esc_html( $titulo ); ?>
				</h2>
			</div>

			<!-- Botones de filtro -->
			<div role="group" aria-label="<?php esc_attr_e( 'Filtrar por tipo de establecimiento', 'chocolate-el-ambateno' ); ?>" class="flex flex-wrap gap-2" id="grupo-filtros-establecimientos">
				<?php foreach ( $tipos as $tipo_id => $tipo_label ) : 
					$activo = ( 'todos' === $tipo_id );
				?>
					<button type="button" data-filtro="<?php echo esc_attr( $tipo_id ); ?>" aria-pressed="<?php echo $activo ? 'true' : 'false'; ?>" class="btn-filtro-local min-h-11 rounded-md border-2 px-4 font-semibold transition-colors <?php echo $activo ? 'border-crema bg-crema text-burdeos' : 'border-crema/50 text-crema hover:border-crema hover:bg-burdeos-claro'; ?>">
						<?php echo esc_html( $tipo_label ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		</div>

		<p id="conteo-establecimientos" class="mt-6 text-sm text-crema/85" aria-live="polite">
			<?php echo esc_html( sprintf( __( 'Mostrando %d puntos de venta', 'chocolate-el-ambateno' ), count( $establecimientos ) ) ); ?>
		</p>

		<ul id="lista-establecimientos" class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
			<?php foreach ( $establecimientos as $e ) : 
				$icon_name = ( 'online' === $e['tipo'] ) ? 'globe' : ( ( 'cafeteria' === $e['tipo'] ) ? 'coffee' : 'store' );
				$label_tipo = isset( $etiquetas_tipo[ $e['tipo'] ] ) ? $etiquetas_tipo[ $e['tipo'] ] : $e['tipo'];
			?>
				<li data-tipo="<?php echo esc_attr( $e['tipo'] ); ?>" class="item-establecimiento flex gap-4 rounded-xl border border-crema/15 bg-burdeos-oscuro/70 p-5 transition-colors hover:border-oliva/70">
					<span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-oliva text-tinta">
						<?php ambateno_icon( $icon_name, 'h-6 w-6' ); ?>
					</span>
					<div class="flex min-w-0 flex-col gap-1">
						<h3 class="font-display text-lg font-semibold leading-snug">
							<?php echo esc_html( $e['nombre'] ); ?>
						</h3>
						<p class="inline-flex items-center gap-1.5 text-sm text-crema/90">
							<?php ambateno_icon( 'map-pin', 'h-4 w-4 shrink-0 text-crema/90' ); ?>
							<?php echo esc_html( $e['ciudad'] ); ?>
						</p>
						<p class="text-sm text-crema/85">
							<?php echo esc_html( $e['detalle'] ); ?>
						</p>
						<span class="mt-1 self-start rounded-md bg-crema px-2 py-0.5 text-xs font-semibold text-burdeos">
							<?php echo esc_html( $label_tipo ); ?>
						</span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php get_template_part( 'template-parts/wave', null, array( 'class' => 'text-crema-claro' ) ); ?>
</section>
