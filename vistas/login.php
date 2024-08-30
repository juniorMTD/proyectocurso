<div class="custom-login">
    <div class="container">
            <div class="main-container">
                <div class="col-lg-6 custom-info-section">
                    <img src="./biblioteca/banner/loginimagen.jpg" alt="Info Image" class="img-fluid">
                </div>
                <div class="col-lg-6 custom-login-section">
                    <div class="login-content">
                        <div class="logo">
                            <img style="border-radius:50%" src="./biblioteca/images/logo.jpg" alt="Logo TERRACIVIL">
                        </div>
                        <h2>BIENVENIDO A LA PAGINA DE RECURSOS DE TERRACIVIL</h2>
                        <p>Por favor ingrese a su cuenta</p>
                        <form action="" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="login_usu">USUARIO</label>
                                <input type="text" id="login_usu" name="login_usu" class="form-control" placeholder="Usuario">
                            </div>
                            <div class="form-group">
                                <label for="login_usu">CONTRASEÑA</label>
                                <input type="password" id="login_usu" name="login_clv" class="form-control" placeholder="contraseña">
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">ENTRAR</button><br>
                                <a href="./index.php?mostrar=pag"  class="btn btn-warning btn-block">SALIR</a>
                            </div>

                            <?php
                                if(isset($_POST['login_usu']) && isset($_POST['login_clv'])){
                                    require_once "./conexion/conexion_db.php";
                                    require_once "./php/main.php";
                                    require_once "./php/iniciar_sesion.php";
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>