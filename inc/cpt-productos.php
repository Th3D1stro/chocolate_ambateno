<?php
/**
 * Tipo de contenido personalizado: Productos (ambateno_producto) y taxonomía de categorías.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_register_cpt_productos() {
	$labels = array(
		'name'               => _x( 'Productos', 'post type general name', 'chocolate-el-ambateno' ),
		'singular_name'      => _x( 'Producto', 'post type singular name', 'chocolate-el-ambateno' ),
		'menu_name'          => _x( 'Productos Cacao', 'admin menu', 'chocolate-el-ambateno' ),
		'name_admin_bar'     => _x( 'Producto', 'add new on admin bar', 'chocolate-el-ambateno' ),
		'add_new'            => _x( 'Añadir nuevo', 'producto', 'chocolate-el-ambateno' ),
		'add_new_item'       => __( 'Añadir nuevo producto', 'chocolate-el-ambateno' ),
		'new_item'           => __( 'Nuevo producto', 'chocolate-el-ambateno' ),
		'edit_item'          => __( 'Editar producto', 'chocolate-el-ambateno' ),
		'view_item'          => __( 'Ver producto', 'chocolate-el-ambateno' ),
		'all_items'          => __( 'Todos los productos', 'chocolate-el-ambateno' ),
		'search_items'       => __( 'Buscar productos', 'chocolate-el-ambateno' ),
		'not_found'          => __( 'No se encontraron productos.', 'chocolate-el-ambateno' ),
		'not_found_in_trash' => __( 'No hay productos en la papelera.', 'chocolate-el-ambateno' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'producto' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-cart',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'ambateno_producto', $args );

	// Taxonomía de categorías para productos
	$tax_labels = array(
		'name'              => _x( 'Categorías', 'taxonomy general name', 'chocolate-el-ambateno' ),
		'singular_name'     => _x( 'Categoría', 'taxonomy singular name', 'chocolate-el-ambateno' ),
		'search_items'      => __( 'Buscar categorías', 'chocolate-el-ambateno' ),
		'all_items'         => __( 'Todas las categorías', 'chocolate-el-ambateno' ),
		'edit_item'         => __( 'Editar categoría', 'chocolate-el-ambateno' ),
		'update_item'       => __( 'Actualizar categoría', 'chocolate-el-ambateno' ),
		'add_new_item'      => __( 'Añadir nueva categoría', 'chocolate-el-ambateno' ),
		'new_item_name'     => __( 'Nombre de la nueva categoría', 'chocolate-el-ambateno' ),
		'menu_name'         => __( 'Categorías', 'chocolate-el-ambateno' ),
	);

	register_taxonomy(
		'categoria_producto',
		array( 'ambateno_producto' ),
		array(
			'hierarchical'      => true,
			'labels'            => $tax_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'categoria-producto' ),
			'show_in_rest'      => true,
		)
	);
}
add_action( 'init', 'ambateno_register_cpt_productos' );

/**
 * Meta boxes para datos del producto.
 */
