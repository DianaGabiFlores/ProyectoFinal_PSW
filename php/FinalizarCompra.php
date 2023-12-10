<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/FinalizarCompraStyles.css">
    <link rel="icon" type="image/png" href="../imagenes/Icon2.png" />
    <script src="https://kit.fontawesome.com/24d265bea9.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>Finalizar Compra</title>
</head>

<body>
    <header>

        <?php
        include("menu.php");
        ?>
        <script>
            document.getElementsByClassName("animate__animated animate__fadeInDown")[0].innerHTML = "— Finalizar Compra —";
            document.getElementsByClassName("animate__animated animate__fadeInUp")[0].innerHTML = "Una forma fácil de consumir tus dulces favoritos";
        </script>


        <?php
        $usuario = $_SESSION['usuario'];
        $precioTotal = $_POST['total'];
        echo "<script>var precioTotal = '$precioTotal';</script>";
        $_SESSION['Productos'] = $_POST['Productos'];
        $_SESSION['precioTotal'] = $precioTotal;
        $codigo = "";
        function numerorandom()
        {
            $codigo = "";
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $max = strlen($caracteres) - 1;
            for ($i = 0; $i < 10; $i++) {
                $codigo .= $caracteres[mt_rand(0, $max)];
            }
            return $codigo;
        }
        $servidor = 'localhost';
        $cuenta = 'root';
        $password = '';
        $bd = 'Store';

        $conexion = new mysqli($servidor, $cuenta, $password, $bd);

        if ($conexion->connect_errno) {
            die('Error en la conexion');
        } else {
            $Compras = "SELECT COUNT(Usuario) AS veces FROM Ventas WHERE usuario = '$usuario'";
            $resultado = $conexion->query($Compras);
            while ($fila = $resultado->fetch_assoc()) {
                $Compras = $fila["veces"];
            }

            if ($Compras == 0) {
                echo "<script>var ComprasHechas = false;</script>";
            } else {
                echo "<script>var ComprasHechas = true;</script>";
            }
        }

        ?>

        <div class="wave" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
                style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-40.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #FFFFFF"></path>
            </svg></div>


    </header>


    <main class="main">
        <div class="div_main">
            <form action="Pedidos_PDF.php" method="post" class="formFinalizar">
                <div class="header">
                    <ul>
                        <li class="active form_1_progressbar">
                            <div>
                                <p><i class="fa-solid fa-truck-fast fa-beat" style="color: #ffffff;"></i></p>
                            </div>
                        </li>
                        <li class="form_2_progressbar">
                            <div>
                                <p><i class="fa-solid fa-ticket-simple fa-beat" style="color: #ffffff;"></i></p>
                            </div>
                        </li>
                        <li class="form_3_progressbar">
                            <div>
                                <p><i class="fa-solid fa-money-check fa-beat" style="color: #ffffff;"></i></p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="formulario_envio" id="form1">
                    <h2>Formulario de Envío</h2>
                    <div class="linea"></div>
                    
                    <label for="Nombre_Completo">Nombre Completo</label>
                    <label for="Correo">Correo Electrónico</label>
                    <input type="text" name="Nombre_Completo" id="Nombre_Completo" placeholder="Nombre Completo"
                        required>
                    <input type="email" name="Correo" id="Correo" placeholder="Correo Electrónico" required>
                    <label for="Direccion">Dirección</label>
                    <label for="CodigoPostal">Código Postal</label>
                    <input type="text" name="Direccion" id="Direccion" placeholder="Indica tu Dirección" required>
                    <input type="number" name="CodigoPostal" id="CodigoPostal" placeholder="Ingresa los 5 dígitos"
                        min="0" max="100000" required>
                    <label for="Pais">País</label>
                    <label for="Ciudad">Ciudad</label>
                    <select name="Pais" id="Pais" required>
                        <option value="México">México</option>
                        <option value="Estados Unidos">Estados Unidos</option>
                        <option value="Internacional">Internacional</option>
                    </select>
                    <input type="text" name="Ciudad" id="Ciudad" placeholder="Ciudad" required>
                    <label for="NumeroTelefonico">Número Telefónico</label>
                    <br>
                    <input type="number" name="NumeroTelefonico" id="NumeroTelefonico" placeholder="Ingresa los 10 dígitos" min="0" max="1000000000" required>
                    <button type="button" class="editar" id="editar">Editar</button>
                    <div class="bth-box">
                        <button type="button" class="next" id="Next1">Siguiente</button>
                    </div>
                </div>

                <div class="div_TotalDeCompra" id="form2">
                    <h2>Total de la Compra</h2>
                    <div class="linea"></div>
                    <div class="div_cupon">
                        <label for="Cupon" class="block">Cupón</label>
                        <input type="text" id="Cupon" name="Cupon" placeholder="Cupón">
                        <button type="button" class="ValidarCupon" id="ValidarCupon">Validar</button>
                        <small class="block cuponDescuento" id="cuponDescuento"></small>
                    </div>
                    <div class="div_imYgas">
                        <div class="div_impuestos">
                            <label for="Impuestos">Impuestos</label>
                            <p class="paises"></p>
                            <input type="text" id="Impuestos" name="Impuestos" value="10" readOnly>
                        </div>
                        <div class="div_gastosEnvio">
                            <label for="GastosE">Gastos de Envío</label>
                            <p class="paises"></p>
                            <input type="text" id="GastosE" name="GastosE" value="40" readOnly>
                            <small class="block GastoEnvioPorque" id="GastoEnvioPorque"></small>
                        </div>
                    </div>
                    
                    <div class="div_Total">
                        <h2>Total</h2>
                        <div class="linea"></div>
                        <table>
                            <tr>
                                <td>
                                    <p>Precio Total de los Productos</p>
                                </td>
                                <td class="tdPrecio signoPesos">
                                    <p>$</p>
                                </td>
                                <td class="tdPrecio">
                                    <p id="totalAbsoluto"></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Descuento del Cupón</p>
                                </td>
                                <td class="tdPrecio signoPesos">
                                    <p>-$</p>
                                </td>
                                <td class="tdPrecio">
                                    <p id="cuponNeto">0</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Impuestos</p>
                                </td>
                                <td class="tdPrecio signoPesos">
                                    <p>$</p>
                                </td>
                                <td class="tdPrecio">
                                    <p id="impuestoNeto"></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Gastos de Envío</p>
                                </td>
                                <td class="tdPrecio signoPesos">
                                    <p>$</p>
                                </td>
                                <td class="tdPrecio">
                                    <p id="gastosNeto"></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Total</p>
                                </td>
                                <td class="tdPrecio signoPesos totalNeta">
                                    <p>$</p>
                                </td>
                                <td class="tdPrecio totalNeta">
                                    <p id="totalNeta"></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="bth-box">
                        <button type="button" class="back" id="Back1">Retroceder</button>
                        <button type="button" class="next" id="Next2">Siguiente</button>
                    </div>
                </div>

                <div class="Forma_Pago" id="form3">
                    <h2>Forma de Pago</h2>
                    <div class="linea"></div>
                    <section class="bancos">
                        <label class="labelB putborder" id="BBVA1">
                            <input type="radio" name="TipoDePago" id="BBVA" value="BBVA" checked>
                            <img class="BBVA" src="../imagenes/BBVA.png" alt="BBVA">
                        </label>
                        <label class="labelB" id="Santander1">
                            <input type="radio" name="TipoDePago" id="Santander" value="Santander">
                            <img class="Santander" src="../imagenes/Santander.png" alt="Santander">
                        </label>
                        <label class="labelB" id="OXXO1">
                            <input type="radio" name="TipoDePago" id="OXXO" value="OXXO">
                            <img class="OXXO" src="../imagenes/OXXO.png" alt="OXXO">
                        </label>
                    </section>

                    <section class="formBanco">
                        <label class="block" for="Bname">Nombre del titular de tarjeta<input type="text" class="block"
                                name="Bname" id="Bname" placeholder="Ingresa tu nombre completo" required></label>
                        <label class="block" for="Btarjeta">Número de la tarjeta<input type="number" class="block"
                                name="Btarjeta" id="Btarjeta" placeholder="0000 0000 0000 0000" size="16"
                                required></label>
                        <label class="Bfecha" for="Bfecha">Fecha de vencimiento<input type="text" class="block Bfecha"
                                name="Bfecha" id="Bfecha" size="5" placeholder="01/24" required></label>
                        <label class="Bseguridad" for="Bseguridad">Código de seguridad<input type="number"
                                class="block Bseguridad" name="Bseguridad" id="Bseguridad" size="3" placeholder="CVV"
                                required></label>
                    </section>

                    <section class="optionOxxo">
                        <p>
                            Ahora tienes la oportunidad de pagar tus compras en tu OXXO más cercano. Disfruta de esta
                            gran ventaja que tienes en tus manos.
                            Copia el código siguiente y muestráselo al cajero. Y el pago estará hecho.
                        </p>
                        <?php $codigo = numerorandom(); ?>
                        <p class="codigo">
                            <?php echo $codigo; ?>
                        </p>
                        <input type="text" id="codigo" style="display:none" value=<?php echo $codigo; ?>>
                    </section>
                    <div class="bth-box">
                        <button type="button" class="back" id="Back2">Retroceder</button>
                        <button type="submit" class="Enviar" id="Enviar">Finalizar</button>
                    </div>
                </div>

            </form>
        </div>
    </main>
    <?php
    include("footer.php");
    ?>
    <script src="../js/FinalizarCompra.js"></script>
</body>

</html>

<?php
?>