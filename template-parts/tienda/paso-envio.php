<?php
/**
 * Paso 2 del Checkout: Datos y método de envío.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$provincias = array(
	'Azuay', 'Bolívar', 'Cañar', 'Carchi', 'Chimborazo', 'Cotopaxi', 'El Oro', 'Esmeraldas',
	'Galápagos', 'Guayas', 'Imbabura', 'Loja', 'Los Ríos', 'Manabí', 'Morona Santiago',
	'Napo', 'Orellana', 'Pastaza', 'Pichincha', 'Santa Elena', 'Santo Domingo de los Tsáchilas',
	'Sucumbíos', 'Tungurahua', 'Zamora Chinchipe'
);
?>
<form id="form-paso-envio" noValidate class="flex flex-col gap-6">
	<!-- Métodos de Envío -->
	<fieldset class="rounded-xl border border-crema-oscuro bg-white p-5 sm:p-8">
		<legend class="sr-only"><?php esc_html_e( 'Método de envío', 'chocolate-el-ambateno' ); ?></legend>
		<h2 class="font-display text-2xl font-semibold text-burdeos">
			<?php esc_html_e( '¿Cómo quieres recibirlo?', 'chocolate-el-ambateno' ); ?>
		</h2>
		
		<div class="mt-4 grid gap-3 md:grid-cols-3">
			<!-- Retiro -->
			<label class="label-metodo-envio flex cursor-pointer flex-col gap-1 rounded-lg border-2 p-4 transition-colors border-crema-oscuro hover:border-burdeos/60">
				<span class="flex items-center gap-2">
					<input type="radio" name="metodo_envio" value="retiro" class="h-5 w-5 accent-burdeos" />
					<span class="font-semibold text-burdeos"><?php esc_html_e( 'Retiro en tienda', 'chocolate-el-ambateno' ); ?></span>
				</span>
				<span class="text-sm text-tinta/80"><?php esc_html_e( 'Taller El Ambateño, Ambato', 'chocolate-el-ambateno' ); ?></span>
				<span class="text-sm text-tinta/80"><?php esc_html_e( 'Listo en 24 h', 'chocolate-el-ambateno' ); ?></span>
				<span class="mt-1 text-lg font-bold text-caramelo-oscuro"><?php esc_html_e( 'Gratis', 'chocolate-el-ambateno' ); ?></span>
			</label>

			<!-- Estándar -->
			<label class="label-metodo-envio flex cursor-pointer flex-col gap-1 rounded-lg border-2 p-4 transition-colors border-burdeos bg-crema">
				<span class="flex items-center gap-2">
					<input type="radio" name="metodo_envio" value="estandar" checked class="h-5 w-5 accent-burdeos" />
					<span class="font-semibold text-burdeos"><?php esc_html_e( 'Envío estándar', 'chocolate-el-ambateno' ); ?></span>
				</span>
				<span class="text-sm text-tinta/80"><?php esc_html_e( 'A todo Ecuador continental', 'chocolate-el-ambateno' ); ?></span>
				<span class="text-sm text-tinta/80"><?php esc_html_e( '3 a 5 días hábiles', 'chocolate-el-ambateno' ); ?></span>
				<span class="mt-1 text-lg font-bold text-caramelo-oscuro">$3.50</span>
			</label>

			<!-- Express -->
			<label class="label-metodo-envio flex cursor-pointer flex-col gap-1 rounded-lg border-2 p-4 transition-colors border-crema-oscuro hover:border-burdeos/60">
				<span class="flex items-center gap-2">
					<input type="radio" name="metodo_envio" value="express" class="h-5 w-5 accent-burdeos" />
					<span class="font-semibold text-burdeos"><?php esc_html_e( 'Envío express', 'chocolate-el-ambateno' ); ?></span>
				</span>
				<span class="text-sm text-tinta/80"><?php esc_html_e( 'Ciudades principales', 'chocolate-el-ambateno' ); ?></span>
				<span class="text-sm text-tinta/80"><?php esc_html_e( 'Hasta 48 h, según destino', 'chocolate-el-ambateno' ); ?></span>
				<span class="mt-1 text-lg font-bold text-caramelo-oscuro">$6.50</span>
			</label>
		</div>
	</fieldset>

	<!-- Datos del Cliente -->
	<fieldset class="rounded-xl border border-crema-oscuro bg-white p-5 sm:p-8">
		<legend class="sr-only"><?php esc_html_e( 'Datos de contacto y entrega', 'chocolate-el-ambateno' ); ?></legend>
		<h2 class="font-display text-2xl font-semibold text-burdeos">
			<?php esc_html_e( 'Tus datos', 'chocolate-el-ambateno' ); ?>
		</h2>
		<p class="mt-1 text-sm text-tinta/75">
			<?php esc_html_e( 'Usa datos ficticios: este es un sitio de demostración.', 'chocolate-el-ambateno' ); ?>
		</p>

		<div class="mt-5 grid gap-5 md:grid-cols-2">
			<!-- Nombre -->
			<div class="flex flex-col gap-1.5">
				<label for="envio-nombre" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Nombre completo', 'chocolate-el-ambateno' ); ?></label>
				<input id="envio-nombre" name="nombre" autocomplete="name" required class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
				<p id="envio-nombre-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
					<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
					<span><?php esc_html_e( 'Escribe tu nombre completo.', 'chocolate-el-ambateno' ); ?></span>
				</p>
			</div>

			<!-- Cédula -->
			<div class="flex flex-col gap-1.5">
				<label for="envio-cedula" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Cédula / ID (simulado)', 'chocolate-el-ambateno' ); ?></label>
				<input id="envio-cedula" name="cedula" inputmode="numeric" maxlength="10" placeholder="1800000000" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
				<p id="envio-cedula-ayuda" class="text-xs text-tinta/70"><?php esc_html_e( '10 dígitos. No escribas tu cédula real.', 'chocolate-el-ambateno' ); ?></p>
				<p id="envio-cedula-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
					<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
					<span><?php esc_html_e( 'La cédula debe tener 10 dígitos (dato simulado).', 'chocolate-el-ambateno' ); ?></span>
				</p>
			</div>

			<!-- Teléfono -->
			<div class="flex flex-col gap-1.5">
				<label for="envio-telefono" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Teléfono', 'chocolate-el-ambateno' ); ?></label>
				<input id="envio-telefono" name="telefono" type="tel" inputmode="numeric" autocomplete="tel" placeholder="0990000000" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
				<p id="envio-telefono-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
					<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
					<span><?php esc_html_e( 'Escribe un teléfono de 9 o 10 dígitos.', 'chocolate-el-ambateno' ); ?></span>
				</p>
			</div>

			<!-- Correo -->
			<div class="flex flex-col gap-1.5">
				<label for="envio-correo" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Correo electrónico', 'chocolate-el-ambateno' ); ?></label>
				<input id="envio-correo" name="correo" type="email" autocomplete="email" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
				<p id="envio-correo-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
					<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
					<span><?php esc_html_e( 'Escribe un correo válido.', 'chocolate-el-ambateno' ); ?></span>
				</p>
			</div>

			<!-- Campos condicionales de entrega a domicilio -->
			<div id="seccion-direccion-entrega" class="contents">
				<div class="flex flex-col gap-1.5">
					<label for="envio-provincia" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Provincia', 'chocolate-el-ambateno' ); ?></label>
					<select id="envio-provincia" name="provincia" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos">
						<option value=""><?php esc_html_e( 'Selecciona una provincia', 'chocolate-el-ambateno' ); ?></option>
						<?php foreach ( $provincias as $prov ) : ?>
							<option value="<?php echo esc_attr( $prov ); ?>"><?php echo esc_html( $prov ); ?></option>
						<?php endforeach; ?>
					</select>
					<p id="envio-provincia-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
						<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
						<span><?php esc_html_e( 'Selecciona tu provincia.', 'chocolate-el-ambateno' ); ?></span>
					</p>
				</div>

				<div class="flex flex-col gap-1.5">
					<label for="envio-ciudad" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Ciudad', 'chocolate-el-ambateno' ); ?></label>
					<input id="envio-ciudad" name="ciudad" autocomplete="address-level2" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
					<p id="envio-ciudad-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
						<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
						<span><?php esc_html_e( 'Escribe tu ciudad.', 'chocolate-el-ambateno' ); ?></span>
					</p>
				</div>

				<div class="flex flex-col gap-1.5 md:col-span-2">
					<label for="envio-direccion" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Dirección', 'chocolate-el-ambateno' ); ?></label>
					<input id="envio-direccion" name="direccion" autocomplete="street-address" placeholder="<?php esc_attr_e( 'Calle principal, número y referencia', 'chocolate-el-ambateno' ); ?>" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
					<p id="envio-direccion-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
						<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
						<span><?php esc_html_e( 'Escribe la dirección completa (calle, número y referencia).', 'chocolate-el-ambateno' ); ?></span>
					</p>
				</div>
			</div>

			<!-- Mensaje para retiro en tienda -->
			<div id="seccion-retiro-tienda" class="hidden md:col-span-2">
				<p class="rounded-lg bg-oliva-claro p-4 text-sm text-tinta">
					<?php esc_html_e( 'Retira tu pedido en el taller El Ambateño (Av. Cevallos y Montalvo, Ambato) presentando tu número de pedido.', 'chocolate-el-ambateno' ); ?>
				</p>
			</div>
		</div>
	</fieldset>

	<div class="flex flex-col-reverse gap-3 xs:flex-row xs:justify-between">
		<button type="button" id="btn-envio-volver-carrito" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border-2 border-burdeos px-5 py-2.5 font-semibold text-burdeos transition-colors duration-200 hover:bg-burdeos hover:text-crema">
			<?php ambateno_icon( 'arrow-left', 'h-5 w-5' ); ?>
			<?php esc_html_e( 'Volver al carrito', 'chocolate-el-ambateno' ); ?>
		</button>
		<button type="submit" id="btn-envio-continuar-pago" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta">
			<?php esc_html_e( 'Continuar al pago', 'chocolate-el-ambateno' ); ?>
			<?php ambateno_icon( 'arrow-right', 'h-5 w-5' ); ?>
		</button>
	</div>
</form>
