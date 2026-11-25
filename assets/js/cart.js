/**
 * Almacén del Carrito en localStorage para Chocolate El Ambateño.
 * Clave oficial: "el-ambateno-carrito".
 * Resiliente a modo incógnito y cuotas de almacenamiento con try/catch.
 */

(function () {
  const STORAGE_KEY = 'el-ambateno-carrito';
  const MAX_CANTIDAD = 99;

  const limitar = (n) => Math.min(MAX_CANTIDAD, Math.max(1, Math.round(Number(n) || 1)));

  function leerAlmacen() {
    try {
      const guardado = window.localStorage.getItem(STORAGE_KEY);
      if (!guardado) return {};
      const parsed = JSON.parse(guardado);
      if (!parsed || typeof parsed !== 'object') return {};

      const limpio = {};
      for (const [id, cantidad] of Object.entries(parsed)) {
        if (typeof cantidad === 'number' && cantidad > 0) {
          limpio[id] = limitar(cantidad);
        }
      }
      return limpio;
    } catch (e) {
      return {};
    }
  }

  function guardarAlmacen(items) {
    try {
      window.localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    } catch (e) {
      // Modo incógnito o cuota excedida: se mantiene en memoria
    }
  }

  let items = leerAlmacen();

  function notificarCambio() {
    guardarAlmacen(items);
    const count = Object.values(items).reduce((acc, qty) => acc + qty, 0);

    // Actualizar badge en el header en cualquier página
    const badge = document.getElementById('header-cart-count');
    if (badge) {
      badge.textContent = count;
    }

    const btnNavbar = document.getElementById('btn-tienda-navbar');
    if (btnNavbar) {
      const label = count === 1 ? '1 producto en el carrito' : `${count} productos en el carrito`;
      btnNavbar.setAttribute('aria-label', `Tienda: ${label}`);
    }

    window.dispatchEvent(
      new CustomEvent('ambateno:cart-updated', {
        detail: {
          items: { ...items },
          count,
        },
      })
    );
  }

  window.AmbatenoCart = {
    getItems() {
      return { ...items };
    },

    getCount() {
      return Object.values(items).reduce((acc, qty) => acc + qty, 0);
    },

    add(id, cantidad) {
      const cant = Number(cantidad) || 1;
      items[id] = limitar((items[id] || 0) + cant);
      notificarCambio();
    },

    setQty(id, cantidad) {
      const cant = Number(cantidad);
      if (cant <= 0) {
        delete items[id];
      } else {
        items[id] = limitar(cant);
      }
      notificarCambio();
    },

    remove(id) {
      delete items[id];
      notificarCambio();
    },

    clear() {
      items = {};
      notificarCambio();
    },
  };

  document.addEventListener('DOMContentLoaded', () => {
    notificarCambio();
  });
})();
