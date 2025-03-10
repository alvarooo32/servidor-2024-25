<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titulo</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
</head>

<body>
    <?php
        // Parametros para la paginacion
        //limit->  cantidad de resultados "https://pokeapi.co/api/v2/pokemon?limit=$limit&offset=$offset"
        if (isset($_GET["limit"])) {
            $limit = $_GET["limit"];
        } else {
            $limit = 5;
        }
        //offset-> Paginacion "https://pokeapi.co/api/v2/pokemon?limit=$limit&offset=$offset"
        if (isset($_GET["offset"])) {
            $offset = (int)$_GET["offset"];
        } else {
            $offset = 0;
        }
                
        //search-> ?search=pickachu

        //filter-> ?category=action

        //sort-> Especifica el campo por el que ordenar (ej., nombre, precio)  ?sort=precio&order=desc
        if (isset($_GET["sort"])) {
            $sort = $_GET["sort"];
        } else {
            $sort = "name"; // Valor por defecto para sort
        }
        //order->  Especifica la dirección del orden (ej., asc para ascendente o desc ?sort=precio&order=desc
        if (isset($_GET["order"])) {
            $order = $_GET["order"];
        } else {
            $order = "asc"; // Valor por defecto para order o desc
        }
        
        //Llamada a la url de la Api
        $apiUrl = "https://pokeapi.co/api/v2/pokemon?limit=$limit&offset=$offset";
        //url donde se encuentran los pokemons poniendo un limite y paginas

        //cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl); //enlazo con apiUrl que es donde esta la informacion que voy a necesitar
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        $datos = json_decode($respuesta, true);
        $pagination = $datos; //datos para guardar toda la informacion que habra en la pagina
        $pokemons = $datos["results"]; //results es donde se encuentra el arrays con todos los pokemons