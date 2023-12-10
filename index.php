<!DOCTYPE html>
<html lang="en">

<?php
    session_start();

    $cantidad= null;

if (isset($_SESSION['usuario'])){    
    $servidor='localhost:3307';
    $cuenta='root';
    $password='';
    $bd='store';
    
    //conexion a la base de datos
    $conexion = new mysqli($servidor,$cuenta,$password,$bd);
    
    if ($conexion->connect_errno){
        die('Error en la conexion');
    }
    $usuario = $_SESSION['usuario'];
    $sql = "SELECT SUM(cantidad) as cant FROM Carrito WHERE usuario='$usuario';";
    
    $resultado = $conexion -> query($sql); 
    while( $fila = $resultado -> fetch_assoc() ){
        $cantidad = $fila['cant'];
    }  
    if($cantidad == null){
        $cantidad = 0;
    }  

}else{
    
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="imagenes/Icon2.png"/>

    <title>Inicio | Candy Craze</title>
    <link rel="stylesheet" href="css/estilospagp.css">
    <link rel="stylesheet" href="css/estiloCupon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300&family=Playball&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f3a304d792.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .footer {
            background: #3d0c11;
            color: white;
            font-family: 'Merienda', cursive;
        }

        .footer h2, .footer h3 {
            font-family: 'Playball', cursive;
        }

        .footer p, .footer a, .footer i {
            margin-right: 15px;
        }

        .footer .links ul {
            list-style-type: none;
        }

        .footer .links ul li a {
            text-decoration: none;
            color: rgb(168, 168, 168);
            transition: color 0.2s;
        }

        .footer .links ul li a:hover {
            text-decoration: none;
            color: #f78ca2;
        }

        .footer .about-company i {
            font-size: 25px;
        }

        .footer .about-company i:hover {
            color: #f78ca2;
            transition: color 0.2s ease;
        }

        .footer .about-company a {
            color: white;
            transition: color 0.2s;
        }

        .footer .about-company a:hover {
            color: #f78ca2;
        }

        .footer .location i {
            font-size: 18px;
            margin-right: 15px;
        }

        .footer .copyright p {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            margin-top: -25px;
        }
        #saludos, .saludos{
            position: absolute;
            color: white;
            top: 90px;
            right: 40px;
            text-align: right;
            display: flex;
            justify-content: end;
            margin-right: 20px;
        }
        @media only screen and (max-width: 992px) {
            #saludos, .saludos{
                top: 130px;
                left: 50px;
                justify-content: start;
            }
        }
    </style>
</head>

