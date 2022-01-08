
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
    <header class="cabecera">
        <h1>Tienda Online</h1>
        <a href="../login.php"><img src="../web-root/img/userPR15-01.png" height="50px"></a>
            
    </header>
    <main class="logout">
        <?php
            session_start();
            session_destroy();
        ?>
        <section>
            <h1>Ha cerrado la sesión</h1>
            <a class="boton" href="../index.php">Inicio</a>
        </section>
        

    </main>
<footer>
        <p>Footer de David</p>
        
        <a href="../index.php"><img src="../web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>