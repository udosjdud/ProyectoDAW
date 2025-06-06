$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const correo = urlParams.get('correo'); // Correo que se ha introducido en el formulario del inicio
    const messageContainer = document.querySelector('.contenedor_mensaje');

    if (error) {
        var message = '';
        switch (error) {
            case 'invalid_credentials':
                message = 'Credenciales inválidas';
                break;
            case 'passwords_dont_match':
                message = 'Las contraseñas no coinciden';
                break;
            case 'email_exists':
                message = 'Este correo electrónico ya está registrado';
                break;
            case 'invalid_email':
                message = 'Por favor, introduce un correo electrónico válido (.com o .es)';
                break;
            case 'db_error':
                message = 'Error de conexión con la base de datos';
                break;
            case 'server_error':
                message = 'Error del servidor: ' + urlParams.get('message');
                break;
            default:
                message = 'Ha ocurrido un error';
        }

        messageContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }

    if (correo) {
        $("#correo").val(correo);
    }
});