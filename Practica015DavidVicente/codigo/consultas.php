<?php

/*
    Funcion que valida si el formulario de login ha sido correcto
    inicia la sesión y se carga en la variable superglobal si la sesion
    está validada el usuario el nombre del usuario y su perfil todo esto 
    rescatandolo antes de la base de datos
*/
function valida()
{
    if(isset($_REQUEST['valida']))
    {
    
        try
        {
            $user = $_REQUEST['user'];
            $pass = $_REQUEST['pass'];
            $con= new PDO("mysql:host=".IP.";dbname=".BBDD,USER,PASS);
            $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql=$con->prepare("select * from usuarios where usuario = :user and clave = :pass");
            
            $sql->bindParam(":user", $user);
            $encrip = sha1($pass);
            //Se encripta la contraseña para compararla con la qu exista en la base de datos
            $sql -> bindParam(":pass", $encrip);
            $sql->execute();


            if($sql->rowCount()==1)
            {

                session_start();
                //super SESSION nombre, usuario, perfil

                $row=$sql->fetch();
                //En el fetch se almacena el contenido que devuelve la sentencia despues de 
                //ser ejecutada

                if(($row["usuario"]==$user) && ($row["clave"]==$encrip))
                {
                    $_SESSION['validada'] = true;
                    $_SESSION["usuario"] = $row["usuario"];
                    $_SESSION["nombre"] = $row["nombre"];
                    $_SESSION["perfil"] = $row["perfil"];
                    
                    //Páginas a las que tiene acceso
                    $sqlp = $con->prepare("select descripcion, url 
                    from paginas p join accede a on (p.codigo = a.codigoPagina)
                    where codigoPerfil = :perfil");
    
                    $sqlp->bindParam(":perfil", $_SESSION["perfil"]);
                    $sqlp->execute();
    
                    $paginas=array();
                    while($row=$sqlp->fetch())
                    {
                        $paginas[$row[0]]=$row[1];
                    }
                    $_SESSION['paginas']=$paginas;

                    unset($con);
                    return true;
                }else
                {
                    unset($con);
                    return false;
                }
                
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
            unset($con);
        }
    }
}


//funcion que nos lleva a la pagina del formulario

function crearFormulario()
{
    if(isset($_REQUEST['crearCuenta']))
    {

        header("Location: ./paginas/crearCuenta.php");
    }
}

?>