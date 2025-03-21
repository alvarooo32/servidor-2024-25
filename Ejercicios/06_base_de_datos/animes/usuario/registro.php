<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro   </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );    

        require('../conexion.php');
    ?>
</head>
<body>
    <?php
        function depurar(string $entrada) : string {
            // Para que el usuario no pueda usar etiquetas en los campos Ej: <h1>Hola</h1>
            $salida = htmlspecialchars($entrada);
            // Para quitar los espacios de delante y detrás
            $salida = trim($salida);
            // Quita posibles bugs muy raros como que el usuario introduzca: \n (No está de más ponerla)
            $salida = stripcslashes($salida);
            // Para quitar los múltiples espacios entre variables y demás
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }
    ?>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = depurar($_POST["usuario"]);
        $contrasena = $_POST["contrasena"];

        $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);

        /*
        $sql = "INSERT INTO usuarios VALUES ('$usuario','$contrasena_cifrada')";
        $_conexion -> query($sql);
        */

        #1. Preparacion
        $sql = $conexion -> prepare("INSERT INTO usuarios (usuario, contrasena, contrasena_cifrada VALUES (?,?,?)");

        #2. Enlazado
        $sql -> bind_param("sss", 
            $usuario,
            $contrasena,
            $contrasena_cifrada
        );

        #3. Ejeccucion
        $sql -> execute();

        #4. Retrieve no pq es solo en los select

        #5.cerrar la consulta
        $_conexion -> close();

        header("location: iniciar_sesion.php");
        exit;
    }
    ?>
    <div class="container">
        <h1>Registro</h1>
        
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" name="usuario">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input class="form-control" type="password" name="contrasena">
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Registrarse">
            </div>
        </form>
        <div class="mb-3">
            <h3>O, si ya tienes cuenta, inicia sesión</h3>
            <a class="btn btn-secondary" href="iniciar_sesion.php">Iniciar sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>