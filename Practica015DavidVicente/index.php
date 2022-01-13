<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>

    <style>
        .container
        {
            display: flex;
        }

        .productos
        {
            padding: 25px;
            display: flex;
            flex-wrap: wrap;
            float: left;
            width: 70%;
        }

        .visitas
        {
            float: right;
            width: 30%;  
            padding: 25px;
        }

        .visitas h2
        {
            color: #d02b4d;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 1.9em;
            display: inline-block;
        }

    </style>


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
            
            session_start();
        
            if(validaSession()==false)
            {
                echo "<a href='./login.php'><img src='./web-root/img/userPR15-01.png' height='50px'></a>";
            }else
            {
                echo "<a href='./paginas/indexPerfil.php'><img src='./web-root/img/userPR15-01.png' height='50px'></a>";
            }
        
            
            
        ?>
    </header>
    <main>
        <img class="fondo" src="./web-root/img/tshirt-gc9f1d4dee_1920.jpg"> 
        <div class="container">
            <div class="productos">

                <?php
                    $array=mostrarProductos();
                    
                    foreach ($array as $key => $value) {
                        
                        echo "<a class='enlaces' href='./paginas/comprarProducto.php?codigo=".$key.
                        "&descripcion=".$value['descripcion']."&precio=".$value['precio'].
                        "&stock=".$value['stock']."'><div class='producto'>".$value['precio']."€</br>".
                        $value['descripcion']."</div></a>";
                    }
                ?>
            </div>

            <div class="visitas">
                <h2>Ultimas Visitas</h2>
            </div>
        </div>
    </main>
        

    <!--<footer>
        <p>Footer de David</p>
        <a href="../index.html"><img src="./web-root/img/volver.png" height="20px"></a>
    </footer>-->
</body>
</html>