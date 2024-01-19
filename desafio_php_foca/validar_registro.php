<?php

include("db.php");
session_start();

// Verificar si se ha enviado el formulario
if (isset($_POST['registrar']) && isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['password'])) {

    // Recoger los datos del formulario
    $nombre = $_POST['usuario'];
    $correo = $_POST['email'];
    $contraseña = $_POST['password'];

    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($contraseña)) {
        include("registro.php");
        echo "<h1>Todos los campos son obligatorios.</h1>";
    } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        include("registro.php");
        echo "<h1>Correo electronico invalido.</h1>";
        
    } else {
        $query = "INSERT INTO usuarios (nombre, email, contrasena, rol_id) VALUES (?, ?, ?, 2)";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("sss", $nombre, $correo, $contraseña);

        $resultado = $stmt->execute();

        if ($resultado) {
            header("Location: index.php");
            exit();
        } else {
            echo "<h1>Error al registrar usuario.</h1>";
        }
    }
}
