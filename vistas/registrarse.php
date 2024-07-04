<div class="registration">
    <div class="registration-container">
        <form id="registration-form" action="./php/usuario_web.php" method="POST" data-redirect-url="./index.php?mostrar=pag">
            <h2>REGISTRO A TERRA CIVIL</h2>
            
            <!-- mensaje de alerta -->
            <div id="alert" class="alert-overlay">
                <div class="alert-container">
                    <span class="close" onclick="closeAlert()">&times;</span>
                    <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="dni">N° DNI (*)</label>
                    <input type="number" id="dni" name="dni" placeholder="Ingresa tu numero de DNI" >
                </div>
                <div class="form-group">
                    <label for="nom">Nombres (*)</label>
                    <input type="text" id="nom" name="nom" placeholder="Ingresa tus nombres" >
                </div>
                <div class="form-group">
                    <label for="apel">Apellidos (*)</label>
                    <input type="text" id="apel" name="apel" placeholder="Ingresa tus apellidos" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">Universidad (*)</label>
                    <input type="text" id="uni" name="uni" placeholder="Ingresa el nombre completo" >
                </div>
                <div class="form-group">
                    <label for="full-name">Facultad (*)</label>
                    <input type="text" id="facultad" name="facultad" placeholder="Ingresa tu facultad" >
                </div>
                <div class="form-group">
                    <label for="full-name">Escuela (*)</label>
                    <input type="text" id="escuela" name="escuela" placeholder="Ingresa tu escuela" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email (*)</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa un correo válido" >
                </div>
                <div class="form-group">
                    <label for="phone-number">N° Celular (*)</label>
                    <input type="text" id="celular" name="celular" placeholder="Ingresa un numero celular" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="dire">Direccion </label>
                    <textarea id="dire" name="dire" placeholder="Ingresa tu direccion actual"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Usuario (*)</label>
                    <input type="text" id="user" name="user" placeholder="Ingresa tu usuario" >
                </div>
                <div class="form-group">
                    <label for="password">Clave (*)</label>
                    <input type="password" id="clv" name="clv" placeholder="Ingresar una clave" >
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmar Clave (*)</label>
                    <input type="password" id="clv2" name="clv2" placeholder="Confirma tu clave" >
                </div>
            </div>
            <br>
            <div class="form-group-btn">
                <button type="submit" class="register-btn">REGISTRAR</button>
                <a href="./index.php?mostrar=pag" type="submit" class="register-btn btn-warning">SALIR</a>
            </div>
        </form>
    </div>
</div>