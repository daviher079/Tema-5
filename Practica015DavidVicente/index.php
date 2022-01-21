<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>

    <style>
        .listaDatos
        {
            width: 100%;
            height: 40px;
            list-style: none;
            color: transparent;
        }


        .listaDatos:hover
        {
            color: #d02b4d;
            background-color: rgba(99, 99, 99, 0.404);
            padding: 5px;
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
        
            echo "<div class='user'>";
            if(validaSession()==false)
            {
                echo "<a href='./login.php'><img src='./web-root/img/userPR15-01.png' height='50px'></a>";
            }else
            {
                echo "<h2>".$_SESSION['nombre']."</h2>";
                echo "<a href='./paginas/indexPerfil.php'><img src='./web-root/img/userPR15-01.png' height='50px'></a>";
            }
            echo "</div>";
        
            
            
        ?>
    </header>
    <main>
        <img class="fondo" src="./web-root/img/tshirt-gc9f1d4dee_1920.jpg"> 
        <div class="container">
            <div class="productos">

                <?php
                    $array=mostrarProductos();
                    
                    foreach ($array as $key => $value) {
                        if($value['imagenBaja']!="")
                        {
                            echo "<a class='enlaces' href='./paginas/comprarProducto.php?codigo=".$key.
                            "&descripcion=".$value['descripcion']."&precio=".$value['precio'].
                            "&stock=".$value['stock']."&imagen=".$value['imagenAlta']."'>
                                <div class='producto' style='background-image: url(./web-root/imgBajas/".$value['imagenBaja']."); background-size: 100% 100%; background-repeat: no-repeat; color: #d02b4d'>". 
                                    "<ul class='listaDatos'>".
                                    "<li>".$value['precio']."€</li>".
                                    "<li>".$value['descripcion']."</li>".
                                "</div>
                            </a>";
                        }else
                        {
                            echo "<a class='enlaces' href='./paginas/comprarProducto.php?codigo=".$key.
                            "&descripcion=".$value['descripcion']."&precio=".$value['precio'].
                            "&stock=".$value['stock']."'>
                                <div class='producto'>". 
                                    $value['precio']."€</br>".
                                    $value['descripcion']."
                                </div>
                            </a>";

                        }
                        //style="background-image: url('/assets/img/fondo-cabecera.jpg'); width: 100; height: 100; "
                    
                    }
                ?>
            </div>

            <div class="visitas">
                <h2>Ultimas Visitas</h2>
                <?php
                    if(isset($_COOKIE['visitado']))
                    {
                        $arrayProductosVisitados = $_COOKIE['visitado'];
                        echo "<ul>";
                        foreach ($arrayProductosVisitados as $key => $value) {
                    
                            $arrayDatosProducto=VerProducto($value);
                            echo  "<li><a class='prVisitado' href='./paginas/comprarProducto.php?codigo=".$arrayDatosProducto[0].
                        "&descripcion=".$arrayDatosProducto[1]."&precio=".$arrayDatosProducto[2].
                        "&stock=".$arrayDatosProducto[3]."'>".$arrayDatosProducto[1]."</a></li>";
        
                        }
                        echo "</ul>";
                    }
                ?>
            </div>
        </div>
    </main>
        

    <footer>
        <p>Footer de David</p>
        <a href="../index.html"><img src="./web-root/img/volver.png" height="20px"></a>
    </footer>


</body>
</html>