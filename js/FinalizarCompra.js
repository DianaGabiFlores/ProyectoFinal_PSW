var Part1 = document.getElementById("form1"); 
var Part2 = document.getElementById("form2");
var Part3 = document.getElementById("form3"); 

var Next1 = document.getElementById("Next1");
var Next2 = document.getElementById("Next2");
var Back1 = document.getElementById("Back1");
var Back2 = document.getElementById("Back2");
var Editar = document.getElementById("editar");

var form_2_progressbar = document.querySelector(".form_2_progressbar");
var form_3_progressbar = document.querySelector(".form_3_progressbar");

var Validar = document.getElementById("ValidarCupon"); 
var paises = document.getElementsByClassName("paises");

const cupones = ["BIENVENIDA15", "DULCE2024", "NAVIDULCE30"];
const cuponesDescuento = [15, 20, 30];
var precioNeto;

Next1.onclick = function(){
    var name = document.getElementById("Nombre_Completo");
    var correo = document.getElementById("Correo");
    var direccion = document.getElementById("Direccion");
    var codigo = document.getElementById("CodigoPostal");
    var ciudad = document.getElementById("Ciudad");
    var numero = document.getElementById("NumeroTelefonico");
    var pais = document.getElementById("Pais").value;

    var Impuestos = document.getElementById("Impuestos");
    var GastosE = document.getElementById("GastosE");

    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var EstaCorrecto = false; 
    // var EstaCorrecto = true; 
    var GastosDeEnvio = 0; 
    var boolGastosDeEnvio = true; 

    if (name.value.length !== 0) {
        if(numero.value.length === 10 ){
            if(direccion.value.length !== 0 ){
                if(codigo.value.length === 5 ){
                    if(ciudad.value.length !== 0 ){
                        if (correo.value.match(validRegex)) {
                            EstaCorrecto = true; 
                        }
                    }
                }
            } 
        }
    }
    if(EstaCorrecto){
        Part1.style.left = "-1100px"; 
        Part2.style.left = "10%"; 
        form_2_progressbar.classList.add("active"); 

        name.readOnly = true; 
        correo.readOnly = true; 
        direccion.readOnly = true; 
        codigo.readOnly = true; 
        ciudad.readOnly = true; 
        numero.readOnly = true;
        document.getElementById("Pais").readOnly = true; 
        document.getElementById("totalAbsoluto").innerHTML = precioTotal;

        for(const paiss of paises){
            paiss.innerHTML = pais; 
        }

        var impuestoNeto = document.getElementById("impuestoNeto");
        var gastosNeto = document.getElementById("gastosNeto"); 
        var impues; 
        if(precioTotal > 350){
            GastosE.value = "$"+0
            gastosNeto.innerHTML = 0;
            document.getElementById("GastoEnvioPorque").innerHTML = "¡Tu envío es gratis! Has comprado más de $350 pesos en productos.";
            boolGastosDeEnvio = false; 
        }
        if(pais === "México"){
            impues = 0.16; 
            GastosDeEnvio = 90; 
        }else if(pais === "Estados Unidos"){
            impues = 0.19; 
            GastosDeEnvio = 200; 
        }else{
            impues = 0.24; 
            GastosDeEnvio = 350; 
        }
        impues = (precioTotal * impues).toFixed(2);
        Impuestos.value = "$"+impues;
        impuestoNeto.innerHTML = impues; 
        if(boolGastosDeEnvio){
            GastosE.value = "$"+GastosDeEnvio;
            gastosNeto.innerHTML = GastosDeEnvio;
        }else{
            GastosDeEnvio = 0; 
        }
        precioNeto = (Number(precioTotal) + Number(GastosDeEnvio) + Number(impues)).toFixed(2); 
        document.getElementById("totalNeta").innerHTML = precioNeto;
    }else if(!EstaCorrecto){
        Swal.fire({
            icon: "question",
            title: "¡Han faltado campos!",
            text: "Vuelve a revisar tus datos una vez más",
            background: "#fff",
        });   
    }
}

Back1.onclick = function(){
    Part1.style.left = "10%"; 
    Part2.style.left = "1100px"; 
    form_2_progressbar.classList.remove("active");
}

