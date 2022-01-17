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

        $codigo = $_POST['codigo'];
        $nombre = $_SESSION['nombre'];

        if(!isset($_COOKIE[$nombre]))
        {
            setcookie($nombre.'[0]',$codigo, time()+31536000, "/" );
        }else
        {
            $arrayDeseos=$_COOKIE[$nombre];
            array_unshift($arrayDeseos, $codigo);

            foreach ($arrayDeseos as $key => $value) {
                setcookie($nombre.'['.$key.']',$value, time()+31536000, "/" );
            }

        }
    }
}

function deleteDeseo()
{
    if(isset($_POST['codigo']))
    {
        $codigo = $_POST['codigo'];
        $nombre = $_SESSION['nombre'];
        $arrayDeseos=$_COOKIE[$nombre];
        if(in_array($codigo, $arrayDeseos))
        {
            foreach ($arrayDeseos as $key => $value) {
                if($codigo==$value)
                {
                    setcookie($nombre.'['.$key.']',$value, time()-31536000, "/" );
                }
            }
        }
    }
}


//Para saber si el codigo del producto esta dentro
//de la cookie con in_array() si esta hay que pasarle el codigo y 
//darle a setcookie un valor negativo

//Si es false buscar en que posicion del array y borrarlo




?>