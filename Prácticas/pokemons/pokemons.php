<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon API</title>
    <?php error_reporting(E_ALL); ini_set("display_errors", 1); ?>
    <style>
        img{
            width: 75px;
        }
    </style>
</head>

<body class="text-center">

    <div>
        <?php
        $limit = " "; // Número de Pokémons por página
        if (isset($_GET["limit"]) && !empty($_GET["limit"])) {
            $limit = $_GET["limit"];
        }else{
            $limit = 5;
        }
        $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0; 

        $apiURL = "https://pokeapi.co/api/v2/pokemon?offset=$offset&limit=$limit";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($curl);
        curl_close($curl);
        $pokemonData = json_decode($respuesta, true);
        $totalPokemon = $pokemonData['count']; 
        $pokemonList = $pokemonData['results'];

        $previousOffset = max(0, $offset - $limit);
        $nextOffset = min($totalPokemon - $limit, $offset + $limit);
        ?>
        <form action="" method="GET">
            <h1>Pokemon API</h1>
            <label for="pokemons">¿Cuántos pokémons quieres mostrar?</label>
            <input type="number" name="limit" id="limit">
            <input type="submit" value="Mostrar">
            <br><br>

            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Pokémon</th>
                            <th>Imagen</th>
                            <th>Tipos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Pokémons
                        foreach ($pokemonList as $pokemonItem) {
                            $pokemonName = $pokemonItem['name'];
                            $apiURL = "https://pokeapi.co/api/v2/pokemon/$pokemonName";
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $apiURL);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            $respuesta = curl_exec($curl);
                            curl_close($curl);
                            $pokemonDetail = json_decode($respuesta, true);

                            if (isset($pokemonDetail['id'])) {
                                $name = $pokemonDetail['name'];
                                $urlImage = $pokemonDetail['sprites']['other']['official-artwork']['front_default'] ?? 'https://via.placeholder.com/150';
                                ?>

                                <tr>
                                    <td><?php echo ucfirst($name); ?></td>
                                    </td>
                                    <td>
                                        <!--Imagen pokemon-->
                                        <a href="pokemon_info.php?pokemon=<?php echo $name; ?>">
                                            <img src="<?php echo $urlImage; ?>" alt="Imagen de <?php echo $name; ?>">
                                        </a>
                                    </td>
                                    <td>
                                        <ul style="list-style-type: none;">
                                            <?php
                                            //tipos
                                            foreach ($pokemonDetail['types'] as $type) {
                                                echo "<li>" . ucfirst($type['type']['name']) . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                </tr>

                            <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--Si no hay pagina anyerior no muestra anterior-->
            <div>
                    <div>
                        <?php if ($offset > 0) { ?>
                            <a href="?offset=<?php echo $previousOffset; ?>">Anterior</a>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if ($nextOffset < $totalPokemon) { ?>
                            <a href="?offset=<?php echo $nextOffset; ?>">Siguiente</a>
                        <?php } ?>
                    </div>
            </div>
        </form>
    </div>
</body>

</html>