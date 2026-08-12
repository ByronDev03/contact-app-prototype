let datos = JSON.parse(localStorage.getItem('usuarios')) || [
    {id: 1, nombre: 'Byron', email: 'byronjorge.158@gmail.com', edad: 23},
    {id: 2, nombre: 'Danna', email: 'danna.147@hotmail.com', edad: 30}
];

function guardarDatos() {
    localStorage.setItem('usuarios', JSON.stringify(datos));
}

//ELEMENTOS DEL DOM
const form = document.getElementById('formulario');
const idInput = document.getElementById('id');
const nombreInput = document.getElementById('nombre');
const edadInput = document.getElementById('edad');
const emailInput = document.getElementById('email');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const tbody = document.querySelector('#tabla tbody');
const errorNombre = document.getElementById('errorNombre');
const errorEdad = document.getElementById('errorEdad');
const errorEmail = document.getElementById('errorEmail');

// MOSTRAR DATOS (READ)
function renderizar() {
    tbody.innerHTML = '';
    datos.forEach (d => {
        const fila = `
            <tr>
                <td>${d.id}</td>
                <td>${d.nombre}</td>
                <td>${d.edad}</td>
                <td>${d.email}</td>
                <td class="acciones">
                    <button class="btn-editar" onClick="editar(${d.id})">
                        <i class="bi bi-pencil"></i>
                        <span>Editar</span>
                    </button>

                    <button class="btn-eliminar" onClick="eliminar(${d.id})">
                        <i class="bi bi-trash"></i>
                        <span>Eliminar</span>
                    </button>
                </td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', fila);
    });
}

// VALIDAR FORMULARIO
function validarFormulario() {

    let valido = true;

    // Limpiar mensajes anteriores
    errorNombre.textContent = '';
    errorEdad.textContent = '';
    errorEmail.textContent = '';

    nombreInput.classList.remove('input-error');
    edadInput.classList.remove('input-error');
    emailInput.classList.remove('input-error');

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

    // VALIDAR EDAD
    const edad = Number(edadInput.value);

    if (edadInput.value === '') {
        errorEdad.textContent = 'La edad es obligatoria.';
        edadInput.classList.add('input-error');
        valido = false;
    } else if (edad < 1 || edad > 99) {
        errorEdad.textContent = 'La edad debe estar entre 1 y 99 años.';
        edadInput.classList.add('input-error');
        valido = false;
    }

    // VALIDAR EMAIL
    const email = emailInput.value.trim();

    const formatoEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === '') {
        errorEmail.textContent = 'El correo electrónico es obligatorio.';
        emailInput.classList.add('input-error');
        valido = false;
    } else if (!formatoEmail.test(email)) {
        errorEmail.textContent = 'Ingresa un correo electrónico válido.';
        emailInput.classList.add('input-error');
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
    const edad = +edadInput.value;
    const email = emailInput.value.trim();

    if (id) {
        // Actualizar
        const item = datos.find(d => d.id == id);
        item.nombre = nombre;
        item.edad = edad;
        item.email = email;
    } else {
        // Crear
        datos.push({
            id: Date.now(),
            nombre,
            edad,
            email
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
    edadInput.value = item.edad;
    emailInput.value = item.email;

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
    errorEdad.textContent = '';
    errorEmail.textContent = '';

    // Quitar estilos de error
    nombreInput.classList.remove('input-error');
    edadInput.classList.remove('input-error');
    emailInput.classList.remove('input-error');
});