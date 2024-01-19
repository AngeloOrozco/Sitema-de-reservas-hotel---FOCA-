<?php

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: index.php");
    exit();
}

?>

<?php include("includes/header.php") ?>

<div class="container mt-5">
    <form action="logout.php" method="post">
        <input type="submit" class="btn btn-danger" value="Logout">
    </form>
    <br>
    <h1>Bienvenido cliente <?= $_SESSION['nombre_usuario'] ?></h1>

    <div class="text-center">
        <h1 class="mt-4 display-4 fw-bold">Información de Habitaciones</h1>
    </div>

    <?php
    include("db.php");
    $query = "select * from habitaciones where estado = 1";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
    ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Habitación <?= $row['numero'] ?></h5>
                <p class="card-text"><?= $row['descripcion'] ?></p>
            </div>
        </div>

    <?php } ?>

    <h1 class="mt-4">Seleccionar Habitación</h1>

    <form action="reservas/procesar_reserva.php" method="post">
        <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
            <input type="date" class="form-control" name="fecha_ingreso" required>
        </div>

        <div class="mb-3">
            <label for="fecha_egreso" class="form-label">Fecha de Egreso:</label>
            <input type="date" class="form-control" name="fecha_egreso" required>
        </div>

        <div class="mb-3">
            <label for="numero_habitacion" class="form-label">Número de Habitación:</label>
            <select class="form-select" name="numero_habitacion" required>
                <?php
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                ?>

                    <option value="<?= $row['id'] ?>">
                        <?= $row['numero'] ?>
                    </option>

                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="procesar_reserva">Reservar Habitación</button>
    </form>
    <br>
    <h1 class="mt-4">Reservas</h1>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Habitación</th>
                <th>Ingreso</th>
                <th>Egreso</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = "select * from reservas order by fecha_checkin";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
                $id_hab = $row['habitacion_id'];
                $consulta = "select * from habitaciones where id='$id_hab'";
                $resultado_id = mysqli_query($conn, $consulta);
                $id_hab_result = mysqli_fetch_array($resultado_id);
            ?>
                <tr>
                    <td><?= $id_hab_result['numero'] ?></td>
                    <td><?= $row['fecha_checkin'] ?></td>
                    <td><?= $row['fecha_checkout'] ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <br>
    <h1 class="mt-4">Tus reservas</h1>
    <br>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Habitación</th>
                <th>Ingreso</th>
                <th>Egreso</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $id_user = $_SESSION['id_usuario'];
            $query = "select * from reservas where usuario_id='$id_user' order by fecha_checkin";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
                $id_hab = $row['habitacion_id'];
                $consulta = "select * from habitaciones where id='$id_hab'";
                $resultado_id = mysqli_query($conn, $consulta);
                $id_hab_result = mysqli_fetch_array($resultado_id);
            ?>
                <tr>
                    <td><?= $id_hab_result['numero'] ?></td>
                    <td><?= $row['fecha_checkin'] ?></td>
                    <td><?= $row['fecha_checkout'] ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("includes/footer.php") ?>