Next2.onclick = function(){
    Part2.style.left = "-1100px"; 
    Part3.style.left = "10%"; 
    form_3_progressbar.classList.add("active");
}

Back2.onclick = function(){
    Part2.style.left = "10%"; 
    Part3.style.left = "1100px"; 
    form_3_progressbar.classList.remove("active");
}

Validar.onclick = function(){
    var cupon = document.getElementById("Cupon");
    var texto = "Por el momento este cupón no está disponible"; 
    for(let i=0; i<3; i++){
        if(cupones[i] == cupon.value){
            if(i == 0){
                if(ComprasHechas === true){
                    texto = "Este cupón solo es válido para tu primer compra";
                    break;  
                }
            }
            cupon.readOnly = true; 
            document.getElementById("cuponDescuento").innerHTML = "Tu descuento es del "+cuponesDescuento[i]+"%";
            var precioCupon = (precioTotal * (cuponesDescuento[i]/100)).toFixed(2); 
            document.getElementById("cuponNeto").innerHTML = precioCupon;
            precioNeto = (Number(precioNeto) - Number(precioCupon)).toFixed(2); 
            document.getElementById("cuponValor").value = precioCupon;
            document.getElementById("totalNeta").innerHTML = precioNeto;    
            break; 
        }
    }
    if(document.getElementById("cuponDescuento").innerHTML.length == 0){
        cupon.value = "";
        Swal.fire({
        icon: "question",
        title: "¡No es correcto!",
        text: texto,
        background: "#fff",
        })          
    }
}

Editar.onclick = function(){
    document.getElementById("Nombre_Completo").readOnly = false; 
    document.getElementById("Correo").readOnly = false; 
    document.getElementById("Direccion").readOnly = false;
    document.getElementById("CodigoPostal").readOnly = false; 
    document.getElementById("Ciudad").readOnly = false; 
    document.getElementById("NumeroTelefonico").readOnly = false;
    document.getElementById("Pais").readOnly = false;
}

var TipoDe = document.querySelectorAll('input[name="TipoDePago"]'); 

for (const banco of TipoDe) {
    banco.addEventListener('click', function(){
        quitarborde();
        quitarblancoyNegro();
        ponerfondo();
        opciones();
    });
}

function check() {
    var bank =  document.querySelector('input[name=TipoDePago]:checked').value;
    return bank;
}
function ponerfondo(){
    datos = check();
    misdatos=datos+"1"; 
    var select = document.getElementById(misdatos); 
    select.style.outline="2px solid #d8006c"; 
    document.querySelector('img[class='+datos+']').style.filter = 'grayscale(100%)';
}
function quitarborde(){
    var selected = document.getElementsByClassName('labelB'); 
    for(const sel of selected){
        sel.style.outline="none"; 
    }
}

function quitarblancoyNegro(){
    var selected = document.querySelectorAll(".labelB img"); 
    for(const sel of selected){
        sel.style.filter = 'none';; 
    }
}

function opciones(){
    datos = check();
    if(datos === "BBVA"){
        displayStyle("block", "none", true);
        var oxxo = document.getElementsByClassName("formBanco");
        oxxo[0].classList.remove("nuevoDiseño");
    }else if(datos === "Santander"){
        displayStyle("block", "none", true);
        var oxxo = document.getElementsByClassName("formBanco");
        oxxo[0].classList.add("nuevoDiseño");
    }else if(datos === "OXXO"){
        displayStyle("none", "block", false);
    }
}

function displayStyle(first, second, bool){
    var Bname = document.getElementById("Bname"); 
    var Btarjeta = document.getElementById("Btarjeta"); 
    var Bfecha = document.getElementById("Bfecha"); 
    var Bseguridad = document.getElementById("Bseguridad"); 
    var oxxo = document.getElementsByClassName("formBanco");
    oxxo[0].style.display = first;  
    var optionOxxo = document.getElementsByClassName("optionOxxo");
    optionOxxo[0].style.display = second;
    Bname.required = bool;
    Btarjeta.required = bool;
    Bfecha.required = bool;
    Bseguridad.required = bool;
}


