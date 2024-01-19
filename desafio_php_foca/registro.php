<?php include("includes/header.php") ?>

<div class="container mt-5">
    <form action="validar_registro.php" method="post" class="col-md-6 offset-md-3">
        <h1 class="text-center mb-4">Registro de cuenta</h1>

        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="usuario" placeholder="Ingrese su nombre" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo:</label>
            <input type="text" class="form-control" name="email" placeholder="Ingrese su correo" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" required>
        </div>

        <button type="submit" class="btn btn-primary" name="registrar">Registrar</button>
    </form>
</div>
<?php include("includes/footer.php") ?>