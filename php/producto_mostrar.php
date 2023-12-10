
<?php 
    $categorias = array("México", "Japón", "Corea");
    $cat = $_GET['cat'];
    $max = $_GET['max'];
    $cate = $_GET['cate'];

    function totalDatos($conexion, $categorias, $num, $max, $cate){
        //SELECT COUNT(IdProducto) AS Total FROM productos where (precio *((100-descuento)/100)) >= 100;
        if($num == 3){
            $sql = "SELECT *FROM productos;";
        }else {
            //categoria
            $sql = "SELECT *FROM productos WHERE Categoria= '$categorias[$num]';";
        }
        $resultado = $conexion -> query($sql); 
        $i = -1; 
        while( $fila = $resultado -> fetch_assoc() ){
            $flag = true; $desplegar= false; 
            $PrecioD=$fila['precio'] * ((100-$fila['descuento'])/100);

            $etiqueta = "SELECT *FROM etiquetasproductos WHere idProducto=".$fila['idProducto'].";";
            $resultado_eti = $conexion -> query($etiqueta); 
            while( $eti_nombre = $resultado_eti -> fetch_assoc() ){
                $etiqueta_id = $eti_nombre['idEtiqueta'];
            }
            if($max == 0 && $cate == 5){ 
                $desplegar = true; $i = $i + 1;
            }else if($PrecioD <= $max && $cate == 5){ 
                $desplegar = true; $i = $i + 1;
            }else if($PrecioD <= $max && $cate == $etiqueta_id){
                $desplegar = true; $i = $i + 1;
            }
        }    
        return $i;
    }

    function datos($conexion, $categorias, $num, $max, $cate){
        if($num == 3){
            $sql = "SELECT *FROM productos;";
        }else {
            //categoria
            $sql = "SELECT *FROM productos WHERE Categoria= '$categorias[$num]';";
        }
        $resultado = $conexion -> query($sql); 
        $i = -1; 
        while( $fila = $resultado -> fetch_assoc() ){
            $flag = true; $desplegar= false; 
            $PrecioD=$fila['precio'] * ((100-$fila['descuento'])/100);

            $etiqueta = "SELECT *FROM etiquetasproductos WHere idProducto=".$fila['idProducto'].";";
            $resultado_eti = $conexion -> query($etiqueta); 
            while( $eti_nombre = $resultado_eti -> fetch_assoc() ){
                $etiqueta_id = $eti_nombre['idEtiqueta'];
            }
            if($max == 0 && $cate == 5){ 
                $desplegar = true; $i = $i + 1;
            }else if($PrecioD <= $max && $cate == 5){ 
                $desplegar = true; $i = $i + 1;
            }else if($PrecioD <= $max && $cate == $etiqueta_id){
                $desplegar = true; $i = $i + 1;
            }
            if($desplegar == true){
            ?>
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
            <?php //$i = $i + 1 ?>
        </div>
        <?php }
        } 
    }

    $servidor='localhost:3307';
    $cuenta='root';
    $password='';
    $bd='store';
    
    //conexion a la base de datos
    $conexion = new mysqli($servidor,$cuenta,$password,$bd);

    if ($conexion->connect_errno){
        die('Error en la conexion');
    }
?>


<div class="encontrados">
    <p>Productos encontrados: <?php echo totalDatos($conexion, $categorias, $cat, $max, $cate)+1 ?></p>
</div>
<div class="Div_Productos">
    <?php 
    datos($conexion, $categorias, $cat, $max, $cate) ?>
</div>
