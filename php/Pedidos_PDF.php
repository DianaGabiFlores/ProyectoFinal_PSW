<head>
    <script src="https://kit.fontawesome.com/d60c975bf8.js" crossorigin="anonymous"></script>
    <script>
        function crearPDF() {
            // window.location.href = 'crearPDF.php';
            var newWindow = window.open('reciboPDF.php', '_blank');
            newWindow.focus();
        }
    </script>
    <link rel="stylesheet" href="../css/styleRecibo.css">
</head>
<?php 
    session_start();

    include("menu.php");
     
    //conexion a la base de datos
    $conexion = new mysqli($servidor,$cuenta,$password,$bd);

    if ($conexion->connect_errno){
         die('Error en la conexion');
    }else{
        $usuario = $_SESSION['usuario'];
        $precioTotal = $_SESSION['precioTotal'];
        $sql1 = "SELECT MAX(IdPedido) AS max FROM Ventas";
        $resultado = $conexion -> query($sql1); 
        while( $fila = $resultado -> fetch_assoc()){ 
            $maxIdPedido = $fila['max']+1;
        }
        $sql2 = "INSERT INTO Ventas(IdPedido, Usuario, Total) VALUES('$maxIdPedido','$usuario', '$precioTotal')";
        $resultado = $conexion -> query($sql2); 

        $sql = "SELECT *FROM Carrito WHERE usuario='$usuario';";
        $resultado1 = $conexion -> query($sql); 
        while( $fila = $resultado1 -> fetch_assoc()){ 
            if (in_array($fila['IdProducto'], $_SESSION['Productos'])) { 
                $id = $fila['IdProducto'];
                $cant = $fila['cantidad'];
                $sql3 = "INSERT INTO ProductoVendidos(IdPedido, IdProducto, Cantidad) VALUES('$maxIdPedido','$id', '$cant')";
                // echo $sql3; 
                $conexion->query($sql3);
                $sqll = "DELETE FROM Carrito WHERE usuario='$usuario' AND IdProducto='$id';";
                $conexion->query($sqll); 
                
                $sql5 = "SELECT *FROM productos WHERE idProducto='$id';";
                $resultado2 = $conexion -> query($sql5); 
                while( $fila2 = $resultado2 -> fetch_assoc()){ 
                    $existencias = $fila2['existencias']- $cant;
                    $sql6 = "UPDATE productos SET existencias='$existencias' WHERE Idproducto = '$id'";
                    $resultado3 = $conexion -> query($sql6); 
                }
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $_SESSION['nombreRecibo'] = $_POST['Nombre_Completo'];
            $_SESSION['correoRecibo'] = $_POST['Correo'];
            $_SESSION['direccionRecibo'] = $_POST['Direccion'] . ", C.P. " . $_POST['CodigoPostal'] . ", " . $_POST['Ciudad'] . ", " . $_POST['Pais'] . ".";
            $_SESSION['telRecibo'] = $_POST['NumeroTelefonico'];
            $_SESSION['impuestosRecibo'] = $_POST['Impuestos'];
            $_SESSION['envioRecibo'] = $_POST['GastosE'];
            $_SESSION['tipoPagoRecibo'] = $_POST['TipoDePago'];
            $_SESSION['nombrePagoRecibo'] = $_POST['Bname'];
            $_SESSION['tarjetaRecibo'] = $_POST['Btarjeta'];
            if($_SESSION['tipoPagoRecibo'] != "OXXO"){
                $tarjeta = str_repeat('*', strlen($_SESSION['tarjetaRecibo']) - 4) . substr($_SESSION['tarjetaRecibo'], -4);
            }
            $_SESSION['IdPedido'] = $maxIdPedido;
            $_SESSION['cupon'] = $_POST['cuponValor'];
        }
        
?>
<body>
    <h2 id="titulopag">Recibo de compra</h2>
    <div class="linea"></div>
    <div id="recibo-container">
        <div id="recibo">
            <div id="cliente">
                <h5 class="tituloInfo">Cliente</h5>
                <div class="texto">
                    <?php echo $_SESSION['nombreRecibo'];?> <br>
                    <?php echo $_SESSION['direccionRecibo'];?> <br>
                    <?php echo $_SESSION['telRecibo'];?> <br>
                    <?php echo $_SESSION['correoRecibo'];?> 
                </div>
            </div>
            
            <div id="productos">
                <table id="productosTabla">
                    <tr>
                        <th class="titulosTabla campoProd">Producto</th>
                        <th class="titulosTabla">Cantidad</th>
                        <th class="titulosTabla">Precio</th>
                        <th class="titulosTabla">Total</th>
                    </tr>
                
                    <?php
                        $TOTAL=0;
                        $consulta = "SELECT pv.IdProducto, pv.Cantidad, p.nombre, p.precio, p.descuento FROM productovendidos pv JOIN productos p ON pv.IdProducto = p.idProducto WHERE pv.IdPedido =". $_SESSION['IdPedido'] . ";";
                        $result = $conexion->query($consulta);
                        if ($result->num_rows > 0) {
                            while ($fila = $result->fetch_assoc()) {
                                echo "<tr><td class='registro'>" . $fila['nombre'] . "</td>";
                                echo "<td class='registro'>" . $fila['Cantidad'] . "</td>";
                                $precio = (100-$fila['descuento']) / 100 * $fila['precio'];
                                echo "<td class='registro'>$" . number_format($precio, 2) . "</td>";
                                echo "<td class='registro'>$" . number_format($precio*$fila['Cantidad'], 2) . "</td></tr>";
                                $TOTAL += $precio*$fila["Cantidad"];
                            }
                        }
                    ?>                        
                </table>
            </div>
            <div id="pago-container">
                <div id="pago">
                    <h5 class="tituloInfo">Información de Pago</h5>
                    <div class="texto">
                        <?php 
                            if($_SESSION['tipoPagoRecibo'] != "OXXO"){
                        ?>
                            <table>
                                <tr>
                                    <td class="bold">Banco:</td>
                                    <td><?php echo $_SESSION['tipoPagoRecibo'];?> </td>
                                </tr>
                                <tr>
                                    <td class="bold">Nombre:</td>
                                    <td><?php echo $_SESSION['nombrePagoRecibo'];?></td>
                                </tr>
                                <tr>
                                    <td class="bold">Cuenta:</td>
                                    <td><?php echo $tarjeta;?></td>
                                </tr>
                            </table>
                        <?php
                            }else{
                                echo "Pago en OXXO";
                            }
                        ?>
                    </div>
                </div>
            
                <div id="totales">
                    <table>
                        <tr>
                            <td class="bold">Subtotal:</td>
                            <td class="precio">$<?php echo number_format($TOTAL, 2);?></td>
                        </tr>
                        <tr>
                            <td class="bold">Cupón:</td>
                            <td class="precio">-$ <?php echo number_format($_SESSION['cupon'], 2);?></td>
                        </tr>
                        <tr>
                            <td class="bold">Impuestos:</td>
                            <td class="precio">$ <?php echo number_format($_SESSION['impuestosRecibo'], 2);?></td>
                        </tr>
                        <tr>
                            <td class="bold">Envío:</td>
                            <td class="precio">$ <?php echo number_format($_SESSION['envioRecibo'], 2);?></td>
                        </tr>
                        <tr id="vacio"></tr>
                        <tr>
                            <td colspan="2"  id="total">TOTAL: $<?php echo number_format($TOTAL + $_SESSION['envioRecibo'] + $_SESSION['impuestosRecibo'] - $_SESSION['cupon'], 2);?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="boton-container">
                <button type="button" class="btn" id="abrir" onclick="crearPDF()">
                    <i class="fa-regular fa-file-pdf fa-lg" style="color: #ffffff;"></i>
                    Abrir recibo
                </button>
            </div>
            
        </div>
    </div>
</body>
<?php
    include("correoRecibo.php");
    include("footer.php");
    }
?>
    
    



