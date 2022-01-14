window.addEventListener("load", iniciar);

//objeto de Ajax
var miXHR;
function iniciar() {
	var boton = document.getElementById("deseo");
    boton.addEventListener("click", ajax, false);
    //false no puede llamar a un evento dentro 
}

function ajax() {
    // Creamos un objeto XHR.
    miXHR = new XMLHttpRequest();
    enviar();

}

function enviar() {
    if (miXHR) {
        //Si existe el objeto miXHR
        var url = '../paginas/validarListadeDeseos.php';

        miXHR.open('POST', url, true); 
        //Abrimos la url, true=ASINCRONA

        // En cada cambio de estado(readyState) se llamará a la función estadoPeticion
        miXHR.onreadystatechange = estadoPeticion;
        miXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var codigo = document.getElementById("codigo").value
        var boton = document.getElementById("deseo");
        if(boton.checked==true)
        {
            miXHR.send("codigo = " + codigo+"&accion=true");

        }else
        {
            miXHR.send("codigo = " + codigo+"&accion=false");
        }

    }
}


function estadoPeticion() {
    if(this.readyState == 4) {
            if (this.status == 200) {            
                document.getElementById("deseo").checked = true;
            }           
    }
}