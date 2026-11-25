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
 * Devuelve todos los productos formateados para JavaScript y templates.
 */
function ambateno_get_all_products_data() {
	$query = new WP_Query(
		array(
			'post_type'      => 'ambateno_producto',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		)
	);

	$theme_uri  = get_template_directory_uri();
	$productos  = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id = get_the_ID();

			// Imagen destacada o respaldo del tema
			$img_id = get_post_thumbnail_id( $post_id );
			if ( $img_id ) {
				$img_url = wp_get_attachment_image_url( $img_id, 'large' );
			} else {
				$img_name = get_post_meta( $post_id, '_ambateno_fallback_img', true );
				$img_url  = $img_name ? $theme_uri . '/assets/img/' . $img_name : $theme_uri . '/assets/img/producto-barra.webp';
			}

			// Categorías (slugs)
			$terms = wp_get_post_terms( $post_id, 'categoria_producto', array( 'fields' => 'slugs' ) );
			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				$terms = array( 'negro' );
			}

			// Etiquetas
			$raw_tags = get_post_meta( $post_id, '_ambateno_etiquetas', true );
			$tags     = array_filter( array_map( 'trim', explode( ',', $raw_tags ) ) );

			// Nutrición parseada
			$raw_nutri = get_post_meta( $post_id, '_ambateno_nutricion', true );
			$nutri_map = array(
				'porcion'       => '25 g',
				'energia'       => '140 kcal',
				'grasas'        => '11 g',
				'carbohidratos' => '7 g',
				'azucares'      => '0 g',
				'proteina'      => '3 g',
			);
			if ( ! empty( $raw_nutri ) ) {
				$lines = explode( "\n", $raw_nutri );
				foreach ( $lines as $line ) {
					$parts = explode( ':', $line, 2 );
					if ( count( $parts ) === 2 ) {
						$key = strtolower( trim( $parts[0] ) );
						$val = trim( $parts[1] );
						if ( strpos( $key, 'porci' ) !== false ) {
							$nutri_map['porcion'] = $val;
						} elseif ( strpos( $key, 'energ' ) !== false ) {
							$nutri_map['energia'] = $val;
						} elseif ( strpos( $key, 'grasa' ) !== false ) {
							$nutri_map['grasas'] = $val;
						} elseif ( strpos( $key, 'carboh' ) !== false ) {
							$nutri_map['carbohidratos'] = $val;
						} elseif ( strpos( $key, 'az' ) !== false ) {
							$nutri_map['azucares'] = $val;
						} elseif ( strpos( $key, 'prot' ) !== false ) {
							$nutri_map['proteina'] = $val;
						}
					}
				}
			}

			$productos[] = array(
				'id'           => get_post_field( 'post_name', $post_id ),
				'nombre'       => get_the_title(),
				'descripcion'  => get_the_content(),
				'precio'       => floatval( get_post_meta( $post_id, '_ambateno_precio', true ) ),
				'peso'         => get_post_meta( $post_id, '_ambateno_peso', true ) ?: '200 g',
				'imagen'       => $img_url,
				'alt'          => get_the_title(),
				'categorias'   => $terms,
				'etiquetas'    => $tags,
				'ingredientes' => get_post_meta( $post_id, '_ambateno_ingredientes', true ) ?: '',
				'nutricion'    => $nutri_map,
			);
		}
		wp_reset_postdata();
	}

	// Respaldo de los 15 productos originales si aún no se han importado
	if ( empty( $productos ) ) {
		$nutri_default = array(
			'porcion'       => '25 g',
			'energia'       => '140 kcal',
			'grasas'        => '11 g',
			'carbohidratos' => '7 g',
			'azucares'      => '0 g',
			'proteina'      => '3 g',
		);

		$productos = array(
			array(
				'id'           => 'tradicional-200',
				'nombre'       => 'Chocolate tradicional El Ambateño 200 g',
				'descripcion'  => 'Nuestra barra insignia: cacao fino de aroma molido en piedra, ideal para taza o para comer en cuadros.',
				'precio'       => 6.50,
				'peso'         => '200 g',
				'imagen'       => $theme_uri . '/assets/img/producto1.jpg',
				'alt'          => 'Chocolate tradicional El Ambateño 200 g',
				'categorias'   => array( 'negro', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten' ),
				'ingredientes' => 'Pasta de cacao, manteca de cacao, stevia, canela.',
				'nutricion'    => $nutri_default,
			),
			array(
				'id'           => 'tradicional-200-libre-gluten',
				'nombre'       => 'Chocolate tradicional El Ambateño 200 g, Libre de Gluten',
				'descripcion'  => 'Nuestra barra insignia ahora sin gluten',
				'precio'       => 8.75,
				'peso'         => '200 g',
				'imagen'       => $theme_uri . '/assets/img/producto2.jpg',
				'alt'          => 'Chocolate tradicional El Ambateño 200 g, sin gluten',
				'categorias'   => array( 'negro', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten' ),
				'ingredientes' => 'Pasta de cacao, manteca de cacao, stevia, canela.',
				'nutricion'    => array_merge( $nutri_default, array( 'energia' => '150 kcal', 'grasas' => '12 g' ) ),
			),
			array(
				'id'           => 'tradicional-200-sin-azucar',
				'nombre'       => 'Chocolate tradicional El Ambateño 200 g. Sin Azucar',
				'descripcion'  => 'Nuestra barra tradicional ahora sin azucar',
				'precio'       => 4.75,
				'peso'         => '200 g',
				'imagen'       => $theme_uri . '/assets/img/producto3.jpg',
				'alt'          => 'Barra 70% Cacao Puro, sin azúcar',
				'categorias'   => array( 'negro', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten' ),
				'ingredientes' => 'Pasta de cacao (70 %), manteca de cacao, eritritol.',
				'nutricion'    => $nutri_default,
			),
			array(
				'id'           => 'barra-rosas',
				'nombre'       => 'Barra con Pétalos de Rosa, sin azúcar',
				'descripcion'  => 'Un homenaje a las rosas ecuatorianas: pétalos deshidratados sobre chocolate 65 %.',
				'precio'       => 3.50,
				'peso'         => '40 g',
				'imagen'       => $theme_uri . '/assets/img/producto-sabores.webp',
				'alt'          => 'Barra con Pétalos de Rosa, sin azúcar',
				'categorias'   => array( 'negro', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten' ),
				'ingredientes' => 'Pasta de cacao (65 %), manteca de cacao, pétalos de rosa, eritritol.',
				'nutricion'    => $nutri_default,
			),
			array(
				'id'           => 'barra-hierbaluisa',
				'nombre'       => 'Barra Hierbaluisa, sin azúcar',
				'descripcion'  => 'Frescura cítrica de la hierbaluisa andina con la profundidad del cacao fino de aroma.',
				'precio'       => 3.50,
				'peso'         => '40 g',
				'imagen'       => $theme_uri . '/assets/img/producto-sabores.webp',
				'alt'          => 'Barra Hierbaluisa, sin azúcar',
				'categorias'   => array( 'negro', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten', 'Vegano' ),
				'ingredientes' => 'Pasta de cacao (65 %), manteca de cacao, hierbaluisa, eritritol.',
				'nutricion'    => $nutri_default,
			),
			array(
				'id'           => 'chocolate-taza',
				'nombre'       => 'Chocolate a la taza tradicional',
				'descripcion'  => 'Tabletas para disolver en leche caliente, con canela y clavo de olor como lo hacían las abuelas.',
				'precio'       => 5.25,
				'peso'         => '250 g',
				'imagen'       => $theme_uri . '/assets/img/producto-taza.webp',
				'alt'          => 'Chocolate a la taza tradicional',
				'categorias'   => array( 'negro' ),
				'etiquetas'    => array( 'Libre de gluten' ),
				'ingredientes' => 'Pasta de cacao, panela, canela, clavo de olor.',
				'nutricion'    => array( 'porcion' => '25 g', 'energia' => '120 kcal', 'grasas' => '7 g', 'carbohidratos' => '13 g', 'azucares' => '10 g', 'proteina' => '2 g' ),
			),
			array(
				'id'           => 'chips-coco',
				'nombre'       => 'Chips de coco con cacao',
				'descripcion'  => 'Láminas de coco tostado cubiertas de cacao. Un snack crocante para media mañana.',
				'precio'       => 3.25,
				'peso'         => '60 g',
				'imagen'       => $theme_uri . '/assets/img/producto-sabores.webp',
				'alt'          => 'Chips de coco con cacao',
				'categorias'   => array( 'snacks', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Vegano' ),
				'ingredientes' => 'Coco deshidratado, cacao en polvo, aceite de coco, stevia.',
				'nutricion'    => array( 'porcion' => '20 g', 'energia' => '110 kcal', 'grasas' => '10 g', 'carbohidratos' => '4 g', 'azucares' => '0 g', 'proteina' => '1 g' ),
			),
			array(
				'id'           => 'premezcla-brownie',
				'nombre'       => 'Premezcla para brownie sin azúcar',
				'descripcion'  => 'Solo agrega huevos y mantequilla. Brownies húmedos en 30 minutos, sin gluten ni azúcar.',
				'precio'       => 6.00,
				'peso'         => '350 g',
				'imagen'       => $theme_uri . '/assets/img/producto-taza.webp',
				'alt'          => 'Premezcla para brownie sin azúcar',
				'categorias'   => array( 'snacks', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten' ),
				'ingredientes' => 'Harina de almendra, cacao en polvo, eritritol, polvo de hornear sin gluten.',
				'nutricion'    => array( 'porcion' => '35 g', 'energia' => '150 kcal', 'grasas' => '9 g', 'carbohidratos' => '8 g', 'azucares' => '0 g', 'proteina' => '5 g' ),
			),
			array(
				'id'           => 'crema-avellanas',
				'nombre'       => 'Crema de avellanas y cacao',
				'descripcion'  => 'Untable, intensa y sin aceite de palma. Para el pan del desayuno o directo de la cuchara.',
				'precio'       => 7.50,
				'peso'         => '220 g',
				'imagen'       => $theme_uri . '/assets/img/producto-taza.webp',
				'alt'          => 'Crema de avellanas y cacao',
				'categorias'   => array( 'snacks' ),
				'etiquetas'    => array( 'Libre de gluten' ),
				'ingredientes' => 'Avellanas (45 %), cacao, panela, manteca de cacao.',
				'nutricion'    => array( 'porcion' => '15 g', 'energia' => '90 kcal', 'grasas' => '7 g', 'carbohidratos' => '5 g', 'azucares' => '4 g', 'proteina' => '2 g' ),
			),
			array(
				'id'           => 'nibs-cacao',
				'nombre'       => 'Nibs de cacao tostado',
				'descripcion'  => 'Trocitos de grano de cacao tostado: crocantes, amargos y perfectos sobre yogur o granola.',
				'precio'       => 4.00,
				'peso'         => '150 g',
				'imagen'       => $theme_uri . '/assets/img/producto-sabores.webp',
				'alt'          => 'Nibs de cacao tostado',
				'categorias'   => array( 'snacks', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten', 'Vegano' ),
				'ingredientes' => 'Nibs de cacao fino de aroma 100 %.',
				'nutricion'    => array( 'porcion' => '15 g', 'energia' => '85 kcal', 'grasas' => '7 g', 'carbohidratos' => '3 g', 'azucares' => '0 g', 'proteina' => '2 g' ),
			),
			array(
				'id'           => 'gift-box',
				'nombre'       => 'Gift Box Ambato (6 barras)',
				'descripcion'  => 'Seis barras surtidas en caja de regalo con cinta oliva y tarjeta personalizada.',
				'precio'       => 24.00,
				'peso'         => '6 × 50 g',
				'imagen'       => $theme_uri . '/assets/img/producto-regalo.webp',
				'alt'          => 'Gift Box Ambato (6 barras)',
				'categorias'   => array( 'regalos' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten' ),
				'ingredientes' => 'Surtido de barras 60 %, 70 % y 85 % sin azúcar.',
				'nutricion'    => $nutri_default,
			),
			array(
				'id'           => 'caja-bombones',
				'nombre'       => 'Caja de bombones artesanales',
				'descripcion'  => 'Doce bombones rellenos de frutas andinas: mora, uvilla, maracuyá y naranjilla.',
				'precio'       => 15.00,
				'peso'         => '12 unidades',
				'imagen'       => $theme_uri . '/assets/img/producto-regalo.webp',
				'alt'          => 'Caja de bombones artesanales',
				'categorias'   => array( 'regalos' ),
				'etiquetas'    => array( 'Libre de gluten' ),
				'ingredientes' => 'Chocolate 60 %, pulpa de frutas andinas, panela.',
				'nutricion'    => array( 'porcion' => '2 bombones', 'energia' => '130 kcal', 'grasas' => '8 g', 'carbohidratos' => '12 g', 'azucares' => '9 g', 'proteina' => '2 g' ),
			),
			array(
				'id'           => 'cobertura-pro',
				'nombre'       => 'Cobertura profesional 70% · 1 kg',
				'descripcion'  => 'Botones de cobertura de alta fluidez para templado, bombonería y repostería profesional.',
				'precio'       => 18.50,
				'peso'         => '1 kg',
				'imagen'       => $theme_uri . '/assets/img/producto-barra.webp',
				'alt'          => 'Cobertura profesional 70% · 1 kg',
				'categorias'   => array( 'profesional', 'negro' ),
				'etiquetas'    => array( 'Libre de gluten', 'Vegano' ),
				'ingredientes' => 'Pasta de cacao (70 %), manteca de cacao, panela orgánica.',
				'nutricion'    => array( 'porcion' => '25 g', 'energia' => '145 kcal', 'grasas' => '10 g', 'carbohidratos' => '10 g', 'azucares' => '7 g', 'proteina' => '2 g' ),
			),
			array(
				'id'           => 'cacao-polvo-pro',
				'nombre'       => 'Cacao en polvo profesional 500 g',
				'descripcion'  => 'Cacao alcalinizado de color intenso para panadería, bebidas y decoración.',
				'precio'       => 9.75,
				'peso'         => '500 g',
				'imagen'       => $theme_uri . '/assets/img/producto-taza.webp',
				'alt'          => 'Cacao en polvo profesional 500 g',
				'categorias'   => array( 'profesional', 'sin-azucar' ),
				'etiquetas'    => array( 'Sin azúcar', 'Libre de gluten', 'Vegano' ),
				'ingredientes' => 'Cacao en polvo 100 % (22-24 % de grasa).',
				'nutricion'    => array( 'porcion' => '10 g', 'energia' => '35 kcal', 'grasas' => '2 g', 'carbohidratos' => '1 g', 'azucares' => '0 g', 'proteina' => '2 g' ),
			),
		);
	}

	return $productos;
}