<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a href="index.php" style="text-decoration: none;">
                    <img src="imagenes/LogoCC.png" alt="Candy Craze" style="margin-right:10px; width:70px;">
                </a>
                <a class="navbar-brand" href="index.php">Candy Craze</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="d-flex ms-auto">
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="php/productos.php">Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="php/acerca.php">Acerca de</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="php/contacto.php">Contáctanos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="php/ayuda.php">Ayuda</a>
                            </li>
                            <?php 
                            if(isset($_SESSION['admin'])){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="php/altas.php">Administrador</a>
                            </li>
                            <?php 
                            }
                            ?>
                        </ul>
                        <?php 
                            if(!isset($_SESSION['usuario'])){?>
                                <a href="php/login.php" class="navbar-nav">
                                    <span class="nav-link">
                                        <i class="fa-solid fa-user menuIcons"></i>
                                    </span>
                                </a>
                        <?php }elseif(isset($_SESSION['usuario'])){ ?>
                            <a href="php/logout.php" class="navbar-nav">
                                <span class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i>
                                </span>
                            </a>
                        <?php } ?>
                        <a href="php/carrito.php" class="navbar-nav">
                            <span class="nav-link">
                                <i class="fa-solid fa-cart-shopping menuIcons"></i><sub><?php echo $cantidad ?></sub>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="saludos" id="saludos">
            <?php 
                if(isset($_SESSION['usuario'])){
                    date_default_timezone_set('America/Mexico_City'); 
                    $hora_actual = date('H');
                    if($hora_actual >=5 && $hora_actual < 12){
                        $saludo = "Buenos días";
                    }elseif($hora_actual >= 12 && $hora_actual < 19){
                        $saludo = "Buenas tardes"; 
                    }else {
                        $saludo = "Buenas noches"; 
                    }
            ?>
                <p><?php echo $saludo." ".$_SESSION['usuario']?></p>
            <?php 
                }
            ?>
        </div>
        <section class="textos-header">
            <h2 class="animate__animated animate__fadeInDown">— Bienvenido a Candy Craze —</h2>
            <h1 class="animate__animated animate__fadeInUp">¡Delicias Globales en un Click!</h1>
        </section>
        <div class="wave" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
            style="height: 100%; width: 100%;">
            <path d="M0.00,49.98 C150.00,150.00 349.20,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                style="stroke: none; fill: #f9dec9"></path>
        </svg></div>
    </header>

    <main>
        <section class="caracteristicas">
            <h3>Características Destacadas</h3>
            <h2>Lo Que Nos Distingue</h2>
            <div class="linea"></div>
            <br>
            <div class="contenedor">
                <div class="cuadro">
                    <div class="icono">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div class="contenido">
                        <h2>Envío Gratuito</h2>
                        <p>Apartir de $350 por pedido</p>
                    </div>
                </div>
                <div class="cuadro">
                    <div class="icono">
                        <i class="fa-regular fa-credit-card"></i>
                    </div>
                    <div class="contenido">
                        <h2>Pago con Tarjeta</h2>
                        <p>Variedad de Opciones</p>
                    </div>
                </div>
                <div class="cuadro">
                    <div class="icono">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <div class="contenido">
                        <h2>Devoluciones Fáciles</h2>
                        <p>Compra con Confianza</p>
                    </div>
                </div>
                <div class="cuadro">
                    <div class="icono">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div class="contenido">
                        <h2>Garantía de Calidad</h2>
                        <p>Compromiso con la Calidad</p>
                    </div>
                </div>
            </div>
        </section>
        <div style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
                style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #fff;"></path>
            </svg></div>
        <section class="acercaCC">
            <div class="contenedor2">
                <div class="imgCont">
                    <img src="imagenes/img1.jpg" alt="">
                    <img src="imagenes/img2.png" alt="">
                    <img src="imagenes/img3.jpg" alt="">
                    <img src="imagenes/img4.jpg" alt="">
                </div>
                <div class="txtCont">
                    <h3>Acerca de Candy Craze</h3>
                    <h2>Bienvenido a la Mejor Dulcería Internacional.</h2>
                    <div class="linea"></div>
                    <br>
                    <h4>Tu ventana a una experiencia global de sabores dulces.</h4>
                    <br>
                    <p>Nuestra tienda ofrece una ecléctica selección de golosinas internacionales.
                        Cada producto cuenta una historia cultural única, y nos enorgullece brindar
                        autenticidad y calidad al colaborar con proveedores locales. En Candy Craze,
                        no solo encontrarás golosinas, sino una experiencia que te invita a explorar el mundo a través
                        de sus sabores.</p>
                    <a href="php/contacto.php">
                        <button type="button" class="btn btn-primary">CONTÁCTANOS</button>
                    </a>

                </div>
            </div>
        </section>
        <section class="producCC">
            <div class="wave2" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150"
                    preserveAspectRatio="none" style="height: 100%; width: 100%;">
                    <path d="M0.00,49.98 C149.99,150.00 271.49,-49.98 500.00,49.98 L500.00,0.00 L0.00,0.00 Z"
                        style="stroke: none; fill: #fff;"></path>
                </svg></div>
            <div class="contenedor3">
                <h3>Saborea la Felicidad en cada Dulce</h3>
                <br>
                <h2>Descubre la magia de nuestros productos que harán de cada momento un festín para tus sentidos.
                    ¡Ven y déjate llevar por el placer de los sabores inolvidables en nuestra dulcería!</h2>
                <br>
                <div style="text-align: center;">
                    <a href="php/productos.php">
                        <button type="button" class="btn btn-primary">EXPLORA NUESTROS PRODUCTOS</button>
                    </a>
                </div>
            </div>
            <div class="wave2" style="height: 150px; overflow: hidden;">
                <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
                    <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                        style="stroke: none; fill: #f9dec9"></path>
                </svg>
            </div>
        </section>
        <section>
            <div class="commentsCC">
                <h3>¿Cuál es la opinión de los clientes?</h3>
                <h2>Testimonios</h2>
                <div class="linea"></div>
                <div class="container my-5">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <div class="card text-center p-4">
                                    <i class="fa-solid fa-quote-left icono"></i>
                                    <div class="card-body">
                                        <p class="card-text">"¡Excelente servicio! Me encantó la atención al cliente y
                                            la calidad de los productos."</p>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <img src="imagenes/mujer.jpg" alt="Cliente 1"
                                            class="testimonial-img mx-auto d-block">
                                        <h5 class="card-title">Ximena Gonzáles</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="card text-center p-4">
                                    <i class="fa-solid fa-quote-left icono"></i>
                                    <div class="card-body">
                                        <p class="card-text">"Increíble experiencia de compra. Recibí mi pedido a tiempo
                                            y en perfecto estado."</p>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <img src="imagenes/hombre1.jpg" alt="Cliente 2"
                                            class="testimonial-img mx-auto d-block">
                                        <h5 class="card-title">Eduardo Preciado</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="card text-center p-4">
                                    <i class="fa-solid fa-quote-left icono"></i>
                                    <div class="card-body">
                                        <p class="card-text">"Los productos son de alta calidad y el proceso de compra
                                            fue fácil y rápido."</p>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <img src="imagenes/hombre2.png" alt="Cliente 3"
                                            class="testimonial-img mx-auto d-block">
                                        <h5 class="card-title">Carlos Jiménez</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
            <div style="height: 150px; overflow: hidden;">
                <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
                    <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                        style="stroke: none; fill: #fff"></path>
                </svg>
            </div>
        </section>
        <section class="suscripcionCC">
            <h3>No te pierdas nuestras irresistibles ofertas</h3>
            <h2>Suscríbete</h2>
            <div class="linea"></div>
            <div class="container mt-5">
                <form action="php/email.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3 mx-auto">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                                <input type="text" class="form-control" placeholder="Correo electrónico"
                                    name="correosub" required>
                                <button class="btn btn-primary" name="submit" type="submit" id="peticion-submit"
                                    data-submit="...Sending">ENVIAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <button class="Btn" id="openCardBtn">
            <svg class="logoIcon" height="2.5em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6ZM4 8C4 5.79086 5.79086 4 8 4C10.2091 4 12 5.79086 12 8C12 10.2091 10.2091 12 8 12C5.79086 12 4 10.2091 4 8ZM17 15C15.8954 15 15 15.8954 15 17C15 18.1046 15.8954 19 17 19C18.1046 19 19 18.1046 19 17C19 15.8954 18.1046 15 17 15ZM13 17C13 14.7909 14.7909 13 17 13C19.2091 13 21 14.7909 21 17C21 19.2091 19.2091 21 17 21C14.7909 21 13 19.2091 13 17ZM19.7071 6.70711C20.0976 6.31658 20.0976 5.68342 19.7071 5.29289C19.3166 4.90237 18.6834 4.90237 18.2929 5.29289L5.29289 18.2929C4.90237 18.6834 4.90237 19.3166 5.29289 19.7071C5.68342 20.0976 6.31658 20.0976 6.70711 19.7071L19.7071 6.70711Z"></path></svg>
            <span class="tooltip"><b>Cupón</b></span>
        </button>

        <div class="cardC cardC-5" id="myCard" style="position:fixed;top:20px;right:120px;z-index:1000;">
            <p class="dismiss" type="button"><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></p>
            <br>
            <img src="imagenes/cuponAñoNuevo.png" alt="" width=450px;>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const openCardBtn = document.getElementById('openCardBtn');
                const myCard = document.getElementById('myCard');
                const dismissBtn = myCard.querySelector('.dismiss');

                openCardBtn.addEventListener('click', function () {
                    // Solo mostrar la tarjeta al hacer clic en el botón
                    myCard.style.display = 'block';
                });

                dismissBtn.addEventListener('click', function () {
                    myCard.style.display = 'none';
                });
            });
        </script>
    </main>

    <?php
        if (isset($_SESSION['enviado'])) { 
    ?>
    <script>
        Swal.fire({
        icon: "success",
        title: "¡Registro exitoso!",
        text: "Bienvenido a la mejor dulcecomunidad",
        width: 600,
        padding: "3em",
        color: "black",
        background: "#fff url(images/trees.png)",
        backdrop: `
            rgba(247,140,162,0.2)
            url("imagenes/Dulces3.gif")
            left top
            no-repeat
            `
        });
    </script>

    <?php
        unset($_SESSION['enviado']);
        }
    ?>

    <div style="height: 150px; overflow: hidden; margin-bottom:-110px;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" 
    style="height: 100%; width: 100%;">
    <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" 
    style="stroke: none; fill: #3d0c11"></path></svg></div>
    <footer>
        <div class="mt-5 pt-5 pb-5 footer">
            <div class="container">
              <div class="row">
                <div class="col-lg-5 col-xs-12 about-company">
                <img src="imagenes/LogoCC.png" alt="CandyCraze" style="margin-bottom:10px;width:100px;">
                  <h2>Candy Craze</h2>
                  <p class="pr-5 text-white-50">Embárcate en un viaje de sabores exquisitos en nuestra dulcería internacional, donde cada bocado es una ventana abierta a la deliciosa diversidad de dulces de todo el mundo.</p>
                  <p>
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com/candycraze2023?igshid=OGQ5ZDc2ODk2ZA%3D%3D&utm_source=qr" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                </p>
                </div>
                <div class="col-lg-2 col-xs-12 links">
                  <h3 class="mt-lg-0 mt-sm-3">Links</h3>
                    <ul class="m-0 p-0">
                      <li><a href="index.php">Inicio</a></li>
                      <li><a href="productos.php">Productos</a></li>
                      <li><a href="acerca.php">Acerca de</a></li>
                      <li><a href="contacto.php">Contáctanos</a></li>
                      <li><a href="ayuda.php">Ayuda</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-xs-12 location">
                  <h3 class="mt-lg-0 mt-sm-4">Ubicación</h3>
                  <p class="pr-5 text-white-50">Av. Universidad # 940, Ciudad Universitaria, C.P. 20100, Aguascalientes, Ags. México.</p>
                  <p class="mb-0"><i class="fa fa-phone mr-3"></i>(541) 754-3010</p>
                  <p><i class="fa fa-envelope-o mr-3"></i>candycraze511@gmail.com</p>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col copyright">
                    <p class=""><small class="text-white-50">© Candy Craze 2023. Todos los derechos reservados. <br>Esta página constituye un proyecto académico.</small></p>
                </div>
                <?php 
                    date_default_timezone_set('America/Mexico_City'); // Establecer la zona horaria de México
                    $ultimaActualizacion = filemtime("../"); // Obtener la última actualización 
                    setlocale(LC_TIME, 'es_VE.UTF-8','esp'); // Establecer el locale a español para strftime
                    $fechaFormateada = strftime('%e de %B del %Y', $ultimaActualizacion); // Formatear la fecha
                    $fechaFormateada = mb_convert_case($fechaFormateada, MB_CASE_TITLE, 'UTF-8'); // Convertir la primera letra de cada palabra en mayúscula
                    $horaActual = date('h:i A');
                    // Mostrar la fecha formateada
                    echo '<p class="" style="text-align:center;"><small class="text-white-50">Última actualización: ' . $fechaFormateada . ' a las ' . $horaActual . ' (Hora de México)</small></p>';
                    
                ?>
              </div>
            </div>
        </div>            
    </footer>
</body>

</html>

<?php 
    if(isset($_SESSION['logout'])){
        ?>
        <script>
            Swal.fire({
            icon: "success",
            title: "Abandonarás tu sesión",
            text: "¡Has cerrado sesión de tu cuenta!",
            })
        </script>
        <?php 
        unset($_SESSION['logout']);
        unset($_SESSION['captcha']);
        unset($_SESSION['intentos']);
    }
?>