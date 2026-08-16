// ==========================================
// ELEMENTOS DEL DOM
// ==========================================
const authCard = document.querySelector('.auth-card');
const showRegisterButton = document.getElementById('showRegister');
const showLoginButton = document.getElementById('showLogin');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const forgotPassword = document.getElementById('forgotPassword');
const toast = document.getElementById('toast');
const toastMessage = document.getElementById('toastMessage');

// ==========================================
// GIRAR TARJETA → REGISTRO
// ==========================================
showRegisterButton.addEventListener(
    'click',
    () => {
        authCard.classList.add(
            'is-flipped'
        );
        setTimeout(() => {
            document
                .getElementById('registerName')
                .focus();
        }, 400);
    }
);

// ==========================================
// GIRAR TARJETA → LOGIN
// ==========================================
showLoginButton.addEventListener(
    'click',
    () => {
        authCard.classList.remove(
            'is-flipped'
        );
        setTimeout(() => {
            document
                .getElementById('loginEmail')
                .focus();
        }, 400);
    }
);

// ==========================================
// MOSTRAR / OCULTAR CONTRASEÑA
// ==========================================
const passwordToggles =
    document.querySelectorAll(
        '.password-toggle'
    );

passwordToggles.forEach(button => {
    button.addEventListener(
        'click',
        () => {
            const input = document.getElementById(button.dataset.target);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
                button.setAttribute('aria-label', 'Ocultar contraseña');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
                button.setAttribute('aria-label', 'Mostrar contraseña');
            }
        }
    );
});

// ==========================================
// LOGIN
// ==========================================
loginForm.addEventListener(
    'submit',
    event => {
        event.preventDefault();
        const email = document.getElementById('loginEmail').value.trim();
        const password = document.getElementById('loginPassword').value.trim();
        
        limpiarErroresLogin();

        let valido = true;

        if (email === '') {
            mostrarError('loginEmailError', 'El correo electrónico es obligatorio.');
            valido = false;
        }

        if (password === '') {
            mostrarError('loginPasswordError', 'La contraseña es obligatoria.');
            valido = false;
        }

        if (!valido) {
            return;
        }
        /*
            TODAVÍA NO EXISTE AUTENTICACIÓN REAL.
            En la segunda parte:
            JavaScript
                ↓
            PHP
                ↓
            MySQL
                ↓
            Verificar usuario
                ↓
            Verificar contraseña
                ↓
            Crear sesión
                ↓
            Redirigir al CRUD
        */
        mostrarToast('Formulario de inicio de sesión listo.');
    }
);

// ==========================================
// REGISTRO
// ==========================================
registerForm.addEventListener(
    'submit',
    event => {

        event.preventDefault();

        const name = document.getElementById('registerName').value.trim();
        const email = document.getElementById('registerEmail').value.trim();
        const password = document.getElementById('registerPassword').value.trim();

        limpiarErroresRegistro();

        let valido = true;

        if (name === '') {
            mostrarError('registerNameError', 'El nombre es obligatorio.');

            valido = false;
        }

        if (email === '') {
            mostrarError('registerEmailError', 'El correo electrónico es obligatorio.');

            valido = false;
        }

        if (password === '') {
            mostrarError('registerPasswordError', 'La contraseña es obligatoria.');

            valido = false;

        } else if (password.length < 6) {
            mostrarError('registerPasswordError', 'La contraseña debe contener al menos 6 caracteres.');
            valido = false;
        }

        if (!valido) {
            return;
        }
        /*
            TODAVÍA NO GUARDAMOS EL USUARIO.
            Posteriormente:
            Formulario
                ↓
            PHP
                ↓
            Validación
                ↓
            password_hash()
                ↓
            MySQL
        */
        mostrarToast('Formulario de registro listo.');
    }
);

// ==========================================
// ¿OLVIDASTE TU CONTRASEÑA?
// ==========================================
forgotPassword.addEventListener(
    'click',
    event => {
        event.preventDefault();
        mostrarToast('La recuperación de contraseña se implementará después.');
    }
);

// ==========================================
// FUNCIONES AUXILIARES
// ==========================================
function mostrarError(elementId, mensaje) {
    document.getElementById(elementId).textContent = mensaje;
}

function limpiarErroresLogin() {
    document.getElementById('loginEmailError').textContent = '';
    document.getElementById('loginPasswordError').textContent = '';
}

function limpiarErroresRegistro() {
    document.getElementById('registerNameError').textContent = '';
    document.getElementById('registerEmailError').textContent = '';
    document.getElementById('registerPasswordError').textContent = '';
}

function mostrarToast(mensaje) {
    toastMessage.textContent = mensaje;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}