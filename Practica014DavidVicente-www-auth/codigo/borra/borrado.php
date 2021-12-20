<?php
    require_once("../../segura/conexionBD.php");

    function dsn()
    {
        return "mysql:host=".IP.";dbname=".BBDD;
    }

    
    $id=intval($_REQUEST['id']);
    
    borrarRegistro($id);
    header("Location: ../../lecturaTabla.php");

    function borrarRegistro($id)
    {

        try
        {
            
            @$con=new PDO(dsn(), USER, PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $preparada=$con->prepare("delete from DATOSCLUB where id=:id");
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
?>