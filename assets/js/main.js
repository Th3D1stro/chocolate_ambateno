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

  // 4. Sistema simulado de registro e inicio de sesión
  const AUTH_STORAGE_KEY = 'el-ambateno-auth-user';
  const modalAuth = document.getElementById('modal-auth');
  const btnOpenAuth = document.getElementById('btn-open-auth');
  const btnCloseAuth = document.getElementById('btn-cerrar-auth');
  const tabLogin = document.getElementById('tab-login');
  const tabRegister = document.getElementById('tab-register');
  const formLogin = document.getElementById('form-auth-login');
  const formRegister = document.getElementById('form-auth-register');
  const authAlert = document.getElementById('auth-alert');
  const navUserLogged = document.getElementById('nav-user-logged');
  const userDisplayName = document.getElementById('user-display-name');
  const userAvatarInitial = document.getElementById('user-avatar-initial');
  const btnLogout = document.getElementById('btn-logout');

  function getLoggedUser() {
    try {
      const data = localStorage.getItem(AUTH_STORAGE_KEY);
      return data ? JSON.parse(data) : null;
    } catch (e) {
      return null;
    }
  }

  function setLoggedUser(user) {
    try {
      if (user) {
        localStorage.setItem(AUTH_STORAGE_KEY, JSON.stringify(user));
      } else {
        localStorage.removeItem(AUTH_STORAGE_KEY);
      }
    } catch (e) {}
    updateAuthUI();
  }

  function updateAuthUI() {
    const user = getLoggedUser();
    if (user && user.nombre) {
      if (btnOpenAuth) {
        btnOpenAuth.classList.add('hidden');
        btnOpenAuth.style.setProperty('display', 'none', 'important');
        btnOpenAuth.setAttribute('hidden', '');
      }
      if (navUserLogged) {
        navUserLogged.classList.remove('hidden');
        navUserLogged.style.setProperty('display', 'flex', 'important');
        navUserLogged.removeAttribute('hidden');
      }
      if (userDisplayName) {
        const primerNombre = user.nombre.split(' ')[0] || user.nombre;
        userDisplayName.textContent = primerNombre;
        userDisplayName.title = `${user.nombre} (${user.email || ''})`;
      }
      if (userAvatarInitial) {
        userAvatarInitial.textContent = (user.nombre.charAt(0) || 'U').toUpperCase();
      }
    } else {
      if (btnOpenAuth) {
        btnOpenAuth.classList.remove('hidden');
        btnOpenAuth.style.removeProperty('display');
        btnOpenAuth.removeAttribute('hidden');
      }
      if (navUserLogged) {
        navUserLogged.classList.add('hidden');
        navUserLogged.style.setProperty('display', 'none', 'important');
        navUserLogged.setAttribute('hidden', '');
      }
    }
  }

  function showAuthAlert(msg, type = 'error') {
    if (!authAlert) return;
    authAlert.textContent = msg;
    authAlert.className = `mt-4 rounded-xl p-3 text-sm font-medium ${
      type === 'success' ? 'bg-oliva-claro text-tinta border border-oliva' : 'bg-burdeos/10 text-burdeos border border-burdeos/30'
    }`;
    authAlert.classList.remove('hidden');
  }

  function hideAuthAlert() {
    if (authAlert) authAlert.classList.add('hidden');
  }

  function switchTab(mode) {
    hideAuthAlert();
    if (mode === 'register') {
      tabRegister.classList.add('bg-burdeos', 'text-crema', 'shadow-xs');
      tabRegister.classList.remove('text-burdeos');
      tabRegister.setAttribute('aria-selected', 'true');

      tabLogin.classList.remove('bg-burdeos', 'text-crema', 'shadow-xs');
      tabLogin.classList.add('text-burdeos');
      tabLogin.setAttribute('aria-selected', 'false');

      formLogin.classList.add('hidden');
      formRegister.classList.remove('hidden');
    } else {
      tabLogin.classList.add('bg-burdeos', 'text-crema', 'shadow-xs');
      tabLogin.classList.remove('text-burdeos');
      tabLogin.setAttribute('aria-selected', 'true');

      tabRegister.classList.remove('bg-burdeos', 'text-crema', 'shadow-xs');
      tabRegister.classList.add('text-burdeos');
      tabRegister.setAttribute('aria-selected', 'false');

      formRegister.classList.add('hidden');
      formLogin.classList.remove('hidden');
    }
  }

  function openAuthModal(mode = 'login') {
    if (!modalAuth) return;
    switchTab(mode);
    modalAuth.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeAuthModal() {
    if (!modalAuth) return;
    modalAuth.classList.add('hidden');
    document.body.style.overflow = '';
    hideAuthAlert();
  }

  if (btnOpenAuth) {
    btnOpenAuth.addEventListener('click', () => openAuthModal('login'));
  }
  if (btnCloseAuth) {
    btnCloseAuth.addEventListener('click', closeAuthModal);
  }
  if (modalAuth) {
    const backdrop = modalAuth.querySelector('.auth-backdrop');
    if (backdrop) backdrop.addEventListener('click', closeAuthModal);
    modalAuth.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeAuthModal();
    });
  }

  if (tabLogin) tabLogin.addEventListener('click', () => switchTab('login'));
  if (tabRegister) tabRegister.addEventListener('click', () => switchTab('register'));

  // Manejo de Registro
  if (formRegister) {
    formRegister.addEventListener('submit', (e) => {
      e.preventDefault();
      const nombre = document.getElementById('register-name').value.trim();
      const email = document.getElementById('register-email').value.trim();
      const password = document.getElementById('register-password').value;

      if (!nombre || !email || !password) {
        showAuthAlert('Por favor completa todos los campos requeridos.', 'error');
        return;
      }
      if (password.length < 4) {
        showAuthAlert('La contraseña debe tener al menos 4 caracteres.', 'error');
        return;
      }

      // Guardar lista de usuarios registrados simulados
      let usuarios = [];
      try {
        usuarios = JSON.parse(localStorage.getItem('el-ambateno-users-db') || '[]');
      } catch (err) {
        usuarios = [];
      }

      const existe = usuarios.find((u) => u.email.toLowerCase() === email.toLowerCase());
      if (existe) {
        showAuthAlert('Este correo ya se encuentra registrado. Inicia sesión.', 'error');
        return;
      }

      usuarios.push({ nombre, email, password });
      try {
        localStorage.setItem('el-ambateno-users-db', JSON.stringify(usuarios));
      } catch (err) {}

      // Iniciar sesión automáticamente
      setLoggedUser({ nombre, email });
      showAuthAlert('¡Cuenta creada con éxito! Bienvenido.', 'success');
      setTimeout(() => {
        closeAuthModal();
        formRegister.reset();
      }, 1200);
    });
  }

  // Manejo de Login
  if (formLogin) {
    formLogin.addEventListener('submit', (e) => {
      e.preventDefault();
      const email = document.getElementById('login-email').value.trim();
      const password = document.getElementById('login-password').value;

      let usuarios = [];
      try {
        usuarios = JSON.parse(localStorage.getItem('el-ambateno-users-db') || '[]');
      } catch (err) {
        usuarios = [];
      }

      // Si no hay usuarios en la base simulada, permitir credenciales de demostración
      let usuario = usuarios.find((u) => u.email.toLowerCase() === email.toLowerCase() && u.password === password);
      if (!usuario && email && password) {
        // Permitir acceso de demostración con cualquier contraseña si se prueba directamente
        const nombreDemo = email.split('@')[0].replace(/[._-]/g, ' ');
        usuario = {
          nombre: nombreDemo.charAt(0).toUpperCase() + nombreDemo.slice(1),
          email: email
        };
      }

      if (usuario) {
        setLoggedUser(usuario);
        showAuthAlert(`¡Hola de nuevo, ${usuario.nombre.split(' ')[0]}!`, 'success');
        setTimeout(() => {
          closeAuthModal();
          formLogin.reset();
        }, 800);
      } else {
        showAuthAlert('Credenciales incorrectas. Verifica tu correo y contraseña.', 'error');
      }
    });
  }

  // Manejo de Logout
  if (btnLogout) {
    btnLogout.addEventListener('click', () => {
      setLoggedUser(null);
    });
  }

  // Inicializar estado de autenticación al cargar la página
  updateAuthUI();
});
