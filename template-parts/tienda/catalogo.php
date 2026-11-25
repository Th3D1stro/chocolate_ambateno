<?php
/**
 * Catálogo de la tienda: Buscador, filtros de categoría, ordenación y cuadrícula.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categorias = array(
	'todo'        => __( 'Ver todo', 'chocolate-el-ambateno' ),
	'sin-gluten'  => __( 'Sin gluten', 'chocolate-el-ambateno' ),
	'sin-azucar'  => __( 'Sin azúcar', 'chocolate-el-ambateno' ),
	'express'     => __( 'Express', 'chocolate-el-ambateno' ),
);
?>
<section aria-labelledby="titulo-catalogo" class="flex flex-col gap-6">
	<div id="inicio-catalogo" class="scroll-mt-36">
		<h2 id="titulo-catalogo" class="sr-only">
			<?php esc_html_e( 'Catálogo de productos', 'chocolate-el-ambateno' ); ?>
		</h2>

		<!-- Barra superior del catálogo -->
		<div class="flex flex-col gap-4 rounded-xl border border-crema-oscuro bg-white/80 p-4">
			<div class="flex flex-col gap-3 md:flex-row">
				<!-- Buscador -->
				<div class="relative flex-1">
					<label for="buscar-producto" class="sr-only"><?php esc_html_e( 'Buscar productos', 'chocolate-el-ambateno' ); ?></label>
					<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-burdeos/70">
						<?php ambateno_icon( 'search', 'h-5 w-5' ); ?>
					</span>
					<input id="buscar-producto" type="search" placeholder="<?php esc_attr_e( 'Buscar por nombre, ej. rosas', 'chocolate-el-ambateno' ); ?>" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white pl-10 pr-12 text-tinta placeholder:text-tinta/50 transition-colors hover:border-burdeos/45 focus-visible:border-burdeos [&::-webkit-search-cancel-button]:hidden" />
					<button type="button" id="btn-limpiar-busqueda" class="hidden absolute right-0.5 top-1/2 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-md text-burdeos hover:bg-crema" aria-label="<?php esc_attr_e( 'Limpiar búsqueda', 'chocolate-el-ambateno' ); ?>">
						<?php ambateno_icon( 'x', 'h-5 w-5' ); ?>
					</button>
				</div>

				<!-- Ordenar por -->
				<div class="flex items-center gap-2 md:w-60">
					<label for="ordenar-productos" class="shrink-0 text-sm font-semibold text-burdeos"><?php esc_html_e( 'Ordenar por', 'chocolate-el-ambateno' ); ?></label>
					<select id="ordenar-productos" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos">
						<option value="relevancia"><?php esc_html_e( 'Destacados', 'chocolate-el-ambateno' ); ?></option>
						<option value="precio-asc"><?php esc_html_e( 'Precio: menor a mayor', 'chocolate-el-ambateno' ); ?></option>
						<option value="precio-desc"><?php esc_html_e( 'Precio: mayor a menor', 'chocolate-el-ambateno' ); ?></option>
						<option value="nombre"><?php esc_html_e( 'Nombre (A-Z)', 'chocolate-el-ambateno' ); ?></option>
					</select>
				</div>
			</div>

			<!-- Filtro por categoría -->
			<div role="group" aria-label="<?php esc_attr_e( 'Filtrar por categoría', 'chocolate-el-ambateno' ); ?>" class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1" id="grupo-filtros-categorias">
				<?php foreach ( $categorias as $cat_id => $cat_label ) : 
					$activo = ( 'todo' === $cat_id );
				?>
					<button type="button" data-categoria="<?php echo esc_attr( $cat_id ); ?>" aria-pressed="<?php echo $activo ? 'true' : 'false'; ?>" class="btn-filtro-categoria min-h-11 shrink-0 rounded-md border-2 px-4 text-sm font-semibold transition-colors <?php echo $activo ? 'border-burdeos bg-burdeos text-crema' : 'border-burdeos/25 text-burdeos hover:border-burdeos hover:bg-crema'; ?>">
						<?php echo esc_html( $cat_label ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Contador de resultados -->
	<p id="conteo-productos" class="text-sm text-tinta/80" aria-live="polite">
		<?php esc_html_e( 'Cargando catálogo…', 'chocolate-el-ambateno' ); ?>
	</p>

	<!-- Estado vacío cuando no hay resultados -->
	<div id="catalogo-vacio" class="hidden flex flex-col items-center gap-4 rounded-xl border-2 border-dashed border-crema-oscuro bg-white/60 px-6 py-14 text-center">
		<?php ambateno_icon( 'search-x', 'h-12 w-12 text-caramelo' ); ?>
		<p class="font-display text-2xl font-semibold text-burdeos">
			<?php esc_html_e( 'Sin resultados', 'chocolate-el-ambateno' ); ?>
		</p>
		<p id="catalogo-vacio-texto" class="max-w-sm text-pretty text-tinta/80">
			<?php esc_html_e( 'No encontramos productos en esta categoría. Prueba con otra palabra.', 'chocolate-el-ambateno' ); ?>
		</p>
		<button type="button" id="btn-reset-filtros" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-5 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema">
			<?php esc_html_e( 'Limpiar filtros', 'chocolate-el-ambateno' ); ?>
		</button>
	</div>

	<!-- Grilla de productos (generada dinámicamente por JavaScript con los datos de WordPress) -->
	<ul id="grilla-productos" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3"></ul>

	<!-- Paginación -->
	<nav id="paginacion-catalogo" aria-label="<?php esc_attr_e( 'Paginación del catálogo', 'chocolate-el-ambateno' ); ?>" class="hidden flex flex-wrap items-center justify-center gap-2">
		<button type="button" id="btn-pagina-anterior" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-3 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema disabled:cursor-not-allowed disabled:opacity-50">
			<?php ambateno_icon( 'chevron-left', 'h-5 w-5' ); ?>
			<?php esc_html_e( 'Anterior', 'chocolate-el-ambateno' ); ?>
		</button>
		<ul id="lista-paginas-numeros" class="flex gap-1"></ul>
		<button type="button" id="btn-pagina-siguiente" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-3 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema disabled:cursor-not-allowed disabled:opacity-50">
			<?php esc_html_e( 'Siguiente', 'chocolate-el-ambateno' ); ?>
			<?php ambateno_icon( 'chevron-right', 'h-5 w-5' ); ?>
		</button>
	</nav>
</section>
