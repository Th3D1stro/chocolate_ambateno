<?php
/**
 * Importación inicial de demostración y sincronización de catálogo al activar o actualizar el tema.
 *
 * Crea y mantiene sincronizados:
 * 1. Páginas Inicio (asignada como portada estática), Tienda (plantilla Tienda), Términos y Privacidad.
 * 2. 15 Productos con categorías actualizadas (Sin gluten, Sin azúcar, Express), precios, pesos, etiquetas, ingredientes y nutrición.
 * 3. 9 Puntos de venta / establecimientos (conservados intactos para uso futuro).
 * 4. Actualiza los enlaces permanentes y sincroniza datos existentes sin duplicar.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sincroniza categorías y productos en la base de datos de WordPress.
 * Lee directamente de ambateno_get_canonical_products_list() (fuente única de verdad).
 * Inserta los que falten y actualiza los existentes con sus nuevas categorías y metadatos.
 */
function ambateno_sync_catalog_data() {
	// 1. Asegurar la existencia de las categorías solicitadas
	$cats = array(
		'sin-gluten' => 'Sin gluten',
		'sin-azucar' => 'Sin azúcar',
		'express'    => 'Express',
	);
	foreach ( $cats as $slug => $nombre ) {
		if ( ! term_exists( $slug, 'categoria_producto' ) ) {
			wp_insert_term( $nombre, 'categoria_producto', array( 'slug' => $slug ) );
		}
	}

	// 2. Sincronizar desde la lista canónica de cpt-productos.php
	if ( ! function_exists( 'ambateno_get_canonical_products_list' ) ) {
		return;
	}
	$productos      = ambateno_get_canonical_products_list();
	$slugs_actuales = array();

	foreach ( $productos as $p ) {
		$slug = isset( $p['id'] ) ? $p['id'] : ( $p['slug'] ?? '' );
		if ( empty( $slug ) ) {
			continue;
		}
		$slugs_actuales[] = $slug;

		$existing = get_page_by_path( $slug, OBJECT, 'ambateno_producto' );
		if ( ! $existing ) {
			$post_id = wp_insert_post(
				array(
					'post_title'   => $p['nombre'],
					'post_name'    => $slug,
					'post_content' => $p['descripcion'],
					'post_status'  => 'publish',
					'post_type'    => 'ambateno_producto',
				)
			);
		} else {
			$post_id = $existing->ID;
			wp_update_post(
				array(
					'ID'           => $post_id,
					'post_title'   => $p['nombre'],
					'post_content' => $p['descripcion'],
					'post_status'  => 'publish',
				)
			);
		}

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_ambateno_precio', $p['precio'] );
			update_post_meta( $post_id, '_ambateno_peso', $p['peso'] );
			$tags_str = is_array( $p['etiquetas'] ) ? implode( ', ', $p['etiquetas'] ) : ( $p['etiquetas'] ?? '' );
			update_post_meta( $post_id, '_ambateno_etiquetas', $tags_str );
			update_post_meta( $post_id, '_ambateno_ingredientes', $p['ingredientes'] ?? '' );

			if ( is_array( $p['nutricion'] ) ) {
				$n         = $p['nutricion'];
				$nutri_str = "Porción: " . ( $n['porcion'] ?? '25 g' ) . "\n"
					. "Energía: " . ( $n['energia'] ?? '140 kcal' ) . "\n"
					. "Grasas: " . ( $n['grasas'] ?? '11 g' ) . "\n"
					. "Carbohidratos: " . ( $n['carbohidratos'] ?? '7 g' ) . "\n"
					. "Azúcares: " . ( $n['azucares'] ?? '0 g' ) . "\n"
					. "Proteína: " . ( $n['proteina'] ?? '3 g' );
				update_post_meta( $post_id, '_ambateno_nutricion', $nutri_str );
			} elseif ( ! empty( $p['nutricion'] ) ) {
				update_post_meta( $post_id, '_ambateno_nutricion', $p['nutricion'] );
			}

			$img_val = isset( $p['imagen'] ) ? basename( $p['imagen'] ) : 'producto-barra.webp';
			update_post_meta( $post_id, '_ambateno_fallback_img', $img_val );

			$cats_arr = isset( $p['categorias'] ) ? $p['categorias'] : ( $p['cats'] ?? array( 'sin-gluten' ) );
			wp_set_object_terms( $post_id, $cats_arr, 'categoria_producto', false );
		}
	}

	// Despublicar posts antiguos que ya no están en el array de productos
	$old_posts = get_posts(
		array(
			'post_type'      => 'ambateno_producto',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		)
	);
	foreach ( $old_posts as $old ) {
		if ( ! in_array( $old->post_name, $slugs_actuales, true ) ) {
			wp_update_post(
				array(
					'ID'          => $old->ID,
					'post_status' => 'draft',
				)
			);
		}
	}

	$current_hash = md5( wp_json_encode( $productos ) );
	update_option( 'ambateno_catalog_data_hash', $current_hash );
	update_option( 'ambateno_catalog_version', defined( 'AMBATENO_CATALOG_VERSION' ) ? AMBATENO_CATALOG_VERSION : '2.0.0' );
}

