<?php


if(isset($_POST['accion']))
    {

        if($_POST['accion']=="true")
        {
            addDeseo($_POST['codigo']);
        }else
        {
            deleteDeseo($_POST['codigo']);
        }

    }

function addDeseo()
{
    if(isset($_POST['codigo']))
    {
        session_start();
        $codigo = $_POST['codigo'];
        $usuario = $_SESSION['usuario'];

        if(!isset($_COOKIE[$usuario]))
        {
            setcookie($usuario.'[0]',$codigo, time()+31536000, "/" );
            //setcookie('visitado['.$key.']',$value, time()+31536000, "/");
            $prueba =0;
            echo $prueba;
        }else
        {
            $arrayDeseos=$_COOKIE[$usuario];
            array_unshift($arrayDeseos, $codigo);

            foreach ($arrayDeseos as $key => $value) {
                setcookie($usuario.'['.$key.']',$value, time()+31536000, "/" );
            }

        }
    }
}

function deleteDeseo()
{
    if(isset($_POST['codigo']))
    {
        session_start();
        $codigo = $_POST['codigo'];
        $usuario = $_SESSION['usuario'];
        $arrayDeseos=$_COOKIE[$usuario];
        if(in_array($codigo, $arrayDeseos))
        {
            foreach ($arrayDeseos as $key => $value) {
                if($codigo==$value)
                {
                    setcookie($usuario.'['.$key.']',$value, time()-31536000, "/" );
                }
            }
        }
    }
}


//Para saber si el codigo del producto esta dentro
//de la cookie con in_array() si esta hay que pasarle el codigo y 
//darle a setcookie un valor negativo

//Si es false buscar en que posicion del array y borrarlo

require_once("../seguro/datosBD.php");

function VerProducto($codigo)
{

    try{
        $array=array();
        $con= new PDO("mysql:host=".IP.";dbname=".BBDD,USER,PASS);
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql=$con->prepare("select * from productos where codigoProducto =:codigo");
            
            $sql->bindParam(":codigo", $codigo);
            $sql->execute();

            if($sql->rowCount()==1)
            {
                $row=$sql->fetch();
                array_push($array, $row['codigoProducto'], $row['descripcion'], $row['precio'], $row['stock']);
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