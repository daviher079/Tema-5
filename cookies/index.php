<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Tienda Online</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-9">

            <?php
                /*print_r($_COOKIE);
                setcookie("nombre","david", time()+3600, "/");*/
                
                require_once("./funciones/funcionesBD.php");

                if(isset($_COOKIE['visitado']))
                {
                    $producto= VerProducto($_COOKIE['visitado']);
                }

                $array= buscaProductos();

            ?>
            <table class="table">

                <thead>
                    <td>Nombre</td>
                    <td>imagen</td>
                    <td>codigo</td>
                </thead>

                <tbody>

                <?php
                    foreach ($array as $key => $value) {
                    echo "<tr>";
                    echo "<td>".$value['nombre']."</td>";
                    echo "<td> <img src='".$value['baja']."'/></td>";
                    echo "<td> <a href='./verProducto.php?codigo=".$value['codigo']."'>Ver</a></td>";
                    echo "</tr>";
                    
                    }
                ?>
                </tbody>

            </table>

        </div>
        <div class="col-3">
            <h3>Ultimas visitas</h3>

            <?php
                echo "<h2>".$producto[0]."</h2>";
            ?>
        </div>
    </div>
</div>
        
</body>
</html>
