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

    if(isset($_GET['id_reserva'])){
        $id_reserva = $_GET['id_reserva'];
        $query = "DELETE FROM reservas WHERE id = ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<h1>Reserva eliminada correctamente.</h1>";
        } else {
            echo "<h1>No se pudo eliminar la reserva.</h1>";
        }

        $stmt->close();
    }
    else {
        echo "ID de reserva no proporcionado en la URL.";
    }


?>