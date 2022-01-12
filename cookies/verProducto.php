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
            

            setcookie("visitado[0]",$_REQUEST['codigo'], time()+3600, "/");

        }else
        {
           //contar cuantas hay
           $arrayProductosVisitados = $_COOKIE['visitado'];

           $numero=count($arrayProductosVisitados);

           if(!in_array($_REQUEST['codigo'], $arrayProductosVisitados))
           {
               if($numero<3)
               {
                    array_unshift($arrayProductosVisitados, $_REQUEST['codigo']);

                    foreach ($arrayProductosVisitados as $key => $value) {
                        setcookie('visitado['.$key.']',$value, time()+3600, "/");
                    }  
               }else
               {
                   //Ordenar poniendo el primero el ultimo codigo
                    array_unshift($arrayProductosVisitados, $_REQUEST['codigo']);
                    array_pop($arrayProductosVisitados);

                    foreach ($arrayProductosVisitados as $key => $value) {
                        setcookie('visitado['.$key.']',$value, time()+3600, "/");
                    }
               }
           }
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
