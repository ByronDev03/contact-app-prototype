let datos = JSON.parse(localStorage.getItem('usuarios')) || [
    {id: 1, nombre: 'Byron', telefono: '7351234567', fechaCreacion: Date.now()},
    {id: 2, nombre: 'Danna', telefono: '7771990122', fechaCreacion: Date.now()}
];

function guardarDatos() {
    localStorage.setItem('usuarios', JSON.stringify(datos));
}

//ELEMENTOS DEL DOM
const form = document.getElementById('formulario');
const idInput = document.getElementById('id');
const nombreInput = document.getElementById('nombre');
const telefonoInput = document.getElementById('telefono');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const tbody = document.querySelector('#tabla tbody');
const errorNombre = document.getElementById('errorNombre');
const errorTelefono = document.getElementById('errorTelefono');
const busquedaInput = document.getElementById('busqueda');
const btnLimpiarFiltros = document.getElementById('btnLimpiarFiltros');
const contadorResultados = document.getElementById('contadorResultados');

// FUNCIÓN PARA MOSTRAR "HACE X DÍAS"
function tiempoTranscurrido(fecha) {
    const ahora = new Date();
    const fechaCreacion = new Date(fecha);
    const diferencia = ahora - fechaCreacion;
    const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

    if (dias === 0) {
        return 'Hoy';
    }

    if (dias === 1) {
        return 'Hace 1 día';
    }

    return `Hace ${dias} días`;
}

// MOSTRAR DATOS (READ)
function renderizar(lista = datos) {
    tbody.innerHTML = '';

    if (lista.length == 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="sin-resultados">
                    <i class="bi bi-search"></i>
                    No se encontaron resultados.
                </td>
            </tr>    
        `;

        contadorResultados.textContent = '0 resultados';
        return;
    }

    lista.forEach(d => {
        const fila = `
            <tr>
                <td>${d.nombre}</td>
                <td>${d.telefono}</td>
                <td>${tiempoTranscurrido(d.fechaCreacion)}</td>
                <td class="acciones">
                
                    <button class="btn-editar" onClick="editar(${d.id})">
                        <i class="bi bi-pencil"></i>
                        <span>Edit</span>
                    </button>

                    <button class="btn-eliminar" onClick="eliminar(${d.id})">
                        <i class="bi bi-trash"></i>
                        <span>Delete</span>
                    </button>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', fila);
    });

    contadorResultados.textContent = 
        `${lista.length} ${lista.length === 1 ? 'resultado' : 'resultados'}`;
}

// BÚSQUEDA Y FILTRADO
function aplicarFiltros() {
    const texto = busquedaInput.value.trim().toLowerCase();

    const resultados = datos.filter(d => {
        return (
            d.nombre.toLowerCase().includes(texto) || 
            d.telefono.includes(texto)
        );
    });

    renderizar(resultados);
}

busquedaInput.addEventListener('input', aplicarFiltros);

btnLimpiarFiltros.addEventListener('click', () => {
    busquedaInput.value = '';
    renderizar();
});

// VALIDAR FORMULARIO
function validarFormulario() {

    let valido = true;

    // Limpiar mensajes anteriores
    errorNombre.textContent = '';
    errorTelefono.textContent = '';

    nombreInput.classList.remove('input-error');
    telefonoInput.classList.remove('input-error');

    // VALIDAR NOMBRE
    const nombre = nombreInput.value.trim();

    if (nombre === '') {
        errorNombre.textContent = 'El nombre es obligatorio.';
        nombreInput.classList.add('input-error');
        valido = false;
    } else if (nombre.length < 2) {
        errorNombre.textContent = 'El nombre debe contener al menos 2 caracteres.';
        nombreInput.classList.add('input-error');
        valido = false;
    } else if (!/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/.test(nombre)) {
        errorNombre.textContent = 'El nombre no puede contener números ni caracteres especiales.';
        nombreInput.classList.add('input-error');
        valido = false;
    }

    // VALIDAR TELÉFONO
    const telefono = telefonoInput.value.trim();

    if (telefono == '') {
        errorTelefono.textContent = 'El número telefónico es obligatorio.';
        telefonoInput.classList.add('input-error');
        valido = false;
    } else if (!/^[0-9\s+()-]{7,20}$/.test(telefono)) {
        errorTelefono.textContent = 'Ingresa un número telefónico válido.';
        telefonoInput.classList.add('input-error');
        valido = false;
    }

    return valido;
}

// CREAR Y ACTUALIZAR (CREATE / UPDATE)
form.addEventListener('submit', e => {
    e.preventDefault();

    if (!validarFormulario()) {
        return;
    }

    const id = idInput.value;
    const nombre = nombreInput.value.trim();
    const telefono = telefonoInput.value.trim();

    if (id) {
        // Actualizar
        const item = datos.find(d => d.id == id);
        item.nombre = nombre;
        item.telefono = telefono;
    } else {
        // Crear
        datos.push({
            id: Date.now(),
            nombre,
            telefono,
            fechaCreacion: Date.now()
        });
    }

    guardarDatos();

    form.reset();
    idInput.value = '';

    btnGuardar.querySelector('span').textContent = 'Agregar';
    btnGuardar.querySelector('i').className = 'bi bi-plus-circle';

    btnCancelar.classList.add('oculto');

    renderizar();
});

// EDITAR (UPDATE)
function editar(id) {
    const item = datos.find(d => d.id == id);

    idInput.value = item.id;
    nombreInput.value = item.nombre;
    telefonoInput.value = item.telefono;

    btnGuardar.querySelector('span').textContent = 'Actualizar';
    btnGuardar.querySelector('i').className = 'bi bi-arrow-repeat';

    btnCancelar.classList.remove('oculto');

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// ELIMINAR (DELETE)
function eliminar(id) {
    if (confirm('¿Eliminar este registro?')) {
        datos = datos.filter(d => d.id != id);
        guardarDatos();
        renderizar();
    }
}

// CANCELAR BÓTON EDITAR
btnCancelar.addEventListener('click', () => {
    // Limpiar formulario
    form.reset();

    // Vaciar el id oculto
    idInput.value = '';

    // Restaurar botón Agregar
    btnGuardar.querySelector('span').textContent = 'Agregar';
    btnGuardar.querySelector('i').className = 'bi bi-plus-circle';

    // Ocultar el botón cancelar
    btnCancelar.classList.add('oculto');

    // Limpiar mensajes de error
    errorNombre.textContent = '';
    errorTelefono.textContent = '';

    // Quitar estilos de error
    nombreInput.classList.remove('input-error');
    telefonoInput.classList.remove('input-error');
});

renderizar();