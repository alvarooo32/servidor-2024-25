<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>waifus</title> <!-- Título de la página -->
</head>
<body>
    <?php
    // Obtenemos el ID del personaje desde la URL (parámetro "id")
    $id = $_GET["id"];

    // Construimos la URL de la API para obtener los detalles del personaje específico
    $apiUrl = "https://dragonball-api.com/api/characters/$id";

    // Inicializamos cURL para hacer una solicitud HTTP a la API
    $curl = curl_init();
    // Configuramos cURL para que apunte a la URL de la API
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    // Configuramos cURL para que devuelva la respuesta como una cadena en lugar de imprimirla directamente
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Ejecutamos la solicitud y guardamos la respuesta en la variable $respuesta
    $respuesta = curl_exec($curl);
    // Cerramos la conexión cURL
    curl_close($curl);

    // Decodificamos la respuesta JSON de la API a un array asociativo de PHP
    $datos = json_decode($respuesta, true);
    // Extraemos las transformaciones del personaje (si las tiene)
    $transformaciones = $datos["transformations"];
    ?>

    <!-- Mostramos la información del personaje -->
    <p><b>Nombre: </b><?php echo $datos["name"] ?></p><br> <!-- Mostramos el nombre del personaje -->
    <p><b>Raza: </b><?php echo $datos["race"] ?></p><br> <!-- Mostramos la raza del personaje -->
    <p><b>Género: </b><?php echo $datos["gender"] ?></p><br> <!-- Mostramos el género del personaje -->
    <!-- Mostramos la imagen del personaje -->
    <p><img src="<?php echo ($datos["image"]);?>" width="140" height="200"></img></p><br>
    <!-- Mostramos la descripción del personaje -->
    <p><b>Descripción: </b><?php echo $datos["description"] ?></p><br>

    <!-- Mostramos las transformaciones del personaje -->
    <p><b>Transformaciones: </b></p>
    <ul>
        <?php
        // Verificamos si el personaje tiene transformaciones
        if($transformaciones == null){ ?>
            <!-- Si no tiene transformaciones, mostramos un mensaje -->
            <li>
                <p>Este personaje no tiene transformaciones</p>
            </li>
        <?php } else { 
            // Si tiene transformaciones, las recorremos con un bucle foreach
            foreach($transformaciones as $transformacion) {?>
            <li>
                <!-- Mostramos el nombre de la transformación -->
                <p>Nombre: <?php echo $transformacion["name"] ?></p>
                <!-- Mostramos la imagen de la transformación -->
                <p><img src="<?php echo ($transformacion["image"]);?>" width="140" height="200"></img></p>
            </li>
        <?php } }?>
    </ul>
</body>
</html>