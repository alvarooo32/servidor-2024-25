<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiste aleatorio</title>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    ?>
</head>
<body>
    <?php
        $apiUrlCategorias = "https://api.chucknorris.io/jokes/categories";//url donde se encuentran todas las categorias de chistes

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrlCategorias);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuestaCategorias = curl_exec($curl);
        curl_close($curl);

        $categorias = json_decode($respuestaCategorias, true);// Convierte la respuesta JSON en un array asociativo de PHP

        if (isset($_GET['categories'])) {//categories pq es el nombre que tiene en el json
            $categoriaSeleccionada = $_GET['categories'];
            $apiUrlRandom = "https://api.chucknorris.io/jokes/random?category=$categoriaSeleccionada"; // Al random le meto la categoria que hemos seleccionado
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $apiUrlRandom);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $respuestaRandom = curl_exec($curl);
            curl_close($curl);

            $datosRandom = json_decode($respuestaRandom, true);
            $chiste = $datosRandom['value']; // coge el value q es donde estan los chistes aleatorios
            $foto = $datosRandom['icon_url']; // coge la foto que hay
        }
    ?>
    <div>
        <form method="get">
            <label for="categories">Categoria:</label>
            <select name="categories" id="categories"> <!--Importante llamar al select de la misma forma que se llama en el json-->
                <?php
                    foreach($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria ?>"><?php echo $categoria ?></option>
                    <?php } ?>   
            </select><br>
            <input type="submit" value="Generar"><br><br>
        </form>

        <?php
        if (isset($chiste)) { ?>
            <img src="<?php echo $foto ?>"><br>
            <p><?php echo $chiste ?></p>
        <?php } ?>
    </div>
</body>
</html>