/* nuevo js */

document.addEventListener('DOMContentLoaded', function () {

    // Función genérica para mostrar el diálogo de confirmación
    function showConfirmationDialog(title, text, confirmButtonText, callback) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }


    // Manejo del envío del formulario con confirmación actualizar
    let updateForm=document.querySelector('#update-form');
    if(updateForm){
        updateForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevenir el envío del formulario por defecto

            // Capturar referencia al formulario
            let form = this;

            // Definir el callback para enviar el formulario
            let submitForm = () => {
                // Obtener los datos del formulario
                let formData = new FormData(form);

                // Obtener la URL de redirección del atributo de datos
                let redirectUrl = form.getAttribute('data-redirect-url');

                // Realizar la petición AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualización Exitosa',
                            text: data.message,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = redirectUrl; // Redireccionar a la página deseada
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '¡Hubo un problema al procesar tu solicitud! Por favor, intenta nuevamente más tarde.'
                    });
                });
            };

            // Mostrar la confirmación de envío
            showConfirmationDialog('¿Estás seguro?', '¡No podrás revertir esto!', 'Sí, actualizar!', submitForm);
        });
    }


    // Manejo del envío del formulario con confirmación guardar
    let registrationForm=document.querySelector('#registration-form');

    if(registrationForm){
        registrationForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevenir el envío del formulario por defecto

            // Definir el callback para enviar el formulario
            let submitForm = () => {
                // Obtener los datos del formulario
                let formData = new FormData(this);

                // Obtener la URL de redirección del atributo de datos
                let redirectUrl = this.getAttribute('data-redirect-url');

                // Realizar la petición AJAX
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registro Exitoso',
                            text: data.message,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = redirectUrl; // Redireccionar a la página deseada
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '¡Hubo un problema al procesar tu solicitud! Por favor, intenta nuevamente más tarde.'
                    });
                });
            };

            // Mostrar la confirmación de envío
            showConfirmationDialog('¿Estás seguro?', '¡No podrás revertir esto!', 'Sí, guardar!', submitForm);
        });
    }


    let deleteForm=document.querySelector('#delete-form');

    if(deleteForm){
        deleteForm.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                e.preventDefault();
                
    
                // Obtener el ID y la URL del registro a eliminar
                let button = e.target.closest('.delete-btn');
                let deleteUrl = button.getAttribute('data-url');
    
                // Definir el callback para eliminar el registro
                let deleteRecord = () => {
                    // Realizar la petición AJAX para eliminar el registro
                    fetch(deleteUrl, {
                        method: 'GET'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminación Exitosa',
                                text: data.message,
                                showConfirmButton: true
                            }).then(() => {
                                // Eliminar la fila de la tabla
                                button.closest('tr').remove();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '¡Hubo un problema al procesar tu solicitud! Por favor, intenta nuevamente más tarde.'
                        });
                    });
                };
    
                // Mostrar la confirmación de eliminación
                showConfirmationDialog('¿Estás seguro?', '¡No podrás revertir esto!', 'Sí, eliminar!', deleteRecord);
            }
        });

    }

   
});