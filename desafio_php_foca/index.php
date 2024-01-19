<?php include("includes/header.php") ?>
    

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="validar.php" method="post">
                <h1 class="mb-4">Sistema Login</h1>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su correo" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>

            <div class="mt-3">
                <a href="registro.php">Crear una cuenta</a>
            </div>
        </div>
    </div>
</div>



    <?php include("includes/footer.php") ?>