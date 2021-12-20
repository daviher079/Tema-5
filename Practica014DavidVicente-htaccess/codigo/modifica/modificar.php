<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../web-root/css/resetCSS.css"/>
    <link rel="stylesheet" href="../../web-root/css/style.css"/>
    <title>Modificar Registro</title>
</head>
<body>
    <header>
        <img class="logo" src="../../web-root/img/LogotipoDavidVicente.png"/>
        <h1>Modificar Registro</h1>
    </header>
    <main>
    
        <div class="content">
            <div class="title">
                <h1>DWES</h1>

                <form action="modificar.php" method="post">
                    <?php
                        require_once("../../segura/conexionBD.php");
  
                        function dsn()
                        {
                            return "mysql:host=".IP.";dbname=".BBDD;
                        }

                        try
                        {
                            if(isset($_REQUEST['id']))
                                $id=intval($_REQUEST['id']);


                            @$con=new PDO(dsn(), USER, PASS);
                            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $preparado=$con->prepare("select * from DATOSCLUB where ID=:id");
                            
                    
                            $preparado->bindParam(":id",$id);
                    
                            $preparado->execute();
                            
                            while($row=$preparado->fetch(PDO::FETCH_ASSOC))
                            {
                                echo "<input type='hidden' name='prueba' value='".$row['ID']."'>";
                                echo "<input type='number' id='puntos' name='puntos' value='".$row['PUNTOS']."'>";
                                echo "<input type='number' id='mediaGoles' name='mediaGoles' value='".$row['MEDIA_GOLES']."' step='0.25'>";
                                echo "<input type='text' id='nombre' name='nombre' value='".$row['NOMBRE']."'>";
                                echo "<input type='date' id='fecha' name='fecha' value='".$row['FECHA']."'>";
                            }
                              
                            
                            
                            $preparado->closeCursor();
                    
                        }
                        catch(PDOException $e)
                        {
                            $numError = $e->getCode();
                    
                            // Si no existe la tabla... (nº error = 1146)
                            if($numError == 1146)
                            {
                                echo "<br>La tabla no existe.<br>";
                            }
                            
                            // Error al no reconocer la BBDD
                            if($numError == 1049)
                            {
                                echo "<br>No se reconoce la BBDD.<br>";
                            }
                            // Error al conectar con el servidor...
                            else if($numError == 2002)
                            {
                                echo "<br>Error al conectar con el servidor.<br>";
                            }
                            // Error de autenticación...
                            else if($numError == 1045)
                            {
                                echo "<br>Error en la autenticación.<br>";
                            }
                        }finally
                        {
                            unset($con);
                        }
                    ?>

                    <section id="botones" style="margin-top:35px;">
                        <input type="submit" name="boton" value="Modificar">
                        <a href="../../lecturaTabla.php"><img src="../../web-root/img/volver.png" height="30px"></a>
                    </section>
                </form>    

                <?php
                    if(sizeof($_REQUEST)>0 && isset($_REQUEST['boton']))
                    {
                        if($_REQUEST['boton']=='Modificar')
                        {
                            try
                            {
                                @$con=new PDO(dsn(), USER, PASS);
                                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $preparada=$con->prepare("update DATOSCLUB 
                                set PUNTOS = ?, 
                                NOMBRE = ?, 
                                MEDIA_GOLES = ?, 
                                FECHA = ? 
                                WHERE ID = ?");
                                $con->beginTransaction();

                                $puntos=$_REQUEST['puntos'];
                                $nombre=$_REQUEST['nombre'];
                                $mediaGoles=$_REQUEST['mediaGoles'];
                                $fecha=$_REQUEST['fecha'];
                                $id=$_REQUEST['prueba'];

                                $arrayParametros=array($puntos, $nombre, $mediaGoles, $fecha, $id);
                                $preparada->execute($arrayParametros);    

                                $con->commit();
                                $preparado->closeCursor();
                                
                                header('Location: ../../lecturaTabla.php');
                            }
                            catch(PDOException $e)
                            {

                                $con->rollBack();
                                $numError = $e->getCode();
                        
                                // Si no existe la tabla... (nº error = 1146)
                                if($numError == 1146)
                                {
                                    echo "<br>La tabla no existe.<br>";
                                }
                                
                                // Error al no reconocer la BBDD
                                if($numError == 1049)
                                {
                                    echo "<br>No se reconoce la BBDD.<br>";
                                }
                                // Error al conectar con el servidor...
                                else if($numError == 2002)
                                {
                                    echo "<br>Error al conectar con el servidor.<br>";
                                }
                                // Error de autenticación...
                                else if($numError == 1045)
                                {
                                    echo "<br>Error en la autenticación.<br>";
                                }
                            }finally
                            {
                                unset($con);
                            }
                        }
                    }
                ?>   
        
            </div>
        </div>  
        
    </main>

   
    <footer>
        <p>Footer de David</p>
        <a href="verCodigo.php?ficheroPHP=<?php
            $pagina=basename($_SERVER['SCRIPT_FILENAME']);
            echo $pagina;
        ?>"><img src="../../web-root/img/gafas-de-sol.png" height="100px"></a>
    </footer>
</body>
</html>