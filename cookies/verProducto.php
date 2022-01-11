<?php




?>

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

<?php
    require_once("./funciones/funcionesBD.php");

    if(isset($_REQUEST['codigo']))
    {


        if(!isset($_COOKIE['visitado']))
        {
            echo"No hay cookie";
            setcookie("visitado",$_REQUEST['codigo'], time()+3600, "/");

        }else
        {
            //header("Location: index.php");
            setcookie("visitado",$_REQUEST['codigo'], time()+3600, "/");
        }


        $array=VerProducto($_REQUEST['codigo']);
    
    
        echo "<h1>".$array[0]."</h1>";
        echo "<p>".$array[1]."</p>";
        echo"<img src='".$array[2]."'/>";

    }
    else
    {
        header("Location: index.php");
    }
    ?>

    <a href="./index.php">volver</a>
</body>
</html>
