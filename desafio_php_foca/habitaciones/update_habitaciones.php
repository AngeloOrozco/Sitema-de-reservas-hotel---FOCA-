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

    if(isset($_POST['update_habitaciones'])){
        $id = $_GET['id'];
        $numero = $_POST['numero'];
        $descripcion = $_POST['descripcion'];

        $query = "update habitaciones set numero = ?, descripcion = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss",$numero,$descripcion,$id);
        $stmt->execute();

        header("Location: ../admin.php");

    }

?>

<?php include("../includes/header.php") ?>

<div class="container mt-5">
    <h2 class="mb-4">Editar Habitación</h2>
    <form action="update_habitaciones.php?id=<?= $_GET['id'] ?>" method="post" class="col-md-6">
        <div class="mb-3">
            <label for="numero" class="form-label">Número:</label>
            <input type="text" class="form-control" name="numero" placeholder="Número de habitación" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la habitación" required>
        </div>
        <button type="submit" class="btn btn-primary" name="update_habitaciones">Actualizar</button>
    </form>
</div>

<?php include("../includes/footer.php") ?>