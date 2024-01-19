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

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $query = "select * from habitaciones where id='$id'";
        $resultado = mysqli_query($conn, $query);
        $filas = mysqli_fetch_array($resultado);
        
        if($filas['estado']){
            $query = "update habitaciones set estado=0 where id='$id'";
            mysqli_query($conn,$query);
            header("location: ../admin.php");
            exit;
        }
        else{
            $query = "update habitaciones set estado=1 where id='$id'";
            mysqli_query($conn,$query);
            header("location: ../admin.php");
            exit;
        }

    }
?>