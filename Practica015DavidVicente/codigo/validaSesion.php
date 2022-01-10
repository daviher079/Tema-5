<?php
/**
 * Funcion que comprueba si existe en la variable superglobal
 * session si el usuario ha validado la sesion devuelve true sino false
 */
    function validaSession()
    {
        if(isset($_SESSION['validada']))
        {
            return true;
        }else
        {
           return false;
        }
    }


    function validaPagina($pagina)
    {
        if(in_array($pagina, $_SESSION['paginas'])){
            return true;
        }else
        {
            return false;
        }
    }

?>