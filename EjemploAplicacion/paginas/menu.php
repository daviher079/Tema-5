<?php
    require_once "../funciones/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(!validaSession())
    {
        
    }

    //y sino te llevo al login y exit
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../../web-root/css/style.css"/>
    <title>Menu</title>

    <style>
        .logout
        {
            float: right;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background-color: transparent;
            color: #d02b4d;
            text-decoration: none;
            padding: 7px;
            font-size: 1.05em;
        }

        .logout:hover
        {
            color: #7c1227;
        }
    </style>
</head>
<body>
    <header>
        <img class="logo" src="../../web-root/img/LogotipoDavid.jpg"/>
        <h1>Menu</h1>
        <?php
            echo "<h1>".$_SESSION['nombre']."</h1>";
        ?>

    </header>

    
        
    <div style="display: flex;">


        <?php
        foreach ($_SESSION['paginas'] as $key => $value) {
            echo" <a class='boton' href='./".$value."'>".$key."</a> ";
        }
        ?>
    </div>
    <br>
    <a class="logout" href="../logout.php">Logout</a>

</body>
</html>