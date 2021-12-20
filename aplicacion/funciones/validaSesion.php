<?php
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