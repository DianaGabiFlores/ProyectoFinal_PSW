<?php 

$categorias = array("México", "Japón", "Corea");
function datos($conexion, $categorias, $num){
    if($num == 3){
        $sql = "SELECT *FROM productos;";
    }else {
        $sql = "SELECT *FROM productos WHERE Categoria= '$categorias[$num]';";
    }
    $resultado = $conexion -> query($sql);
    $i = 0;  
    while( $fila = $resultado -> fetch_assoc() ){
        $flag = true; ?>
        <div class="Producto_in">
            <div class="imagen">
                <img src="<?php echo $fila['imagen'] ?>" alt="Producto">
            </div>
            <h5><?php echo $fila['nombre'] ?></h5>
            <p class="Descripcion"><?php echo $fila['descripcion'] ?></p>
            <?php if($fila['descuento'] != 0){
                $PrecioD=$fila['precio'] * ((100-$fila['descuento'])/100); ?>
                <p class="precio">$<?php echo $PrecioD." \t "?><del class="Precio_tachado">$<?php echo $fila['precio'] ?></del></p>
            <?php } else { ?>
                <p class="precio">$<?php echo $fila['precio'] ?></p>
            <?php } ?>
            <hr>
            <?php if($fila['existencias'] == 0){ $flag= false;?>
                <h6 class="Agotado">Producto agotado</h6>
            <?php }else { ?>
                <h6>Existencias: <?php echo $fila['existencias'] ?></h6>
            <?php } 
            ?>
            <h6 style="display:none;" id="exis<?php echo $i ?>" ><?php echo $fila['existencias'] ?></h6>
            <?php if($flag){ ?>
            <div class="seleccion_productos">
                <button class="seleccion_boton" type="submit" value="<?php echo $i ?>" name="Resta">-</button>
                <p id="ProductoCarro<?php echo $i ?>">0</p>
                <button class="seleccion_boton" type="submit" value="<?php echo $i ?>" name="Suma">+</button>
                
            </div>
            <div>
                <form method="post" action="productos.php">
                    <!-- <i class="fa-solid fa-cart-shopping fa-bounce fa-2xl" style="color: #ff3e9e;"></i> -->
                    <input style="display:none;" class="id" type="int" name="id" value="<?php echo $fila['idProducto'] ?>">
                    <input style="display:none;" type="int" name="cantidad" id="cantidad<?php echo $i ?>" value="0">
                    <div class="alinear">
                    <!-- Boton Dinamico -->
                        <button class="button" type="submit" value="<?php echo $i ?>" name="agregar">
                            <span class="button__text">Agregar</span>
                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor"
                                    height="24" fill="none" class="svg">
                                    <line y2="19" y1="5" x2="12" x1="12"></line>
                                    <line y2="12" y1="12" x2="19" x1="5"></line>
                                </svg></span>
                        </button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <button style="display:none;" class="seleccion_boton" type="submit" value="<?php echo $i ?>" name="Resta">-</button>
            <button style="display:none;" class="seleccion_boton" type="submit" value="<?php echo $i ?>" name="Suma">+</button>
        <?php } ?>
        <?php $i = $i + 1 ?>
    </div>
<?php }
}

$servidor = 'localhost:3307';
$cuenta = 'root';
$password = '';
$bd = 'store';

//conexion a la base de datos
$conexion = new mysqli($servidor, $cuenta, $password, $bd);

