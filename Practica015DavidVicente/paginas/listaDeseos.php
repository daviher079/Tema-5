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
    <title>Lista de Deseos</title>

</head>
<body>
    <header class="cabecera">
       <h1>Tienda Online</h1>
       <div class='user'>
            <?php
                echo "<h2>".$_SESSION['nombre']."</h2>";
            ?>    
                <a href="../index.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
        </div>
    </header>
    
    <div style="display: flex;">

        <aside>
            

        <?php
            
            echo"<ul>";
            /**
             * Se recorren las páginas a las que puede acceder al usuario
             */
                foreach ($_SESSION['paginas'] as $key => $value) {
                    echo" <li><a class='boton' href='./".$value."'>".$key."</a> </li>";
                }
            echo "</ul>";    
        ?>
        </aside>  
        <main class="mainModPerfil">
        <?php
            require_once("./validarListadeDeseos.php");
            //session_start();
            $usuario= $_SESSION['usuario'];

            if(!isset($_COOKIE[$usuario]))
            {
                echo "<h2>No hay productos añadidos a la lista de deseos</h2>";
            }else
            {
                foreach ($_COOKIE[$usuario] as $key => $value) {
                    $producto=VerProducto($value);
                    
    
                    echo "<a class='enlaces' href='./comprarProducto.php?codigo=".$producto[0].
                            "&descripcion=".$producto[1]."&precio=".$producto[2].
                            "&stock=".$producto[3]."'><div class='producto'>".
                            $producto[1]."</div></a>";
                }
            }

            


    
        ?>


</main>
    </div>
    
    
</body>
</html>