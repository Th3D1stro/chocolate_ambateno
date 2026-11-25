<?php
/**
 * Importación inicial de demostración al activar el tema.
 *
 * Crea:
 * 1. Páginas Inicio (asignada como portada estática), Tienda (plantilla Tienda), Términos y Privacidad.
 * 2. 15 Productos con categorías, precios, pesos, etiquetas, ingredientes y nutrición.
 * 3. 9 Puntos de venta / establecimientos.
 * 4. Actualiza los enlaces permanentes sin duplicar datos si ya existen.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_run_demo_import() {
	if ( get_option( 'ambateno_demo_data_imported' ) ) {
		return;
	}

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
<p>Cuando la tienda sea real, podrás solicitar el acceso, la rectificación o la eliminación de tus datos escribiendo a hola@elambateno.ec, conforme a la Ley Orgánica de Protección de Datos Personales del Ecuador.</p>";

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

	// 5. Categorías de productos
	$cats = array(
		'negro'       => 'Chocolate negro',
		'sin-azucar'  => 'Sin azúcar',
		'snacks'      => 'Snacks',
		'regalos'     => 'Regalos',
		'profesional' => 'Línea profesional',
	);
	foreach ( $cats as $slug => $nombre ) {
		if ( ! term_exists( $slug, 'categoria_producto' ) ) {
			wp_insert_term( $nombre, 'categoria_producto', array( 'slug' => $slug ) );
		}
	}

	// 6. Productos (15 productos del catálogo original)
	$nutri_barra_default = "Porción: 25 g\nEnergía: 140 kcal\nGrasas: 11 g\nCarbohidratos: 7 g\nAzúcares: 0 g\nProteína: 3 g";

	$productos = array(
		array(
			'slug'         => 'tradicional-200',
			'nombre'       => 'Chocolate tradicional El Ambateño 200 g',
			'descripcion'  => 'Nuestra barra insignia: cacao fino de aroma molido en piedra, ideal para taza o para comer en cuadros.',
			'precio'       => 6.50,
			'peso'         => '200 g',
			'cats'         => array( 'negro', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten',
			'ingredientes' => 'Pasta de cacao, manteca de cacao, stevia, canela.',
			'nutricion'    => $nutri_barra_default,
			'imagen'       => 'producto-barra.webp',
		),
		array(
			'slug'         => 'barra-85',
			'nombre'       => 'Barra 85% Cacao Intenso, sin azúcar',
			'descripcion'  => 'Notas a frutos rojos y madera. Para quienes buscan el sabor más puro del cacao ecuatoriano.',
			'precio'       => 4.75,
			'peso'         => '50 g',
			'cats'         => array( 'negro', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten, Vegano',
			'ingredientes' => 'Pasta de cacao (85 %), manteca de cacao, eritritol.',
			'nutricion'    => "Porción: 25 g\nEnergía: 150 kcal\nGrasas: 12 g\nCarbohidratos: 7 g\nAzúcares: 0 g\nProteína: 3 g",
			'imagen'       => 'producto-barra.webp',
		),
		array(
			'slug'         => 'barra-70',
			'nombre'       => 'Barra 70% Cacao Puro, sin azúcar',
			'descripcion'  => 'Equilibrada y sedosa, con un final suave a nuez. La favorita para empezar en el chocolate oscuro.',
			'precio'       => 4.75,
			'peso'         => '50 g',
			'cats'         => array( 'negro', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten, Vegano',
			'ingredientes' => 'Pasta de cacao (70 %), manteca de cacao, eritritol.',
			'nutricion'    => $nutri_barra_default,
			'imagen'       => 'producto-barra.webp',
		),
		array(
			'slug'         => 'barra-60-sal',
			'nombre'       => 'Barra 60% con Sal y Nibs, sin azúcar',
			'descripcion'  => 'Crocante de nibs tostados y un toque de sal marina que realza el dulzor natural del cacao.',
			'precio'       => 3.50,
			'peso'         => '40 g',
			'cats'         => array( 'negro', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten',
			'ingredientes' => 'Pasta de cacao (60 %), manteca de cacao, nibs de cacao, sal marina, eritritol.',
			'nutricion'    => $nutri_barra_default,
			'imagen'       => 'producto-sabores.webp',
		),
		array(
			'slug'         => 'barra-rosas',
			'nombre'       => 'Barra con Pétalos de Rosa, sin azúcar',
			'descripcion'  => 'Un homenaje a las rosas ecuatorianas: pétalos deshidratados sobre chocolate 65 %.',
			'precio'       => 3.50,
			'peso'         => '40 g',
			'cats'         => array( 'negro', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten',
			'ingredientes' => 'Pasta de cacao (65 %), manteca de cacao, pétalos de rosa, eritritol.',
			'nutricion'    => $nutri_barra_default,
			'imagen'       => 'producto-sabores.webp',
		),
		array(
			'slug'         => 'barra-hierbaluisa',
			'nombre'       => 'Barra Hierbaluisa, sin azúcar',
			'descripcion'  => 'Frescura cítrica de la hierbaluisa andina con la profundidad del cacao fino de aroma.',
			'precio'       => 3.50,
			'peso'         => '40 g',
			'cats'         => array( 'negro', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten, Vegano',
			'ingredientes' => 'Pasta de cacao (65 %), manteca de cacao, hierbaluisa, eritritol.',
			'nutricion'    => $nutri_barra_default,
			'imagen'       => 'producto-sabores.webp',
		),
		array(
			'slug'         => 'chocolate-taza',
			'nombre'       => 'Chocolate a la taza tradicional',
			'descripcion'  => 'Tabletas para disolver en leche caliente, con canela y clavo de olor como lo hacían las abuelas.',
			'precio'       => 5.25,
			'peso'         => '250 g',
			'cats'         => array( 'negro' ),
			'etiquetas'    => 'Libre de gluten',
			'ingredientes' => 'Pasta de cacao, panela, canela, clavo de olor.',
			'nutricion'    => "Porción: 25 g\nEnergía: 120 kcal\nGrasas: 7 g\nCarbohidratos: 13 g\nAzúcares: 10 g\nProteína: 2 g",
			'imagen'       => 'producto-taza.webp',
		),
		array(
			'slug'         => 'chips-coco',
			'nombre'       => 'Chips de coco con cacao',
			'descripcion'  => 'Láminas de coco tostado cubiertas de cacao. Un snack crocante para media mañana.',
			'precio'       => 3.25,
			'peso'         => '60 g',
			'cats'         => array( 'snacks', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Vegano',
			'ingredientes' => 'Coco deshidratado, cacao en polvo, aceite de coco, stevia.',
			'nutricion'    => "Porción: 20 g\nEnergía: 110 kcal\nGrasas: 10 g\nCarbohidratos: 4 g\nAzúcares: 0 g\nProteína: 1 g",
			'imagen'       => 'producto-sabores.webp',
		),
		array(
			'slug'         => 'premezcla-brownie',
			'nombre'       => 'Premezcla para brownie sin azúcar',
			'descripcion'  => 'Solo agrega huevos y mantequilla. Brownies húmedos en 30 minutos, sin gluten ni azúcar.',
			'precio'       => 6.00,
			'peso'         => '350 g',
			'cats'         => array( 'snacks', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten',
			'ingredientes' => 'Harina de almendra, cacao en polvo, eritritol, polvo de hornear sin gluten.',
			'nutricion'    => "Porción: 35 g\nEnergía: 150 kcal\nGrasas: 9 g\nCarbohidratos: 8 g\nAzúcares: 0 g\nProteína: 5 g",
			'imagen'       => 'producto-taza.webp',
		),
		array(
			'slug'         => 'crema-avellanas',
			'nombre'       => 'Crema de avellanas y cacao',
			'descripcion'  => 'Untable, intensa y sin aceite de palma. Para el pan del desayuno o directo de la cuchara.',
			'precio'       => 7.50,
			'peso'         => '220 g',
			'cats'         => array( 'snacks' ),
			'etiquetas'    => 'Libre de gluten',
			'ingredientes' => 'Avellanas (45 %), cacao, panela, manteca de cacao.',
			'nutricion'    => "Porción: 15 g\nEnergía: 90 kcal\nGrasas: 7 g\nCarbohidratos: 5 g\nAzúcares: 4 g\nProteína: 2 g",
			'imagen'       => 'producto-taza.webp',
		),
		array(
			'slug'         => 'nibs-cacao',
			'nombre'       => 'Nibs de cacao tostado',
			'descripcion'  => 'Trocitos de grano de cacao tostado: crocantes, amargos y perfectos sobre yogur o granola.',
			'precio'       => 4.00,
			'peso'         => '150 g',
			'cats'         => array( 'snacks', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten, Vegano',
			'ingredientes' => 'Nibs de cacao fino de aroma 100 %.',
			'nutricion'    => "Porción: 15 g\nEnergía: 85 kcal\nGrasas: 7 g\nCarbohidratos: 3 g\nAzúcares: 0 g\nProteína: 2 g",
			'imagen'       => 'producto-sabores.webp',
		),
		array(
			'slug'         => 'gift-box',
			'nombre'       => 'Gift Box Ambato (6 barras)',
			'descripcion'  => 'Seis barras surtidas en caja de regalo con cinta oliva y tarjeta personalizada.',
			'precio'       => 24.00,
			'peso'         => '6 × 50 g',
			'cats'         => array( 'regalos' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten',
			'ingredientes' => 'Surtido de barras 60 %, 70 % y 85 % sin azúcar.',
			'nutricion'    => $nutri_barra_default,
			'imagen'       => 'producto-regalo.webp',
		),
		array(
			'slug'         => 'caja-bombones',
			'nombre'       => 'Caja de bombones artesanales',
			'descripcion'  => 'Doce bombones rellenos de frutas andinas: mora, uvilla, maracuyá y naranjilla.',
			'precio'       => 15.00,
			'peso'         => '12 unidades',
			'cats'         => array( 'regalos' ),
			'etiquetas'    => 'Libre de gluten',
			'ingredientes' => 'Chocolate 60 %, pulpa de frutas andinas, panela.',
			'nutricion'    => "Porción: 2 bombones\nEnergía: 130 kcal\nGrasas: 8 g\nCarbohidratos: 12 g\nAzúcares: 9 g\nProteína: 2 g",
			'imagen'       => 'producto-regalo.webp',
		),
		array(
			'slug'         => 'cobertura-pro',
			'nombre'       => 'Cobertura profesional 70% · 1 kg',
			'descripcion'  => 'Botones de cobertura de alta fluidez para templado, bombonería y repostería profesional.',
			'precio'       => 18.50,
			'peso'         => '1 kg',
			'cats'         => array( 'profesional', 'negro' ),
			'etiquetas'    => 'Libre de gluten, Vegano',
			'ingredientes' => 'Pasta de cacao (70 %), manteca de cacao, panela orgánica.',
			'nutricion'    => "Porción: 25 g\nEnergía: 145 kcal\nGrasas: 10 g\nCarbohidratos: 10 g\nAzúcares: 7 g\nProteína: 2 g",
			'imagen'       => 'producto-barra.webp',
		),
		array(
			'slug'         => 'cacao-polvo-pro',
			'nombre'       => 'Cacao en polvo profesional 500 g',
			'descripcion'  => 'Cacao alcalinizado de color intenso para panadería, bebidas y decoración.',
			'precio'       => 9.75,
			'peso'         => '500 g',
			'cats'         => array( 'profesional', 'sin-azucar' ),
			'etiquetas'    => 'Sin azúcar, Libre de gluten, Vegano',
			'ingredientes' => 'Cacao en polvo 100 % (22-24 % de grasa).',
			'nutricion'    => "Porción: 10 g\nEnergía: 35 kcal\nGrasas: 2 g\nCarbohidratos: 1 g\nAzúcares: 0 g\nProteína: 2 g",
			'imagen'       => 'producto-taza.webp',
		),
	);

	foreach ( $productos as $p ) {
		$existing = get_page_by_path( $p['slug'], OBJECT, 'ambateno_producto' );
		if ( ! $existing ) {
			$post_id = wp_insert_post(
				array(
					'post_title'   => $p['nombre'],
					'post_name'    => $p['slug'],
					'post_content' => $p['descripcion'],
					'post_status'  => 'publish',
					'post_type'    => 'ambateno_producto',
				)
			);
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_ambateno_precio', $p['precio'] );
				update_post_meta( $post_id, '_ambateno_peso', $p['peso'] );
				update_post_meta( $post_id, '_ambateno_etiquetas', $p['etiquetas'] );
				update_post_meta( $post_id, '_ambateno_ingredientes', $p['ingredientes'] );
				update_post_meta( $post_id, '_ambateno_nutricion', $p['nutricion'] );
				update_post_meta( $post_id, '_ambateno_fallback_img', $p['imagen'] );
				wp_set_object_terms( $post_id, $p['cats'], 'categoria_producto' );
			}
		}
	}

	// 7. Puntos de Venta (9 establecimientos)
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

	// 8. Reescritura de enlaces permanentes
	flush_rewrite_rules();

	// Marcar importación como realizada
	update_option( 'ambateno_demo_data_imported', 1 );
}
add_action( 'after_switch_theme', 'ambateno_run_demo_import' );
