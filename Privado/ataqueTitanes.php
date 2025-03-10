<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ataque a los Titanes</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
</head>
<body>
    
    <?php
        // Parámetros para la paginación
        $limit = isset($_GET["limit"]) ? (int)$_GET["limit"] : 20;
        $offset = isset($_GET["offset"]) ? (int)$_GET["offset"] : 0;

        // Llamada a la URL de la API de Attack on Titan
        $apiUrl = "https://api.attackontitanapi.com/characters?limit=$limit&offset=$offset";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl); //enlazo con apiUrl que es donde esta la informacion que voy a necesitar
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        $datos = json_decode($respuesta, true);
        $pagination = $datos; //datos para guardar toda la informacion que habra en la pagina
        $personajes = $datos["results"];



    ?>
    <h1>Ataque a los Titanes</h1>
    <form method="get">
        
    </form>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($personajes as $personaje) { ?> 
                    <tr>
                        <td>
                            <?php echo ucwords($personaje["name"])?> <!--Primera letra en mayus del nombre de cada pokemon-->
                        </td>
                        <td>
                            <?php echo $personaje["age"];?>
                        </td>
                        <td>
                            <?php echo $personaje["gender"];?>
                        </td>
                        <td>
                            <img src="<?php echo $personaje["img"] ?>">
                        </td>
                        <td>

                        </td>
                    </tr>
                <?php } ?>
        </tbody>

    </table>
</body>