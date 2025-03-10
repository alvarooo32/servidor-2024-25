<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakus</title> <!-- Título de la página -->
</head>
<body>
    <?php
    // Verificamos si existe el parámetro "page" en la URL (para la paginación)
    if(isset($_GET["page"])){
        $pag = $_GET["page"]; // Obtenemos el valor de "page"
        // Si el valor de "page" es menor que 2, lo forzamos a 1 (para evitar páginas negativas o cero)
        if($pag < 2){
            $pag = 1;
        }
    } else{
        // Si no existe el parámetro "page", asumimos que es la primera página
        $pag = 1;
    }

    // Verificamos si existe el parámetro "limit" en la URL (para limitar la cantidad de personajes por página)
    if(isset($_GET["limit"])){
        $limite = $_GET["limit"]; // Obtenemos el valor de "limit"
        // Si el valor de "limit" es menor que 1, lo forzamos a 5 (valor por defecto)
        if($limite < 1){
            $limite = 5;
        }
    } else{
        // Si no existe el parámetro "limit", asumimos un límite de 5 personajes por página
        $limite = 5;
    }

    // Construimos la URL de la API con el número de página actual y el límite de personajes
    $apiUrl = "https://dragonball-api.com/api/characters?page=$pag&limit=$limite";

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
    // Extraemos la lista de personajes (items) del array de datos
    $guerreros = $datos["items"];
    // Extraemos el número total de páginas disponibles (meta -> totalPages)
    $ultima_pagina = $datos["meta"]["totalPages"];

    // Mostramos el número de la última página y la página actual (solo para depuración)
    echo "<h1>$ultima_pagina</h1>";
    echo "<h1>$pag</h1>";
    ?>

    <!-- Formulario para seleccionar la cantidad de personajes por página -->
    <form method="get">
        <label>Seleccione la cantidad de personajes: </label>
        <input type="number" id="limit" name="limit"> <!-- Campo para ingresar el límite -->
        <input type="submit" value="Enviar"> <!-- Botón para enviar el formulario -->
    </form>

    <!-- Creamos una tabla HTML para mostrar los personajes -->
    <table border="1px">
        <thead>
            <tr>
                <th>Nombre</th> <!-- Columna para el nombre -->
                <th>Raza</th>   <!-- Columna para la raza -->
                <th>Genero</th>  <!-- Columna para el género -->
                <th></th>       <!-- Columna para la imagen -->
            </tr>
        </thead>
        <tbody align="center">
            <?php
            // Recorremos el array de personajes ($guerreros) con un bucle foreach
            foreach($guerreros as $guerrero){
            ?>
            <tr>
                <!-- Columna del nombre: creamos un enlace a personaje.php con el ID del personaje -->
                <td>
                    <a href="personaje.php?id=<?php echo $guerrero["id"] ?>">
                        <?php echo $guerrero["name"] ?> <!-- Mostramos el nombre del personaje -->
                    </a>
                </td>
                <!-- Columna de la raza: mostramos la raza del personaje -->
                <td><?php echo $guerrero["race"] ?></td>
                <!-- Columna del género: mostramos el género del personaje -->
                <td><?php echo $guerrero["gender"] ?></td>
                <!-- Columna de la imagen: mostramos la imagen del personaje -->
                <td><img src="<?php echo ($guerrero["image"]);?>" width="140" height="200"></img></td>
            </tr>
            <?php } // Fin del bucle foreach ?>
        </tbody>
    </table>

    <!-- Enlaces de paginación -->
    <?php
    // Mostrar el enlace "Inicio" solo si estamos en la tercera página o más
    if($pag > 2){ ?>
        <a href="?limit=<?= $limite ?>&page=1">Inicio</a> <!-- Enlace a la primera página -->
    <?php } else { ?>
        <a href="" hidden>Inicio</a> <!-- Enlace oculto si no cumple la condición -->
    <?php } ?>

    <!-- Mostrar el enlace "Anterior" solo si no estamos en la primera página -->
    <?php if($pag > 1){ ?>
        <a href="?limit=<?= $limite ?>&page=<?= $pag - 1 ?>">Anterior</a> <!-- Enlace a la página anterior -->
    <?php } else { ?>
        <a href="" hidden>Anterior</a> <!-- Enlace oculto si estamos en la primera página -->
    <?php } ?>

    <!-- Mostrar el enlace "Siguiente" solo si no estamos en la última página -->
    <?php if($pag < $ultima_pagina){ ?>
        <a href="?limit=<?= $limite ?>&page=<?= $pag + 1 ?>">Siguiente</a> <!-- Enlace a la página siguiente -->
    <?php } else { ?>
        <a href="" hidden>Siguiente</a> <!-- Enlace oculto si estamos en la última página -->
    <?php } ?>

    <!-- Mostrar el enlace "Final" solo si no estamos en la penúltima o última página -->
    <?php if($pag < $ultima_pagina-1){ ?>
        <a href="?limit=<?= $limite ?>&page=<?= $ultima_pagina ?>">Final</a> <!-- Enlace a la última página -->
    <?php } else { ?>
        <a href="" hidden>Final</a> <!-- Enlace oculto si estamos en la penúltima o última página -->
    <?php } ?>
    
</body>
</html>