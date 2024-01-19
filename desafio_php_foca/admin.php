<?php
include("db.php");
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: index.php");
    exit();
}
// Verificar el rol del usuario
if ($_SESSION['rol_id'] != 1) {
    // El usuario no tiene el rol de administrador, redirigir a una página de error o a una página adecuada para su rol.
    header("Location: error.php");
    exit();
}

?>
<?php include("includes/header.php") ?>

<div class="container mt-5">
    <form action="logout.php" method="post">
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <br>

    <h1 class="mt-4 pb-4">Hola admin</h1>

    <h2>Crear nueva habitación</h2>
    <form action="habitaciones/save_habitaciones.php" method="post">
        <div class="mb-3">
            <label for="numero" class="form-label">Número:</label>
            <input type="text" class="form-control" id="numero" name="numero" placeholder="Número de habitación" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción de la habitación" required>
        </div>

        <button type="submit" class="btn btn-primary" name="save_habitaciones">Guardar</button>
    </form>

    <br>

    <h2 class="mt-4">Habitaciones</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = "select * from habitaciones";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result)){
            ?>
            <tr>
                <td><?= $row['numero'] ?></td>
                <td><?= $row['descripcion'] ?></td>
                <td><?php echo $estado = $row['estado'] ? 'Activo' : 'Inhabilitado'; ?></td>
                <td>
                    <a href="habitaciones/update_habitaciones.php?id=<?= $row['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="habitaciones/cambiar_estado.php?id=<?= $row['id'] ?>" class="btn btn-info">Estado</a>
                </td>
            </tr>

            <?php } ?>
            
        </tbody>
    </table>

    <h2 class="mt-4">Reservas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Habitación</th>
                <th>Ingreso</th>
                <th>Egreso</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = "select * from reservas order by fecha_checkin";
            $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_array($result)){
                $id_hab = $row['habitacion_id'];
                $consulta = "select * from habitaciones where id='$id_hab'";
                $resultado_id = mysqli_query($conn,$consulta);
                $id_hab_result = mysqli_fetch_array($resultado_id);
            ?>
            <tr>
                <td><?= $id_hab_result['numero'] ?></td>
                <td><?= $row['fecha_checkin'] ?></td>
                <td><?= $row['fecha_checkout'] ?></td>
                <td>
                    <a href="reservas/delete_reservas.php?id_reserva=<?= $row['id'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>

            <?php } ?>
            
        </tbody>
    </table>
</div>


    <?php include("includes/footer.php") ?>