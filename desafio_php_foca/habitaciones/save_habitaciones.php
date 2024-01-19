<?php
session_start();
include("../db.php");


// Verificar si el usuario está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: ../index.php");
    exit();
}
// Verificar el rol del usuario
if ($_SESSION['rol_id'] != 1) {
    // El usuario no tiene el rol de administrador, redirigir a una página de error o a una página adecuada para su rol.
    header("Location: ../error.php");
    exit();
}

    $numero = $_POST['numero'];
    $descripcion = $_POST['descripcion'];
    if(isset($_POST['save_habitaciones'])){
        $query = "insert into habitaciones(numero, descripcion, estado) VALUES('$numero', '$descripcion', 1) ";
        mysqli_query($conn, $query);

        if($query){
            header("location: ../admin.php");
            exit;
        }
        else{
            echo "<h1>Error al registrar habitacion.</h1>";
        }
    }

?>