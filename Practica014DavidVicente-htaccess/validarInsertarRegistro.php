<?php
    
    //Definicion de las constantes que contienen los patrones que comprueban si la cadena es correcta
    
    define("PATRONNOMBRE", '/^[A-Z]{1}[a-z]{2}/');
    define("PATRONFECHA", '/[0-9]{2}(-|\/)[0-9]{2}(-|\/)[0-9]{4}/');

    function validarFormulario(){
        $bandera=true;
        if(isset($_REQUEST['enviado']))
        {
            
            if(validarPuntos()==true && validarNombre()==true && validarMedia()==true && validarFecha()==true)
            {
                require_once("segura/conexionBD.php");
                function dsn()
                {
                    return "mysql:host=".IP.";dbname=".BBDD;
                }
                $puntos = intval($_REQUEST['puntos']);
                $nombre = strtoupper($_REQUEST['nombre']);
                $mediaGoles = floatval($_REQUEST['mediaGoles']);
                $fecha = "";

                if($_REQUEST['fecha'][2]=='/')
                {
                    $fecha = str_replace("/", "-", $_REQUEST['fecha']);
                }else
                {
                    $fecha=$_REQUEST['fecha'];        
                }
                
                $dat = date('Y-m-d', strtotime($fecha));

                try
                {
                    @$con=new PDO(dsn(), USER, PASS);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $preparada=$con->prepare("insert into DATOSCLUB values(ID,?,?,?,?)"); 
                    $con->beginTransaction();  
                    $arrayParametros=array($puntos, $nombre, $mediaGoles, $dat);
                    $preparada->execute($arrayParametros);
                    $con->commit();
                    
                    $preparado->closeCursor();
            
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
            else{
                
                $bandera = false;
            }     
        } else
        {
            $bandera= false;
        }
        
        return $bandera;
    }

    /*
        Comprueba que el campo no este vacio y se haya enviado algo en el formulario
        Se añade la funcion dentro del campo value en el apartado de html
    */

    function recordarGenerico($var){
        if(!empty($_REQUEST[$var])&& isset($_REQUEST['enviado']))
        {
            echo $_REQUEST[$var];        
        }
    }

    /*
        Se ejecuta cuando el input esta vacio para avisar al usuario que ese campo debe rellenarlo 
    */
    
    function comprobarGenerico($var){
        if(empty($_REQUEST[$var]) && isset($_REQUEST['enviado'])){
            
            echo "<label>Debe haber un campo ".$var."</label>";
        }           
    }

    /*
        A esta funcion se le pasa un patrón y la cadena que tiene que validar se ejecuta dos veces
        en el codigo una cada vez que se valida un campo y otra en cada input para informar al usuario 
        de las caracteristicas que debe cumplir ese campo 
    */

    function expresionGenerico($patron, $var){
        
        $bandera=true;

        if(!empty($var) && isset($_REQUEST['enviado']) && preg_match($patron, $var)==false)
        {
            $bandera=false;
        }

        return $bandera;
    }

    /*
        Comprueba si el formulario ha sido enviado, si el input nombre ha sido envidado y si cumple 
        las caracteristicas de la expresion regular 
    */

    function validarPuntos()
    {
        $bandera=true;
        if(!empty($_REQUEST['puntos']) && isset($_REQUEST['enviado']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }
    
    function validarNombre()
    {
        
        $bandera=true;
        if(!empty($_REQUEST['nombre']) && isset($_REQUEST['enviado']) && expresionGenerico(PATRONNOMBRE, $_REQUEST['nombre'])==true)
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    function validarMedia()
    {
        $bandera=true;
        if(!empty($_REQUEST['mediaGoles']) && isset($_REQUEST['enviado']))
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

    /*
        Comprueba si el formulario ha sido enviado, si el input fecha ha sido envidado y si cumple 
        las caracteristicas de la expresion regular 
    */

    function validarFecha()
    {
        $bandera=true;
        
        if(!empty($_REQUEST['fecha']) && isset($_REQUEST['enviado']) && expresionGenerico(PATRONFECHA, $_REQUEST['fecha'])==true)
        {
            $bandera=true;    
        }
        else
        {
            $bandera=false;
        }
        return $bandera;
    }

?>
