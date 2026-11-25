<?php
/**
 * Modal de Autenticación simulada (Registro e Inicio de sesión).
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="modal-auth" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">
	<!-- Backdrop -->
	<div class="auth-backdrop absolute inset-0 bg-tinta/70 backdrop-blur-xs" aria-hidden="true"></div>

	<!-- Panel -->
	<div class="aviso-entrada relative max-h-[92vh] w-full max-w-md overflow-y-auto rounded-2xl bg-crema-claro p-6 text-tinta shadow-2xl border-2 border-burdeos/20 sm:p-8">
		<!-- Botón cerrar -->
		<button type="button" id="btn-cerrar-auth" class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-crema text-burdeos transition-colors hover:bg-burdeos hover:text-crema" aria-label="<?php esc_attr_e( 'Cerrar ventana de autenticación', 'chocolate-el-ambateno' ); ?>">
			<?php ambateno_icon( 'x', 'h-5 w-5' ); ?>
		</button>

		<!-- Encabezado con logo y título -->
		<div class="text-center">
			<div class="mx-auto mb-3 flex justify-center">
				<?php get_template_part( 'template-parts/logo', null, array( 'tono' => 'oscuro', 'clase' => 'h-16 w-auto' ) ); ?>
			</div>
			<h2 id="auth-modal-title" class="font-display text-2xl font-bold text-burdeos">
				<?php esc_html_e( 'Bienvenido a El Ambateño', 'chocolate-el-ambateno' ); ?>
			</h2>
			<p id="auth-modal-subtitle" class="mt-1 text-sm text-tinta/80">
				<?php esc_html_e( 'Inicia sesión para gestionar tus pedidos y perfil', 'chocolate-el-ambateno' ); ?>
			</p>
		</div>

		<!-- Selector de pestañas: Iniciar sesión / Registrarse -->
		<div class="mt-6 flex rounded-xl border border-burdeos/20 bg-white p-1" role="tablist">
			<button type="button" id="tab-login" role="tab" aria-selected="true" class="flex-1 rounded-lg py-2.5 text-sm font-bold transition-all bg-burdeos text-crema shadow-xs">
				<?php esc_html_e( 'Iniciar sesión', 'chocolate-el-ambateno' ); ?>
			</button>
			<button type="button" id="tab-register" role="tab" aria-selected="false" class="flex-1 rounded-lg py-2.5 text-sm font-semibold text-burdeos transition-all hover:bg-crema/60">
				<?php esc_html_e( 'Registrarse', 'chocolate-el-ambateno' ); ?>
			</button>
		</div>

		<!-- Alerta / Mensaje de error o éxito -->
		<div id="auth-alert" class="hidden mt-4 rounded-xl p-3 text-sm font-medium" role="alert"></div>

		<!-- FORMULARIO 1: INICIO DE SESIÓN -->
		<form id="form-auth-login" class="mt-5 flex flex-col gap-4">
			<div>
				<label for="login-email" class="block text-sm font-semibold text-burdeos mb-1">
					<?php esc_html_e( 'Correo electrónico', 'chocolate-el-ambateno' ); ?>
				</label>
				<div class="relative">
					<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-burdeos/60">
						<?php ambateno_icon( 'mail', 'h-4 w-4' ); ?>
					</span>
					<input type="email" id="login-email" required placeholder="tu@correo.com" class="h-11 w-full rounded-lg border-2 border-burdeos/20 bg-white pl-10 pr-3 text-sm text-tinta transition-colors placeholder:text-tinta/40 focus-visible:border-burdeos focus-visible:outline-none" />
				</div>
			</div>

			<div>
				<label for="login-password" class="block text-sm font-semibold text-burdeos mb-1">
					<?php esc_html_e( 'Contraseña', 'chocolate-el-ambateno' ); ?>
				</label>
				<div class="relative">
					<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-burdeos/60">
						<?php ambateno_icon( 'lock', 'h-4 w-4' ); ?>
					</span>
					<input type="password" id="login-password" required placeholder="••••••••" class="h-11 w-full rounded-lg border-2 border-burdeos/20 bg-white pl-10 pr-3 text-sm text-tinta transition-colors placeholder:text-tinta/40 focus-visible:border-burdeos focus-visible:outline-none" />
				</div>
			</div>

			<button type="submit" class="mt-2 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-lg bg-burdeos px-4 py-2.5 font-bold text-crema transition-colors hover:bg-burdeos-oscuro">
				<?php ambateno_icon( 'user', 'h-4 w-4' ); ?>
				<?php esc_html_e( 'Ingresar a mi cuenta', 'chocolate-el-ambateno' ); ?>
			</button>
		</form>

		<!-- FORMULARIO 2: REGISTRO -->
		<form id="form-auth-register" class="hidden mt-5 flex flex-col gap-4">
			<div>
				<label for="register-name" class="block text-sm font-semibold text-burdeos mb-1">
					<?php esc_html_e( 'Nombre completo', 'chocolate-el-ambateno' ); ?>
				</label>
				<div class="relative">
					<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-burdeos/60">
						<?php ambateno_icon( 'user', 'h-4 w-4' ); ?>
					</span>
					<input type="text" id="register-name" required placeholder="Ej. Carlos Morales" class="h-11 w-full rounded-lg border-2 border-burdeos/20 bg-white pl-10 pr-3 text-sm text-tinta transition-colors placeholder:text-tinta/40 focus-visible:border-burdeos focus-visible:outline-none" />
				</div>
			</div>

			<div>
				<label for="register-email" class="block text-sm font-semibold text-burdeos mb-1">
					<?php esc_html_e( 'Correo electrónico', 'chocolate-el-ambateno' ); ?>
				</label>
				<div class="relative">
					<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-burdeos/60">
						<?php ambateno_icon( 'mail', 'h-4 w-4' ); ?>
					</span>
					<input type="email" id="register-email" required placeholder="tu@correo.com" class="h-11 w-full rounded-lg border-2 border-burdeos/20 bg-white pl-10 pr-3 text-sm text-tinta transition-colors placeholder:text-tinta/40 focus-visible:border-burdeos focus-visible:outline-none" />
				</div>
			</div>

			<div>
				<label for="register-password" class="block text-sm font-semibold text-burdeos mb-1">
					<?php esc_html_e( 'Contraseña', 'chocolate-el-ambateno' ); ?>
				</label>
				<div class="relative">
					<span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-burdeos/60">
						<?php ambateno_icon( 'lock', 'h-4 w-4' ); ?>
					</span>
					<input type="password" id="register-password" minlength="4" required placeholder="Mínimo 4 caracteres" class="h-11 w-full rounded-lg border-2 border-burdeos/20 bg-white pl-10 pr-3 text-sm text-tinta transition-colors placeholder:text-tinta/40 focus-visible:border-burdeos focus-visible:outline-none" />
				</div>
			</div>

			<button type="submit" class="mt-2 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-lg bg-burdeos px-4 py-2.5 font-bold text-crema transition-colors hover:bg-burdeos-oscuro">
				<?php ambateno_icon( 'check', 'h-4 w-4' ); ?>
				<?php esc_html_e( 'Crear mi cuenta', 'chocolate-el-ambateno' ); ?>
			</button>
		</form>
	</div>
</div>