function ambateno_add_producto_meta_boxes() {
	add_meta_box(
		'ambateno_producto_detalles',
		__( 'Detalles del Producto y Nutrición', 'chocolate-el-ambateno' ),
		'ambateno_render_producto_meta_box',
		'ambateno_producto',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ambateno_add_producto_meta_boxes' );

function ambateno_render_producto_meta_box( $post ) {
	wp_nonce_field( 'ambateno_save_producto_meta', 'ambateno_producto_nonce' );

	$precio       = get_post_meta( $post->ID, '_ambateno_precio', true );
	$peso         = get_post_meta( $post->ID, '_ambateno_peso', true );
	$etiquetas    = get_post_meta( $post->ID, '_ambateno_etiquetas', true );
	$ingredientes = get_post_meta( $post->ID, '_ambateno_ingredientes', true );
	$nutricion    = get_post_meta( $post->ID, '_ambateno_nutricion', true );

	if ( empty( $nutricion ) ) {
		$nutricion = "Porción: 25 g\nEnergía: 140 kcal\nGrasas: 11 g\nCarbohidratos: 7 g\nAzúcares: 0 g\nProteína: 3 g";
	}
	?>
	<table class="form-table">
		<tr>
			<th><label for="ambateno_precio"><?php esc_html_e( 'Precio en dólares ($)', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<input type="number" step="0.01" min="0" name="ambateno_precio" id="ambateno_precio" value="<?php echo esc_attr( $precio ); ?>" class="regular-text" placeholder="6.50" required />
			</td>
		</tr>
		<tr>
			<th><label for="ambateno_peso"><?php esc_html_e( 'Peso / Presentación', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<input type="text" name="ambateno_peso" id="ambateno_peso" value="<?php echo esc_attr( $peso ); ?>" class="regular-text" placeholder="200 g" />
			</td>
		</tr>
		<tr>
			<th><label for="ambateno_etiquetas"><?php esc_html_e( 'Etiquetas (separadas por comas)', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<input type="text" name="ambateno_etiquetas" id="ambateno_etiquetas" value="<?php echo esc_attr( $etiquetas ); ?>" class="large-text" placeholder="Sin azúcar, Libre de gluten, Vegano" />
			</td>
		</tr>
		<tr>
			<th><label for="ambateno_ingredientes"><?php esc_html_e( 'Ingredientes', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<textarea name="ambateno_ingredientes" id="ambateno_ingredientes" rows="3" class="large-text" placeholder="Pasta de cacao, manteca de cacao, stevia..."><?php echo esc_textarea( $ingredientes ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th>
				<label for="ambateno_nutricion"><?php esc_html_e( 'Información Nutricional', 'chocolate-el-ambateno' ); ?></label>
				<p class="description"><?php esc_html_e( 'Un campo por línea en formato Clave: Valor.', 'chocolate-el-ambateno' ); ?></p>
			</th>
			<td>
				<textarea name="ambateno_nutricion" id="ambateno_nutricion" rows="6" class="large-text code"><?php echo esc_textarea( $nutricion ); ?></textarea>
			</td>
		</tr>
	</table>
	<?php
}

function ambateno_save_producto_meta( $post_id ) {
	if ( ! isset( $_POST['ambateno_producto_nonce'] ) || ! wp_verify_nonce( $_POST['ambateno_producto_nonce'], 'ambateno_save_producto_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['ambateno_precio'] ) ) {
		update_post_meta( $post_id, '_ambateno_precio', floatval( $_POST['ambateno_precio'] ) );
	}
	if ( isset( $_POST['ambateno_peso'] ) ) {
		update_post_meta( $post_id, '_ambateno_peso', sanitize_text_field( $_POST['ambateno_peso'] ) );
	}
	if ( isset( $_POST['ambateno_etiquetas'] ) ) {
		update_post_meta( $post_id, '_ambateno_etiquetas', sanitize_text_field( $_POST['ambateno_etiquetas'] ) );
	}
	if ( isset( $_POST['ambateno_ingredientes'] ) ) {
		update_post_meta( $post_id, '_ambateno_ingredientes', sanitize_textarea_field( $_POST['ambateno_ingredientes'] ) );
	}
	if ( isset( $_POST['ambateno_nutricion'] ) ) {
		update_post_meta( $post_id, '_ambateno_nutricion', sanitize_textarea_field( $_POST['ambateno_nutricion'] ) );
	}
}
add_action( 'save_post_ambateno_producto', 'ambateno_save_producto_meta' );

/**
 * Lista canónica de productos definidos en el código del tema.
 * Puedes agregar, quitar o modificar productos directamente en este array.
 * Cualquier cambio se reflejará de inmediato en el catálogo de la tienda
 * y se sincronizará automáticamente con la base de datos de WordPress.
 *
 * @return array
 */
function ambateno_get_canonical_products_list() {
	$theme_uri     = get_template_directory_uri();
	$nutri_default = array(
		'porcion'       => '25 g',
		'energia'       => '140 kcal',
		'grasas'        => '11 g',
		'carbohidratos' => '7 g',
		'azucares'      => '0 g',
		'proteina'      => '3 g',
	);

	return array(
		array(
			'id'           => 'tradicional-200',
			'nombre'       => 'Chocolate tradicional El Ambateño 200 g',
			'descripcion'  => 'Nuestra barra insignia: cacao fino de aroma molido en piedra, ideal para taza o para comer en cuadros.',
			'precio'       => 6.50,
			'peso'         => '200 g',
			'imagen'       => $theme_uri . '/assets/img/productos/producto1.jpg',
			'alt'          => 'Chocolate tradicional El Ambateño 200 g',
			'categorias'   => array( 'sin-gluten', 'sin-azucar', 'express' ),
			'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten', 'Express' ),
			'ingredientes' => 'Pasta de cacao, manteca de cacao, stevia, canela.',
			'nutricion'    => $nutri_default,
		),
		array(
			'id'           => 'tradicional-200-libre-gluten',
			'nombre'       => 'Chocolate tradicional El Ambateño 200 g, Libre de Gluten',
			'descripcion'  => 'Nuestra barra insignia ahora sin gluten',
			'precio'       => 8.75,
			'peso'         => '200 g',
			'imagen'       => $theme_uri . '/assets/img/productos/producto2.jpg',
			'alt'          => 'Chocolate tradicional El Ambateño 200 g, sin gluten',
			'categorias'   => array( 'sin-gluten', 'express' ),
			'etiquetas'    => array( 'Libre de gluten', 'Express' ),
			'ingredientes' => 'Pasta de cacao, manteca de cacao, stevia, canela.',
			'nutricion'    => array_merge( $nutri_default, array( 'energia' => '150 kcal', 'grasas' => '12 g' ) ),
		),
		array(
			'id'           => 'tradicional-200-sin-azucar',
			'nombre'       => 'Chocolate tradicional El Ambateño 200 g. Sin Azucar',
			'descripcion'  => 'Nuestra barra tradicional ahora sin azucar',
			'precio'       => 4.75,
			'peso'         => '200 g',
			'imagen'       => $theme_uri . '/assets/img/productos/producto3.jpg',
			'alt'          => 'Barra 70% Cacao Puro, sin azúcar',
			'categorias'   => array( 'sin-azucar', 'express' ),
			'etiquetas'    => array( 'Sin azúcar', 'Express' ),
			'ingredientes' => 'Pasta de cacao (70 %), manteca de cacao, eritritol.',
			'nutricion'    => $nutri_default,
		),
		// ===================== CHOCOLATE EXPRESS (MICROONDAS) =====================
array(
	'id'           => 'express-150',
	'nombre'       => 'Chocolate Express 150 g',
	'descripcion'  => 'El sabor de siempre, ahora a tu ritmo. Chocolate para microondas.',
	'precio'       => 3.50,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-150.jpg',
	'alt'          => 'Chocolate Express 150 g',
	'categorias'   => array( 'express' ),
	'etiquetas'    => array( 'Express', 'Microondas' ),
	'ingredientes' => 'Pasta de cacao, azúcar, manteca de cacao, canela, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-150-libre-gluten',
	'nombre'       => 'Chocolate Express 150 g, Libre de Gluten',
	'descripcion'  => 'Chocolate para microondas, sin gluten.',
	'precio'       => 4.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-150-libre-gluten.png',
	'alt'          => 'Chocolate Express 150 g, libre de gluten',
	'categorias'   => array( 'express', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Libre de gluten' ),
	'ingredientes' => 'Pasta de cacao, azúcar, manteca de cacao, canela, lecitina de girasol. Libre de gluten.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-150-sin-azucar',
	'nombre'       => 'Chocolate Express 150 g, Sin Azúcar',
	'descripcion'  => 'Chocolate para microondas, sin azúcar.',
	'precio'       => 3.25,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-150-sin-azucar.jpg',
	'alt'          => 'Chocolate Express 150 g, sin azúcar',
	'categorias'   => array( 'express', 'sin-azucar' ),
	'etiquetas'    => array( 'Express', 'Sin azúcar' ),
	'ingredientes' => 'Pasta de cacao, manteca de cacao, stevia, canela, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),

// ===================== CHOCOLATE DE SABORES =====================
array(
	'id'           => 'express-maracuya-150',
	'nombre'       => 'Chocolate Express sabor Maracuyá 150 g',
	'descripcion'  => 'Chocolate de taza sabor maracuyá, para microondas.',
	'precio'       => 3.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-maracuya-150.jpg',
	'alt'          => 'Chocolate Express sabor Maracuyá 150 g',
	'categorias'   => array( 'express', 'sabores', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Sin gluten', '85% cacao' ),
	'ingredientes' => 'Pasta de cacao (85 %), azúcar, manteca de cacao, aroma natural de maracuyá, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-galleta-150',
	'nombre'       => 'Chocolate Express sabor Galleta 150 g',
	'descripcion'  => 'Chocolate de taza sabor galleta, para microondas.',
	'precio'       => 3.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-galleta-150.jpg',
	'alt'          => 'Chocolate Express sabor Galleta 150 g',
	'categorias'   => array( 'express', 'sabores', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Sin gluten', '85% cacao' ),
	'ingredientes' => 'Pasta de cacao (85 %), azúcar, manteca de cacao, aroma natural a galleta, vainilla, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-mandarina-150',
	'nombre'       => 'Chocolate Express sabor Mandarina 150 g',
	'descripcion'  => 'Chocolate de taza sabor mandarina, para microondas.',
	'precio'       => 3.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-mandarina-150.jpg',
	'alt'          => 'Chocolate Express sabor Mandarina 150 g',
	'categorias'   => array( 'express', 'sabores', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Sin gluten', '85% cacao' ),
	'ingredientes' => 'Pasta de cacao (85 %), azúcar, manteca de cacao, aroma natural de mandarina, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-choco-banana-150',
	'nombre'       => 'Chocolate Express sabor Choco Banana 150 g',
	'descripcion'  => 'Chocolate de taza sabor choco banana, para microondas.',
	'precio'       => 3.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-choco-banana-150.jpg',
	'alt'          => 'Chocolate Express sabor Choco Banana 150 g',
	'categorias'   => array( 'express', 'sabores', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Sin gluten', '85% cacao' ),
	'ingredientes' => 'Pasta de cacao (85 %), azúcar, manteca de cacao, banano deshidratado, aroma natural de banano, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-fresa-150',
	'nombre'       => 'Chocolate Express sabor Fresa 150 g',
	'descripcion'  => 'Chocolate de taza sabor fresa, para microondas.',
	'precio'       => 3.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-fresa-150.jpg',
	'alt'          => 'Chocolate Express sabor Fresa 150 g',
	'categorias'   => array( 'express', 'sabores', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Sin gluten', '85% cacao' ),
	'ingredientes' => 'Pasta de cacao (85 %), azúcar, manteca de cacao, fresa deshidratada, aroma natural de fresa, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'express-manzana-150',
	'nombre'       => 'Chocolate Express sabor Manzana 150 g',
	'descripcion'  => 'Chocolate de taza sabor manzana, para microondas.',
	'precio'       => 3.75,
	'peso'         => '150 g',
	'imagen'       => $theme_uri . '/assets/img/productos/express-manzana-150.jpg',
	'alt'          => 'Chocolate Express sabor Manzana 150 g',
	'categorias'   => array( 'express', 'sabores', 'sin-gluten' ),
	'etiquetas'    => array( 'Express', 'Sin gluten', '85% cacao' ),
	'ingredientes' => 'Pasta de cacao (85 %), azúcar, manteca de cacao, manzana deshidratada, aroma natural de manzana, canela, lecitina de girasol.',
	'nutricion'    => $nutri_default,
),

// ===================== CHOCOLATE DE REPOSTERÍA =====================
array(
	'id'           => 'nibs-cacao-200',
	'nombre'       => 'Nibs de cacao 200 g',
	'descripcion'  => 'El secreto de tus postres: nibs de cacao para repostería.',
	'precio'       => 4.50,
	'peso'         => '200 g',
	'imagen'       => $theme_uri . '/assets/img/productos/nibs-cacao-200.jpg',
	'alt'          => 'Nibs de cacao 200 g',
	'categorias'   => array( 'reposteria' ),
	'etiquetas'    => array( 'Repostería' ),
	'ingredientes' => 'Nibs de cacao 100 % (granos de cacao fermentados, secos, tostados y triturados).',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'syrup-chocolate-250',
	'nombre'       => 'Syrup de chocolate 250 ml',
	'descripcion'  => 'Syrup de chocolate para postres y bebidas.',
	'precio'       => 3.25,
	'peso'         => '250 ml',
	'imagen'       => $theme_uri . '/assets/img/productos/syrup-chocolate-250.jpg',
	'alt'          => 'Syrup de chocolate 250 ml',
	'categorias'   => array( 'reposteria' ),
	'etiquetas'    => array( 'Repostería' ),
	'ingredientes' => 'Agua, azúcar, pasta de cacao, cacao en polvo, vainilla, conservante (sorbato de potasio).',
	'nutricion'    => $nutri_default,
),
array(
	'id'           => 'polvo-cacao-200',
	'nombre'       => 'Polvo de cacao 200 g',
	'descripcion'  => 'Cacao en polvo para tus recetas de repostería.',
	'precio'       => 3.00,
	'peso'         => '200 g',
	'imagen'       => $theme_uri . '/assets/img/productos/polvo-cacao-200.jpg',
	'alt'          => 'Polvo de cacao 200 g',
	'categorias'   => array( 'reposteria' ),
	'etiquetas'    => array( 'Repostería' ),
	'ingredientes' => 'Cacao en polvo 100 % natural, sin azúcar.',
	'nutricion'    => $nutri_default,
),
	);
}

/**
 * Devuelve todos los productos formateados para JavaScript y templates.
 * Lee prioritariamente la lista canónica de código, resolviendo imágenes y metadatos.
 *
 * @return array
 */
function ambateno_get_all_products_data() {
	$theme_uri  = get_template_directory_uri();
	$canonical  = ambateno_get_canonical_products_list();
	$productos  = array();

	foreach ( $canonical as $p ) {
		$slug    = $p['id'];
		$img_url = isset( $p['imagen'] ) ? $p['imagen'] : '';

		// Si existe en WordPress y tiene imagen destacada subida en wp-admin, respetarla
		$post_obj = get_page_by_path( $slug, OBJECT, 'ambateno_producto' );
		if ( $post_obj ) {
			$thumb_id = get_post_thumbnail_id( $post_obj->ID );
			if ( $thumb_id ) {
				$custom_img = wp_get_attachment_image_url( $thumb_id, 'large' );
				if ( $custom_img ) {
					$img_url = $custom_img;
				}
			}
		}

		// Normalizar la URL de la imagen para que admita URLs absolutas o relativas
		if ( empty( $img_url ) ) {
			$img_url = $theme_uri . '/assets/img/producto-barra.webp';
		} elseif ( strpos( $img_url, 'http://' ) !== 0 && strpos( $img_url, 'https://' ) !== 0 && strpos( $img_url, '//' ) !== 0 ) {
			if ( strpos( $img_url, 'assets/' ) !== false ) {
				$img_url = $theme_uri . '/' . ltrim( $img_url, '/' );
			} else {
				$img_url = $theme_uri . '/assets/img/' . ltrim( $img_url, '/' );
			}
		}

		$item           = $p;
		$item['imagen'] = $img_url;
		$productos[]    = $item;
	}

	return $productos;
}
