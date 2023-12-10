<!-- Captcha in not the same -->
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php 
    // El captcha es incorrecto
    session_start();
    // unset($_SESSION["usuario"]);
    if(isset($_SESSION['Bloqueada']) && isset($_SESSION['mal'])){
        unset($_SESSION['mal']); 
    }
    if(isset($_SESSION['Equal'])){
        ?>
        <script>
            Swal.fire({
            icon: "error",
            title: "¡Oh no!",
            text: "¡El captcha es incorrecto!",
            })          
        </script>
        <?php
        unset($_SESSION['Equal']);
        unset($_SESSION['captcha']);
    }
    // Ha ingresado el usuario a su cuenta
    if(isset($_SESSION['in'])){
        ?>
        <script>
            Swal.fire({
            icon: "success",
            title: "¡Felicidades!",
            text: "¡Haz ingresado a tu cuenta <?php echo $_SESSION['usuario']; ?>!",
            background: "#fff url(../images/trees.png)",
            backdrop: `
            rgba(247,140,162,0.2)
            url("../imagenes/Dulces3.gif")
            left top
            no-repeat
            `
            <?php 
            // echo $SESSION['usuario']; 
            ?>
            }).then((result) => {
            if (result.isConfirmed) {
                location. assign('../index.php')
            }});
        </script>
        <?php 
        unset($_SESSION['in']);
        unset($_SESSION['captcha']);
        unset($_SESSION["intentos"]);
        unlink("../archivos/strikes.txt");               
    }
    if(isset($_SESSION['intentos'])){
        ?>
        <script>
            document.getElementById("preg").style.display = "block";
            document.getElementById("pass").placeholder='Nueva Contraseña';
            document.getElementById("pregunta_extra").required = true;
            document.getElementById("user").removeAttribute('required');
            document.getElementById("user").style.display = "none";
            document.getElementById("usericon").style.display = "none";
            document.getElementById("repetidacontra").style.display = "flex";
            document.getElementById("passrepetir").required = true;
            document.getElementById("contratext").style.display = "block";
        </script>
        <?php
    }
    if(isset($_SESSION['error'])){
        ?>
        <script>
            Swal.fire({
            icon: "error",
            title: "¡Oh no!",
            text: "¡Tu cuenta ha sido eliminada!",
            })          
        </script>
        <?php
        unset($_SESSION['error']);
        unset($_SESSION['captcha']);
        unset($_SESSION['intentos']);
    }
    if(isset($_SESSION['Bloqueada'])){
        ?>
        <script>
            Swal.fire({
            icon: "error",
            title: "¡Oh no!",
            text: "¡Tu cuenta ha sido bloqueada!",
            })          
        </script>
        <?php
        unset($_SESSION['error']);
        unset($_SESSION['captcha']);
        unset($_SESSION['intentos']);
        unset($_SESSION['Bloqueada']);
    }

    if(isset($_SESSION['mal'])){
        ?>
        <script>
            Swal.fire({
            icon: "error",
            title: "Los datos no son correctos",
            text: "Vuelve a introducirlos.",
            })          
        </script>
        <?php
        unset($_SESSION['mal']);
    }
?>