/**
 * Verifica si la base de datos requiere sincronización al iniciar WordPress.
 * Si el array canónico de cpt-productos.php cambió de contenido, sincroniza de inmediato.
 */
function ambateno_check_catalog_sync() {
	if ( ! function_exists( 'ambateno_get_canonical_products_list' ) ) {
		return;
	}
	$productos    = ambateno_get_canonical_products_list();
	$current_hash = md5( wp_json_encode( $productos ) );
	$saved_hash   = get_option( 'ambateno_catalog_data_hash' );

	if ( $saved_hash !== $current_hash ) {
		ambateno_sync_catalog_data();
	}
}
add_action( 'init', 'ambateno_check_catalog_sync', 20 );

/**
 * Proceso completo de importación inicial al activar el tema.
 */
function ambateno_run_demo_import() {
	// 1. Crear Página Inicio
	$inicio = get_page_by_path( 'inicio' );
	if ( ! $inicio ) {
		$inicio_id = wp_insert_post(
			array(
				'post_title'   => 'Inicio',
				'post_name'    => 'inicio',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
	} else {
		$inicio_id = $inicio->ID;
	}

	// Asignar "Inicio" como portada estática
	if ( $inicio_id && ! is_wp_error( $inicio_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $inicio_id );
	}

	// 2. Crear Página Tienda
	$tienda = get_page_by_path( 'tienda' );
	if ( ! $tienda ) {
		$tienda_id = wp_insert_post(
			array(
				'post_title'   => 'Tienda',
				'post_name'    => 'tienda',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $tienda_id && ! is_wp_error( $tienda_id ) ) {
			update_post_meta( $tienda_id, '_wp_page_template', 'page-tienda.php' );
		}
	} else {
		update_post_meta( $tienda->ID, '_wp_page_template', 'page-tienda.php' );
	}

	// 3. Crear Página Términos y Condiciones
	$terminos = get_page_by_path( 'terminos' );
	if ( ! $terminos ) {
		$contenido_terminos = "<p>Este sitio es un proyecto de demostración. No se procesan pagos, no se almacenan datos de tarjetas y no se envían productos reales.</p>
<h2>Uso del sitio</h2>
<p>El contenido, las imágenes y la identidad visual pertenecen a El Ambateño. Puedes navegar, consultar productos y simular compras libremente.</p>
<h2>Precios y disponibilidad</h2>
<p>Los precios mostrados son referenciales, están expresados en dólares estadounidenses y no incluyen IVA hasta el paso de pago.</p>
<h2>Envíos y devoluciones</h2>
<p>Los tiempos de entrega indicados son estimados y dependen del destino dentro de Ecuador continental.</p>";

		wp_insert_post(
			array(
				'post_title'   => 'Términos y condiciones',
				'post_name'    => 'terminos',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => $contenido_terminos,
			)
		);
	}

	// 4. Crear Página Política de Privacidad
	$privacidad = get_page_by_path( 'privacidad' );
	if ( ! $privacidad ) {
		$contenido_privacidad = "<p>En este sitio de demostración ningún dato que escribas en los formularios se envía a un servidor.</p>
<h2>Datos que guardamos</h2>
<p>Solo el contenido de tu carrito se guarda en el almacenamiento local de tu navegador para que no lo pierdas al recargar la página. Puedes borrarlo vaciando el carrito.</p>
<h2>Tus derechos</h2>
<p>Cuando la tienda sea real, podrás solicitar el acceso, la rectificación o la eliminación de tus datos escribiendo a chocolateelambatenio@gmail.com, conforme a la Ley Orgánica de Protección de Datos Personales del Ecuador.</p>";

		wp_insert_post(
			array(
				'post_title'   => 'Política de privacidad',
				'post_name'    => 'privacidad',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => $contenido_privacidad,
			)
		);
	}

	// 5. Sincronizar catálogo y productos
	ambateno_sync_catalog_data();

	// 6. Puntos de Venta (9 establecimientos conservados intactos)
	$locales = array(
		array(
			'nombre'  => 'Taller y tienda El Ambateño',
			'ciudad'  => 'Ambato',
			'tipo'    => 'fisica',
			'detalle' => 'Lun a sáb · 09:00 a 19:00',
		),
		array(
			'nombre'  => 'Mercado Central, puesto 42',
			'ciudad'  => 'Ambato',
			'tipo'    => 'fisica',
			'detalle' => 'Todos los días · 07:00 a 17:00',
		),
		array(
			'nombre'  => 'Café Los Andes',
			'ciudad'  => 'Ambato',
			'tipo'    => 'cafeteria',
			'detalle' => 'Chocolate caliente de la casa',
		),
		array(
			'nombre'  => 'Cafetería Tungurahua',
			'ciudad'  => 'Baños de Agua Santa',
			'tipo'    => 'cafeteria',
			'detalle' => 'Barras y tazas para llevar',
		),
		array(
			'nombre'  => 'Despensa Saludable',
			'ciudad'  => 'Quito',
			'tipo'    => 'fisica',
			'detalle' => 'Línea sin azúcar y sin gluten',
		),
		array(
			'nombre'  => 'Supermercado La Merced',
			'ciudad'  => 'Latacunga',
			'tipo'    => 'fisica',
			'detalle' => 'Pasillo de productos locales',
		),
		array(
			'nombre'  => 'Casa del Cacao',
			'ciudad'  => 'Riobamba',
			'tipo'    => 'cafeteria',
			'detalle' => 'Catas los viernes por la tarde',
		),
		array(
			'nombre'  => 'Tienda online El Ambateño',
			'ciudad'  => 'Envíos a todo Ecuador',
			'tipo'    => 'online',
			'detalle' => 'Entrega en hasta 48 h',
		),
		array(
			'nombre'  => 'Mercado Andino (marketplace)',
			'ciudad'  => 'Cobertura nacional',
			'tipo'    => 'online',
			'detalle' => 'Pago contra entrega disponible',
		),
	);

	foreach ( $locales as $loc ) {
		$check = get_page_by_title( $loc['nombre'], OBJECT, 'ambateno_tienda' );
		if ( ! $check ) {
			$loc_id = wp_insert_post(
				array(
					'post_title'  => $loc['nombre'],
					'post_status' => 'publish',
					'post_type'   => 'ambateno_tienda',
				)
			);
			if ( $loc_id && ! is_wp_error( $loc_id ) ) {
				update_post_meta( $loc_id, '_ambateno_ciudad', $loc['ciudad'] );
				update_post_meta( $loc_id, '_ambateno_tipo', $loc['tipo'] );
				update_post_meta( $loc_id, '_ambateno_detalle', $loc['detalle'] );
			}
		}
	}

	// 7. Reescritura de enlaces permanentes
	flush_rewrite_rules();

	// Marcar importación como realizada
	update_option( 'ambateno_demo_data_imported', 1 );
}
add_action( 'after_switch_theme', 'ambateno_run_demo_import' );