if($conexion->connect_errno) {
    die('Error en la conexion');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../imagenes/Icon2.png" />

    <title>Productos | Candy Craze</title>

    <!-- Links css -->
    <link rel="stylesheet" href="../css/estilospagp.css">
    <link rel="stylesheet" href="../css/estilotienda.css">
    <link rel="stylesheet" href="../css/styles_Productos.css">

    <!-- Links para funciones externas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300&family=Playball&display=swap"
        rel="stylesheet">

    <!-- Scripts para funciones externas -->
    <script src="https://kit.fontawesome.com/f3a304d792.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Animaciones link -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <header>
        <?php
        include "menu.php";
        ?>
        <script>
            document.getElementsByClassName("animate__animated animate__fadeInDown")[0].innerHTML = "— Productos Candy Craze —";
            document.getElementsByClassName("animate__animated animate__fadeInUp")[0].innerHTML = "Disfruta de nuestra gran variedad de dulces";
        </script>
        <div class="wave" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
                style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-40.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #FFFFFF"></path>
            </svg></div>
    </header>
    
    <section class="preguntasTitle">
        <h3>¡Los mejores dulces están en Candy Craze!</h3>
        <h2>Productos</h2>
        <div class="linea"></div>
        <br>
    </section>
    <!-- Filtro -->
    <div class="radioacomodo">
        <div class="radio-inputs">
            <label class="radio">
                <input type="radio" name="categoria" value="3" checked="">
                <span class="name">Todos</span>
            </label>
            <label class="radio">
                <input type="radio" name="categoria" value="0">
                <span class=" name">México</span>
            </label>
            <label class="radio">
                <input type="radio" name="categoria" value="1">
                <span class="name">Japón</span>
            </label>

            <label class="radio">
                <input type="radio" name="categoria" value="2">
                <span class="name">Corea</span>
            </label>
        </div>
    </div>

    <?php $max = round(precioMax($conexion), 0, PHP_ROUND_HALF_UP); ?>

    <div class="ContenedorFiltro">
        <div class="conteinerRange">
            <span>0</span>
            <div class="slidecontainer">
                <input type="range" min="1" max="<?php echo $max; ?>" value="<?php echo $max; ?>" class="slider" id="myRange">
            </div>
            <span id="valor"></span>
        </div>

        <div class="conteinerSelect">
            <select name="categoria" id="categorias">
                <?php 
                echo Select($conexion); 
                ?>
            </select>
        </div>
        <div class="conteinerboton">
            <button class="filtroPrecio" id="filtro">Filtrar</button>
        </div>
    </div>

    <?php 
        if (isset($_SESSION['usuario']) && !isset($_SESSION['admin'])){?>
            <div id="logeado" style="display:none;">true</div> 
        <?php }else{ ?>
            <div id="logeado" style="display:none;">false</div>
        <?php }
    ?>

    <!-- <hr id="division_Productos"> -->
    <!-- Filtro de precios -->
<!--     <div class="radioacomodo">
        <div class="radio-input">
            <input value="value-1" name="value-radio" id="value-1" type="radio">
            <label for="value-1">$100</label>
            <input value="value-2" name="value-radio" id="value-2" type="radio">
            <label for="value-2">$80</label>
            <input value="value-3" name="value-radio" id="value-3" type="radio">
            <label for="value-3">$60</label>
            <input value="value-4" name="value-radio" id="value-4" type="radio">
            <label for="value-4">$40</label>
            <input value="value-5" name="value-radio" id="value-5" type="radio">
            <label for="value-5">$20</label>
        </div>
    </div> -->


    <div id="Productos_div">
        <div class="Div_Productos">
            <?php datos($conexion, $categorias, 3) ?>
        </div>
    </div>

    <?php
    include("footer.php");
    ?>


    <!-- Funcion de animaciones de scroll -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="../js/AJAX_pro.js"></script>
</body>

</html>

<?php 

if(isset($_POST['agregar'])){
    unset($_POST['agregar']);
    // Si no esta en sesión se redirige al login
    if (!isset($_SESSION['usuario'])){        
        IrLogin();
    //Agrega al carrito    
    }else{
        $User = $_SESSION['usuario'];
        $idPro = $_POST['id'];
        $cantidad = $_POST['cantidad'];
        $flag1 = false;
        //Comprobamos que la cantidad sea diferenta a 0
        if($cantidad != 0){
            $comprobar = "SELECT *FROM Carrito WHERE usuario='$User' AND IdProducto='$idPro';";
            $resultado1 = $conexion -> query($comprobar); 
            //Identificar si el producto ya esta en el carrito
            while( $fila = $resultado1 -> fetch_assoc() ){
                $acomulada = $fila['cantidad'];
                $flag1 = true;
            }
            //Si esta agregado, hay que sumar a la cantidad y comprobar que no exceda las existencias
            if($flag1){
                $acomulada = $acomulada + $cantidad;
                $sql1 = "SELECT existencias FROM productos WHERE idProducto=$idPro";
                $resultado1 = $conexion -> query($sql1);
                while( $fila = $resultado1 -> fetch_assoc() ){ $total = $fila['existencias'];}
                if($acomulada <= $total){
                    $_SESSION['articulos'] = $cantidad;
                    $agregar = "UPDATE Carrito set cantidad='$acomulada' WHERE usuario='$User' AND IdProducto='$idPro';";
                    // $resultado = $conexion -> query($sql);
                }else{
                    $_SESSION['articulos'] = $total - ($acomulada - $cantidad );
                    $agregar = "UPDATE Carrito set cantidad='$total' WHERE usuario='$User' AND IdProducto='$idPro';";
                    // $resultado = $conexion -> query($sql);
                }
            }else{
                $_SESSION['articulos'] = $cantidad;
                $agregar= "INSERT INTO Carrito VALUES('$User', '$idPro', '$cantidad');";
                // $resultado = $conexion -> query($sql); 
            }
            // echo $sql;
            $producto = "SELECT *FROM productos WHERE idProducto=$idPro;";
            $resultado = $conexion -> query($producto);
            while( $fila = $resultado -> fetch_assoc() ){ $_SESSION['imagen'] = $fila['imagen']; $_SESSION['nombre'] = $fila['nombre'];}
            Agregar($agregar);
            $_SESSION['adentro'] = false;
            
            // <script>location. assign('productos.php');</script>
        }
    }
}

function Select($conexion){
    $sql = "Select *from etiquetas;";
    $resultado = $conexion -> query($sql);
    $select = '<option value="5">Todos</option>';
    while( $fila = $resultado -> fetch_assoc()){
        $select.= '<option value="'.$fila['idEtiqueta'].'">'.$fila['etiqueta'].'</option>';
    }
    return $select;
}

function precioMax($conexion){
    $sql = "SELECT MAX(precio *((100-descuento)/100)) AS max FROM productos;";
    $resultado = $conexion -> query($sql);
    while( $fila = $resultado -> fetch_assoc()){ 
        return $fila['max'];
    }
}

function IrLogin(){?>           
    <script>
        Swal.fire({
        title: "¡Lo sentimos!",
        text: "Debes iniciar sesión para agregar productos",
        imageUrl: "../imagenes/iniciar_Sesión.png",
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: "Login"
        }).then((result) => {
        if (result.isConfirmed) {
            location. assign('login.php')
        }});
    </script>
<?php }

function Agregar($agregar){ ?>
    <script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn",
          cancelButton: "btn"
        },
      });
      swalWithBootstrapButtons.fire({
        title: "Producto seleccionado",
        html: "<br><h5>Nombre: <?php echo $_SESSION['nombre'] ?></h5> <br> <h5>Cantidad: <?php echo $_SESSION['articulos'] ?></h5>",
        imageUrl: "<?php echo $_SESSION['imagen'] ?>", 
        imageHeight: 150,
        imageAlt: "Producto",
        showCancelButton: true, 
        confirmButtonColor: "#D8006C",    
        cancelButtonColor: "#3D0C11",          
        confirmButtonText: "Sí, agregar!",
        cancelButtonText: "No agregar",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            var sql = "<?php echo $agregar ?>";

            misdatos="sql="+sql;
            console.log(misdatos);

            var envio = new XMLHttpRequest();        
            envio.open("GET","Funcion_Carrito.php?"+misdatos, true);  
            envio.onreadystatechange=function(){
                if (envio.readyState == 4 && envio.status == 200){
                    location. assign('productos.php');
                }
            }
            envio.send();
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
            location. assign('productos.php');
        }
      });
    </script>  
<?php }

?>