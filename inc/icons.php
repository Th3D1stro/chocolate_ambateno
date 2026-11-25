<?php
/**
 * Renderizado de iconos SVG de Lucide para el tema.
 *
 * @package Chocolate_El_Ambateno
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Devuelve el marcado SVG de un icono de Lucide.
 *
 * @param string $name Nombre del icono en kebab-case.
 * @param string $class Clases CSS adicionales.
 * @param bool   $aria_hidden Si debe incluir aria-hidden="true".
 * @return string Marcado SVG seguro.
 */
function ambateno_get_icon( $name, $class = 'h-5 w-5', $aria_hidden = true ) {
	$aria_attr = $aria_hidden ? ' aria-hidden="true"' : '';
	$cls       = esc_attr( $class );

	$icons = array(
		'alert-circle'        => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
		'arrow-left'          => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
		'arrow-right'         => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'award'               => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
		'banknote'            => '<rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/>',
		'calendar-clock'      => '<path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h5"/><path d="M17.5 17.5 16 16.3V14"/><circle cx="16" cy="16" r="6"/>',
		'candy-off'           => '<path d="m8.5 8.5 7 7"/><path d="M18.5 18.5 22 22"/><path d="m2 2 20 20"/><path d="M11.5 6.5A5.002 5.002 0 0 1 17.5 12.5"/><path d="M6.5 11.5A5.002 5.002 0 0 0 12.5 17.5"/><path d="m16 8 3-3a2 2 0 0 0 0-2.83l-.17-.17a2 2 0 0 0-2.83 0L13 5"/><path d="m8 16-3 3a2 2 0 0 0 0 2.83l.17.17a2 2 0 0 0 2.83 0L11 19"/>',
		'check'               => '<path d="M20 6 9 17l-5-5"/>',
		'check-circle-2'      => '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
		'chef-hat'            => '<path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" x2="18" y1="17" y2="17"/>',
		'chevron-left'        => '<path d="m15 18-6-6 6-6"/>',
		'chevron-right'       => '<path d="m9 18 6-6-6-6"/>',
		'clock'               => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
		'coffee'              => '<path d="M10 2v2"/><path d="M14 2v2"/><path d="M16 8a1 1 0 0 1 1 1v8a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V9a1 1 0 0 1 1-1h12Z"/><path d="M6 2v2"/><path d="M17 10h1a3 3 0 0 1 3 3v1a3 3 0 0 1-3 3h-1"/>',
		'cooking-pot'         => '<path d="M2 12h20"/><path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/><path d="m4 8 16-4"/><path d="m8.86 6.78-.4-.91a2 2 0 0 1 1.02-2.65l1.83-.8a2 2 0 0 1 2.65 1.02l.4.91"/>',
		'credit-card'         => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
		'eye'                 => '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
		'file-text'           => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
		'flame'               => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>',
		'globe'               => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
		'home'                => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
		'info'                => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>',
		'landmark'            => '<line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7"/>',
		'lock'                => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
		'mail'                => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'map'                 => '<path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/>',
		'map-pin'             => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
		'menu'                => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
		'minus'               => '<path d="M5 12h14"/>',
		'mouse-pointer-click' => '<path d="m9 9 5 12 1.8-5.2L21 14Z"/><path d="M7.2 2.2 8 5.1"/><path d="m5.1 8-2.9-.8"/><path d="M14 4.1 12 6"/><path d="m6 12-1.9 2"/>',
		'pencil-line'         => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>',
		'phone'               => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'plus'                => '<path d="M5 12h14"/><path d="M12 5v14"/>',
		'search'              => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
		'search-x'            => '<path d="m13.5 8.5-5 5"/><path d="m8.5 8.5 5 5"/><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
		'send'                => '<path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>',
		'shield-check'        => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
		'shopping-bag'        => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
		'store'               => '<path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2 2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2 2 2 0 0 1-2 2H7a2 2 0 0 1-2-2 2 2 0 0 1-2 2H2a2 2 0 0 1-2-2"/>',
		'trash-2'             => '<path d="3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/>',
		'truck'               => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
		'users'               => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'wheat-off'           => '<path d="m2 2 20 20"/><path d="M7.4 7.4A6.002 6.002 0 0 0 12 18V2"/><path d="M12 6a6 6 0 0 1 6 6c0 1.25-.38 2.41-1.03 3.38"/><path d="M8.5 13.5a6 6 0 0 1-2.92-2.92"/><path d="M15.5 10.5a6 6 0 0 0-3.5-3.5"/>',
		'x'                   => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg viewBox="0 0 24 24" class="%s" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%s>%s</svg>',
		$cls,
		$aria_attr,
		$icons[ $name ]
	);
}

/**
 * Imprime directamente el SVG de un icono.
 *
 * @param string $name Nombre del icono.
 * @param string $class Clases CSS adicionales.
 * @param bool   $aria_hidden Si debe incluir aria-hidden="true".
 */
function ambateno_icon( $name, $class = 'h-5 w-5', $aria_hidden = true ) {
	echo ambateno_get_icon( $name, $class, $aria_hidden ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
