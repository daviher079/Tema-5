<?php
//recuperar los datos para conectarse a la base de datos
require_once("./seguro/datosBD.php");


/*
    Funcion para crear la base de datos la primera vez que carga va a dar error 
    porque no va a encontrar la base de datos por lo tanto entrará por el numero de 
    error 1049 y se ejecutará la funcion flie_get_contents para ejecutar el script que 
    creará la base de datos
*/
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


/*
    Esta función se ejecutará en el index.php para mostrar todos los productos que
    hay en la base de datos se crea un array asociativo que será donde se almacenan todos 
    los productos usando el codigo de producto como key y añadiendo todos sus datos dentro
    de cada array que ha generado su key. Devuelve el array asociativo
*/

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