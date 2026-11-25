/**
 * Interactividad de la Portada (Landing Page) para Chocolate El Ambateño.
 * Controla:
 * - Scroll-spy con IntersectionObserver en las 6 secciones.
 * - Sincronización de enlaces activos en navbar y migas de pan dinámicas.
 * - Animación sutil .reveal (IntersectionObserver con threshold 0.12).
 * - Filtro de puntos de venta por canal: Todos ('todos'), Tienda física ('fisica'), Cafetería ('cafeteria'), Online ('online').
 * - Validación y envío simulado del formulario de contacto.
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Scroll-spy de secciones y migas de pan dinámicas
  const seccionesIds = ['inicio', 'chocolate', 'preparacion', 'historia', 'donde', 'contacto'];
  const labelsSecciones = {
    inicio: 'Inicio',
    chocolate: 'Nuestro chocolate',
    preparacion: 'Preparación',
    historia: 'Nuestra historia',
    donde: 'Dónde encontrarlo',
    contacto: 'Contacto',
  };

  const elementosSecciones = seccionesIds
    .map((id) => document.getElementById(id))
    .filter((el) => el !== null);

  const migaActiva = document.getElementById('miga-activa-landing');
  const navLinks = document.querySelectorAll('.nav-link[data-seccion-id]');
  const navLinksMovil = document.querySelectorAll('.nav-link-movil[data-seccion-id]');

  function marcarActivo(id) {
    // Actualizar nav enlaces escritorio
    navLinks.forEach((link) => {
      const linkId = link.getAttribute('data-seccion-id');
      if (linkId === id) {
        link.classList.remove('text-crema', 'hover:bg-burdeos-claro');
        link.classList.add('bg-crema', 'text-burdeos');
        link.setAttribute('aria-current', 'location');
      } else {
        link.classList.remove('bg-crema', 'text-burdeos');
        link.classList.add('text-crema', 'hover:bg-burdeos-claro');
        link.removeAttribute('aria-current');
      }
    });

    // Actualizar nav enlaces móvil
    navLinksMovil.forEach((link) => {
      const linkId = link.getAttribute('data-seccion-id');
      if (linkId === id) {
        link.classList.remove('text-crema', 'hover:bg-burdeos-claro');
        link.classList.add('bg-crema', 'text-burdeos');
        link.setAttribute('aria-current', 'location');
      } else {
        link.classList.remove('bg-crema', 'text-burdeos');
        link.classList.add('text-crema', 'hover:bg-burdeos-claro');
        link.removeAttribute('aria-current');
      }
    });

    // Actualizar miga de pan activa
    if (migaActiva) {
      if (id === 'inicio') {
        migaActiva.textContent = 'Inicio';
      } else if (labelsSecciones[id]) {
        migaActiva.innerHTML = `<a href="#inicio" class="text-burdeos hover:underline hover:text-caramelo-oscuro">Inicio</a> <span class="text-caramelo" aria-hidden="true">›</span> <span class="text-tinta font-semibold">${labelsSecciones[id]}</span>`;
      }
    }
  }

  if (elementosSecciones.length > 0) {
    const spyObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            marcarActivo(entry.target.id);
          }
        });
      },
      { rootMargin: '-40% 0px -55% 0px' }
    );

    elementosSecciones.forEach((el) => spyObserver.observe(el));
  }

  // 2. Animación de entrada .reveal
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.classList.add('reveal-ready');

    const revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );

    document.querySelectorAll('.reveal:not(.is-visible)').forEach((el) => {
      revealObserver.observe(el);
    });
  }

  // 3. Filtro interactivo de puntos de venta
  const contenedorFiltros = document.getElementById('grupo-filtros-establecimientos');
  const listaEstablecimientos = document.getElementById('lista-establecimientos');
  const conteoEstablecimientos = document.getElementById('conteo-establecimientos');

  if (contenedorFiltros && listaEstablecimientos) {
    const botones = contenedorFiltros.querySelectorAll('.btn-filtro-local');
    const items = listaEstablecimientos.querySelectorAll('.item-establecimiento');

    botones.forEach((btn) => {
      btn.addEventListener('click', () => {
        const filtro = btn.getAttribute('data-filtro');

        // Actualizar estados visuales de los botones
        botones.forEach((b) => {
          const activo = b === btn;
          b.setAttribute('aria-pressed', activo ? 'true' : 'false');
          if (activo) {
            b.classList.remove('border-crema/50', 'text-crema', 'hover:border-crema', 'hover:bg-burdeos-claro');
            b.classList.add('border-crema', 'bg-crema', 'text-burdeos');
          } else {
            b.classList.remove('border-crema', 'bg-crema', 'text-burdeos');
            b.classList.add('border-crema/50', 'text-crema', 'hover:border-crema', 'hover:bg-burdeos-claro');
          }
        });

        // Filtrar elementos de la lista
        let visibles = 0;
        items.forEach((item) => {
          const tipo = item.getAttribute('data-tipo');
          if (filtro === 'todos' || tipo === filtro) {
            item.classList.remove('hidden');
            visibles++;
          } else {
            item.classList.add('hidden');
          }
        });

        // Actualizar anuncio accesible
        if (conteoEstablecimientos) {
          const texto = visibles === 1 ? 'Mostrando 1 punto de venta' : `Mostrando ${visibles} puntos de venta`;
          conteoEstablecimientos.textContent = texto;
        }
      });
    });
  }

  // 4. Formulario de contacto accesible con validación
  const formContacto = document.getElementById('form-contacto');
  const exitoContacto = document.getElementById('contacto-exito');
  const btnReiniciar = document.getElementById('btn-contacto-reiniciar');
  const anuncioContacto = document.getElementById('anuncio-contacto');

  if (formContacto) {
    const campos = {
      nombre: {
        input: document.getElementById('contacto-nombre'),
        error: document.getElementById('contacto-nombre-error'),
        validar: (v) => v.trim().length > 0,
      },
      correo: {
        input: document.getElementById('contacto-correo'),
        error: document.getElementById('contacto-correo-error'),
        validar: (v) => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim()),
      },
      telefono: {
        input: document.getElementById('contacto-telefono'),
        error: document.getElementById('contacto-telefono-error'),
        validar: (v) => v.trim().length === 0 || /^\d{9,10}$/.test(v.replace(/[\s-]/g, '')),
      },
      mensaje: {
        input: document.getElementById('contacto-mensaje'),
        error: document.getElementById('contacto-mensaje-error'),
        validar: (v) => v.trim().length >= 10,
      },
    };

    // Limpiar errores mientras el usuario escribe
    Object.values(campos).forEach(({ input, error }) => {
      if (!input || !error) return;
      input.addEventListener('input', () => {
        error.classList.add('hidden');
        input.removeAttribute('aria-invalid');
      });
    });

    formContacto.addEventListener('submit', (e) => {
      e.preventDefault();
      let primerInvalido = null;
      let contadorErrores = 0;

      for (const [id, campo] of Object.entries(campos)) {
        if (!campo.input || !campo.error) continue;
        const esValido = campo.validar(campo.input.value);
        if (!esValido) {
          campo.error.classList.remove('hidden');
          campo.input.setAttribute('aria-invalid', 'true');
          contadorErrores++;
          if (!primerInvalido) primerInvalido = campo.input;
        } else {
          campo.error.classList.add('hidden');
          campo.input.removeAttribute('aria-invalid');
        }
      }

      if (contadorErrores > 0) {
        if (anuncioContacto) {
          anuncioContacto.textContent = `Revisa ${contadorErrores} ${contadorErrores === 1 ? 'campo' : 'campos'} del formulario.`;
        }
        if (primerInvalido) primerInvalido.focus();
        return;
      }

      // Envío simulado exitoso
      formContacto.reset();
      formContacto.classList.add('hidden');
      if (exitoContacto) exitoContacto.classList.remove('hidden');
      if (anuncioContacto) {
        anuncioContacto.textContent = 'Mensaje enviado. Te responderemos pronto.';
      }
    });

    if (btnReiniciar) {
      btnReiniciar.addEventListener('click', () => {
        if (exitoContacto) exitoContacto.classList.add('hidden');
        formContacto.classList.remove('hidden');
        if (campos.nombre.input) campos.nombre.input.focus();
      });
    }
  }
});
