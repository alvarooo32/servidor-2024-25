<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
    require('../util/conexion.php');
    session_start(); 
    if (!isset($_SESSION["usuario"])) { 
        header("Location: ../usuario/iniciar_sesion.php"); 
        exit();
    }
    ?>
    <style>
        .error{
            color: red;
        }
        img{
            width: 160px;
            height: 200px;
        }
    </style>
</head>
<body>
    <?php
        function depurar(string $entrada) : string {
            // Para que el usuario no pueda usar etiquetas en los campos Ej: <h1>Hola</h1>
            $salida = htmlspecialchars($entrada);
            // Para quitar los espacios de delante y detrás
            $salida = trim($salida);
            // Quita posibles bugs muy raros como que el usuario introduzca: \n (No está de más ponerla)
            $salida = stripcslashes($salida);
            // Para quitar los múltiples espacios entre variables y demás
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }
    ?>
    <div class="container">

        <?php 
            if (isset($_SESSION["usuario"])) {
                echo "<h2>Bienvenid@ ". $_SESSION["usuario"] . "</h2>"; 
                } else { 
                    echo "<h2>Bienvenid@ Inicia Sesión</h2>"; 
            } 
        ?> 

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_producto = depurar($_POST["id_producto"]);

            //borro producto usando el id correcto
            $sql = "DELETE FROM productos WHERE id_producto = $id_producto";
            if ($_conexion->query($sql)) {
                echo "<p class='text-success'>Producto eliminado correctamente.</p>";
            } else {
                echo "<p class='text-danger'>Error al eliminar el producto: " . $_conexion->error . "</p>";
            }
        }

        //obtengo todos los productos
        $sql = "SELECT * FROM productos";
        $resultado = $_conexion->query($sql); 
        ?>

        <a class="btn btn-warning" href="../usuario/cerrar_sesion.php">Cerrar sesión</a>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Descripción</th>
                    <th></th> <!--Hueco para los botones-->
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                while($fila = $resultado -> fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>". $fila["nombre"] ."</td>";
                    echo "<td>". $fila["precio"] ."</td>";
                    echo "<td>". $fila["categoria"] ."</td>";
                    echo "<td>". $fila["stock"] ."</td>";
                    ?>
                    <td>
                        <img src="imagen/<?php echo $fila["imagen"]; ?>" >
                    </td>
                    <?php
                    echo "<td>". $fila["descripcion"] ."</td>";
                    ?>
                    <td>
                        <a class="btn btn-primary" 
                        href="editar_producto.php?id_producto=<?php echo $fila["id_producto"]?>">Editar</a>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $fila["id_producto"] ?>">
                            <input class="btn btn-danger" type="submit" value="Borrar">
                        </form>
                    </td>
                    <?php
                        echo "</tr>";
                }
            ?>
            </tbody>
        </table>
        <table>
            <thead>
                <th>
                    <div>
                        <a class="btn btn-primary" href="nuevo_producto.php">Nuevo Producto</a>
                    </div>
                </th>
                <th>
                    <div>
                        <a class="btn btn-success" href="../categorias/index.php">Ir a Categorías</a>
                    </div>
                </th>
                <th>
                    <div>
                        <a class="btn btn-secondary" href="../index.php">Volver a Página Principal</a>
                    </div>
                </th>
            </thead>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>