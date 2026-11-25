/**
 * Script global para Chocolate El Ambateño.
 * Controla:
 * - Detección de scroll para navbar sticky y sombra.
 * - Menú móvil accesible con Esc y retorno de foco.
 * - Modal del Mapa del Sitio con focus trap, bloqueo de scroll y Esc.
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Navbar sticky y sombra en scroll
  const navbarBar = document.getElementById('navbar-bar');
  const navbarInner = document.getElementById('navbar-inner');

  const onScroll = () => {
    if (!navbarBar || !navbarInner) return;
    const scrolled = window.scrollY > 24;
    if (scrolled) {
      navbarBar.classList.add('shadow-lg', 'shadow-tinta/25');
      navbarInner.classList.remove('h-20');
      navbarInner.classList.add('h-16');
    } else {
      navbarBar.classList.remove('shadow-lg', 'shadow-tinta/25');
      navbarInner.classList.remove('h-16');
      navbarInner.classList.add('h-20');
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // 2. Menú móvil accesible
  const btnMenuMovil = document.getElementById('btn-menu-movil');
  const menuMovil = document.getElementById('menu-movil');
  const iconOpen = document.getElementById('icon-menu-open');
  const iconClose = document.getElementById('icon-menu-close');

  if (btnMenuMovil && menuMovil) {
    const toggleMenu = (abrir) => {
      const estaAbierto = typeof abrir === 'boolean' ? abrir : menuMovil.hasAttribute('hidden');
      if (estaAbierto) {
        menuMovil.removeAttribute('hidden');
        btnMenuMovil.setAttribute('aria-expanded', 'true');
        btnMenuMovil.setAttribute('aria-label', 'Cerrar menú');
        if (iconOpen) iconOpen.classList.add('hidden');
        if (iconClose) iconClose.classList.remove('hidden');
      } else {
        menuMovil.setAttribute('hidden', '');
        btnMenuMovil.setAttribute('aria-expanded', 'false');
        btnMenuMovil.setAttribute('aria-label', 'Abrir menú');
        if (iconOpen) iconOpen.classList.remove('hidden');
        if (iconClose) iconClose.classList.add('hidden');
      }
    };

    btnMenuMovil.addEventListener('click', () => toggleMenu());

    // Cierre con Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !menuMovil.hasAttribute('hidden')) {
        toggleMenu(false);
        btnMenuMovil.focus();
      }
    });

    // Cierre al hacer clic en un enlace del menú móvil
    menuMovil.querySelectorAll('.nav-link-movil').forEach((link) => {
      link.addEventListener('click', () => toggleMenu(false));
    });
  }

  // 3. Modal accesible del Mapa del Sitio
  const modalSitemap = document.getElementById('modal-sitemap');
  const btnAbrirSitemap = document.getElementById('btn-abrir-sitemap');
  const btnCerrarSitemap = document.getElementById('btn-cerrar-sitemap');
  const triggersSitemap = document.querySelectorAll('.btn-trigger-sitemap');

  if (modalSitemap) {
    let anteriorFoco = null;
    const focusableSelector = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

    const abrirModal = () => {
      anteriorFoco = document.activeElement;
      modalSitemap.classList.remove('hidden');
      document.body.style.overflow = 'hidden';

      const focusables = modalSitemap.querySelectorAll(focusableSelector);
      if (focusables.length > 0) {
        focusables[0].focus();
      }
    };

    const cerrarModal = () => {
      modalSitemap.classList.add('hidden');
      document.body.style.overflow = '';
      if (anteriorFoco && typeof anteriorFoco.focus === 'function') {
        anteriorFoco.focus();
      }
    };

    if (btnAbrirSitemap) {
      btnAbrirSitemap.addEventListener('click', abrirModal);
    }

    triggersSitemap.forEach((btn) => {
      btn.addEventListener('click', abrirModal);
    });

    if (btnCerrarSitemap) {
      btnCerrarSitemap.addEventListener('click', cerrarModal);
    }

    // Clic en backdrop para cerrar
    const backdrop = modalSitemap.querySelector('.modal-backdrop');
    if (backdrop) {
      backdrop.addEventListener('click', cerrarModal);
    }

    // Cierre al pulsar cualquier enlace dentro del mapa del sitio
    modalSitemap.querySelectorAll('.modal-sitemap-link').forEach((link) => {
      link.addEventListener('click', cerrarModal);
    });

    // Focus trap y tecla Escape
    modalSitemap.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        e.preventDefault();
        cerrarModal();
        return;
      }

      if (e.key === 'Tab') {
        const focusables = Array.from(modalSitemap.querySelectorAll(focusableSelector));
        if (focusables.length === 0) return;

        const primero = focusables[0];
        const ultimo = focusables[focusables.length - 1];

        if (e.shiftKey && document.activeElement === primero) {
          e.preventDefault();
          ultimo.focus();
        } else if (!e.shiftKey && document.activeElement === ultimo) {
          e.preventDefault();
          primero.focus();
        }
      }
    });
  }
});
