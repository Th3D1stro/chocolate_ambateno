<?php
/**
 * Opciones editables del tema en el Personalizador de WordPress (Customizer API).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ambateno_customize_register( $wp_customize ) {

	$theme_uri = get_template_directory_uri();

	// Panel principal para El Ambateño
	$wp_customize->add_panel(
		'ambateno_panel_landing',
		array(
			'title'       => __( 'El Ambateño · Secciones de Portada', 'chocolate-el-ambateno' ),
			'description' => __( 'Edita los textos y contenidos de las secciones de la portada.', 'chocolate-el-ambateno' ),
			'priority'    => 30,
		)
	);

	// 1. Portada / Hero
	$wp_customize->add_section(
		'ambateno_sec_hero',
		array(
			'title'    => __( 'Portada · Hero', 'chocolate-el-ambateno' ),
			'panel'    => 'ambateno_panel_landing',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'ambateno_hero_badge',
		array(
			'default'           => 'Hecho a mano en Ambato, Ecuador',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_badge',
		array(
			'label'   => __( 'Texto de ubicación / Insignia superior', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_hero_titulo',
		array(
			'default'           => 'Chocolate artesanal con el carácter de los Andes',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_titulo',
		array(
			'label'   => __( 'Título principal (H1)', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_hero_descripcion',
		array(
			'default'           => 'Cacao fino de aroma ecuatoriano en una barra tradicional de 200 g, sin azúcar y libre de gluten, hecha para compartir en familia.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_descripcion',
		array(
			'label'   => __( 'Descripción', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_hero',
			'type'    => 'textarea',
		)
	);

	// Hero Imagen de fondo
	$wp_customize->add_setting(
		'ambateno_hero_imagen',
		array(
			'default'           => $theme_uri . '/assets/img/hero-chocolate.webp',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ambateno_hero_imagen',
			array(
				'label'       => __( 'Imagen de fondo del Hero', 'chocolate-el-ambateno' ),
				'description' => __( 'Recomendado: 1920x1080 o similar en formato WebP o JPG.', 'chocolate-el-ambateno' ),
				'section'     => 'ambateno_sec_hero',
			)
		)
	);

	// Hero Botón 1
	$wp_customize->add_setting(
		'ambateno_hero_btn1_texto',
		array(
			'default'           => 'Ver productos',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_btn1_texto',
		array(
			'label'   => __( 'Texto del botón principal', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_hero_btn1_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_btn1_url',
		array(
			'label'       => __( 'URL del botón principal (vacío = página Tienda)', 'chocolate-el-ambateno' ),
			'section'     => 'ambateno_sec_hero',
			'type'        => 'url',
		)
	);

	// Hero Botón 2
	$wp_customize->add_setting(
		'ambateno_hero_btn2_texto',
		array(
			'default'           => 'Conoce nuestra historia',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_btn2_texto',
		array(
			'label'   => __( 'Texto del botón secundario', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_hero_btn2_url',
		array(
			'default'           => '#historia',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_hero_btn2_url',
		array(
			'label'   => __( 'Enlace del botón secundario', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_hero',
			'type'    => 'text',
		)
	);

	// 2. Nuestro Chocolate
	$wp_customize->add_section(
		'ambateno_sec_chocolate',
		array(
			'title'    => __( 'Nuestro chocolate', 'chocolate-el-ambateno' ),
			'panel'    => 'ambateno_panel_landing',
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'ambateno_chocolate_subtitulo',
		array(
			'default'           => 'Una barra, tres maneras de disfrutarla',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_chocolate_subtitulo',
		array(
			'label'   => __( 'Subtítulo', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_chocolate',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_chocolate_titulo',
		array(
			'default'           => 'Nuestro chocolate',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_chocolate_titulo',
		array(
			'label'   => __( 'Título', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_chocolate',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_chocolate_descripcion',
		array(
			'default'           => 'Todas nuestras presentaciones pesan 200 g y nacen del mismo cacao fino de aroma, tostado lento y molido en piedra en nuestro taller de Ambato.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_chocolate_descripcion',
		array(
			'label'   => __( 'Descripción', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_chocolate',
			'type'    => 'textarea',
		)
	);

	// Chocolate Imagen
	$wp_customize->add_setting(
		'ambateno_chocolate_imagen',
		array(
			'default'           => $theme_uri . '/assets/img/producto-barra.webp',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ambateno_chocolate_imagen',
			array(
				'label'   => __( 'Imagen destacada de la sección', 'chocolate-el-ambateno' ),
				'section' => 'ambateno_sec_chocolate',
			)
		)
	);

	// Chocolate Botón
	$wp_customize->add_setting(
		'ambateno_chocolate_btn_texto',
		array(
			'default'           => 'Comprar ahora',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_chocolate_btn_texto',
		array(
			'label'   => __( 'Texto del botón', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_chocolate',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_chocolate_btn_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'ambateno_chocolate_btn_url',
		array(
			'label'       => __( 'URL del botón (vacío = página Tienda)', 'chocolate-el-ambateno' ),
			'section'     => 'ambateno_sec_chocolate',
			'type'        => 'url',
		)
	);

	// 3. Preparación
	$wp_customize->add_section(
		'ambateno_sec_preparacion',
		array(
			'title'    => __( 'Preparación', 'chocolate-el-ambateno' ),
			'panel'    => 'ambateno_panel_landing',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'ambateno_prep_subtitulo',
		array(
			'default'           => 'Paso a paso con nuestro chef chocolatero',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_prep_subtitulo',
		array(
			'label'   => __( 'Subtítulo', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_preparacion',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_prep_titulo',
		array(
			'default'           => 'Preparación',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_prep_titulo',
		array(
			'label'   => __( 'Título', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_preparacion',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_prep_descripcion',
		array(
			'default'           => 'Así preparamos en el taller el chocolate caliente de la casa. Cuatro pasos, quince minutos y una barra de 200 g para cuatro tazas.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_prep_descripcion',
		array(
			'label'   => __( 'Descripción', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_preparacion',
			'type'    => 'textarea',
		)
	);

	// Preparación Imágenes: Chef y Receta
	$wp_customize->add_setting(
		'ambateno_prep_chef_imagen',
		array(
			'default'           => $theme_uri . '/assets/img/chef-chocolatero.webp',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ambateno_prep_chef_imagen',
			array(
				'label'   => __( 'Foto del chef chocolatero', 'chocolate-el-ambateno' ),
				'section' => 'ambateno_sec_preparacion',
			)
		)
	);

	$wp_customize->add_setting(
		'ambateno_receta_texto',
		array(
			'default'           => '1 barra tradicional de 200 g, 1 litro de leche, 1 rama de canela y una pizca de sal. Sirve con queso fresco para la experiencia ambateña completa.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_receta_texto',
		array(
			'label'   => __( 'Texto de la receta destacada', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_preparacion',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'ambateno_prep_receta_imagen',
		array(
			'default'           => $theme_uri . '/assets/img/producto-taza.webp',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ambateno_prep_receta_imagen',
			array(
				'label'   => __( 'Foto de la receta destacada', 'chocolate-el-ambateno' ),
				'section' => 'ambateno_sec_preparacion',
			)
		)
	);

	// 4. Historia
	$wp_customize->add_section(
		'ambateno_sec_historia',
		array(
			'title'    => __( 'Nuestra historia', 'chocolate-el-ambateno' ),
			'panel'    => 'ambateno_panel_landing',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'ambateno_historia_titulo',
		array(
			'default'           => 'Nuestra historia',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_historia_titulo',
		array(
			'label'   => __( 'Título', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_historia',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_historia_p1',
		array(
			'default'           => 'El Ambateño nació en una cocina familiar de Ambato, la tierra de las flores y las frutas, donde el chocolate de taza siempre acompañó las tardes frías de la sierra. Quisimos conservar esa receta y hacerla apta para todos: sin azúcar y libre de gluten.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_historia_p1',
		array(
			'label'   => __( 'Párrafo 1', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_historia',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'ambateno_historia_p2',
		array(
			'default'           => 'Trabajamos de la mano de INPHEC para cuidar cada etapa del proceso, desde la selección del grano hasta el empaque. [Describe aquí la relación real de la marca con INPHEC: certificación, acompañamiento técnico o programa de emprendimiento.]',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_historia_p2',
		array(
			'label'   => __( 'Párrafo 2 (vínculo con INPHEC)', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_historia',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'ambateno_historia_cita',
		array(
			'default'           => '“Hacemos el chocolate que nos gustaría compartir con nuestra familia.”',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_historia_cita',
		array(
			'label'   => __( 'Cita destacada', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_historia',
			'type'    => 'text',
		)
	);

	// Historia Imagen
	$wp_customize->add_setting(
		'ambateno_historia_imagen',
		array(
			'default'           => $theme_uri . '/assets/img/historia-taller.webp',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ambateno_historia_imagen',
			array(
				'label'   => __( 'Foto del taller / historia', 'chocolate-el-ambateno' ),
				'section' => 'ambateno_sec_historia',
			)
		)
	);

	// 5. Dónde Encontrarlo
	$wp_customize->add_section(
		'ambateno_sec_donde',
		array(
			'title'    => __( 'Dónde encontrarlo', 'chocolate-el-ambateno' ),
			'panel'    => 'ambateno_panel_landing',
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'ambateno_donde_subtitulo',
		array(
			'default'           => 'Tiendas, cafeterías y canales online',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_donde_subtitulo',
		array(
			'label'   => __( 'Subtítulo', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_donde',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_donde_titulo',
		array(
			'default'           => 'Dónde encontrarlo',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_donde_titulo',
		array(
			'label'   => __( 'Título', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_donde',
			'type'    => 'text',
		)
	);

	// 6. Contacto
	$wp_customize->add_section(
		'ambateno_sec_contacto',
		array(
			'title'       => __( 'Contacto y Ubicación', 'chocolate-el-ambateno' ),
			'description' => __( 'Datos de contacto para la portada, footer y esquema LocalBusiness.', 'chocolate-el-ambateno' ),
			'priority'    => 35,
		)
	);

	$wp_customize->add_setting(
		'ambateno_contacto_direccion',
		array(
			'default'           => 'Av. Cevallos 08-45 y Montalvo, Ambato, Tungurahua',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_contacto_direccion',
		array(
			'label'   => __( 'Dirección física', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_contacto',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_contacto_telefono',
		array(
			'default'           => '+593 3 000 0000',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_contacto_telefono',
		array(
			'label'   => __( 'Teléfono visible', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_contacto',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_contacto_correo',
		array(
			'default'           => 'hola@elambateno.ec',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'ambateno_contacto_correo',
		array(
			'label'   => __( 'Correo electrónico', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_contacto',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'ambateno_contacto_horario',
		array(
			'default'           => 'Lunes a sábado, 09:00 a 19:00',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'ambateno_contacto_horario',
		array(
			'label'   => __( 'Horario de atención', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_contacto',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'ambateno_contacto_mapa_url',
		array(
			'default'           => 'https://www.google.com/maps?q=Ambato,Tungurahua,Ecuador&z=14&output=embed',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'ambateno_contacto_mapa_url',
		array(
			'label'   => __( 'URL del iframe de Google Maps', 'chocolate-el-ambateno' ),
			'section' => 'ambateno_sec_contacto',
			'type'    => 'url',
		)
	);

	// 7. Redes Sociales
	$wp_customize->add_section(
		'ambateno_sec_redes',
		array(
			'title'    => __( 'Redes Sociales', 'chocolate-el-ambateno' ),
			'priority' => 36,
		)
	);

	$redes = array(
		'instagram' => array( 'label' => 'Instagram', 'default' => 'https://instagram.com/' ),
		'facebook'  => array( 'label' => 'Facebook', 'default' => 'https://facebook.com/' ),
		'tiktok'    => array( 'label' => 'TikTok', 'default' => 'https://tiktok.com/' ),
		'whatsapp'  => array( 'label' => 'WhatsApp', 'default' => 'https://wa.me/59330000000' ),
	);

	foreach ( $redes as $id => $info ) {
		$wp_customize->add_setting(
			"ambateno_redes_{$id}",
			array(
				'default'           => $info['default'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"ambateno_redes_{$id}",
			array(
				'label'   => $info['label'],
				'section' => 'ambateno_sec_redes',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'ambateno_customize_register' );
