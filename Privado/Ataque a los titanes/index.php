<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otakus</title>
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

    // Construimos la URL de la API con el número de página actual
    $apiUrl = "https://api.attackontitanapi.com/characters/?page=$pag";

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
    $titanes = $datos["results"];
    // Extraemos el número total de páginas disponibles (info -> pages)
    $ultima_pagina = $datos["info"]["pages"];

    // Mostramos el número de la última página y la página actual (solo para depuración)
    echo "<h1>$ultima_pagina</h1>";
    echo "<h1>$pag</h1>";
    ?>

    <!-- Creamos una tabla HTML para mostrar los personajes -->
    <table border="1px">
        <thead>
            <tr>
                <th>Nombre</th> <!-- Columna para el nombre -->
                <th>Edad</th>   <!-- Columna para la edad -->
                <th>Genero</th>  <!-- Columna para el género -->
                <th></th>       <!-- Columna para la imagen -->
            </tr>
        </thead>
        <tbody align="center">
            <?php
            // Recorremos el array de personajes ($titanes) con un bucle foreach
            foreach($titanes as $titan){
            ?>
            <tr>
                <!-- Columna del nombre: creamos un enlace a personaje.php con el ID del personaje -->
                <td>
                    <a href="personaje.php?id=<?php echo $titan["id"] ?>">
                        <?php echo $titan["name"] ?> <!-- Mostramos el nombre del personaje -->
                    </a>
                </td>
                <!-- Columna de la edad: mostramos la edad del personaje -->
                <td><?php echo $titan["age"] ?></td>
                <!-- Columna del género: mostramos el género del personaje -->
                <td><?php echo $titan["gender"] ?></td>
                <?php
                // Limpiamos la URL de la imagen: eliminamos la parte "/revision"
                $findme = "/revision";
                $pos = strpos($titan["img"], $findme); // Buscamos la posición de "/revision"
                ?>
                <!-- Columna de la imagen: mostramos la imagen del personaje -->
                <td><img src="<?php echo substr($titan["img"], 0, $pos);?>"></img></td>
            </tr>
            <?php } // Fin del bucle foreach ?>
        </tbody>
    </table>

    <!-- Enlaces de paginación -->
    <?php
    // Mostrar el enlace "Inicio" solo si estamos en la tercera página o más
    if($pag > 3){ ?>
        <a href="?page=<?= ($pag= 1) ?>" >Inicio</a> <!-- Enlace a la primera página -->
    <?php } else { ?>
        <a href="" hidden>Inicio</a> <!-- Enlace oculto si no cumple la condición -->
    <?php }

    // Mostrar el enlace "Anterior" solo si no estamos en la primera página
    if($pag <= 1){ ?>
        <a href="" hidden>Anterior</a> <!-- Enlace oculto si estamos en la primera página -->
    <?php } else { ?>
        <a href="?page=<?= ($pag - 1) ?>" >Anterior</a> <!-- Enlace a la página anterior -->
    <?php }

    // Mostrar el enlace "Siguiente" solo si no estamos en la última página
    if($pag < $ultima_pagina){ ?>
        <a href="?page=<?= ($pag + 1) ?>" >Siguiente</a> <!-- Enlace a la página siguiente -->
    <?php } else { ?>
        <a href="" hidden>Siguiente</a> <!-- Enlace oculto si estamos en la última página -->
    <?php }

    // Mostrar el enlace "Final" solo si no estamos en la penúltima o última página
    if($pag < $ultima_pagina -1){ ?>
        <a href="?page=<?= ($pag= $ultima_pagina) ?>" >Final</a> <!-- Enlace a la última página -->
    <?php } else { ?>
        <a href="" hidden>Final</a> <!-- Enlace oculto si estamos en la penúltima o última página -->
    <?php } ?>
    
</body>
</html>