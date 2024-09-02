<div class="registration">
    <div class="registration-container">
        <form id="registration-form" action="./php/usuario_web.php" method="POST" data-redirect-url="./index.php?mostrar=pag">
            <h2 class="text-center text-white">REGISTRO A TERRA CIVIL INGENIERIA</h2>
            
            <!-- mensaje de alerta -->
            <div id="alert" class="alert-overlay">
                <div class="alert-container">
                    <span class="close" onclick="closeAlert()">&times;</span>
                    <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-12 col-md-12 col-sm-12">
                    <label for="dni">N° DNI (*)</label>
                    <input type="number" class="form-control" id="dni" name="dni" placeholder="Ingresa tu número de DNI" required>
                </div>
                <div class="form-group col-12 col-md-12 col-sm-12">
                    <label for="nom">Nombres (*)</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Ingresa tus nombres" required>
                </div>
                <div class="form-group col-12 col-md-12 col-sm-12">
                    <label for="apel">Apellidos (*)</label>
                    <input type="text" class="form-control" id="apel" name="apel" placeholder="Ingresa tus apellidos" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12 col-md-4">
                    <label for="uni">Universidad (*)</label>
                    <input type="text" class="form-control" id="uni" name="uni" placeholder="Ingresa el nombre completo" required>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="facultad">Facultad (*)</label>
                    <input type="text" class="form-control" id="facultad" name="facultad" placeholder="Ingresa tu facultad" required>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="escuela">Escuela (*)</label>
                    <input type="text" class="form-control" id="escuela" name="escuela" placeholder="Ingresa tu escuela" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label for="email">Email (*)</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa un correo válido" required>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="celular">N° Celular (*)</label>
                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Ingresa un número celular" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12 col-md-12">
                    <label for="dire">Dirección</label>
                    <textarea class="form-control" id="dire" name="dire" placeholder="Ingresa tu dirección actual"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12 col-md-4">
                    <label for="user">Usuario (*)</label>
                    <input type="text" class="form-control" id="user" name="user" placeholder="Ingresa tu usuario" required>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="clv">Clave (*)</label>
                    <input type="password" class="form-control" id="clv" name="clv" placeholder="Ingresa una clave" required>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="clv2">Confirmar Clave (*)</label>
                    <input type="password" class="form-control" id="clv2" name="clv2" placeholder="Confirma tu clave" required>
                </div>
            </div>

            <br>
            <div class="form-group-btn">
                <div class="form-group col-12 col-md-5">
                    <button type="submit" class="register-btn">REGISTRAR</button>
                </div>
                <div class="form-group col-12 col-md-5">
                    <a href="./index.php?mostrar=pag" type="submit" class="register-btn btn-danger">SALIR</a>
                </div>
            </div>
        </form>
    </div>
</div>