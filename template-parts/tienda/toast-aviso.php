<?php
/**
 * Toast flotante de notificación (producto añadido).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="toast-aviso" class="hidden aviso-entrada fixed inset-x-4 bottom-4 z-[90] mx-auto flex max-w-md items-center gap-3 rounded-lg bg-burdeos px-4 py-3 text-crema shadow-2xl sm:inset-x-auto sm:right-6" aria-hidden="true">
	<span class="text-oliva shrink-0">
		<?php ambateno_icon( 'check-circle-2', 'h-5 w-5' ); ?>
	</span>
	<p id="toast-aviso-texto" class="text-sm font-medium"></p>
</div>
