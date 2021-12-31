<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../web-root/css/style.css"/>
    <style>
        .boton1
       {
           -webkit-transition: 1s ease-in-out;
           transition: 1s ease-in-out;
       }
       .boton1:hover
       {
           background-color: #9c102c;
           -webkit-transform: scale(.85);
           transform: scale(.85);
       }
    </style>
    <title>Ejemplo .htaccess</title>
</head>
<body>
    <header>
        <img class="logo" src="../web-root/img/LogotipoDavid.jpg"/>
        <h1>Ejemplo .htaccess</h1>
    </header>
    <main>
        <div style="display: flex;">
            <h2>Desea entrar en:</h2>
            <a class="boton boton1" href="./administrador/config.php">Administrador</a>
            <a class="boton boton1" href="./usuarios/perfil.php">Usuario</a>

        </div>
    </main>
    <footer>
        <p>Footer de David</p>
        <a href="../index.html"><img src="../web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>
