<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluimos Bootstrap para estilizar la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Personajes Rick & Morty</title> <!-- Título de la página -->
</head>
<body>
    <!-- API de Rick & Morty: https://rickandmortyapi.com/documentation/ -->
    <?php
    // Definimos la URL base de la API de Rick & Morty
    $apiUrl = "https://rickandmortyapi.com/api/character";

    // Obtenemos la cantidad de personajes a mostrar desde el parámetro GET "cantidad"
    // Si no se proporciona, por defecto se muestran 20 personajes
    $cantidad = isset($_GET["cantidad"]) && $_GET["cantidad"] != "" ? (int)$_GET["cantidad"] : 20;

    // Obtenemos el género desde el parámetro GET "gender" (si existe)
    $genero = isset($_GET["gender"]) ? $_GET["gender"] : "";

    // Obtenemos la especie desde el parámetro GET "species" (si existe)
    $especie = isset($_GET["species"]) ? $_GET["species"] : "";

    // Si se proporcionan tanto el género como la especie, actualizamos la URL de la API para filtrar
    if(isset($cantidad) && isset($genero) && isset($especie)){
        $apiUrl = "https://rickandmortyapi.com/api/character?gender=$genero&species=$especie";
    }

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
    // Extraemos la lista de personajes (results) del array de datos
    $personajes = $datos["results"];
    ?>

    <!-- Formulario para filtrar y seleccionar la cantidad de personajes -->
    <form method="get">
        <label>¿Cuantos personajes quieres ver?</label>
        <input type="text" name="cantidad"> <!-- Campo para ingresar la cantidad de personajes -->
        <br>
        <label>Genero: </label>
        <select name="gender"> <!-- Selector para elegir el género -->
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <br>
        <label>Especie: </label>
        <select name="species"> <!-- Selector para elegir la especie -->
            <option value="human">Human</option>
            <option value="alien">Alien</option>
        </select>
        <br>
        <input type="submit" value="Buscar"> <!-- Botón para enviar el formulario -->
    </form>
    <br>

    <!-- Tabla para mostrar los personajes -->
    <h2>Tabla de personajes Rick & Morty</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th> <!-- Columna para el nombre -->
                <th scope="col">Genero</th> <!-- Columna para el género -->
                <th scope="col">Especie</th> <!-- Columna para la especie -->
                <th scope="col">Imagen</th> <!-- Columna para la imagen -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Verificamos si la cantidad solicitada es mayor que el número de personajes disponibles
            if($cantidad > count($personajes)) $cantidad = count($personajes);

            // Recorremos los personajes con un bucle for
            for($i=0; $i<$cantidad; $i++) { ?>
                <tr>
                    <!-- Mostramos el nombre del personaje -->
                    <td scope="row"><?php echo $personajes[$i]["name"]?></td>
                    <!-- Mostramos el género del personaje -->
                    <td scope="row"><?php echo $personajes[$i]["gender"]?></td>
                    <!-- Mostramos la especie del personaje -->
                    <td scope="row"><?php echo $personajes[$i]["species"]?></td>
                    <!-- Mostramos la imagen del personaje -->
                    <td scope="row">
                        <img width="100px" src="<?php echo $personajes[$i]["image"]?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>