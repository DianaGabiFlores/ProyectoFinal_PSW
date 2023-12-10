<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/functionlogin.js"></script>
    <link rel="stylesheet" href="../css/loginstyles.css">
    <link rel="stylesheet" href="../css/estilospagp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300&family=Playball&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="../imagenes/Icon2.png" />
    <title>Iniciar Sesión | Candy Craze</title>
</head>
<body>
    <?php
        include ("menu.php");
    ?>
    <script>
        document.getElementsByClassName("animate__animated animate__fadeInDown")[0].innerHTML = "— Inicia Sesión —";
        document.getElementsByClassName("animate__animated animate__fadeInUp")[0].innerHTML = "Desbloquea la posibilidad de comprar todos tus dulces favoritos";
    </script>

    <main>
    <section class="preguntasTitle">
        <h3>¡Tu Experiencia de Compra Más Dulce Comienza Aquí!</h3>
        <h2>Descubre un Mundo de Delicias</h2>
        <div class="linea"></div>
        <br>
        <p>Descubre un mundo de dulzura y comodidad al iniciar sesión. Con nuestra plataforma, accederás a una 
            experiencia de compra personalizada, donde podrás elegir y comprar todos los dulces que desees. 
            Además, disfrutarás de ofertas exclusivas y promociones irresistibles. ¡Inicia sesión ahora y endulza 
            tus momentos con la amplia variedad de delicias que tenemos para ti!</p>
    </section>
    <div style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" 
    style="height: 100%; width: 100%;">
    <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" 
    style="stroke: none; fill: #fff;"></path></svg></div>

    <section class="inicioSesionCC">
        <?php 
            if(!isset($_SESSION['usuario'])){
        ?>
        <div class="formlogin">
            <form class="form" action="cookies.php" method="post">
                <h2>Inicia Sesión</h2>
                <div class="linea"></div>
                <br>
                <div class="input-group mb-3">
                    <span id="usericon" class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input id="user" class="form-control info" type="text" placeholder="Usuario" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" required>
                </div>
                <p class="rescate primera contratext" id="contratext">Ingresa una nueva contraseña</p>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input id="pass" class="form-control info" type="password" placeholder="Contraseña" name="password" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["password"]; } ?>" required>
                </div>
                <div class="input-group mb-3 constraseñarepetida" id="repetidacontra">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="passrepetir" name="passwordR" class="form-control info" placeholder="Repetir Contraseña">
                    <small class="message" id="message">Las contraseñas no coinciden</small>
                </div>
                <div>
                    <div class="containerimage">
                        <img name="image" src="captcha.php?rand=<?php echo rand();?>" id='captcha_image'>
                    </div>
                    <p class="refresh">¿No puedes leer la imagen? <a href="" id="clickhere"> Haz click aquí</a> para actualizar</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-circle-check"></i></span>
                        <input class="form-control captcha" type="text" size="8" name="captcha" placeholder="akvn873j" required>
                    </div>
                </div>
                <div class="preguntas" id="preg">
                    <p id="id"></p>
                    <p class="rescate primera">Pregunta de recuperación:</p>
                    <p class="rescate">¿Quién es tu cantante o banda favorita?</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-question"></i></span>
                        <input id="pregunta_extra" class="form-control pregunta info" type="text" name="pregunta" placeholder="DAY6">
                    </div>
                </div>
                <div class="cookies">
                    <input class="check" type="checkbox" name="remember">
                    <p class="check1">Recordar mi usuario y contraseña </p>
                </div>
                <div class="containerboton">
                    <input class="boton btn btn-primary" type="submit" value="INICIAR SESIÓN" name="submit">
                </div>
                <br>
                <p class="mandarARegistro">¿No tienes cuenta? <a href="Registro.php" id="clickhere">Regístrate</a></p>
            </form>
        </div>
        <?php 
            }
        ?>
    </section>
    </main>
    
    <?php
        include("footer.php");
    ?>
    <script src="../js/script_login_contraseñas.js"></script>
</body>
</html>

<?php 
    include('scriptsLogin.php');
?>
