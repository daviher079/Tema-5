<?php
    require_once "../codigo/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(validaSession()==false)
    {
        header("location: ./403.php");
    }

    //y sino te llevo al login y exit
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
        <link rel="stylesheet" href="../web-root/css/style.css"/>
        <title>Modificar productos</title>
    </head>
    <body>
        <header class="cabecera">
        <h1>Tienda Online</h1>
        <a href="./indexPerfil.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </header>
        

        <main class="mainModPerfil">
            <h2>Modificar Productos</h2>
            <h4><?php echo $_SESSION['nombre'] ?></h4>
        <?php
            require_once("./validarModProducto.php");
            
            $arrayProductos=mostrarProductos();
            echo "<table>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<td>Codigo de Producto</td>";
                        echo "<td>Descripción</td>";
                        echo "<td>Precio</td>";
                        echo "<td>Stock</td>";
                        echo "<td>Modificar</td>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                    foreach ($arrayProductos as $key => $value) {
                        echo "<tr>";
                            echo"<td>".$key."</td>";
                            foreach ($value as $value2) {
                                echo "<td>".$value2."</td>";
                            }
                            echo"<td><a href='./modificarProducto.php?codigo=".$key."'>Modificar</a></td>";
                        echo"</tr>";
                    }
                echo "</tbody>";
            
            echo "</table>";
            $prueba=0;
        ?>
        </main>



    
    </body>
</html>