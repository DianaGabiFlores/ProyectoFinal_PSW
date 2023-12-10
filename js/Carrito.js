
var Check = document.getElementsByClassName("check");

for( let i=0; i<Check.length; i++){
    Check[i].addEventListener('click', function(){
        var precio = Number(document.getElementById("precio"+i).innerHTML);
        var preciototal = Number(document.getElementsByClassName("total")[0].innerHTML);
        if(Check[i].checked){
            final = preciototal + precio;
        }else{
            final = preciototal - precio;
        }
        document.getElementsByClassName("total")[0].innerHTML = Number(final).toFixed(2);
        document.getElementsByClassName("totalinput")[0].value = Number(final).toFixed(2);
    })
}

var total_Boton = document.getElementsByClassName("total")[0];
var finalizar = document.getElementById("Finalizar");

finalizar.addEventListener('click', event => {
    var total_Boton = document.getElementsByClassName("total")[0];
    if(total_Boton.innerHTML == 0.00){
        event.preventDefault();
    }
});

var Borrar = document.querySelectorAll('button[name="delete"]');
var usuario = document.getElementById('usuario').innerHTML;

for (let j=0; j<Borrar.length; j++) {
    Borrar[j].addEventListener('click', function(){
        var id = document.getElementById('elegido'+j).value;
        var sql = "DELETE FROM Carrito WHERE IdProducto ="+id+" AND usuario='"+usuario+"';";

        misdatos="sql="+sql;
        // console.log(misdatos);

        var envio = new XMLHttpRequest();        
        envio.open("GET","Funcion_Carrito.php?"+misdatos, true);  
        envio.onreadystatechange=function(){
            if (envio.readyState == 4 && envio.status == 200){
                location. assign('carrito.php');
            }
        }
        envio.send();
    });
}
