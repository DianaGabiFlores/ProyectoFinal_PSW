<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="astyle.css"> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        #tituloP, .selector, .botonP, legend{
            margin-left: 10px;
        }
        .selector{
            max-height: 500px;
            overflow-y: auto;
        }
        .contenido .tablaP td, .contenido .tablaP th{
            padding-left: 30px;
        }
        .tablaP{
            max-height: 400px;
            overflow-y: auto;
        }
        .botonP{
            background: rgb(31, 40, 57);
            border-color: whitesmoke;
        }
        .botonP:hover{
            background: darkgrey;
            border-color: whitesmoke;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-nowrap">
        <?php include "../panel.html"; ?>
        <script>
            document.getElementById("bajas").style.backgroundColor= "#D8006C";
        </script>
        <div class="d-flex flex-column contenido">
            <div>
                <h1 id="tituloP">Bajas de productos</h1>
                <?php
            
                $servidor='localhost:33065';
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

                        //hacemos cadena con la sentencia mysql para eliminar
                        $sql = "DELETE FROM productos WHERE IdProducto='$eliminar'"; //cambiar a id
                        $conexion->query($sql);
                        if($conexion->affected_rows >= 1){
                            // echo '<br>Registro borrado <br>';
                            ?>
                            <script>
                                swal("Bien!","Producto eliminado correctamente!","success");
                            </script>
                            <?php    
                        }else{
                            ?>
                            <script>
                                swal("Error!","No se pudo eliminar el producto!","error");
                            </script>
                            <?php
                        }
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
                                    echo '<option value="' .$fila["IdProducto"].'">'.$fila["nombre"].'</option>'; //aquí poner el id del producto------------------------
                                }
                                ?>
                            </select>
                            <br>
                            <button type="submit" value="submit" name="submit" class="btn btn-primary botonP">Eliminar</button>
                        </form>
                        <br>
                        </div>
                    <?php
                    }
                    //continaumos con la consulta de datos a la tabla usuarios
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
                                    echo '<th scope="col">Imagen</th>';
                                echo '</tr>';
                                while( $fila = $resultado -> fetch_assoc()){ //recorremos los registros obtenidos de la tabla
                                    echo '<tr>';
                                        echo '<td>'. $fila['IdProducto'] . '</td>';
                                        echo '<td>'. $fila['nombre'] . '</td>';
                                        echo '<td>'. $fila['descripcion'] . '</td>';
                                        echo '<td>'. $fila['existencias'] . '</td>';
                                        echo '<td>'. $fila['precio'] . '</td>';
                                        $url = $fila['imagen'];
                                        echo '<td>';
                                        echo "<img src='$url' alt='' style='max-height: 100px;'>";
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