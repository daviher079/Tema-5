<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>

    <title>CRUD</title>
</head>
<body>
    <header>
        <img class="logo" src="./web-root/img/LogotipoDavidVicente.png"/>
        <h1>CRUD</h1>
    </header>
    <main>
    
        <div class="content">
            <div class="title">
                <h1>DWES</h1>
                <?php
                    require_once("./codigo/funcionesBD.php");
                    if(sizeof($_REQUEST)>0 && (isset($_REQUEST['crear']) || isset($_REQUEST['lectura']) || isset($_REQUEST['insertar'])))
                    {
                        
                        if($_REQUEST['crear']=='CrearBD')
                        {
                            crearBD();
                        }

                        if(isset($_REQUEST['lectura']) && $_REQUEST['lectura']=='LeerTabla')
                        {
                            header('Location: ./lecturaTabla.php');
                        }

                        if(isset($_REQUEST['insertar']) && $_REQUEST['insertar']=='InsertarRegistro')
                        {
                            header('Location: ./insertarRegistro.php');
                        }
                        
                    }
                ?>
                <form action="./index.php" method="post" name="formulario">
                    
                    <?php
                        //BUSCADOR // select * from clientes where nombre like '%me%';
                        $conexion = new mysqli();
                        @$conexion->connect(IP, USER, PASS, BBDD);

                        if ($conexion->connect_errno == 0) 
                        {
                            echo "<input type='submit' name='lectura' value='LeerTabla'>";
                            echo "<input type='submit' name='insertar' value='InsertarRegistro'>";
                        }else
                        {
                            compruebaErrores();

                        }  
                    ?>    
                    
                </form>

            </div>
        </div>  
        
        

    
           
        

    </main>
    <footer>
        <p>Footer de David</p>
        <a href="./verCodigo.php?ficheroPHP=<?php
            $pagina=basename($_SERVER['SCRIPT_FILENAME']);
            echo $pagina;
        ?>"><img src="./web-root/img/gafas-de-sol.png" height="100px"></a>
        <a href="../index.html"><img src="./web-root/img/volver.png" height="25px"></a>
    </footer>
</body>
</html>