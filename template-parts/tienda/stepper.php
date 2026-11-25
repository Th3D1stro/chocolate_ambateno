<?php
/**
 * Stepper de 5 pasos para el proceso de compra.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pasos = array(
	'tienda'       => __( 'Tienda', 'chocolate-el-ambateno' ),
	'carrito'      => __( 'Carrito', 'chocolate-el-ambateno' ),
	'envio'        => __( 'Envío', 'chocolate-el-ambateno' ),
	'pago'         => __( 'Pago', 'chocolate-el-ambateno' ),
	'confirmacion' => __( 'Confirmación', 'chocolate-el-ambateno' ),
);
?>
<nav aria-label="<?php esc_attr_e( 'Progreso de la compra', 'chocolate-el-ambateno' ); ?>" id="nav-stepper">
	<ol class="flex items-start">
		<?php 
		$i = 0;
		foreach ( $pasos as $id => $label ) : 
			$is_first = ( 0 === $i );
			$is_active = ( 0 === $i );
		?>
			<li id="step-item-<?php echo esc_attr( $id ); ?>" data-paso-id="<?php echo esc_attr( $id ); ?>" aria-current="<?php echo $is_active ? 'step' : 'false'; ?>" class="step-node relative flex flex-1 flex-col items-center gap-2">
				<?php if ( ! $is_first ) : ?>
					<span class="step-line absolute right-1/2 top-5 h-1 w-full -translate-y-1/2 bg-crema-oscuro" aria-hidden="true"></span>
				<?php endif; ?>
				<span class="step-circle relative z-10 inline-flex h-10 w-10 items-center justify-center rounded-full font-bold <?php echo $is_active ? 'bg-burdeos text-crema ring-4 ring-burdeos/20' : 'bg-crema-oscuro text-tinta'; ?>">
					<span class="step-num"><?php echo esc_html( $i + 1 ); ?></span>
					<span class="step-check hidden"><?php ambateno_icon( 'check', 'h-5 w-5' ); ?></span>
				</span>
				<span class="step-label text-center text-xs font-semibold sm:text-sm <?php echo $is_active ? 'text-burdeos' : 'text-tinta/80'; ?>">
					<?php echo esc_html( $label ); ?>
					<span class="sr-only step-sr"><?php echo $is_active ? ' (paso actual)' : ' (pendiente)'; ?></span>
				</span>
			</li>
		<?php 
			$i++;
		endforeach; 
		?>
	</ol>
</nav>
