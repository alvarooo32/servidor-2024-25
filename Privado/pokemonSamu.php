<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemons</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
</head>
<body>
    <?php
        // Parametros para la paginacion
        $limit = isset($_GET["limit"]) ? (int)$_GET["limit"] : 5;
        $offset = isset($_GET["offset"]) ? (int)$_GET["offset"] : 0;

        //Llamada a la url de la api pokemon
        $apiUrl = "https://pokeapi.co/api/v2/pokemon?limit=$limit&offset=$offset";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl); //enlazo con apiUrl que es donde esta la informacion que voy a necesitar
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);

        $datos = json_decode($respuesta, true);
        $pagination = $datos; //datos para guardar toda la informacion que habra en la pagina
        $pokemons = $datos["results"]; //results es donde se encuentra el arrays con todos los pokemons
    ?>
    <form method="get">
        <label>¿Cuantos Pokémons quieres mostrar?</label>
        <input type="number" name="limit"> <!--limit para conectarlos con la variable-->
        <input type="submit" value="Mostrar">
        <br><br>
    </form>
    <table>
        <thead>
            <tr>
                <th>Pokemon</th>
                <th>Imagen</th>
                <th>Tipos</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($pokemons as $pokemon) { ?> <!---pokemon es la variable que usaremos todo el rato-->
                    <tr>
                        <td>
                            <?php echo ucwords($pokemon["name"])?> <!--Primera letra en mayus del nombre de cada pokemon-->
                        </td>
                        <td>
                            <?php 

                                $imagenUrl=$pokemon["url"]; //Dentro de URL se encuentra la imagen y el tipo
                                //hacemos curl para obtener los datos que hay dentro de url
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, $imagenUrl); //enlazo con imagenUrl que es donde esta la informacion que voy a necesitar
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                $respuesta = curl_exec($curl);
                                curl_close($curl);
                        
                                $datosPokemon = json_decode($respuesta, true);
                            ?>
                            <img src="<?php echo $datosPokemon["sprites"]["front_default"]?>"> <!--Datos pokemons que es donde se encuntra toda la info + array donde se encuentra exactamente la informacion-->
                        </td>
                        <td><?php
                            $tipos = $datosPokemon["types"]; //Types es donde se encuentran todos los tipos de pokemons
                            foreach($tipos as $tipo){
                                echo ucwords($tipo["type"]["name"]." "); //Para que la primera letra se ponga en mayus y dejar un espacio al final              
                            } 

                            ?></td>
                    </tr>
                <?php } ?>
        </tbody>
    </table>
    <?php
        //"https://pokeapi.co/api/v2/pokemon?limit=$limit&offset=$offset";
        if(isset($pagination["previous"])){ ?>
           <a href="?limit=<?php echo $limit ?>&offset=<?php echo $offset-$limit ?>">Anterior</a> <!--Edito la url principal añadiendo los parametros a limit y offset-->
    <?php } 
        if(isset($pagination["next"])){ ?>
            <a href="?limit=<?php echo $limit ?>&offset=<?php echo $offset+$limit ?>">Siguiente</a>
    <?php } ?>
</body>
</html>