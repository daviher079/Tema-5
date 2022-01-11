<?php

    require_once "../codigo/validaSesion.php";
    
    //Comprobar que hay sesion
    
    session_start();

    if(validaSession()==false)
    {
        header("location: ./403.php");  
    }elseif($_SESSION['perfil']=='USR01' || $_SESSION['perfil']=='MOD01')
    {
        header("location: ./403.php");
    }else
    {
        require_once("../seguro/datosBD.php");
        borrarAlbaran($_REQUEST['codigo']);
        
        header("location: ./mostrarAlbaranes.php");

    }

/**
 * Esta página recibe el id del albaran 
 * y la funcion se conecta a la base de datos para borrar el
 * albaran según su id
 */

function borrarAlbaran($id)
    {

        try
        {
            
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD, USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $preparada=$con->prepare("delete from albaran where idAlbaran=:id");
            $con->beginTransaction();

            $preparada->bindParam(":id", $id);
            $preparada->execute();

            $con->commit();
            $preparada->closeCursor();
        
        }
        catch(PDOException $e)
        {
            $con->rollBack();
            $numError = $e->getCode();

            // Si no existe la tabla... (nº error = 1146)
            if($numError == 1146)
            {
                echo "<p>La tabla no existe.</p>";
            }
            
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<p>No se reconoce la BBDD.</p>";
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


?>