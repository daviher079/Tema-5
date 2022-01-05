<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>

    <title>Tienda Online</title>
</head>
<body>
    <?php
        require_once("./codigo/funcionesBD.php");
        crearBD();
    ?>   
    <header class="cabecera">
       <h1>Tienda Online</h1>
        <?php
            
            require_once "./codigo/validaSesion.php";
            
            //Comprobar que hay sesion
            
            session_start();
        
            if(validaSession()==false)
            {
                echo "<a href='./login.php'><img src='./web-root/img/userPR15-01.png' height='50px'></a>";
            }else
            {
                echo "<a href='./paginas/indexPerfil.php'><img src='./web-root/img/userPR15-01.png' height='50px'></a>";
            }
        
            //y sino te llevo al login y exit
            
        ?>
    </header>
    <main>
        <img class="fondo" src="./web-root/img/tshirt-gc9f1d4dee_1920.jpg">  
    </main>
        

    <footer>
        <p>Footer de David</p>
        <a href="../index.html"><img src="../web-root/img/volver.png" height="20px"></a>
    </footer>
</body>
</html>