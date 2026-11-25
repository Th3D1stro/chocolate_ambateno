<?php
/**
 * Sección 6 de Portada: Contacto y Formulario.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$direccion = get_theme_mod( 'ambateno_contacto_direccion', 'Parque Industrial Ambato, Avenida D entre las calles Tercera y Cuarta, Lote 5 Ambato, Ecuador' );
$telefono  = get_theme_mod( 'ambateno_contacto_telefono', '(+593) 99 393 1813' );
$correo    = get_theme_mod( 'ambateno_contacto_correo', 'chocolateelambatenio@gmail.com' );
$horario   = get_theme_mod( 'ambateno_contacto_horario', 'Siempre Abierto' );
$mapa_url  = get_theme_mod( 'ambateno_contacto_mapa_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.944980726878!2d-78.591675!3d-1.1988381999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d380970aae3c07%3A0x526ed8b120fef3a!2sInphec%20Agroindustrial!5e0!3m2!1ses!2sec!4v1795563398136!5m2!1ses!2sec" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"' );
$tel_href  = 'tel:' . preg_replace( '/\s+/', '', $telefono );
?>
<section id="contacto" aria-labelledby="titulo-contacto" class="patron-puntos relative bg-crema-claro pb-28 pt-16 sm:pt-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6">
		<div class="reveal max-w-2xl">
			<p class="text-lg font-semibold text-caramelo">
				<?php esc_html_e( 'Escríbenos o visítanos', 'chocolate-el-ambateno' ); ?>
			</p>
			<h2 id="titulo-contacto" class="mt-3 text-balance font-display text-4xl font-semibold text-burdeos sm:text-5xl">
				<?php esc_html_e( 'Contacto', 'chocolate-el-ambateno' ); ?>
			</h2>
		</div>

		<div class="mt-10 grid gap-10 lg:grid-cols-2">
			
			<div class="reveal flex flex-col gap-6">
				<ul class="grid gap-4 sm:grid-cols-2">
					<li class="flex gap-3">
						<?php ambateno_icon( 'map-pin', 'mt-1 h-6 w-6 shrink-0 text-caramelo' ); ?>
						<div>
							<h3 class="font-semibold text-burdeos"><?php esc_html_e( 'Dirección', 'chocolate-el-ambateno' ); ?></h3>
							<p class="text-tinta/85"><?php echo esc_html( $direccion ); ?></p>
						</div>
					</li>
					<li class="flex gap-3">
						<?php ambateno_icon( 'phone', 'mt-1 h-6 w-6 shrink-0 text-caramelo' ); ?>
						<div>
							<h3 class="font-semibold text-burdeos"><?php esc_html_e( 'Teléfono', 'chocolate-el-ambateno' ); ?></h3>
							<a href="<?php echo esc_url( $tel_href ); ?>" class="inline-flex min-h-11 items-center text-tinta/85 underline-offset-4 hover:text-burdeos hover:underline">
								<?php echo esc_html( $telefono ); ?>
							</a>
						</div>
					</li>
					<li class="flex gap-3">
						<?php ambateno_icon( 'mail', 'mt-1 h-6 w-6 shrink-0 text-caramelo' ); ?>
						<div>
							<h3 class="font-semibold text-burdeos"><?php esc_html_e( 'Correo', 'chocolate-el-ambateno' ); ?></h3>
							<a href="mailto:<?php echo esc_attr( $correo ); ?>" class="inline-flex min-h-11 items-center text-tinta/85 underline-offset-4 hover:text-burdeos hover:underline">
								<?php echo esc_html( $correo ); ?>
							</a>
						</div>
					</li>
					<li class="flex gap-3">
						<?php ambateno_icon( 'clock', 'mt-1 h-6 w-6 shrink-0 text-caramelo' ); ?>
						<div>
							<h3 class="font-semibold text-burdeos"><?php esc_html_e( 'Horario', 'chocolate-el-ambateno' ); ?></h3>
							<p class="text-tinta/85"><?php echo esc_html( $horario ); ?></p>
						</div>
					</li>
				</ul>

				<div>
					<h3 class="mb-2 font-semibold text-burdeos"><?php esc_html_e( 'Síguenos', 'chocolate-el-ambateno' ); ?></h3>
					<?php get_template_part( 'template-parts/redes-sociales', null, array( 'tono' => 'oscuro' ) ); ?>
				</div>

				<iframe title="<?php esc_attr_e( 'Mapa de Ambato, Ecuador', 'chocolate-el-ambateno' ); ?>" src="<?php echo esc_url( $mapa_url ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="h-72 w-full rounded-xl border-2 border-crema-oscuro bg-crema"></iframe>
			</div>

			<!-- Columna Derecha: Formulario -->
			<div class="reveal rounded-xl border border-crema-oscuro bg-white/85 p-6 shadow-lg shadow-burdeos/5 sm:p-8">
				<h3 class="font-display text-2xl font-semibold text-burdeos">
					<?php esc_html_e( 'Envíanos un mensaje', 'chocolate-el-ambateno' ); ?>
				</h3>
				<p class="mt-1 text-sm text-tinta/75">
					<?php esc_html_e( 'Formulario de demostración: los datos no se envían a ningún lugar.', 'chocolate-el-ambateno' ); ?>
				</p>

				<p class="sr-only" aria-live="polite" id="anuncio-contacto"></p>

				<!-- Estado de éxito -->
				<div id="contacto-exito" role="status" class="hidden mt-6 flex items-start gap-3 rounded-lg border-2 border-oliva bg-oliva-claro p-4 text-tinta">
					<?php ambateno_icon( 'check-circle-2', 'mt-0.5 h-6 w-6 shrink-0 text-burdeos' ); ?>
					<div>
						<p class="font-semibold text-burdeos"><?php esc_html_e( '¡Gracias! Tu mensaje fue enviado.', 'chocolate-el-ambateno' ); ?></p>
						<p class="text-sm"><?php esc_html_e( 'Te responderemos en un plazo de 24 a 48 horas hábiles.', 'chocolate-el-ambateno' ); ?></p>
						<button type="button" id="btn-contacto-reiniciar" class="mt-2 min-h-11 font-semibold text-burdeos underline underline-offset-4">
							<?php esc_html_e( 'Enviar otro mensaje', 'chocolate-el-ambateno' ); ?>
						</button>
					</div>
				</div>

				<!-- Formulario -->
				<form id="form-contacto" noValidate class="mt-6 grid gap-5 sm:grid-cols-2">
					<div class="flex flex-col gap-1.5">
						<label for="contacto-nombre" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Nombre', 'chocolate-el-ambateno' ); ?></label>
						<input id="contacto-nombre" name="nombre" autocomplete="name" required class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta placeholder:text-tinta/50 transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="contacto-nombre-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'Escribe tu nombre.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<div class="flex flex-col gap-1.5">
						<label for="contacto-correo" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Correo electrónico', 'chocolate-el-ambateno' ); ?></label>
						<input id="contacto-correo" name="correo" type="email" autocomplete="email" required class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta placeholder:text-tinta/50 transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="contacto-correo-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'Escribe un correo válido.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<div class="flex flex-col gap-1.5">
						<label for="contacto-telefono" class="text-sm font-semibold text-burdeos">
							<?php esc_html_e( 'Teléfono', 'chocolate-el-ambateno' ); ?> <span class="font-normal text-tinta/70">(<?php esc_html_e( 'opcional', 'chocolate-el-ambateno' ); ?>)</span>
						</label>
						<input id="contacto-telefono" name="telefono" type="tel" inputmode="numeric" autocomplete="tel" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta placeholder:text-tinta/50 transition-colors hover:border-burdeos/45 focus-visible:border-burdeos" />
						<p id="contacto-telefono-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'El teléfono debe tener 9 o 10 dígitos.', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<div class="flex flex-col gap-1.5">
						<label for="contacto-asunto" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Asunto', 'chocolate-el-ambateno' ); ?></label>
						<select id="contacto-asunto" name="asunto" class="h-12 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 text-tinta placeholder:text-tinta/50 transition-colors hover:border-burdeos/45 focus-visible:border-burdeos">
							<option value="consulta"><?php esc_html_e( 'Consulta general', 'chocolate-el-ambateno' ); ?></option>
							<option value="pedido"><?php esc_html_e( 'Pedido al por mayor', 'chocolate-el-ambateno' ); ?></option>
							<option value="distribucion"><?php esc_html_e( 'Quiero ser distribuidor', 'chocolate-el-ambateno' ); ?></option>
							<option value="otro"><?php esc_html_e( 'Otro', 'chocolate-el-ambateno' ); ?></option>
						</select>
					</div>

					<div class="flex flex-col gap-1.5 sm:col-span-2">
						<label for="contacto-mensaje" class="text-sm font-semibold text-burdeos"><?php esc_html_e( 'Mensaje', 'chocolate-el-ambateno' ); ?></label>
						<textarea id="contacto-mensaje" name="mensaje" rows="4" required class="min-h-32 w-full rounded-md border-2 border-burdeos/25 bg-white px-3 py-3 text-tinta placeholder:text-tinta/50 transition-colors hover:border-burdeos/45 focus-visible:border-burdeos"></textarea>
						<p id="contacto-mensaje-error" class="hidden flex items-start gap-1.5 text-sm font-medium text-burdeos">
							<?php ambateno_icon( 'alert-circle', 'mt-0.5 h-4 w-4 shrink-0 text-burdeos' ); ?>
							<span><?php esc_html_e( 'Cuéntanos un poco más (mínimo 10 caracteres).', 'chocolate-el-ambateno' ); ?></span>
						</p>
					</div>

					<button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-burdeos px-5 py-2.5 font-semibold text-crema transition-colors duration-200 hover:bg-burdeos-oscuro active:bg-tinta sm:col-span-2">
						<?php ambateno_icon( 'send', 'h-5 w-5' ); ?>
						<?php esc_html_e( 'Enviar mensaje', 'chocolate-el-ambateno' ); ?>
					</button>
				</form>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/wave', null, array( 'class' => 'text-burdeos' ) ); ?>
</section>
