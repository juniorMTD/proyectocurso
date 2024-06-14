<div class="registration">
    <div class="registration-container">
        <form class="registration-form">
            <h2>REGISTRO A TERRA CIVIL</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">N° DNI</label>
                    <input type="number" id="dni" name="dni" placeholder="Ingresa tu numero de DNI" required>
                </div>
                <div class="form-group">
                    <label for="full-name">Nombres</label>
                    <input type="text" id="nom" name="nom" placeholder="Ingresa tus nombres" required>
                </div>
                <div class="form-group">
                    <label for="full-name">Apellidos</label>
                    <input type="text" id="nom" name="nom" placeholder="Ingresa tus apellidos" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">Universidad</label>
                    <input type="text" id="uni" name="uni" placeholder="Ingresa el nombre completo" required>
                </div>
                <div class="form-group">
                    <label for="full-name">Facultad</label>
                    <input type="text" id="facultad" name="facultad" placeholder="Ingresa tu facultad" required>
                </div>
                <div class="form-group">
                    <label for="full-name">Escuela</label>
                    <input type="text" id="escuela" name="escuela" placeholder="Ingresa tu escuela" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa un correo válido" required>
                </div>
                <div class="form-group">
                    <label for="phone-number">N° Celular</label>
                    <input type="text" id="celular" name="celular" placeholder="Ingresa un numero celular" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="user" name="user" placeholder="Ingresa tu usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Clave</label>
                    <input type="password" id="clv" name="clv" placeholder="Ingresar una clave" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmar Clave</label>
                    <input type="password" id="clv2" name="clv2" placeholder="Confirma tu clave" required>
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