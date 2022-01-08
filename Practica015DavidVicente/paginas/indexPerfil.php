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
    <title>Perfil</title>
</head>
<body>
    <header class="cabecera">
       <h1>Tienda Online</h1>
       <a href="../index.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
    </header>
    
    <aside>

        <?php
            echo "<h1>".$_SESSION['nombre']."</h1>";
            echo"<ul>";
                foreach ($_SESSION['paginas'] as $key => $value) {
                    echo" <li><a class='boton' href='./".$value."'>".$key."</a> </li>";
                }
            echo "</ul>";    
        ?>
    </aside>   

    
    
</body>
</html>