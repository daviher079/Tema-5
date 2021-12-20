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
    <title>Menu</title>
</head>
<body>
    <header>
        <h1>Menu</h1>
        <?php
            echo "<h1>".$_SESSION['nombre']."</h1>";
        ?>

    </header>
    <div style="display: flex;">


        <?php
        foreach ($_SESSION['paginas'] as $key => $value) {
            echo" <a href='./".$value."'>".$key."</a> ";
        }
        ?>
    </div>
    <br>
    <a href="../logout.php">Logout</a>

</body>
</html>