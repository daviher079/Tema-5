
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <title>LogOut</title>
</head>
<body>
    <main>
        <?php
            session_start();
            session_destroy();
        
            echo "<h1>Ha cerrado la sesión</h1>";
        ?>
        
        <a class="boton" href="./login.php">Login</a>

    </main>
<footer>
        <p>Footer de David</p>
        <a href="./verCodigo.php?ficheroPHP=<?php
            $pagina=basename($_SERVER['SCRIPT_FILENAME']);
            echo $pagina;
        ?>"><img src="../web-root/img/gafas-de-sol.png" height="100px"></a>
        <a href="../index.html"><img src="../web-root/img/volver.png" height="25px"></a>
    </footer>
</body>
</html>