<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../librerias/phpmailer/src/Exception.php';
  require '../librerias/phpmailer/src/PHPMailer.php';
  require '../librerias/phpmailer/src/SMTP.php';


  // $nombre = test_input($_POST["nom"]);
  $email = test_input($_POST['correosub']);
  $subje = "Bienvenido a Candy Craze";
  $imagen = "../imagenes/LogoCorreo.png";
  $mensaje = "
  <div style='text-align:justify;'>

  <div style='text-align:center;'>
  <img src='cid:imagenLogo' alt='' width='150px' height='auto'>
  </div>
  <h3>Estimado/a</h3>
  <p><b>¡Bienvenido a Candy Craze!</b> Tu destino de dulces favorito 🍬</p>
  <p>¡Gracias por unirte a la familia Candy Craze! Nos emociona tenerte como parte de nuestra comunidad de amantes de los dulces. A partir de ahora, estarás al tanto de las últimas novedades, ofertas exclusivas y eventos especiales que solo los miembros de Candy Craze disfrutan.
  Si tienes alguna pregunta o inquietud, nuestro equipo de atención al cliente está aquí para ayudarte. Simplemente responde a este correo electrónico y estaremos encantados de asistirte.</p>

  <p>Gracias nuevamente por unirte a <b>Candy Craze</b>. Estamos ansiosos por endulzar tu vida y hacer que cada bocado sea una experiencia deliciosa.</p>

  <div style='text-align:center;'>
  <img src='cid:imagenPromo' alt='' width='300px' height='auto'>
  </div>

  <p><b>¡Dulces saludos!</b></p>

  <p><b>El equipo de Candy Craze</b><p>
  </div>
  ";

  function test_input($data) {
    $data = trim($data);  //quita espacios en los extremos de la cadena
    $data = stripslashes($data); //elimina barras invertidas
    $data = htmlspecialchars($data);
    return $data;
  }

  if(isset($_POST['submit'])){
      $mail = new PHPMailer(true);
      $mail -> isSMTP();
      $mail -> Host = 'smtp.gmail.com';
      $mail -> SMTPAuth = true;
      $mail -> Username = 'candycraze511@gmail.com';
      $mail -> Password = 'jyyb icpr joso jrwu';
      $mail -> SMTPSecure = 'ssl';
      $mail -> Port = 465;
      $mail -> setFrom('candycraze511@gmail.com', 'Candy Craze');
      $mail -> addAddress($email);
      $mail -> isHTML(true);
      $mail -> Subject = $subje;
      $imagen_path = "../imagenes/Cupon1.png";
      $imagen_path2 = "../imagenes/LogoCorreo2.png";
      $mail->AddEmbeddedImage($imagen_path, 'imagenPromo', 'Cupon1.png');
      $mail->AddEmbeddedImage($imagen_path2, 'imagenLogo', 'LogoCorreo2.png');
      $mail -> Body = $mensaje;
      $mail -> send();

      session_start();
      $_SESSION['enviado'] = true;
      header('Location: ../index.php');
      exit();
  }
  ?>

  <?php
      $servidor='llocalhost:3307';
      $cuenta='root';
      $password='';
      $bd='store';
      
      //conexion a la base de datos
      $conexion = new mysqli($servidor,$cuenta,$password,$bd);

      if ($conexion->connect_errno){
          die('Error en la conexion');
      }

      else{
          //conexion exitosa

          /*revisar si traemos datos a insertar en la bd  dependiendo
          de que el boton de enviar del formulario se le dio clic*/

          if(isset($_POST['submit'])&& !empty($_POST['correosub'])){
                  //obtenemos datos del formulario
            $sub = $_POST['correosub'];
                  
            //hacemos cadena con la sentencia mysql para insertar datos
            $sql = "INSERT INTO usuariossubs (correousu) VALUES('$sub')";
            $conexion->query($sql);  //aplicamos sentencia que inserta datos en la tabla usuarios de la base de datos
          }
      }
?>