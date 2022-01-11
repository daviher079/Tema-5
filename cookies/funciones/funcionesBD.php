<?php

require_once("./seguro/datosBD.php");

function buscaProductos()
{
    $array=null;
    try{
        $con= new PDO("mysql:host=".IP.";dbname=".BBDD,USER,PASS);
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql=$con->prepare("select * from producto");
        $sql->execute();

        $array =$sql->fetchAll();


    
    }catch(PDOException $ex)
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
        return $array;
        unset($con);
    }

}


function VerProducto($codigo)
{

    try{
        $array=array();
        $con= new PDO("mysql:host=".IP.";dbname=".BBDD,USER,PASS);
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql=$con->prepare("select * from producto where codigo =:codigo");
            
            $sql->bindParam(":codigo", $codigo);
            $sql->execute();

            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                array_push($array, $row['nombre'], $row['descripcion'], $row['alta']);
            }



    
    }catch(PDOException $ex)
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
        return $array;
        unset($con);
    }
}

?>