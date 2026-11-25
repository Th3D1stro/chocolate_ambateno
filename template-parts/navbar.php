<?php
/**
 * Barra de navegación principal fija (Navbar) con menú accesible y badge de carrito.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_landing = is_front_page();
$home_url   = home_url( '/' );
$tienda_url = ambateno_get_page_url( 'tienda' );

$secciones = array(
	'inicio'      => __( 'Inicio', 'chocolate-el-ambateno' ),
	'chocolate'   => __( 'Nuestro chocolate', 'chocolate-el-ambateno' ),
	'preparacion' => __( 'Preparación', 'chocolate-el-ambateno' ),
	'historia'    => __( 'Nuestra historia', 'chocolate-el-ambateno' ),
	'donde'       => __( 'Dónde encontrarlo', 'chocolate-el-ambateno' ),
	'contacto'    => __( 'Contacto', 'chocolate-el-ambateno' ),
);
?>
<header id="site-header" class="sticky top-0 z-50">
	<div id="navbar-bar" class="on-dark bg-burdeos text-crema transition-shadow duration-300">
		<div id="navbar-inner" class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-4 transition-[height] duration-300 sm:px-6">
			
			<!-- Logo -->
			<a href="<?php echo esc_url( $home_url ); ?>" class="rounded-md" aria-label="<?php esc_attr_e( 'El Ambateño, ir al inicio', 'chocolate-el-ambateno' ); ?>">
				<?php get_template_part('template-parts/logo',null,array('tono'  => 'claro','clase' => 'h-24 w-auto max-w-[220px]',));?>
			</a>
			<!-- Navegación escritorio (con menú registrado o anclas por defecto como respaldo) -->
			<nav aria-label="<?php esc_attr_e( 'Principal', 'chocolate-el-ambateno' ); ?>" class="hidden xl:block">
				<?php
				if ( has_nav_menu( 'menu-principal' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'menu-principal',
							'container'      => false,
							'menu_class'     => 'flex items-center gap-1',
							'fallback_cb'    => 'ambateno_fallback_menu_principal',
						)
					);
				} else {
					ambateno_fallback_menu_principal();
				}
				?>
			</nav>

			<!-- Acciones: Carrito y botón móvil -->
			<div class="flex items-center gap-2">
				<a href="<?php echo esc_url( $tienda_url ); ?>" class="relative inline-flex min-h-11 items-center gap-2 rounded-md border-2 border-crema/60 px-3 font-semibold text-crema transition-colors hover:bg-crema hover:text-burdeos" aria-label="<?php esc_attr_e( 'Ir a la tienda', 'chocolate-el-ambateno' ); ?>" id="btn-tienda-navbar">
					<?php ambateno_icon( 'shopping-bag', 'h-5 w-5' ); ?>
					<span class="hidden sm:inline"><?php esc_html_e( 'Tienda', 'chocolate-el-ambateno' ); ?></span>
					<span id="header-cart-count" class="inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-oliva px-1.5 text-xs font-bold text-tinta" aria-hidden="true">0</span>
				</a>

				<button type="button" id="btn-menu-movil" class="inline-flex h-11 w-11 items-center justify-center rounded-md text-crema hover:bg-burdeos-claro xl:hidden" aria-expanded="false" aria-controls="menu-movil" aria-label="<?php esc_attr_e( 'Abrir menú', 'chocolate-el-ambateno' ); ?>">
					<span id="icon-menu-open"><?php ambateno_icon( 'menu', 'h-6 w-6' ); ?></span>
					<span id="icon-menu-close" class="hidden"><?php ambateno_icon( 'x', 'h-6 w-6' ); ?></span>
				</button>
			</div>
		</div>

		<!-- Menú móvil desplegable -->
		<nav id="menu-movil" aria-label="<?php esc_attr_e( 'Menú móvil', 'chocolate-el-ambateno' ); ?>" hidden class="border-t border-crema/15 xl:hidden">
			<ul class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6">
				<?php foreach ( $secciones as $id => $label ) : 
					$href = $is_landing ? "#{$id}" : "{$home_url}#{$id}";
				?>
					<li>
						<a href="<?php echo esc_url( $href ); ?>" data-seccion-id="<?php echo esc_attr( $id ); ?>" class="nav-link-movil inline-flex min-h-11 w-full items-center rounded-md px-3 py-2 text-base font-medium text-crema transition-colors hover:bg-burdeos-claro">
							<?php echo esc_html( $label ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>

	<!-- Barra de migas de pan integrada en header -->
	<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
</header>
