/* nuevo js */

document.addEventListener('DOMContentLoaded', function () {

    // Selecciona el elemento select por su ID  
    var tipoPreguntaSelect = document.getElementById('tipo_pregunta');

    // Añade un listener para el evento 'change'
    tipoPreguntaSelect.addEventListener('change', function () {
        // Ocultar todos los divs que corresponden a tipos de preguntas
        var divs = document.querySelectorAll('.tipo-pregunta');
        divs.forEach(function (div) {
            div.style.display = 'none';
        });

        // Mostrar el div correspondiente al tipo seleccionado
        var tipo = this.value; // El valor seleccionado en el select
        if (tipo) {
            // Busca el div que corresponde al valor seleccionado
            var divToShow = document.getElementById('tipo_' + tipo + '_div');
            if (divToShow) {
                divToShow.style.display = 'block';
            }
        }
    });

    window.addOpcion = function(tipo) {
        const containerId = tipo == 'simple' ? 'opciones-container-simple' : 'opciones-container-multiple';
        const container = document.getElementById(containerId);
        const newRow = document.createElement('div');
        newRow.className = 'opcion-row custom-form-row';
    
        let inputHTML;
        if (tipo === 'simple') {
          inputHTML = `
            <div class="custom-form-group">
                <input type="radio" name="opcion_simple" value="opcion_${Date.now()}">
            </div>
            <div class="custom-form-group">
              <input type="text" name="opciones_simple[]" class="custom-form-control" placeholder="Digite la opción">
            </div>
            <div class="custom-form-group">
              <button type="button" class="btn-remove-opcion" onclick="removeOpcion(this)">Eliminar</button>
            </div>
          `;
        } else {
          inputHTML = `
            <div class="custom-form-group">
                <input type="checkbox" name="opciones_multiple[]" value="opcion_${Date.now()}">
            </div>
            <div class="custom-form-group">
              <input type="text" name="opciones_multiple_text[]" class="custom-form-control" placeholder="Digite la opción">
            </div>
            <div class="custom-form-group">
              <button type="button" class="btn-remove-opcion" onclick="removeOpcion(this)">Eliminar</button>
            </div>
          `;
        }
    
        newRow.innerHTML = inputHTML;
        container.appendChild(newRow);
      };
    
      window.removeOpcion = function(button) {
        const row = button.parentElement.parentElement;
        row.remove();
      };




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