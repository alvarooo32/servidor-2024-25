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
    $apiUrl = "https://api.attackontitanapi.com/characters/$id";

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
    ?>

    <!-- Mostramos la información del personaje -->
    <p>Nombre: <?php echo $datos["name"] ?></p> <!-- Mostramos el nombre del personaje -->
    <p>Edad: <?php echo $datos["age"] ?></p>    <!-- Mostramos la edad del personaje -->
    <p>Género: <?php echo $datos["gender"] ?></p> <!-- Mostramos el género del personaje -->
    <?php
    // Limpiamos la URL de la imagen: eliminamos la parte "/revision"
    $findme = "/revision";
    $pos = strpos($datos["img"], $findme); // Buscamos la posición de "/revision"
    ?>
    <!-- Mostramos la imagen del personaje -->
    <img src="<?php echo substr($datos["img"], 0, $pos);?>"></img>
    
</body>
</html>