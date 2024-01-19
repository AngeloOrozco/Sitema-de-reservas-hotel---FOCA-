<?php

session_start();
include("../db.php");
if (isset($_POST['procesar_reserva'])) {
    $ingreso = $_POST['fecha_ingreso'];
    $egreso = $_POST['fecha_egreso'];
    $num_habitacion = $_POST['numero_habitacion'];

    // Obtener la marca de tiempo actual
    $hoy = strtotime('today');

    // Convertir las fechas a marcas de tiempo
    $marcaTiempoIngreso = strtotime($ingreso);
    $marcaTiempoEgreso = strtotime($egreso);

    // Validar que la fecha de ingreso no sea anterior al día de hoy
    if ($marcaTiempoIngreso < $hoy) {
        echo "<h1>La fecha de ingreso no puede ser anterior al día de hoy.</h1>";
    } else if ($marcaTiempoEgreso == $hoy || $marcaTiempoEgreso < $marcaTiempoIngreso || $marcaTiempoEgreso == $marcaTiempoIngreso) {
        echo "<h1>La fecha de egreso no puede ser igual al día de hoy o anterior.</h1>";
    } else {
        // Consulta SQL con statements preparados
        $query = "SELECT * FROM reservas WHERE habitacion_id = ? AND (
    (? BETWEEN fecha_checkin AND fecha_checkout)
    OR (? BETWEEN fecha_checkin AND fecha_checkout))";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $num_habitacion, $ingreso, $egreso);

        $stmt->execute();
        $stmt->store_result();

        // Verificar si hay resultados
        if ($stmt->num_rows > 0) {
            // Ya hay una reserva para esa habitación en ese período
            echo "<h1>¡Ya hay una reserva para esa habitación en ese período!</h1>";
        } else {
            $query = "insert into reservas(habitacion_id, usuario_id, fecha_checkin, fecha_checkout) values (?,?,?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $num_habitacion, $_SESSION['id_usuario'], $ingreso, $egreso);
            $stmt->execute();
            header("location: ../cliente.php");
        }

        // Cerrar el statement y liberar resultados
        $stmt->close();
        $conn->close();
    }
}
