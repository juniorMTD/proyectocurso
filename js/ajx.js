/* nuevo js */

let myChart;

function inicializarGrafico(data) {
    const ctx = document.getElementById('myChart').getContext('2d');

    if (myChart) {
        myChart.destroy(); // Destruye el gráfico anterior si existe, para evitar sobrecargas
    }

    myChart = new Chart(ctx, {
        type: 'bar', // Puedes cambiar el tipo de gráfico
        data: {
            labels: ['Opción 1', 'Opción 2', 'Opción 3', 'Opción 4'], // Etiquetas de las opciones
            datasets: [{
                label: 'Respuestas',
                data: data, // Datos dinámicos recibidos
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5 // Valor máximo en el eje Y
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {

    // Selecciona el elemento select por su ID  
    var tipoPreguntaSelect = document.getElementById('tipo_pregunta');

    // Añade un listener para el evento 'change'

    if (tipoPreguntaSelect) {
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
    }

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
                                button.closest('li').remove();
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


    let deleteForm1 = document.querySelector('.x_content'); // Usamos el contenedor que tiene todos los elementos dinámicos

    if (deleteForm1) {
        deleteForm1.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                e.preventDefault();

                // Obtener el botón y su URL para eliminar
                let button = e.target.closest('.delete-btn');
                let deleteUrl = button.getAttribute('data-url');

                // Confirmación para eliminar
                showConfirmationDialog('¿Estás seguro?', '¡No podrás revertir esto!', 'Sí, eliminar!', function () {
                    fetch(deleteUrl, { method: 'GET' })
                        .then(response => {
                            if (!response.ok) throw new Error('Error en la respuesta');
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
                                    // Elimina el contenedor de la pregunta
                                    button.closest('.x_panel').remove();
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
                });
            }
        });
    }

});

function obtenerArchivoPorId(idarchivo){
    $.ajax({
        type:"POST",
        data: "idArchivo="+idarchivo,
        url:"/proyectocurso/php/obtenerarchivo.php",
        success: function(respuesta) {
            var datos = JSON.parse(respuesta);
            if (datos.status === "success") {
                // Colocar la imagen o contenido del archivo en el modal
                $('#archivoObtenido').html(datos.archivo);
            } else {
                // Mostrar mensaje de error si no se encuentra el archivo
                $('#archivoObtenido').html('<p>' + datos.message + '</p>');
            }
        }
    })
}

function obtenerDatosParaGrafico() {
    $.ajax({
        type: "GET",
        url: "/ruta/a/tu/api/encuestas", // Cambia por la ruta correcta
        success: function (respuesta) {
            // Parsear la respuesta para obtener los datos
            const datos = JSON.parse(respuesta);
            
            // Supongamos que 'datos' es un array con los números de respuestas
            const respuestas = datos.respuestas; // ['3', '5', '2', '0'] por ejemplo

            // Llamamos a la función para inicializar o actualizar el gráfico
            inicializarGrafico(respuestas);
        },
        error: function (error) {
            console.error("Error obteniendo los datos: ", error);
        }
    });
}
