<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php            
    session_start();
    if(isset($_POST["submit"])){
        $cipher = "AES-256-CBC"; 
        $encryption_key = "12345678901234567890123456789012"; 
        $iv = str_repeat("0", openssl_cipher_iv_length($cipher));

        $servidor='localhost:3307';
        $cuenta='root';
        $password='';
        $bd='store';
         
        //conexion a la base de datos
        $conexion = new mysqli($servidor,$cuenta,$password,$bd);
    
        if ($conexion->connect_errno){
             die('Error en la conexion');
        }
        else{
            if(isset($_SESSION['intentos'])){
                $username = $_SESSION['intentos'];
                $password = $_POST['password'];
                $passwordR = $_POST['passwordR'];
            }else{
                $username = $_POST['username'];
                $password = $_POST['password'];
                $password = openssl_encrypt($password, $cipher, $encryption_key, 0, $iv);     
            }
            $captcha = $_POST['captcha'];
            $cookies = false; 
            $usuarioEncontrado = false; 
            $preguntar = true;

            if($_SESSION['captcha'] != $captcha){ 
                $_SESSION['Equal'] = false; 
                $usuarioEncontrado = true; 
            }

            $sql = 'select * from usuarios';//hacemos cadena con la sentencia mysql que consulta todo el contenido de la tabla
            $resultado = $conexion -> query($sql); //aplicamos sentencia
            if ($resultado -> num_rows){ //si la consulta genera registros
                while( $fila = $resultado -> fetch_assoc()){ //recorremos los registros obtenidos de la tabla
                    if($fila['usuario'] === $username && !isset($_SESSION['Equal'])){
                        $usuarioEncontrado = true;
                        if(isset($_SESSION["intentos"])){
                            // echo "Entró a los intentos\n"; 
                            if($fila['seguridad'] != $_POST['pregunta']){
                                $preguntar = false; 
                                break; 
                            }
                            // echo "La pregunta de seguridad es correcta\n"; 
                            // echo "La primera es: ".$password." La segunda es: ".$passwordR;
                            if($password != $passwordR){
                                $preguntar = false; 
                                break; 
                            }else{
                                $password = openssl_encrypt($password, $cipher, $encryption_key, 0, $iv);     
                                $sql = "UPDATE Usuarios SET contra='$password' WHERE usuario = '$username'";
                                $conexion->query($sql);
                                if ($conexion->affected_rows >= 1){ 
                                      //   echo "registro insertado" ;
                                }
                            }
                            $_SESSION['usuario'] = $username;
                            $cookies = true;
                            if($fila['administrador'] == 1){
                                $_SESSION['admin'] = true;
                            }
                            $_SESSION['in'] = true; 
                            break;  
                        }
                        if($fila['contra'] === $password){
                            $_SESSION['usuario'] = $username;
                            $cookies = true;
                            if($fila['administrador'] == 1){
                                $_SESSION['admin'] = true;
                            }
                            $_SESSION['in'] = true; 
                            break;  
                        }else{
                            if(isset($_SESSION["intentos"])){
                                $preguntar = false; 
                                break;
                            }
                            $bool = false; 
                            $num = 1; 
                            if(file_exists("../archivos/strikes.txt")){
                                $file = fopen("../archivos/strikes.txt", "r+");
                            }else{
                                $file = fopen("../archivos/strikes.txt", "x+");
                            }
                            $file1 = fopen("../archivos/temporal.txt", "w");
                            while (!feof($file)) {
                                $linea = fgets($file);
                                if ($linea != "") {
                                    $aux = preg_split("/[:]/", $linea);
                                    // echo $aux[0] ." : ". $aux[1]; 
                                    if($aux[0] == $username){
                                        $bool = true; 
                                        $num = $aux[1]; 
                                    }
                                }
                            }
                            if($bool){
                                $num++; 
                                fwrite($file1, $username.":".$num."\r\n"); 
                            }else{
                                unset($_SESSION["intentos"]);
                                fwrite($file1, $username.":1\r\n"); 
                            }
                            fclose($file);
                            fclose($file1);
                            unlink("../archivos/strikes.txt");
                            rename("../archivos/temporal.txt", "../archivos/strikes.txt");
                            chmod("../archivos/strikes.txt", 0777);
                            if($num == 3){
                                $_SESSION["intentos"] = $username;
                                $_SESSION["Bloqueada"] = true;
                            }
                            $_SESSION["mal"] = true;
                            break; 
                        }
                    }
                }   
            }else{
                 echo "no hay datos";
            }
            if(!$preguntar){
                echo $_SESSION['intentos']." estos es";
                $nombre = $_SESSION["intentos"];
                $sql = "DELETE FROM Usuarios WHERE usuario='$nombre';";//hacemos cadena con la sentencia mysql que consulta todo el contenido de la tabla
                $conexion->query($sql);  //aplicamos sentencia que inserta datos en la tabla usuarios de la base de datos
                if ($conexion->affected_rows >= 1){ //revisamos que se inserto un registro
                    unset($_SESSION["intentos"]);
                    unlink("../archivos/strikes.txt");
                    $_SESSION['error'] = true;
                }//fin
            }
            if(!$usuarioEncontrado){
                $_SESSION["mal"] = true;
                unlink("../archivos/strikes.txt");
            }
            if($cookies){
                if(!empty($_POST["remember"])){
                    setcookie("username", $_POST["username"], time()+ 3600);
                    setcookie("password", $_POST["password"], time()+ 3600);
                }else {
                    setcookie("username", "");
                    setcookie("password","");
                }
                header("Location: login.php");

            }
        }
        header("Location: login.php");
    }

?>

