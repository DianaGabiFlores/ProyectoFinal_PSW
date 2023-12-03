<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
session_start();
if(isset($_SESSION['repetido'])){
    ?><script>
        swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: "Usuario en uso.",
        });
    </script><?php
}elseif(isset($_SESSION['insertar'])){
    ?><script>
        swal.fire({
            icon: "success",
            title: "Usuario creado",
        }).then((result) => {
            if (result.isConfirmed) {
                location. assign('../index.php')
            }});
    </script><?php
}elseif(isset($_SESSION['cont'])){
    ?><script>
        swal.fire({
            icon: "question",
            title: "Lo sentimos",
            text: "Las contraseñas no coinciden.",
        });
    </script><?php
}
unset($_SESSION['cont']);
unset($_SESSION['repetido']);
unset($_SESSION['insertar']);
?>