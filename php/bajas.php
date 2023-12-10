<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style_bajas.css">
    <link rel="icon" type="image/png" href="../imagenes/Icon2.png" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Bajas | CandyCraze</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="d-flex flex-nowrap">
        <?php include "../html/panel.html"; ?>
        <script>
            document.getElementById("bajas").style.backgroundColor= "#D8006C";
        </script>
        <div class="d-flex flex-column contenido">
            <div>
                <h1 id="tituloP">Bajas de productos</h1>
                <?php
            
                $servidor='localhost:3307';
                $cuenta='root';
                $password='';
                $bd='store';
            
                //conexion a la base de datos
                $conexion = new mysqli($servidor,$cuenta,$password,$bd);

                if ($conexion->connect_errno){
                    die('Error en la conexion');
                }else{
                    //conexion exitosa
                    if(isset($_POST['submit'])){
                        
                        //obtenemos datos del formulario
                        $eliminar = $_POST['eliminar'];

                        //hacemos cadena con la sentencia mysql para sacar info del eliminado
                        $sql1 = "SELECT * FROM productos WHERE idProducto='$eliminar'";

                        // Ejecutar la consulta
                        $result = $conexion->query($sql1);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $id = $row['idProducto'];
                                $nombre = $row['nombre'];
                                $descripcion = $row['descripcion'];
                                $existencias = $row['existencias'];
                                $precio = $row['precio'];
                                $categoria = $row['categoria'];
                                $url = $row['imagen'];
                            }
                        }

                        //hacemos cadena con la sentencia mysql para eliminar
                        $sql = "DELETE FROM productos WHERE idProducto='$eliminar'"; //cambiar a id
                        $conexion->query($sql);
                        if($conexion->affected_rows >= 1){
                            // echo '<br>Registro borrado <br>';
                            ?>
                            <!-- <script>
                                swal("Bien!","Producto eliminado correctamente!","success");
                            </script> -->
                            <?php
                        }else{
                            ?>
                            <script>
                                swal("Error!","No se pudo eliminar el producto!","error");
                            </script>
                            <?php
                        }

                        ?>
                        <!-- Cuando se de click al botón se muestra el modal -->
                        <script>
                            $(document).ready(function(){
                                $('#staticBackdrop').modal('show');
                            });
                        </script>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header colorHeader">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirmar Eliminación</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="fw-bold">Nombre del producto:</label>
                                            <p><?php echo $nombre ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">ID:</label>
                                            <p><?php echo $id ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Descripción:</label>
                                            <p><?php echo $descripcion ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Precio:</label>
                                            <p><?php echo $precio ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Categoría:</label>
                                            <p><?php echo $categoria ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Imagen:</label>
                                            <img src="<?php echo $url ?>" alt="imagen" style="max-height: 100px;" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" style="background-color:#D8006C; border-radius:5px; color:white; border:none; padding:7px" id="bot1" data-bs-dismiss="modal">Confirmar Eliminación</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        $(document).ready(function(){
                            $('#bot1').click(function(){
                                swal("Bien!","Producto eliminado correctamente!","success");
                            });
                        });
                        </script>

                        <?php
                    }
                    
                    $sql = 'select *from productos'; //hacemos cadena con la sentencia mysql
                    //que consulta todo el contenido de la tabla
                    $resultado = $conexion -> query($sql); //aplicamos sentencia

                    if($resultado -> num_rows){ //si la consulta genera registros?>
                        <div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <legend>Seleccione un producto a eliminar</legend>
                            <br>
                            <select class="browser-default custom-select form-select selector" name="eliminar">
                            <?php
                                while($fila = $resultado -> fetch_assoc()){ //reconoce los registros obtenidos de la tabla
                                    echo '<option value="' .$fila["idProducto"].'">'.$fila["nombre"].'</option>'; //aquí poner el id del producto------------------------
                                }
                                ?>
                            </select>
                            <br>
                            <button type="submit" value="submit" name="submit" class="botonP" style="background-color:#D8006C; border-radius:5px; color:white; border:none; padding:7px">Eliminar</button>
                        </form>
                        <br>
                        </div>
                    <?php
                    }
                    //vemos datos en un tabla de html
                    $sql = 'select * from productos';//hacemos cadena con la sentencia mysql que consulta todo el contenido de la tabla
                    $resultado = $conexion -> query($sql); //aplicamos sentencia

                    if ($resultado -> num_rows){ //si la consulta genera registros
                        echo '<div class="container tablaP">';
                            echo '<table class="table table-hover">';
                                echo '<tr class="table-secondary">';
                                    echo '<th scope="col">Id</th>';
                                    echo '<th scope="col">Nombre</th>';
                                    echo '<th scope="col">Descripción</th>';
                                    echo '<th scope="col">Existencias</th>';
                                    echo '<th scope="col">Precio</th>';
                                    echo '<th scope="col">Categoría</th>';
                                    echo '<th scope="col">Imagen</th>';
                                echo '</tr>';
                                while( $fila = $resultado -> fetch_assoc()){ //recorremos los registros obtenidos de la tabla
                                    echo '<tr>';
                                        echo '<td>'. $fila['idProducto'] . '</td>';
                                        echo '<td>'. $fila['nombre'] . '</td>';
                                        echo '<td>'. $fila['descripcion'] . '</td>';
                                        echo '<td>'. $fila['existencias'] . '</td>';
                                        echo '<td>'. $fila['precio'] . '</td>';
                                        echo '<td>'. $fila['categoria'] . '</td>';
                                        $url = $fila['imagen'];
                                        echo '<td>';
                                        echo "<img src='$url' alt='imagen' style='max-height: 100px;'>";
                                        echo '</td>';
                                    echo '</tr>';
                                }   
                            echo '</table>';
                        echo '</div>';
                    }else{
                        echo "<br><div class='alert alert-primary' role='alert'>";
                            echo "No se encontraron productos";
                        echo "</div>";
                    }
                }//fin
                ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>