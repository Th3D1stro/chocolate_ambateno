<?php
/**
 * Tipo de contenido: Establecimientos / Puntos de Venta (ambateno_tienda).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_register_cpt_establecimientos() {
	$labels = array(
		'name'               => _x( 'Puntos de Venta', 'post type general name', 'chocolate-el-ambateno' ),
		'singular_name'      => _x( 'Punto de Venta', 'post type singular name', 'chocolate-el-ambateno' ),
		'menu_name'          => _x( 'Puntos de Venta', 'admin menu', 'chocolate-el-ambateno' ),
		'name_admin_bar'     => _x( 'Punto de Venta', 'add new on admin bar', 'chocolate-el-ambateno' ),
		'add_new'            => _x( 'Añadir nuevo', 'establecimiento', 'chocolate-el-ambateno' ),
		'add_new_item'       => __( 'Añadir nuevo punto de venta', 'chocolate-el-ambateno' ),
		'new_item'           => __( 'Nuevo punto de venta', 'chocolate-el-ambateno' ),
		'edit_item'          => __( 'Editar punto de venta', 'chocolate-el-ambateno' ),
		'all_items'          => __( 'Todos los puntos de venta', 'chocolate-el-ambateno' ),
		'search_items'       => __( 'Buscar puntos de venta', 'chocolate-el-ambateno' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-location',
		'supports'           => array( 'title' ),
	);

	register_post_type( 'ambateno_tienda', $args );
}
add_action( 'init', 'ambateno_register_cpt_establecimientos' );

function ambateno_add_establecimiento_meta_boxes() {
	add_meta_box(
		'ambateno_tienda_detalles',
		__( 'Información del Punto de Venta', 'chocolate-el-ambateno' ),
		'ambateno_render_establecimiento_meta_box',
		'ambateno_tienda',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ambateno_add_establecimiento_meta_boxes' );

function ambateno_render_establecimiento_meta_box( $post ) {
	wp_nonce_field( 'ambateno_save_tienda_meta', 'ambateno_tienda_nonce' );

	$ciudad  = get_post_meta( $post->ID, '_ambateno_ciudad', true );
	$tipo    = get_post_meta( $post->ID, '_ambateno_tipo', true ) ?: 'fisica';
	$detalle = get_post_meta( $post->ID, '_ambateno_detalle', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="ambateno_ciudad"><?php esc_html_e( 'Ciudad / Cobertura', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<input type="text" name="ambateno_ciudad" id="ambateno_ciudad" value="<?php echo esc_attr( $ciudad ); ?>" class="regular-text" placeholder="Ambato" required />
			</td>
		</tr>
		<tr>
			<th><label for="ambateno_tipo"><?php esc_html_e( 'Tipo de Canal', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<select name="ambateno_tipo" id="ambateno_tipo">
					<option value="fisica" <?php selected( $tipo, 'fisica' ); ?>><?php esc_html_e( 'Tienda física', 'chocolate-el-ambateno' ); ?></option>
					<option value="cafeteria" <?php selected( $tipo, 'cafeteria' ); ?>><?php esc_html_e( 'Cafetería', 'chocolate-el-ambateno' ); ?></option>
					<option value="online" <?php selected( $tipo, 'online' ); ?>><?php esc_html_e( 'Online', 'chocolate-el-ambateno' ); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="ambateno_detalle"><?php esc_html_e( 'Detalle / Horario', 'chocolate-el-ambateno' ); ?></label></th>
			<td>
				<input type="text" name="ambateno_detalle" id="ambateno_detalle" value="<?php echo esc_attr( $detalle ); ?>" class="large-text" placeholder="Lun a sáb · 09:00 a 19:00" />
			</td>
		</tr>
	</table>
	<?php
}

function ambateno_save_establecimiento_meta( $post_id ) {
	if ( ! isset( $_POST['ambateno_tienda_nonce'] ) || ! wp_verify_nonce( $_POST['ambateno_tienda_nonce'], 'ambateno_save_tienda_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['ambateno_ciudad'] ) ) {
		update_post_meta( $post_id, '_ambateno_ciudad', sanitize_text_field( $_POST['ambateno_ciudad'] ) );
	}
	if ( isset( $_POST['ambateno_tipo'] ) ) {
		update_post_meta( $post_id, '_ambateno_tipo', sanitize_text_field( $_POST['ambateno_tipo'] ) );
	}
	if ( isset( $_POST['ambateno_detalle'] ) ) {
		update_post_meta( $post_id, '_ambateno_detalle', sanitize_text_field( $_POST['ambateno_detalle'] ) );
	}
}
add_action( 'save_post_ambateno_tienda', 'ambateno_save_establecimiento_meta' );

/**
 * Devuelve la lista de establecimientos para la portada.
 */
function ambateno_get_establecimientos() {
	$query = new WP_Query(
		array(
			'post_type'      => 'ambateno_tienda',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order ID',
			'order'          => 'ASC',
		)
	);

	$items = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id = get_the_ID();
			$items[] = array(
				'nombre'  => get_the_title(),
				'ciudad'  => get_post_meta( $post_id, '_ambateno_ciudad', true ) ?: 'Ambato',
				'tipo'    => get_post_meta( $post_id, '_ambateno_tipo', true ) ?: 'fisica',
				'detalle' => get_post_meta( $post_id, '_ambateno_detalle', true ) ?: '',
			);
		}
		wp_reset_postdata();
	}

	// Respaldo de los 9 puntos de venta por defecto del inventario
	if ( empty( $items ) ) {
		$items = array(
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
	}

	return $items;
}
