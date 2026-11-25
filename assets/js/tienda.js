/**
 * Lógica completa de la Tienda y Checkout SPA para Chocolate El Ambateño.
 * Controla:
 * - Catálogo interactivo con buscador en tiempo real, filtro por categorías oficiales
 *   (Ver todo 'todo', Sin gluten 'sin-gluten', Sin azúcar 'sin-azucar', Express 'express'), orden y paginación.
 * - Modal de Vista Rápida con tabla nutricional y selector de cantidad.
 * - Panel lateral de resumen del carrito.
 * - Checkout por pasos (Tienda > Carrito > Envío > Pago > Confirmación).
 * - Stepper visual accesible y validaciones de formulario completas.
 * - Generación de código aleatorio AMB-YYYY-XXXXX.
 */

document.addEventListener('DOMContentLoaded', () => {
  const data = window.AmbatenoTiendaData;
  if (!data || !Array.isArray(data.productos)) {
    console.warn('Chocolate El Ambateño: AmbatenoTiendaData no está disponible o no contiene productos.', data);
    return;
  }

  const productos = data.productos;
  const productosPorId = Object.fromEntries(productos.map((p) => [p.id, p]));

  // Constantes
  const IVA_RATE = 0.15;
  const COSTOS_ENVIO = { retiro: 0, estandar: 3.5, express: 6.5 };
  const TIEMPOS_ENVIO = {
    retiro: 'Listo en 24 h',
    estandar: '3 a 5 días hábiles',
    express: 'Hasta 48 h, según destino',
  };
  const NOMBRES_ENVIO = {
    retiro: 'Retiro en tienda',
    estandar: 'Envío estándar',
    express: 'Envío express',
  };
  const NOMBRES_PAGO = {
    tarjeta: 'Tarjeta de crédito/débito',
    transferencia: 'Transferencia bancaria',
    contraentrega: 'Pago contra entrega',
  };

  const ENCABEZADOS_PASO = {
    tienda: {
      titulo: 'Encuentra tu barra ideal en minutos',
      texto: 'Chocolate artesanal de Ambato: elige, añade al carrito y finaliza tu compra en pocos pasos.',
    },
    carrito: {
      titulo: 'Tu carrito',
      texto: 'Revisa los productos y cantidades de tu pedido.',
    },
    envio: {
      titulo: 'Datos de envío',
      texto: 'Cuéntanos dónde y cómo quieres recibir tu chocolate.',
    },
    pago: {
      titulo: 'Pago',
      texto: 'Elige cómo pagar y revisa el total final con IVA.',
    },
    confirmacion: {
      titulo: 'Confirmación',
      texto: 'Tu pedido de demostración está listo.',
    },
  };

  const POR_PAGINA = 6;

  // Estado reactivo
  let pasoActual = 'tienda';
  let busqueda = '';
  let categoriaActual = 'todo';
  let ordenActual = 'relevancia';
  let paginaActual = 1;
  let metodoEnvio = 'estandar';
  let metodoPago = 'tarjeta';
  let pedidoRealizado = null;
  let toastTimer = null;

  // Datos del formulario de envío
  let datosEnvio = {
    nombre: '',
    cedula: '',
    telefono: '',
    correo: '',
    provincia: '',
    ciudad: '',
    direccion: '',
  };

  // Elementos DOM principales
  const tituloDinamico = document.getElementById('titulo-tienda-dinamico');
  const subtituloDinamico = document.getElementById('subtitulo-tienda-dinamico');
  const anuncioTienda = document.getElementById('anuncio-tienda');
  const grillaProductos = document.getElementById('grilla-productos');
  const tmplTarjeta = document.getElementById('tmpl-tarjeta-producto');
  const conteoProductos = document.getElementById('conteo-productos');
  const catalogoVacio = document.getElementById('catalogo-vacio');
  const paginacionNav = document.getElementById('paginacion-catalogo');
  const listaPaginasNumeros = document.getElementById('lista-paginas-numeros');
  const btnPaginaAnterior = document.getElementById('btn-pagina-anterior');
  const btnPaginaSiguiente = document.getElementById('btn-pagina-siguiente');
  const inputBusqueda = document.getElementById('buscar-producto');
  const btnLimpiarBusqueda = document.getElementById('btn-limpiar-busqueda');
  const selectOrden = document.getElementById('ordenar-productos');
  const btnsCategorias = document.querySelectorAll('.btn-filtro-categoria');
  const btnResetFiltros = document.getElementById('btn-reset-filtros');
  const toastAviso = document.getElementById('toast-aviso');
  const toastTexto = document.getElementById('toast-aviso-texto');

  // Vistas de pasos
  const vistasPasos = {
    tienda: document.getElementById('vista-paso-tienda'),
    carrito: document.getElementById('vista-paso-carrito'),
    envio: document.getElementById('vista-paso-envio'),
    pago: document.getElementById('vista-paso-pago'),
    confirmacion: document.getElementById('vista-paso-confirmacion'),
  };

  // Helpers
  const formatPrice = (n) => `$${Number(n || 0).toFixed(2)}`;
  const normalizar = (texto) =>
    (texto || '')
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .toLowerCase()
      .trim();

  function mostrarToast(mensaje) {
    if (!toastAviso || !toastTexto) return;
    toastTexto.textContent = mensaje;
    toastAviso.classList.remove('hidden');

    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
      toastAviso.classList.add('hidden');
    }, 2800);
  }

  function calcularTotales() {
    const cartItems = window.AmbatenoCart.getItems();
    let subtotal = 0;
    for (const [id, cant] of Object.entries(cartItems)) {
      const prod = productosPorId[id];
      if (prod) {
        subtotal += prod.precio * cant;
      }
    }
    subtotal = Math.round(subtotal * 100) / 100;
    const costoEnvio = COSTOS_ENVIO[metodoEnvio] || 0;
    const base = subtotal + costoEnvio;
    const iva = Math.round(base * IVA_RATE * 100) / 100;
    const total = Math.round((base + iva) * 100) / 100;

    return { subtotal, envio: costoEnvio, iva, total };
  }

  // 1. Renderizado del Catálogo de Productos
  function getProductosFiltrados() {
    const q = normalizar(busqueda);
    const lista = productos.filter((p) => {
      const coincideCat = categoriaActual === 'todo' || (Array.isArray(p.categorias) && p.categorias.includes(categoriaActual));
      const coincideBusqueda = normalizar(p.nombre).includes(q) || normalizar(p.descripcion).includes(q);
      return coincideCat && coincideBusqueda;
    });

    if (ordenActual === 'precio-asc') {
      lista.sort((a, b) => a.precio - b.precio);
    } else if (ordenActual === 'precio-desc') {
      lista.sort((a, b) => b.precio - a.precio);
    } else if (ordenActual === 'nombre') {
      lista.sort((a, b) => a.nombre.localeCompare(b.nombre, 'es'));
    }

    return lista;
  }

  function renderCatalogo() {
    if (!grillaProductos || !tmplTarjeta) {
      console.warn('Chocolate El Ambateño: Elementos de catálogo faltantes:', { grillaProductos, tmplTarjeta });
      return;
    }

    const filtrados = getProductosFiltrados();
    const totalPaginas = Math.max(1, Math.ceil(filtrados.length / POR_PAGINA));
    paginaActual = Math.min(paginaActual, totalPaginas);

    const inicio = (paginaActual - 1) * POR_PAGINA;
    const visibles = filtrados.slice(inicio, inicio + POR_PAGINA);

    grillaProductos.innerHTML = '';

    if (filtrados.length === 0) {
      if (catalogoVacio) catalogoVacio.classList.remove('hidden');
      if (paginacionNav) paginacionNav.classList.add('hidden');
      if (conteoProductos) conteoProductos.textContent = 'Sin resultados';
      return;
    }

    if (catalogoVacio) catalogoVacio.classList.add('hidden');

    if (conteoProductos) {
      const etiquetaTotal = filtrados.length === 1 ? 'producto' : 'productos';
      conteoProductos.textContent = `${filtrados.length} ${etiquetaTotal} · página ${paginaActual} de ${totalPaginas}`;
    }

    // Renderizar tarjetas
    visibles.forEach((prod) => {
      const clone = tmplTarjeta.content.cloneNode(true);
      const img = clone.querySelector('.producto-img');
      const nombre = clone.querySelector('.producto-nombre');
      const desc = clone.querySelector('.producto-desc');
      const precio = clone.querySelector('.producto-precio');
      const peso = clone.querySelector('.producto-peso');
      const etiquetasContainer = clone.querySelector('.producto-etiquetas');
      const btnVer = clone.querySelector('.btn-ver-producto');
      const btnMinus = clone.querySelector('.btn-qty-minus');
      const btnPlus = clone.querySelector('.btn-qty-plus');
      const inputQty = clone.querySelector('.input-qty');
      const btnAgregar = clone.querySelector('.btn-agregar-producto');

      if (img) {
        img.src = prod.imagen;
        img.alt = prod.alt || prod.nombre;
      }
      if (nombre) nombre.textContent = prod.nombre;
      if (desc) desc.textContent = prod.descripcion;
      if (precio) precio.textContent = formatPrice(prod.precio);
      if (peso) peso.textContent = ` · ${prod.peso}`;

      if (etiquetasContainer && Array.isArray(prod.etiquetas)) {
        prod.etiquetas.forEach((tag) => {
          const span = document.createElement('span');
          span.className = 'inline-flex items-center gap-1 rounded-md bg-oliva px-2 py-0.5 text-xs font-semibold text-tinta';
          span.textContent = tag;
          etiquetasContainer.appendChild(span);
        });
      }

      // Cantidad local de la tarjeta
      let cantidad = 1;
      const actualizarInput = () => {
        if (inputQty) inputQty.value = cantidad;
        if (btnMinus) btnMinus.disabled = cantidad <= 1;
      };

      if (btnMinus) {
        btnMinus.addEventListener('click', () => {
          if (cantidad > 1) {
            cantidad--;
            actualizarInput();
          }
        });
      }
      if (btnPlus) {
        btnPlus.addEventListener('click', () => {
          if (cantidad < 99) {
            cantidad++;
            actualizarInput();
          }
        });
      }
      if (inputQty) {
        inputQty.addEventListener('change', () => {
          const val = Number.parseInt(inputQty.value, 10);
          cantidad = Math.min(99, Math.max(1, Number.isNaN(val) ? 1 : val));
          actualizarInput();
        });
      }

      if (btnVer) {
        btnVer.addEventListener('click', () => abrirVistaRapida(prod));
      }

      if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
          window.AmbatenoCart.add(prod.id, cantidad);
          mostrarToast(`Añadiste ${cantidad} × ${prod.nombre} al carrito`);
        });
      }

      grillaProductos.appendChild(clone);
    });

    // Paginación
    if (totalPaginas > 1 && paginacionNav && listaPaginasNumeros) {
      paginacionNav.classList.remove('hidden');
      listaPaginasNumeros.innerHTML = '';

      if (btnPaginaAnterior) btnPaginaAnterior.disabled = paginaActual === 1;
      if (btnPaginaSiguiente) btnPaginaSiguiente.disabled = paginaActual === totalPaginas;

      for (let i = 1; i <= totalPaginas; i++) {
        const li = document.createElement('li');
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = i;
        btn.setAttribute('aria-label', `Página ${i}`);
        if (i === paginaActual) {
          btn.setAttribute('aria-current', 'page');
          btn.className = 'inline-flex h-11 w-11 items-center justify-center rounded-md font-semibold transition-colors bg-burdeos text-crema';
        } else {
          btn.className = 'inline-flex h-11 w-11 items-center justify-center rounded-md font-semibold transition-colors text-burdeos hover:bg-crema';
        }
        btn.addEventListener('click', () => {
          paginaActual = i;
          renderCatalogo();
          const scrollTarget = document.getElementById('inicio-catalogo');
          if (scrollTarget) scrollTarget.scrollIntoView({ behavior: 'smooth' });
        });
        li.appendChild(btn);
        listaPaginasNumeros.appendChild(li);
      }
    } else if (paginacionNav) {
      paginacionNav.classList.add('hidden');
    }
  }

  // Eventos del buscador y filtros
  if (inputBusqueda) {
    inputBusqueda.addEventListener('input', (e) => {
      busqueda = e.target.value;
      paginaActual = 1;
      if (btnLimpiarBusqueda) {
        if (busqueda.length > 0) {
          btnLimpiarBusqueda.classList.remove('hidden');
        } else {
          btnLimpiarBusqueda.classList.add('hidden');
        }
      }
      renderCatalogo();
    });
  }

  if (btnLimpiarBusqueda) {
    btnLimpiarBusqueda.addEventListener('click', () => {
      busqueda = '';
      if (inputBusqueda) {
        inputBusqueda.value = '';
        inputBusqueda.focus();
      }
      btnLimpiarBusqueda.classList.add('hidden');
      paginaActual = 1;
      renderCatalogo();
    });
  }

  if (selectOrden) {
    selectOrden.addEventListener('change', (e) => {
      ordenActual = e.target.value;
      renderCatalogo();
    });
  }

  btnsCategorias.forEach((btn) => {
    btn.addEventListener('click', () => {
      categoriaActual = btn.getAttribute('data-categoria');
      paginaActual = 1;

      btnsCategorias.forEach((b) => {
        const activo = b === btn;
        b.setAttribute('aria-pressed', activo ? 'true' : 'false');
        if (activo) {
          b.classList.remove('border-burdeos/25', 'text-burdeos', 'hover:border-burdeos', 'hover:bg-crema');
          b.classList.add('border-burdeos', 'bg-burdeos', 'text-crema');
        } else {
          b.classList.remove('border-burdeos', 'bg-burdeos', 'text-crema');
          b.classList.add('border-burdeos/25', 'text-burdeos', 'hover:border-burdeos', 'hover:bg-crema');
        }
      });

      renderCatalogo();
    });
  });

  if (btnResetFiltros) {
    btnResetFiltros.addEventListener('click', () => {
      busqueda = '';
      categoriaActual = 'todo';
      paginaActual = 1;
      if (inputBusqueda) inputBusqueda.value = '';
      if (btnLimpiarBusqueda) btnLimpiarBusqueda.classList.add('hidden');
      btnsCategorias.forEach((b) => {
        const activo = b.getAttribute('data-categoria') === 'todo';
        b.setAttribute('aria-pressed', activo ? 'true' : 'false');
        if (activo) {
          b.classList.add('border-burdeos', 'bg-burdeos', 'text-crema');
          b.classList.remove('border-burdeos/25', 'text-burdeos');
        } else {
          b.classList.remove('border-burdeos', 'bg-burdeos', 'text-crema');
          b.classList.add('border-burdeos/25', 'text-burdeos');
        }
      });
      renderCatalogo();
    });
  }

  if (btnPaginaAnterior) {
    btnPaginaAnterior.addEventListener('click', () => {
      if (paginaActual > 1) {
        paginaActual--;
        renderCatalogo();
        const target = document.getElementById('inicio-catalogo');
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }

  if (btnPaginaSiguiente) {
    btnPaginaSiguiente.addEventListener('click', () => {
      const filtrados = getProductosFiltrados();
      const totalPaginas = Math.ceil(filtrados.length / POR_PAGINA);
      if (paginaActual < totalPaginas) {
        paginaActual++;
        renderCatalogo();
        const target = document.getElementById('inicio-catalogo');
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }

  // 2. Modal de Vista Rápida
  const modalVR = document.getElementById('modal-vista-rapida');
  const btnCerrarVR = document.getElementById('btn-cerrar-vista-rapida');
  const vrImg = document.getElementById('vr-img');
  const vrEtiquetas = document.getElementById('vr-etiquetas');
  const vrTitulo = document.getElementById('titulo-vista-rapida');
  const vrPrecio = document.getElementById('vr-precio');
  const vrPeso = document.getElementById('vr-peso');
  const vrDesc = document.getElementById('vr-descripcion');
  const vrIngredientes = document.getElementById('vr-ingredientes');
  const vrPorcionLabel = document.getElementById('vr-porcion-label');
  const vrNutricionBody = document.getElementById('vr-nutricion-body');
  const vrQtyMinus = document.getElementById('vr-qty-minus');
  const vrQtyPlus = document.getElementById('vr-qty-plus');
  const vrQtyInput = document.getElementById('vr-qty-input');
  const btnVrAgregar = document.getElementById('btn-vr-agregar');

  let prodActualVR = null;
  let cantVR = 1;

  function abrirVistaRapida(prod) {
    if (!modalVR || !prod) return;
    prodActualVR = prod;
    cantVR = 1;

    if (vrImg) {
      vrImg.src = prod.imagen;
      vrImg.alt = prod.alt || prod.nombre;
    }
    if (vrTitulo) vrTitulo.textContent = prod.nombre;
    if (vrPrecio) vrPrecio.textContent = formatPrice(prod.precio);
    if (vrPeso) vrPeso.textContent = ` · ${prod.peso}`;
    if (vrDesc) vrDesc.textContent = prod.descripcion;
    if (vrIngredientes) vrIngredientes.textContent = prod.ingredientes;

    if (vrEtiquetas) {
      vrEtiquetas.innerHTML = '';
      if (Array.isArray(prod.etiquetas)) {
        prod.etiquetas.forEach((t) => {
          const s = document.createElement('span');
          s.className = 'inline-flex items-center gap-1 rounded-md bg-oliva px-2 py-0.5 text-xs font-semibold text-tinta';
          s.textContent = t;
          vrEtiquetas.appendChild(s);
        });
      }
    }

    // Nutrición
    if (vrNutricionBody && prod.nutricion) {
      if (vrPorcionLabel) vrPorcionLabel.textContent = `porción de ${prod.nutricion.porcion || '25 g'}`;
      const filas = [
        ['Energía', prod.nutricion.energia],
        ['Grasas totales', prod.nutricion.grasas],
        ['Carbohidratos', prod.nutricion.carbohidratos],
        ['Azúcares', prod.nutricion.azucares],
        ['Proteína', prod.nutricion.proteina],
      ];
      vrNutricionBody.innerHTML = filas
        .map(
          ([lbl, val], idx) => `
          <tr class="${idx % 2 === 0 ? 'bg-crema/60' : 'bg-white'}">
            <th scope="row" class="px-3 py-2 text-left font-medium text-tinta">${lbl}</th>
            <td class="px-3 py-2 text-right text-tinta">${val || '-'}</td>
          </tr>`
        )
        .join('');
    }

    if (vrQtyInput) vrQtyInput.value = cantVR;
    if (vrQtyMinus) vrQtyMinus.disabled = true;

    modalVR.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (btnCerrarVR) btnCerrarVR.focus();
  }

  function cerrarVistaRapida() {
    if (!modalVR) return;
    modalVR.classList.add('hidden');
    document.body.style.overflow = '';
  }

  if (btnCerrarVR) btnCerrarVR.addEventListener('click', cerrarVistaRapida);
  const vrBackdrop = modalVR ? modalVR.querySelector('.modal-backdrop') : null;
  if (vrBackdrop) vrBackdrop.addEventListener('click', cerrarVistaRapida);

  if (vrQtyMinus) {
    vrQtyMinus.addEventListener('click', () => {
      if (cantVR > 1) {
        cantVR--;
        if (vrQtyInput) vrQtyInput.value = cantVR;
        vrQtyMinus.disabled = cantVR <= 1;
      }
    });
  }

  if (vrQtyPlus) {
    vrQtyPlus.addEventListener('click', () => {
      if (cantVR < 99) {
        cantVR++;
        if (vrQtyInput) vrQtyInput.value = cantVR;
        if (vrQtyMinus) vrQtyMinus.disabled = false;
      }
    });
  }

  if (vrQtyInput) {
    vrQtyInput.addEventListener('change', () => {
      const v = Number.parseInt(vrQtyInput.value, 10);
      cantVR = Math.min(99, Math.max(1, Number.isNaN(v) ? 1 : v));
      vrQtyInput.value = cantVR;
      if (vrQtyMinus) vrQtyMinus.disabled = cantVR <= 1;
    });
  }

  if (btnVrAgregar) {
    btnVrAgregar.addEventListener('click', () => {
      if (!prodActualVR) return;
      window.AmbatenoCart.add(prodActualVR.id, cantVR);
      mostrarToast(`Añadiste ${cantVR} × ${prodActualVR.nombre} al carrito`);
      cerrarVistaRapida();
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modalVR && !modalVR.classList.contains('hidden')) {
      cerrarVistaRapida();
    }
  });

  // 3. Panel Lateral del Carrito (en el Catálogo)
  const panelCount = document.getElementById('panel-cart-count');
  const panelVacio = document.getElementById('panel-cart-vacio');
  const panelLista = document.getElementById('panel-cart-lista');
  const panelSubtotal = document.getElementById('panel-cart-subtotal');
  const panelTotal = document.getElementById('panel-cart-total');
  const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');

  function renderPanelCarrito() {
    const items = window.AmbatenoCart.getItems();
    const count = window.AmbatenoCart.getCount();
    const lineas = Object.entries(items)
      .filter(([id]) => productosPorId[id])
      .map(([id, cant]) => ({
        prod: productosPorId[id],
        cant,
        total: Math.round(productosPorId[id].precio * cant * 100) / 100,
      }));

    if (panelCount) {
      panelCount.textContent = count === 1 ? '1 artículo' : `${count} artículos`;
    }

    if (lineas.length === 0) {
      if (panelVacio) panelVacio.classList.remove('hidden');
      if (panelLista) panelLista.classList.add('hidden');
      if (panelSubtotal) panelSubtotal.textContent = '$0.00';
      if (panelTotal) panelTotal.textContent = '$0.00';
      if (btnFinalizarCompra) btnFinalizarCompra.disabled = true;
      return;
    }

    if (panelVacio) panelVacio.classList.add('hidden');
    if (panelLista) panelLista.classList.remove('hidden');
    if (btnFinalizarCompra) btnFinalizarCompra.disabled = false;

    panelLista.innerHTML = '';
    let sub = 0;

    lineas.forEach(({ prod, cant, total }) => {
      sub += total;
      const li = document.createElement('li');
      li.className = 'flex gap-3 py-4';
      li.innerHTML = `
        <img src="${prod.imagen}" alt="" width="64" height="64" loading="lazy" class="h-16 w-16 shrink-0 rounded-md object-cover" />
        <div class="flex min-w-0 flex-1 flex-col gap-2">
          <div class="flex items-start justify-between gap-2">
            <p class="font-semibold leading-snug text-burdeos">${prod.nombre}</p>
            <button type="button" data-del-id="${prod.id}" class="btn-del-line -mr-2 -mt-2 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md text-burdeos transition-colors hover:bg-crema" aria-label="Quitar ${prod.nombre} del carrito">
              <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
            </button>
          </div>
          <p class="text-sm text-tinta/75">${formatPrice(prod.precio)} c/u</p>
          <div class="flex flex-wrap items-center justify-between gap-2">
            <div class="inline-flex items-center overflow-hidden rounded-md border-2 border-burdeos/25 bg-white">
              <button type="button" data-minus-id="${prod.id}" class="btn-line-minus inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema" aria-label="Restar uno">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/></svg>
              </button>
              <input type="number" data-input-id="${prod.id}" min="1" max="99" value="${cant}" class="sin-flechas h-11 w-12 border-x border-burdeos/15 bg-transparent text-center font-semibold text-tinta" aria-label="Cantidad" />
              <button type="button" data-plus-id="${prod.id}" class="btn-line-plus inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema" aria-label="Sumar uno">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
              </button>
            </div>
            <p class="font-bold text-caramelo-oscuro">${formatPrice(total)}</p>
          </div>
        </div>`;

      // Eventos
      li.querySelector('.btn-del-line').addEventListener('click', () => window.AmbatenoCart.remove(prod.id));
      li.querySelector('.btn-line-minus').addEventListener('click', () => window.AmbatenoCart.setQty(prod.id, cant - 1));
      li.querySelector('.btn-line-plus').addEventListener('click', () => window.AmbatenoCart.setQty(prod.id, cant + 1));
      li.querySelector('input').addEventListener('change', (e) => window.AmbatenoCart.setQty(prod.id, e.target.value));

      panelLista.appendChild(li);
    });

    sub = Math.round(sub * 100) / 100;
    if (panelSubtotal) panelSubtotal.textContent = formatPrice(sub);
    if (panelTotal) panelTotal.textContent = formatPrice(sub);
  }

  // 4. Stepper y Navegación de Pasos
  const PASOS_LISTA = ['tienda', 'carrito', 'envio', 'pago', 'confirmacion'];

  function actualizarStepper() {
    const indiceActual = PASOS_LISTA.indexOf(pasoActual);

    PASOS_LISTA.forEach((pId, idx) => {
      const item = document.getElementById(`step-item-${pId}`);
      if (!item) return;

      const circle = item.querySelector('.step-circle');
      const numSpan = item.querySelector('.step-num');
      const checkSpan = item.querySelector('.step-check');
      const labelSpan = item.querySelector('.step-label');
      const srSpan = item.querySelector('.step-sr');
      const line = item.querySelector('.step-line');

      if (idx < indiceActual) {
        // Completado
        item.setAttribute('aria-current', 'false');
        if (circle) {
          circle.className = 'step-circle relative z-10 inline-flex h-10 w-10 items-center justify-center rounded-full font-bold bg-oliva text-tinta';
        }
        if (numSpan) numSpan.classList.add('hidden');
        if (checkSpan) checkSpan.classList.remove('hidden');
        if (labelSpan) {
          labelSpan.className = 'step-label text-center text-xs font-semibold sm:text-sm text-tinta/80';
        }
        if (srSpan) srSpan.textContent = ' (completado)';
        if (line) line.className = 'step-line absolute right-1/2 top-5 h-1 w-full -translate-y-1/2 bg-oliva';
      } else if (idx === indiceActual) {
        // Actual
        item.setAttribute('aria-current', 'step');
        if (circle) {
          circle.className = 'step-circle relative z-10 inline-flex h-10 w-10 items-center justify-center rounded-full font-bold bg-burdeos text-crema ring-4 ring-burdeos/20';
        }
        if (numSpan) numSpan.classList.remove('hidden');
        if (checkSpan) checkSpan.classList.add('hidden');
        if (labelSpan) {
          labelSpan.className = 'step-label text-center text-xs font-semibold sm:text-sm text-burdeos';
        }
        if (srSpan) srSpan.textContent = ' (paso actual)';
        if (line) line.className = 'step-line absolute right-1/2 top-5 h-1 w-full -translate-y-1/2 bg-oliva';
      } else {
        // Pendiente
        item.setAttribute('aria-current', 'false');
        if (circle) {
          circle.className = 'step-circle relative z-10 inline-flex h-10 w-10 items-center justify-center rounded-full font-bold bg-crema-oscuro text-tinta';
        }
        if (numSpan) numSpan.classList.remove('hidden');
        if (checkSpan) checkSpan.classList.add('hidden');
        if (labelSpan) {
          labelSpan.className = 'step-label text-center text-xs font-semibold sm:text-sm text-tinta/80';
        }
        if (srSpan) srSpan.textContent = ' (pendiente)';
        if (line) line.className = 'step-line absolute right-1/2 top-5 h-1 w-full -translate-y-1/2 bg-crema-oscuro';
      }
    });
  }

  function irAPaso(nuevoPaso) {
    pasoActual = nuevoPaso;

    // Actualizar encabezados
    if (ENCABEZADOS_PASO[pasoActual]) {
      if (tituloDinamico) tituloDinamico.textContent = ENCABEZADOS_PASO[pasoActual].titulo;
      if (subtituloDinamico) subtituloDinamico.textContent = ENCABEZADOS_PASO[pasoActual].texto;
    }

    // Alternar contenedores
    Object.entries(vistasPasos).forEach(([key, el]) => {
      if (!el) return;
      if (key === pasoActual) {
        el.classList.remove('hidden');
      } else {
        el.classList.add('hidden');
      }
    });

    actualizarStepper();
    actualizarResumenCheckoutAside();

    if (pasoActual === 'carrito') renderPasoCarrito();
    if (pasoActual === 'pago') renderPasoPago();
    if (pasoActual === 'confirmacion' && pedidoRealizado) renderPasoConfirmacion();

    // Scroll al inicio y foco accesible al h1
    window.scrollTo({ top: 0, behavior: 'smooth' });
    if (tituloDinamico) tituloDinamico.focus();

    if (anuncioTienda && ENCABEZADOS_PASO[pasoActual]) {
      anuncioTienda.textContent = `Paso: ${ENCABEZADOS_PASO[pasoActual].titulo}`;
    }
  }

  if (btnFinalizarCompra) {
    btnFinalizarCompra.addEventListener('click', () => irAPaso('carrito'));
  }

  // 5. Resumen Lateral en el Checkout (Aside persistente)
  function actualizarResumenCheckoutAside() {
    const lineasContainer = document.getElementById('checkout-aside-lineas');
    const subtotalEl = document.getElementById('checkout-aside-subtotal');
    const envioEl = document.getElementById('checkout-aside-envio');
    const ivaRow = document.getElementById('checkout-aside-row-iva');
    const ivaEl = document.getElementById('checkout-aside-iva');
    const totalEl = document.getElementById('checkout-aside-total');

    if (!lineasContainer) return;

    const items = window.AmbatenoCart.getItems();
    const lineas = Object.entries(items)
      .filter(([id]) => productosPorId[id])
      .map(([id, cant]) => ({
        prod: productosPorId[id],
        cant,
        total: Math.round(productosPorId[id].precio * cant * 100) / 100,
      }));

    lineasContainer.innerHTML = lineas
      .map(
        ({ prod, cant, total }) => `
      <li class="flex justify-between gap-3">
        <span class="text-tinta/85">${cant} × ${prod.nombre}</span>
        <span class="shrink-0 font-semibold text-tinta">${formatPrice(total)}</span>
      </li>`
      )
      .join('');

    const totales = calcularTotales();

    if (subtotalEl) subtotalEl.textContent = formatPrice(totales.subtotal);

    if (pasoActual === 'carrito') {
      if (envioEl) envioEl.textContent = 'Se calcula en el paso de envío';
      if (ivaRow) ivaRow.classList.add('hidden');
      if (totalEl) totalEl.textContent = formatPrice(totales.subtotal);
    } else {
      if (envioEl) envioEl.textContent = totales.envio === 0 ? 'Gratis' : formatPrice(totales.envio);
      if (ivaRow) ivaRow.classList.remove('hidden');
      if (ivaEl) ivaEl.textContent = formatPrice(totales.iva);
      if (totalEl) totalEl.textContent = formatPrice(totales.total);
    }
  }

  // 6. Paso 1: Carrito
  const listaPasoCarrito = document.getElementById('checkout-cart-lista');
  const msgPasoCarritoVacio = document.getElementById('checkout-cart-vacio-msg');
  const btnCarritoVolver = document.getElementById('btn-carrito-volver-tienda');
  const btnCarritoContinuar = document.getElementById('btn-carrito-continuar-envio');

  function renderPasoCarrito() {
    if (!listaPasoCarrito) return;
    const items = window.AmbatenoCart.getItems();
    const lineas = Object.entries(items)
      .filter(([id]) => productosPorId[id])
      .map(([id, cant]) => ({
        prod: productosPorId[id],
        cant,
        total: Math.round(productosPorId[id].precio * cant * 100) / 100,
      }));

    if (lineas.length === 0) {
      if (msgPasoCarritoVacio) msgPasoCarritoVacio.classList.remove('hidden');
      listaPasoCarrito.innerHTML = '';
      if (btnCarritoContinuar) btnCarritoContinuar.disabled = true;
      irAPaso('tienda');
      return;
    }

    if (msgPasoCarritoVacio) msgPasoCarritoVacio.classList.add('hidden');
    if (btnCarritoContinuar) btnCarritoContinuar.disabled = false;

    listaPasoCarrito.innerHTML = '';
    lineas.forEach(({ prod, cant, total }) => {
      const li = document.createElement('li');
      li.className = 'flex gap-3 py-4';
      li.innerHTML = `
        <img src="${prod.imagen}" alt="" width="64" height="64" loading="lazy" class="h-16 w-16 shrink-0 rounded-md object-cover" />
        <div class="flex min-w-0 flex-1 flex-col gap-2">
          <div class="flex items-start justify-between gap-2">
            <p class="font-semibold leading-snug text-burdeos">${prod.nombre}</p>
            <button type="button" class="btn-del -mr-2 -mt-2 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md text-burdeos transition-colors hover:bg-crema" aria-label="Quitar ${prod.nombre} del carrito">
              <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
            </button>
          </div>
          <p class="text-sm text-tinta/75">${formatPrice(prod.precio)} c/u</p>
          <div class="flex flex-wrap items-center justify-between gap-2">
            <div class="inline-flex items-center overflow-hidden rounded-md border-2 border-burdeos/25 bg-white">
              <button type="button" class="btn-minus inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema" aria-label="Restar uno">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/></svg>
              </button>
              <input type="number" min="1" max="99" value="${cant}" class="sin-flechas h-11 w-12 border-x border-burdeos/15 bg-transparent text-center font-semibold text-tinta" aria-label="Cantidad" />
              <button type="button" class="btn-plus inline-flex h-11 w-11 items-center justify-center text-burdeos transition-colors hover:bg-crema" aria-label="Sumar uno">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
              </button>
            </div>
            <p class="font-bold text-caramelo-oscuro">${formatPrice(total)}</p>
          </div>
        </div>`;

      li.querySelector('.btn-del').addEventListener('click', () => {
        window.AmbatenoCart.remove(prod.id);
        renderPasoCarrito();
      });
      li.querySelector('.btn-minus').addEventListener('click', () => {
        window.AmbatenoCart.setQty(prod.id, cant - 1);
        renderPasoCarrito();
      });
      li.querySelector('.btn-plus').addEventListener('click', () => {
        window.AmbatenoCart.setQty(prod.id, cant + 1);
        renderPasoCarrito();
      });
      li.querySelector('input').addEventListener('change', (e) => {
        window.AmbatenoCart.setQty(prod.id, e.target.value);
        renderPasoCarrito();
      });

      listaPasoCarrito.appendChild(li);
    });
  }

  if (btnCarritoVolver) btnCarritoVolver.addEventListener('click', () => irAPaso('tienda'));
  if (btnCarritoContinuar) btnCarritoContinuar.addEventListener('click', () => irAPaso('envio'));

  // 7. Paso 2: Envío
  const formEnvio = document.getElementById('form-paso-envio');
  const btnEnvioVolver = document.getElementById('btn-envio-volver-carrito');
  const radiosEnvio = document.querySelectorAll('input[name="metodo_envio"]');
  const seccionDireccion = document.getElementById('seccion-direccion-entrega');
  const seccionRetiro = document.getElementById('seccion-retiro-tienda');

  radiosEnvio.forEach((radio) => {
    radio.addEventListener('change', () => {
      metodoEnvio = radio.value;
      radiosEnvio.forEach((r) => {
        const lbl = r.closest('.label-metodo-envio');
        if (!lbl) return;
        if (r.checked) {
          lbl.classList.remove('border-crema-oscuro');
          lbl.classList.add('border-burdeos', 'bg-crema');
        } else {
          lbl.classList.remove('border-burdeos', 'bg-crema');
          lbl.classList.add('border-crema-oscuro');
        }
      });

      if (metodoEnvio === 'retiro') {
        if (seccionDireccion) seccionDireccion.classList.add('hidden');
        if (seccionRetiro) seccionRetiro.classList.remove('hidden');
      } else {
        if (seccionDireccion) seccionDireccion.classList.remove('hidden');
        if (seccionRetiro) seccionRetiro.classList.add('hidden');
      }

      actualizarResumenCheckoutAside();
    });
  });

  if (formEnvio) {
    formEnvio.addEventListener('submit', (e) => {
      e.preventDefault();
      const val = (id) => (document.getElementById(id) ? document.getElementById(id).value.trim() : '');
      const err = (id, mostrar) => {
        const p = document.getElementById(id);
        if (p) p.classList.toggle('hidden', !mostrar);
      };

      const nombre = val('envio-nombre');
      const cedula = val('envio-cedula');
      const telefono = val('envio-telefono');
      const correo = val('envio-correo');
      const provincia = val('envio-provincia');
      const ciudad = val('envio-ciudad');
      const direccion = val('envio-direccion');

      let valido = true;
      let primerFoco = null;

      if (!nombre) {
        err('envio-nombre-error', true);
        valido = false;
        if (!primerFoco) primerFoco = document.getElementById('envio-nombre');
      } else {
        err('envio-nombre-error', false);
      }

      if (!/^\d{10}$/.test(cedula)) {
        err('envio-cedula-error', true);
        valido = false;
        if (!primerFoco) primerFoco = document.getElementById('envio-cedula');
      } else {
        err('envio-cedula-error', false);
      }

      if (!/^\d{9,10}$/.test(telefono.replace(/[\s-]/g, ''))) {
        err('envio-telefono-error', true);
        valido = false;
        if (!primerFoco) primerFoco = document.getElementById('envio-telefono');
      } else {
        err('envio-telefono-error', false);
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(correo)) {
        err('envio-correo-error', true);
        valido = false;
        if (!primerFoco) primerFoco = document.getElementById('envio-correo');
      } else {
        err('envio-correo-error', false);
      }

      if (metodoEnvio !== 'retiro') {
        if (!provincia) {
          err('envio-provincia-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('envio-provincia');
        } else {
          err('envio-provincia-error', false);
        }

        if (!ciudad) {
          err('envio-ciudad-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('envio-ciudad');
        } else {
          err('envio-ciudad-error', false);
        }

        if (direccion.length < 8) {
          err('envio-direccion-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('envio-direccion');
        } else {
          err('envio-direccion-error', false);
        }
      }

      if (!valido) {
        if (primerFoco) primerFoco.focus();
        return;
      }

      datosEnvio = { nombre, cedula, telefono, correo, provincia, ciudad, direccion };
      irAPaso('pago');
    });
  }

  if (btnEnvioVolver) btnEnvioVolver.addEventListener('click', () => irAPaso('carrito'));

  // 8. Paso 3: Pago
  const formPago = document.getElementById('form-paso-pago');
  const btnPagoVolver = document.getElementById('btn-pago-volver-envio');
  const radiosPago = document.querySelectorAll('input[name="metodo_pago"]');
  const panelTarjeta = document.getElementById('pago-panel-tarjeta');
  const panelTransferencia = document.getElementById('pago-panel-transferencia');
  const panelContraentrega = document.getElementById('pago-panel-contraentrega');
  const subtotalPagoEl = document.getElementById('pago-subtotal');
  const envioPagoEl = document.getElementById('pago-envio');
  const ivaPagoEl = document.getElementById('pago-iva');
  const totalPagoEl = document.getElementById('pago-total');
  const btnPagarTexto = document.getElementById('btn-pago-pagar-texto');
  const totalContraentrega = document.querySelector('.total-contraentrega');

  radiosPago.forEach((radio) => {
    radio.addEventListener('change', () => {
      metodoPago = radio.value;
      radiosPago.forEach((r) => {
        const lbl = r.closest('.label-metodo-pago');
        if (!lbl) return;
        if (r.checked) {
          lbl.classList.remove('border-crema-oscuro');
          lbl.classList.add('border-burdeos', 'bg-crema');
        } else {
          lbl.classList.remove('border-burdeos', 'bg-crema');
          lbl.classList.add('border-crema-oscuro');
        }
      });

      if (panelTarjeta) panelTarjeta.classList.toggle('hidden', metodoPago !== 'tarjeta');
      if (panelTransferencia) panelTransferencia.classList.toggle('hidden', metodoPago !== 'transferencia');
      if (panelContraentrega) panelContraentrega.classList.toggle('hidden', metodoPago !== 'contraentrega');
    });
  });

  // Formateo de tarjeta
  const inputNumeroTarj = document.getElementById('tarjeta-numero');
  const inputVencTarj = document.getElementById('tarjeta-vencimiento');

  if (inputNumeroTarj) {
    inputNumeroTarj.addEventListener('input', (e) => {
      const v = e.target.value.replace(/\D/g, '').slice(0, 16);
      e.target.value = v.replace(/(\d{4})(?=\d)/g, '$1 ');
    });
  }

  if (inputVencTarj) {
    inputVencTarj.addEventListener('input', (e) => {
      const v = e.target.value.replace(/\D/g, '').slice(0, 4);
      e.target.value = v.length > 2 ? `${v.slice(0, 2)}/${v.slice(2)}` : v;
    });
  }

  function renderPasoPago() {
    const totales = calcularTotales();
    if (subtotalPagoEl) subtotalPagoEl.textContent = formatPrice(totales.subtotal);
    if (envioPagoEl) envioPagoEl.textContent = totales.envio === 0 ? 'Gratis' : formatPrice(totales.envio);
    if (ivaPagoEl) ivaPagoEl.textContent = formatPrice(totales.iva);
    if (totalPagoEl) totalPagoEl.textContent = formatPrice(totales.total);
    if (totalContraentrega) totalContraentrega.textContent = formatPrice(totales.total);
    if (btnPagarTexto) btnPagarTexto.textContent = `Pagar ${formatPrice(totales.total)}`;
  }

  if (formPago) {
    formPago.addEventListener('submit', (e) => {
      e.preventDefault();
      const val = (id) => (document.getElementById(id) ? document.getElementById(id).value.trim() : '');
      const err = (id, mostrar) => {
        const p = document.getElementById(id);
        if (p) p.classList.toggle('hidden', !mostrar);
      };

      if (metodoPago === 'tarjeta') {
        const titular = val('tarjeta-titular');
        const numero = val('tarjeta-numero').replace(/\s/g, '');
        const venc = val('tarjeta-vencimiento');
        const cvv = val('tarjeta-cvv');

        let valido = true;
        let primerFoco = null;

        if (!titular) {
          err('tarjeta-titular-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('tarjeta-titular');
        } else {
          err('tarjeta-titular-error', false);
        }

        if (numero.length !== 16) {
          err('tarjeta-numero-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('tarjeta-numero');
        } else {
          err('tarjeta-numero-error', false);
        }

        const [mm, aa] = venc.split('/');
        const mes = Number(mm);
        const anio = 2000 + Number(aa);
        const hoy = new Date();
        const fechaValida = mm && aa && aa.length === 2 && mes >= 1 && mes <= 12 && (anio > hoy.getFullYear() || (anio === hoy.getFullYear() && mes >= hoy.getMonth() + 1));

        if (!fechaValida) {
          err('tarjeta-vencimiento-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('tarjeta-vencimiento');
        } else {
          err('tarjeta-vencimiento-error', false);
        }

        if (!/^\d{3,4}$/.test(cvv)) {
          err('tarjeta-cvv-error', true);
          valido = false;
          if (!primerFoco) primerFoco = document.getElementById('tarjeta-cvv');
        } else {
          err('tarjeta-cvv-error', false);
        }

        if (!valido) {
          if (primerFoco) primerFoco.focus();
          return;
        }
      }

      // Procesar compra simulada con retardo
      const btnSubmit = formPago.querySelector('button[type="submit"]');
      if (btnSubmit) {
        btnSubmit.disabled = true;
        if (btnPagarTexto) btnPagarTexto.textContent = 'Procesando…';
      }

      setTimeout(() => {
        const totales = calcularTotales();
        const items = window.AmbatenoCart.getItems();
        const lineas = Object.entries(items)
          .filter(([id]) => productosPorId[id])
          .map(([id, cant]) => ({
            nombre: productosPorId[id].nombre,
            cantidad: cant,
            total: Math.round(productosPorId[id].precio * cant * 100) / 100,
          }));

        const numAleatorio = Math.floor(10000 + Math.random() * 90000);
        const numeroPedido = `AMB-${new Date().getFullYear()}-${numAleatorio}`;

        pedidoRealizado = {
          numero: numeroPedido,
          lineas,
          totales,
          envio: {
            id: metodoEnvio,
            nombre: NOMBRES_ENVIO[metodoEnvio] || metodoEnvio,
            tiempo: TIEMPOS_ENVIO[metodoEnvio] || '',
          },
          pago: metodoPago,
          cliente: { ...datosEnvio },
        };

        window.AmbatenoCart.clear();
        if (btnSubmit) btnSubmit.disabled = false;
        irAPaso('confirmacion');
      }, 900);
    });
  }

  if (btnPagoVolver) btnPagoVolver.addEventListener('click', () => irAPaso('envio'));

  // 9. Paso 4: Confirmación
  const confNumero = document.getElementById('confirmacion-numero');
  const confSaludo = document.getElementById('confirmacion-saludo');
  const confTiempo = document.getElementById('confirmacion-entrega-tiempo');
  const confDetalles = document.getElementById('confirmacion-detalles-envio');
  const confLista = document.getElementById('confirmacion-lineas-lista');
  const confSubtotal = document.getElementById('confirmacion-subtotal');
  const confEnvio = document.getElementById('confirmacion-envio');
  const confIva = document.getElementById('confirmacion-iva');
  const confTotal = document.getElementById('confirmacion-total');
  const btnConfSeguir = document.getElementById('btn-confirmacion-seguir');

  function renderPasoConfirmacion() {
    if (!pedidoRealizado) return;

    if (confNumero) confNumero.textContent = pedidoRealizado.numero;
    if (confSaludo) {
      const nombreCorto = (pedidoRealizado.cliente.nombre || '').split(' ')[0] || 'cliente';
      confSaludo.textContent = `Gracias, ${nombreCorto}. Tu pedido simulado fue registrado.`;
    }
    if (confTiempo) {
      confTiempo.textContent = `Entrega estimada: ${pedidoRealizado.envio.tiempo}`;
    }
    if (confDetalles) {
      confDetalles.textContent = `${pedidoRealizado.envio.nombre} · Pago: ${NOMBRES_PAGO[pedidoRealizado.pago]} · Confirmación enviada a ${pedidoRealizado.cliente.correo}`;
    }
    if (confLista) {
      confLista.innerHTML = pedidoRealizado.lineas
        .map(
          (l) => `
        <li class="flex justify-between gap-3">
          <span class="text-tinta/85">${l.cantidad} × ${l.nombre}</span>
          <span class="shrink-0 font-semibold">${formatPrice(l.total)}</span>
        </li>`
        )
        .join('');
    }

    if (confSubtotal) confSubtotal.textContent = formatPrice(pedidoRealizado.totales.subtotal);
    if (confEnvio) confEnvio.textContent = pedidoRealizado.totales.envio === 0 ? 'Gratis' : formatPrice(pedidoRealizado.totales.envio);
    if (confIva) confIva.textContent = formatPrice(pedidoRealizado.totales.iva);
    if (confTotal) confTotal.textContent = formatPrice(pedidoRealizado.totales.total);
  }

  if (btnConfSeguir) {
    btnConfSeguir.addEventListener('click', () => {
      pedidoRealizado = null;
      irAPaso('tienda');
    });
  }

  // Escuchar cambios globales del carrito
  window.addEventListener('ambateno:cart-updated', () => {
    renderPanelCarrito();
    actualizarResumenCheckoutAside();
    if (pasoActual === 'carrito') renderPasoCarrito();
  });

  // Inicialización
  renderCatalogo();
  renderPanelCarrito();
  actualizarStepper();
});
