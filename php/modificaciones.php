
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../css/style_altas_mod.css">
<link rel="icon" type="image/png" href="../imagenes/Icon2.png" />
<script src="https://kit.fontawesome.com/d60c975bf8.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<title>Modificaciones | CandyCraze</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../js/modificaciones.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


</head>
<body>
    <div class="d-flex flex-nowrap">
        <?php include "../html/panel.html"; ?>
        <script>
            document.getElementById("modificaciones-op").style.backgroundColor= "#D8006C";
        </script>
        <div class="d-flex flex-column contenido">
            <h2>Modificar productos</h2>
            <?php
                $servidor = 'localhost:3307';
                $cuenta = 'root';
                $password = '';
                $bd = 'store';
                
                //conexión a la base de datos
                $conexion = new mysqli($servidor, $cuenta, $password, $bd);
                
                if($conexion -> connect_errno){
                    die('Error en la conexión');
                }else{
                    if(isset($_POST['nombre']) ){                        
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion'];
                        $existencias = $_POST['existencias'];
                        $precio = $_POST['precio'];
                        $descuento = $_POST['descuento'];
                        $id = $_POST['idProducto'];
                        $categoria = $_POST['categoria'];
                        
                        $etiquetas = json_decode($_POST['etiquetas'],true);  

                        //--------------------IMAGEN-----------------------------------------------
                        $targetFile="";
                        if(isset($_FILES["file"]) && !(empty($_FILES["file"]["tmp_name"]))){
                            $targetDir = "../uploads/";  // Directorio donde se guardarán las imágenes
                            $targetFile = $targetDir . basename($_FILES["file"]["name"]);
                    
                            // Verificar si el archivo es una imagen real
                            $check = getimagesize($_FILES["file"]["tmp_name"]);
                            if ($check !== false) {
                                if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                                    echo "Hubo un problema al subir el archivo.";
                                }
                            } else { ?>
                    
                                <div class="alert alert-warning" role="alert">
                                    <strong>El archivo </strong> no es una imagen válida.
                                </div>
                    
                            <?php
                            }
                        }
                        //--------------------------------------------------------------------------
                        if($targetFile != ""){
                            $ne = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', existencias=$existencias, precio=$precio, imagen='$targetFile', descuento=$descuento, categoria ='$categoria' WHERE idProducto='$id';";
                        }else{
                            $ne = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', existencias=$existencias, precio=$precio, descuento=$descuento, categoria ='$categoria' WHERE idProducto='$id';";
                        }
                        
                        $fin = $conexion -> query($ne);

                        $sql_et = "DELETE FROM etiquetasproductos WHERE idProducto='$id'";
                        $fin = $conexion->query($sql_et);

                        foreach ($etiquetas as $valor) {
                            $buscar_et = "SELECT * FROM etiquetas WHERE etiqueta='$valor'";
                            $resultado_etiqueta = $conexion->query($buscar_et);

                            if ($resultado_etiqueta->num_rows > 0) {
                                // Si la etiqueta existe, obtenemos su ID
                                $registro_etiqueta = $resultado_etiqueta->fetch_assoc();
                                $idEtiqueta = $registro_etiqueta['idEtiqueta'];
                            } else {
                                // Si la etiqueta no existe, la insertamos y obtenemos su ID
                                $sql_insert_etiqueta = "INSERT INTO etiquetas (etiqueta) VALUES ('$valor')";
                                $conexion->query($sql_insert_etiqueta);
                                $idEtiqueta = $conexion->insert_id; // Obtener el ID de la etiqueta recién insertada
                            }

                            // Insertamos la relación entre el producto y la etiqueta
                            $sql_insert_relacion = "INSERT INTO etiquetasproductos VALUES ('$id', '$idEtiqueta')";
                            $conexion->query($sql_insert_relacion);
                        }

                        

                    }
                    
                
            ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <form action="" id="formulario-datos"  enctype="multipart/form-data">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar producto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body contenedor-grid">
                                <div class="form-floating mb-3 col-3 idProducto">
                                    <input type="number" class="form-control" id="idProducto" placeholder="Id del producto" name="idProducto" readonly  required>
                                    <label for="idProducto">Id del Producto</label>
                                </div>
                                <div class="form-floating mb-3 col-9 nombre">
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre del producto" name="nombre" required>
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="form-floating mb-3 col-12 descripcion">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="descripcion" style="height: 100px" name="descripcion" required></textarea>
                                    <label for="descripcion">Descripción</label>   
                                </div>
                                <div class="form-floating mb-3 col-4 existencias">
                                    <input type="number" class="form-control" id="existencias" placeholder="Existencias" name="existencias" required>
                                    <label for="existencias">Existencias</label>
                                </div>
                                <div class="input-group mb-3 input-simbolo precio">
                                    <span class="input-group-text">$</span>
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="precio" placeholder="Username" name="precio" required>
                                        <label for="precio">Precio</label>
                                        <div id="simbolo">MXN</div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3 col-4 input-simbolo descuento">
                                    <input type="number" class="form-control" id="descuento" placeholder="Descuento" name="descuento" required>
                                    <label for="descuento">Descuento</label>
                                    <div id="simbolo">%</div>
                                </div>
                                <div class="image-file">
                                    <!-- <p id="label-imagen">Imagen del producto:</p> -->
                                    <label for="file">Imagen del producto:</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="file" name="file" accept="image/*" onchange="mostrarImagen(event)">
                                        <label class="input-group-text" for="file">Upload</label>
                                    </div>
                                </div>
                                        
                                <div class="imagen d-flex justify-content-center align-items-center" style="text-align:center;">
                                    <img id="imagen" src="" alt="Vista previa de la imagen" style="display:none;" />
                                </div>                        
                                
                                <!-- Aqui va el código que faltaba ----------------------------------------------------- -->
                                <div class="etiquetas-grid">
                                    <div class="input-group mb-3" id="etiquetasForm">
                                        <input type="text" id="etiquetaInput" class="form-control" placeholder="Agregar etiquetas" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary btn-etiqueta" onclick="agregarEtiqueta()" type="button" id="button-addon2">Agregar</button>
                                    </div>
                                    
                                    <div id="container-etiquetas">
                                        <!-- Aquí se mostrarían las etiquetas -->
                                    </div>
                                </div>
                                <!-- ---------------------------------------------------------------........................ -->
                                <div class="categorias-grid">
                                    <div id="label-categoria">
                                        Categoría:
                                    </div>
                                    <div id="container-categoria">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categoria" value="México" id="mexico" required>
                                            <label class="form-check-label" for="mexico">
                                                México
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categoria" value="Japón" id="japon" required>
                                            <label class="form-check-label" for="japon">
                                                Japón
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categoria" value="Corea" id="corea" required>
                                            <label class="form-check-label" for="corea">
                                                Corea
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                                    
                                <!-- ---------------------------------------------------------------------------------------- -->
                                
                            </div>
                            <div class="modal-footer">
                                <button style="background-color:#D8006C; border-radius:5px; color:white; border:none; padding:7px" type="submit" name="modProducto" id="modProducto">Guardar cambios</button>
                            </div>
                        </div>
                    </form>    
                </div>
            </div>
            

            <!-- Aqui va el código que corté ----------------------------------------------------- -->
            <?php
                $salida="<tr class='sticky-top'><th>Id</th><th>Nombre</th><th>Descripción</th><th>Existencias</th><th>Precio</th><th>Descuento</th><th>Categoría</th><th>Etiquetas</th><th>Imagen</th><th>&nbsp;</th></tr>";
                $sql = 'select * from productos';//hacemos cadena con la sentencia mysql que consulta todo el contenido de la tabla
                $resultado = $conexion -> query($sql); //aplicamos sentencia
                
                if ($resultado -> num_rows){ //si la consulta genera registros
                    
                    while( $fila = $resultado -> fetch_assoc() ){ //recorremos los registros obtenidos de la tabla
                        //proceso de concatenacion de datos
                        $salida.= '<tr>';
                        $salida.= '<td>'. $fila['idProducto'] . '</td>';
                        $salida.= '<td>'. $fila['nombre'] . '</td>';
                        $salida.= '<td>'. $fila['descripcion'] . '</td>';
                        $salida.= '<td>'. $fila['existencias'] . '</td>';
                        $salida.= '<td>$'. $fila['precio'] . '</td>';
                        $salida.= '<td>'. $fila['descuento'] . '%</td>';
                        $salida.= '<td>'. $fila['categoria'] . '</td>';
                        
                        
                        //-------------------------------------------

                        // Obtener etiquetas asociadas al producto actual
                        $idProductoActual = $fila['idProducto'];
                        $sqlEtiquetas = "SELECT etiquetas.etiqueta 
                                        FROM etiquetas 
                                        INNER JOIN etiquetasproductos 
                                        ON etiquetas.idEtiqueta = etiquetasproductos.idEtiqueta 
                                        WHERE etiquetasproductos.idProducto = $idProductoActual";

                        $resultadoEtiquetas = $conexion->query($sqlEtiquetas);

                        if ($resultadoEtiquetas->num_rows > 0) {
                            $etiquetasProducto = '';
                            while ($filaEtiqueta = $resultadoEtiquetas->fetch_assoc()) {
                                $etiquetasProducto .= $filaEtiqueta['etiqueta'] . ', ';
                            }
                            // Quitar la última coma y espacio
                            $etiquetasProducto = rtrim($etiquetasProducto, ', ');
                        } else {
                            $etiquetasProducto = ''; // Mensaje si el producto no tiene etiquetas asociadas
                        }

                        $salida .= '<td>' . $etiquetasProducto . '</td>';
                        $salida.= '<td><img src="' .$fila['imagen'] .'" alt="X" class="img-chica"></td>';
                        $etiquetasArray = explode(", ", $etiquetasProducto);
                        $salida .= '<td><button type="button" boton-mod class="btn boton-mod" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="modifyRow(' . htmlspecialchars(json_encode($fila), ENT_QUOTES, 'UTF-8') . ',' . htmlspecialchars(json_encode($etiquetasArray), ENT_QUOTES, 'UTF-8') . ')">Modificar</button></td>';
                        
                        $salida.= '</tr>';
                    }//fin while   
                }

                
            ?>

            
            
            <div id="tabla-productos-mod">
                <table class="table table-striped table-hover" >
                    <?php echo $salida ?>
                </table>
            </div>
            
            <?php
            // include "verificarImagen.php";
                }
            ?>
        </div>
    </div>
    
</body>