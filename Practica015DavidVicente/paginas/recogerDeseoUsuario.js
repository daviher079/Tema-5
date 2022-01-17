window.addEventListener("load", iniciar);
var accion = false;

//objeto de Ajax
var miXHR;
function iniciar() {
	var boton = document.getElementById("deseo");
    //boton.checked=localStorage.getItem('accion');
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
        var url = './validarListadeDeseos.php';

        miXHR.open('POST', url, true); 
        //Abrimos la url, true=ASINCRONA

        // En cada cambio de estado(readyState) se llamará a la función estadoPeticion
        miXHR.onreadystatechange = estadoPeticion;
        miXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var codigo = document.getElementById("codigo").value
        var boton = document.getElementById("deseo");
        if(boton.checked==true)
        {
            accion=true
            miXHR.send("codigo="+codigo+"&accion="+accion);
            localStorage.setItem('accion', accion);

        }else
        {
            accion =false;
            localStorage.setItem('accion', accion);
            miXHR.send("codigo="+codigo+"&accion="+accion);
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