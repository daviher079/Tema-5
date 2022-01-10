<?php
    require_once "../codigo/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(validaSession()==false)
    {
        header("location: ./403.php");  
    }elseif($_SESSION['perfil']=='USR01')
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
        <title>Mostrar ventas</title>
    </head>
    <body>
        <header class="cabecera">
        <h1>Tienda Online</h1>
        <a href="./indexPerfil.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </header>


        <main class="mainModPerfil">
            <h2>Mostrar ventas</h2>
            <h4><?php echo $_SESSION['nombre'] ?></h4>
        <?php
            require_once("./validarModificarVentas.php");
            
            $arrayVentas=mostrarVentas();

            if(count($arrayVentas)==0)
            {
                echo "<h2>No hay ventas</h2>";
            }else
            {
            echo "<table>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<td>id Venta</td>";
                        echo "<td>usuario</td>";
                        echo "<td>Fecha</td>";
                        echo "<td>Codigo Producto</td>";
                        echo "<td>Cantidad</td>";
                        echo "<td>Precio total</td>";
                        if($_SESSION['perfil']=='ADM01')
                        {
                            echo "<td>Modificar</td>";
                            echo"<td>Borrar</td>";
                        }    
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                    foreach ($arrayVentas as $key => $value) {
                        echo "<tr>";
                            echo"<td>".$key."</td>";
                            foreach ($value as $value2) {
                                echo "<td>".$value2."</td>";
                            }
                            if($_SESSION['perfil']=='ADM01')
                            {
                                echo "<td><a href='./modificarVenta.php?codigo=".$key."'>Modificar</a></td>";
                                echo "<td><a href='./borrarVenta.php?codigo=".$key."'>Borrar</a></td>";
                            }    
                            echo"</tr>";
                    }
                echo "</tbody>";
            
            echo "</table>";
                }
        ?>
        </main>



    
    </body>
</html>