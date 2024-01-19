<?php
    include("db.php");
    $email = $_POST['email'];
    $contraseña = $_POST['password'];
    session_start();
    $_SESSION['email']=$email;

    $consulta = "select * from usuarios where email='$email' and contrasena='$contraseña'";
    $resultado = mysqli_query($conn,$consulta);

    $filas=mysqli_fetch_array($resultado);

    if($filas && $filas['rol_id']==1){
        //administrador
        $_SESSION['autenticado']=true;
        $_SESSION['rol_id']=$filas['rol_id'];
        $_SESSION['nombre_usuario']=$filas['nombre'];
        $_SESSION['id_usuario']=$filas['id'];

        header("location: admin.php");
    }
    else if($filas && $filas['rol_id']==2){
        //cliente
        $_SESSION['autenticado']=true;
        $_SESSION['id_usuario']=$filas['id'];
        $_SESSION['nombre_usuario']=$filas['nombre'];
        header("location: cliente.php");
    }
    else{
        include("index.php");
        echo "<h1>Contraseña o email incorrectos</h1>";
    }

    mysqli_free_result($resultado);
    mysqli_close($conn);
?>


