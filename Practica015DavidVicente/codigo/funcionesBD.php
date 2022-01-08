<?php

require_once("./seguro/datosBD.php");

function crearBD()
{

    try
    {
        
        $con=new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
        
    }
    catch(PDOException $e)
    {
        $numError = $e->getCode();
        
        // Error al no reconocer la BBDD
        if($numError == 1049)
        {
            //echo "<p>No se reconoce la BBDD.</p>";
            $con=new PDO("mysql:host=".IP, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $commands = file_get_contents("./seguro/tiendaOnline.sql");
            $con->exec($commands);
        }
        
        // Si no existe la tabla... (nº error = 1146)
        if($numError == 1146)
        {
            echo "<p>La tabla no existe.</p>";
        }
        
        // Error al conectar con el servidor...
        else if($numError == 2002)
        {
            echo "<p>Error al conectar con el servidor.</p>";
        }
        // Error de autenticación...
        else if($numError == 1045)
        {
            echo "<p>Error en la autenticación.</p>";
        }
    }finally
    {
        unset($con);
    }
    
    
}

function mostrarProductos()
{
    try
    {
        $arrayProductos=array();
        $con=new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql=$con->prepare("select * from productos;");
        $sql->execute();

        while ($row =$sql->fetch()) {
            $arrayProductos[$row[0]]=array();
            $arrayProductos[$row[0]]['descripcion']=$row[1];
            $arrayProductos[$row[0]]['precio']=$row[2];
            $arrayProductos[$row[0]]['stock']=$row[3];
        }

    }
    catch(PDOException $ex)
    {
        $numError = $ex->getCode();
        
        // Error al no reconocer la BBDD
        if($numError == 1049)
        {
            echo "<p>No se reconoce la BBDD.</p>";
        }
        
        // Si no existe la tabla... (nº error = 1146)
        if($numError == 1146)
        {
            echo "<p>La tabla no existe.</p>";
        }
        
        // Error al conectar con el servidor...
        else if($numError == 2002)
        {
            echo "<p>Error al conectar con el servidor.</p>";
        }
        // Error de autenticación...
        else if($numError == 1045)
        {
            echo "<p>Error en la autenticación.</p>";
        }
    }
    finally
    {
        unset($con);
    }
    return $arrayProductos;
}


?>