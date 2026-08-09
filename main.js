let datos = [
    {id: 1, nombre: 'Byron', email: 'byronjorge.158@gmail.com', edad: 23},
    {id: 2, nombre: 'Danna', email: 'danna.147@hotmail.com', edad: 30}
];

//ELEMENTOS DEL DOM
const form = document.getElementById('formulario');
const idInput = document.getElementById('id');
const nombreInput = document.getElementById('nombre');
const edadInput = document.getElementById('edad');
const emailInput = document.getElementById('email');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const tbody = document.querySelector('#tabla tbody');

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
                    <button onClick="editar(${d.id})"style="background: #0000FF; color: white">Editar</button>
                    <button onClick="eliminar(${d.id})"style="background: #dc3545; color: white">Eliminar</button>
                </td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', fila);
    });
}

// CREAR Y ACTUALIZAR (CREATE / UPDATE)
form.addEventListener('submit', e => {
    e.preventDefault();

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

    form.reset();
    idInput.value = '';
    btnGuardar.textContent = 'Agregar';
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

    btnGuardar.textContent = 'Actualizar';
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

    // Cambiar el botón principal
    btnGuardar.textContent = 'Agregar';

    // Ocultar el botón cancelar
    btnCancelar.classList.add('oculto');
});