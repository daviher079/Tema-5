<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="./web-root/css/style.css"/>
    <title>Lectura Tabla</title>
    
</head>
<body>
    <header>
    <img class="logo" src="./web-root/img/LogotipoDavidVicente.png"/>
        <h1>Lectura Tabla</h1>
    </header>
    <main>
    
        <div class="content">
            <div class="title">
                <h1>DWES</h1>
                <?php
                    require_once("./codigo/funcionesBD.php");
                ?>
                <form action="lecturaTabla.php" method="post">
                    
                    <section class="cabecera">
                        <label for="buscador">Buscador</label>
                        <input type="text" name="buscador" size="30" placeholder="Buscar" id="buscador">
                        <input type="submit" name="Buscar" value="Buscar">
                        <input type="submit" name="insertar" value="InsertarRegistro">
                    </section>
                    

                <?php
                
                if(sizeof($_REQUEST)>0 && (isset($_REQUEST['insertar']) || isset($_REQUEST['Buscar'])))
                {
        
                    if(isset($_REQUEST['insertar']) && $_REQUEST['insertar']=='InsertarRegistro')
                    {
                        header('Location: ./insertarRegistro.php');
                    }
        
                    if(isset($_REQUEST['Buscar']) && $_REQUEST['Buscar']=='Buscar')
                    {

                        filtrado($_REQUEST['buscador']);
                        
                        
                    }
                    
                }else
                {
                    lectura();
                }
                ?>
                    <a href="./index.php" ><img src="./web-root/img/volver.png" height="30px" style="margin-top:30px"></a>
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
    </footer>
</body>
</html>