//var URL_BASE = "/revista/proyecto/";
var URL_BASE = "http://e-navarro.com.ve/";
var array_numeros = new Array();

var cont = 0;
var str_param = "";

campo = new Object();
var paises = [];
var formdata = new FormData();

campo.autor = -1;

$(document).on("ready", function(){  


     $( "#tabs" ).tabs();
     
     $( "#tabs" ).tabs({ active: 0 });
     
     Inicializar();
    
    $("#btn_siguiente").click(function(){
        var index = $( "#tabs" ).tabs( "option", "active" );
        var tam = $('#tabs >ul >li').size();
        if(index < tam-1){index++;}
        $( "#tabs" ).tabs({ active: index });
    });
    
    $("#btn_anterior").click(function(){
        var index = $( "#tabs" ).tabs( "option", "active" );
        if(index > 0){index--;}
        $( "#tabs" ).tabs({ active: index });
    });
    
    $("#btn_enviar").click(function(){
        if(array_numeros.length > 0){
            
            if(validarDatos(array_numeros.length)){
                //uploadData();
                $("#progressBar").show();
                subirDatos();
            }
        }
        else
            alert("no hay autores");
    });
    
    
    
    $("#btn_cargar_autor").click(function(){
        if(campo.autor == -1){
            if(array_numeros.length == 0){
                agregar_campos(cont);
            }else{
                cont++;
                agregar_campos(cont);
            }
        }
    });

      
    $("#btn_add").click(function(){
        cont++;
        agregar_campos(cont);
        
    });
    
    cargarRevistas('#revista');
    cargarMaterias('#materia');
    cargarIdiomas('#idioma');
    
    $("#msj_cargar_autor").hide();
    $("#progressBar").hide();
    
 
});



$.fn.upload = function(remote,data,successFn,progressFn) {
        // if we dont have post data, move it along
        if(typeof data != "object") {
                progressFn = successFn;
                successFn = data;
        }
        return this.each(function() {
                if($(this)[0].files[0]) {
                        //var formData = new FormData();
                        //formData.append($(this).attr("name"), $(this)[0].files[0]);
                        formdata.append($(this).attr("name"), $(this)[0].files[0]);
                        // if we have post data too
                        
                        /*if(typeof data == "object") {
                                for(var i in data) {
                                        formData.append(i,data[i]);
                                }
                        }*/

                        // do the ajax request
                        $.ajax({
                                url: remote,
                                type: 'POST',
                                xhr: function() {
                                        myXhr = $.ajaxSettings.xhr();
                                        if(myXhr.upload && progressFn){
                                                myXhr.upload.addEventListener('progress',function(prog) {
                                                        var value = ~~((prog.loaded / prog.total) * 100);

                                                        // if we passed a progress function
                                                        if(progressFn && typeof progressFn == "function") {
                                                                progressFn(prog,value);

                                                        // if we passed a progress element
                                                        } else if (progressFn) {
                                                                $(progressFn).val(value);
                                                        }
                                                }, false);
                                        }
                                        return myXhr;
                                },
                                data: formdata,
                                dataType: "json",
                                cache: false,
                                contentType: false,
                                processData: false,
                                complete : function(res) {
                                        var json;
                                        try {
                                                json = JSON.parse(res.responseText);
                                        } catch(e) {
                                                json = res.responseText;
                                        }

                                        if(successFn) successFn(json);
                                }
                        });
                }
        });

};

function subirDatos(){
    $("#archivo").upload(URL_BASE + "manuscrito/insertar", formdata
    ,function(data){
            console.log("done", data);


            if(!parseInt(data.status)){
                $.each(data['data'], function(index, value) {
                    $("#error_"+data['data'][index]['idx']+"_nombre").html(data['data'][index]['nombre']);
                    $("#error_"+data['data'][index]['idx']+"_apellido").html(data['data'][index]['apellido']);
                    $("#error_"+data['data'][index]['idx']+"_pais").html(data['data'][index]['pais']);
                    $("#error_"+data['data'][index]['idx']+"_email").html(data['data'][index]['email']);
                    $("#error_"+data['data'][index]['idx']+"_telefono").html(data['data'][index]['telefono']);
                });
               // alert(data[0].nombre);
                document.getElementById("status").innerHTML = "Ocurrio un error verifica los datos..."; 
                $("#progressBar").hide();
                //alert("Los datos fueron almacenados exitosamente...!");
                //document.getElementById("status").innerHTML = event.target.responseText; 
            }
            else{//si hubo algun error mostrarlo
                document.getElementById("status").innerHTML = "Datos almacenados correctamente...!";
                alert("Nuevo Manuscrito creado con éxito!");
                url = URL_BASE + "manuscrito/";
                $(location).attr('href',url);
            }

            $("#progressBar").val(0);
    },$("#progressBar")
);
			

}


/*function progressHandler(event){ 
    document.getElementById("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total; 
    var percent = (event.loaded / event.total) * 100;
    document.getElementById("progressBar").value = Math.round(percent);
    document.getElementById("status").innerHTML = Math.round(percent)+"% uploaded... please wait"; 
} 
function completeHandler(event){
    document.getElementById("resp").innerHTML = "Entro"; 
    data = JSON.parse(event.target.responseText);
    //data = new Object(data);
    //alert(event.target.responseText + "--->" + parseInt(data.status) + " " + data.obra);
    if(!parseInt(data.status)){
        $.each(data['data'], function(index, value) {
            $("#error_"+data['data'][index]['idx']+"_nombre").html(data['data'][index]['nombre']);
            $("#error_"+data['data'][index]['idx']+"_apellido").html(data['data'][index]['apellido']);
            $("#error_"+data['data'][index]['idx']+"_pais").html(data['data'][index]['pais']);
            $("#error_"+data['data'][index]['idx']+"_email").html(data['data'][index]['email']);
            $("#error_"+data['data'][index]['idx']+"_telefono").html(data['data'][index]['telefono']);
        });
       // alert(data[0].nombre);
        document.getElementById("status").innerHTML = "Ocurrio un error verifica los datos..."; 
        //alert("Los datos fueron almacenados exitosamente...!");
        //document.getElementById("status").innerHTML = event.target.responseText; 
    }
    else{//si hubo algun error mostrarlo
        document.getElementById("status").innerHTML = data.msj_file;
    }
    
    
    document.getElementById("progressBar").value = 0; 
} 
function errorHandler(event){
    document.getElementById("status").innerHTML = "Upload Failed"; 
} 
function abortHandler(event){ 
    document.getElementById("status").innerHTML = "Upload Aborted"; 
} 


function uploadData(){  
    //upload con ajax
    var ajax = new XMLHttpRequest(); 
    //ajax.upload.addEventListener("progress", progressHandler, false); 
    ajax.addEventListener("load", completeHandler, false); 
    //ajax.addEventListener("error", errorHandler, false); 
    //ajax.addEventListener("abort", abortHandler, false); 
    ajax.open("POST", URL_BASE + "manuscrito/insertar"); 
    ajax.send(formdata);
    
}*/

function Inicializar(){
    $.post(URL_BASE +'ajax/getPaises', function(datos){
        for(var i = 0; i < datos.length; i++){
            var obj = {id_pais: datos[i].id_pais, pais: datos[i].nombre}
            paises.push(obj);
        }
        
        agregar_campos(array_numeros.length);
            
    }, 'json');
    
    
}

function cargarRevistas(id){
    $.post(URL_BASE +'ajax/getRevistas', function(datos){
        for(var i = 0; i < datos.length; i++){
                $(id).append('<option value="'+ datos[i].issn +'">' + datos[i].nombre + '</option>');
            }
    }, 'json');
    
}


function cargarMaterias(id){
    $.post(URL_BASE +'ajax/getMaterias', function(datos){
        for(var i = 0; i < datos.length; i++){
                $(id).append('<option value="'+ datos[i].id_materia +'">' + datos[i].nombre + '</option>');
            }
    }, 'json');
    
}


function cargarIdiomas(id){
    $.post(URL_BASE +'ajax/getIdiomas', function(datos){
        for(var i = 0; i < datos.length; i++){
                $(id).append('<option value="'+ datos[i].id_idioma +'">' + datos[i].nombre + '</option>');
            }
    }, 'json');
    
}


function siError(e){
    alert('Ocurrió un error al realizar la petición: '+e.statusText);
}


function agregar_campos(iter){
    
    
        var campos = '<div id="caja_campos_'+iter+'">'+
                    '<div class="controls">'+
                        '<label for="nombre">Nombre: </label>'+
                        '<input type="text" name="campo['+iter+'][nombre]" id="campo_'+iter+'_nombre" class="form-control" value="" />'+
                        '<label class="error" id="error_'+iter+'_nombre"></label>'+
                    '</div>'+

                    '<div class="controls">'+
                        '<label for="apellido">Apellido: </label>'+
                        '<input type="text" name="campo['+iter+'][apellido]" id="campo_'+iter+'_apellido" class="form-control" value="" />'+
                        '<label class="error" id="error_'+iter+'_apellido"></label>'+
                    '</div>'+
                    
                    
                    '<div class="controls">'+
                        '<label>G&eacute;nero</label>'+
                        '<div class="radio">'+
                            '<label>'+
                              '<input type="radio" name="campo['+iter+'][genero]" id="campo_'+iter+'_opcionRadio1" value="M" checked>'+
                              'Masculino'+
                            '</label>'+
                        '</div>'+
                        '<div class="radio">'+
                            '<label>'+
                              '<input type="radio" name="campo['+iter+'][genero]" id="campo_'+iter+'_opcionRadio2" value="F">'+
                              'Femenino'+
                            '</label>'+
                        '</div>'+
                    '</div>'+

                    '<div class="controls">'+
                        '<label for="pais">Pais</label>'+
                        '<select id="campo_'+iter+'_pais" name="campo['+iter+'][pais]" class="form-control required">'+
                             '<option value="0">-seleccione-</option>'+
                        '</select>'+
                        '<label class="error" id="error_'+iter+'_pais"></label>'+
                        '<br />'+
                    '</div>'+

                    '<div class="controls">'+
                        '<label for="email">Email: </label>'+
                        '<input type="email" name="campo['+iter+'][email]" id="campo_'+iter+'_email" class="form-control" value="" />'+
                        '<label class="error" id="error_'+iter+'_email"></label>'+
                    '</div>'+
                    
                    '<div class="controls">'+
                      '<label for="telefono">Tel&eacute;fono</label>'+
                      '<input type="text" name="campo['+iter+'][telefono]" id="campo_'+iter+'_telefono" class="form-control" value="" />'+
                      '<label class="error" id="error_'+iter+'_telefono"></label>'+
                    '</div>'+

                    '<div class="controls">'+
                        '<label for="resumenBiografico">Resumen Biografico</label>'+
                        '<textarea id="campo_'+iter+'_resumenBiografico" name="campo['+iter+'][resumenBiografico]" class="form-control" rows="3"></textarea>'+
                        '<br />'+
                    '</div>'+
                    
                       '<div class="radio">'+
                            '<label>'+
                              '<input type="radio" name="campo_responsable" id="campo_'+iter+'_responsable" value="'+iter+'">'+
                              'Contacto para correspondencia'+
                            '</label>'+
                        '</div>'+
                    
                    '<div class="controls"><button id="btn_delete_'+iter+'" campo="'+iter+'" type="button" class="btn btn-danger">Borrar Autor</button></div>'+
                '<hr></div>';
        
        
        $("div#caja_campos_autor").append(campos);
        
       for(var i = 0; i < paises.length; i++){
           $("#campo_"+iter+"_pais").append('<option value="'+ paises[i].id_pais +'">' + paises[i].pais + '</option>');
       }
        
        if(campo.autor == -1){
            campo.autor = iter;
            $("#msj_cargar_autor").hide();
            peticion = $.post(URL_BASE +'autor/getDatosAutor', function(datos){
                
                $("#campo_"+iter+"_nombre").val(datos.nombre);
                $("#campo_"+iter+"_nombre").attr("disabled", "true");
                
                $("#campo_"+iter+"_apellido").val(datos.apellido);
                $("#campo_"+iter+"_apellido").attr("disabled", "true");
                
                $("#campo_"+iter+"_pais option[value="+ datos.pais +"]").attr("selected",true);
                $("#campo_"+iter+"_pais").attr("disabled", "true");
                
                if(datos.genero == 'M')
                    $("#campo_"+iter+"_opcionRadio1").prop('checked',true);
                else
                    $("#campo_"+iter+"_opcionRadio2").prop('checked',true);
                
                $("#campo_"+iter+"_opcionRadio1").attr("disabled", true);
                $("#campo_"+iter+"_opcionRadio2").attr("disabled", true);
                
                
                $("#campo_"+iter+"_email").val(datos.email);
                $("#campo_"+iter+"_email").attr("disabled", "true");
                
                $("#campo_"+iter+"_telefono").val(datos.telefono);
                $("#campo_"+iter+"_telefono").attr("disabled", "true");
                
                $("#campo_"+iter+"_resumenBiografico").val(datos.resumenBiografico);
                $("#campo_"+iter+"_resumenBiografico").attr("disabled", "true");
                
                
            }, 'json');

            peticion.error(siError);  
        }
        
        if(array_numeros.length == 0){
            //establecer por defecto el primer autor
            $("#campo_"+iter+"_responsable").prop('checked',true);
        }

        array_numeros[array_numeros.length] = cont;
        
        $("button#btn_delete_"+iter+"").bind("click", function(){
            
            var cambiarResp = false;
            //verificamos si el autor q se va a borrar es el q esta check
            if($("#campo_"+iter+"_responsable").prop('checked')){ 
                cambiarResp = true;
            }
            
            
            $("div#caja_campos_"+iter+"").remove();

            var idx = array_numeros.indexOf(iter);
            if(array_numeros[idx] == campo.autor){
                campo.autor = -1;
                $("#msj_cargar_autor").show();
            }
            if(idx!=-1) 
                array_numeros.splice(idx, 1);

            if(cambiarResp && array_numeros.length > 0){
                $("#campo_"+array_numeros[0]+"_responsable").prop('checked',true);
            }
            
            
        }); 
        
        $("input#campo_"+iter+"_email").keyup(function(event){
                $.post(URL_BASE +'registro/comprobarEmail', 'email='+$("input#email").val(), function(datos){
                $("label#error_"+iter+"_email").html(datos);
            }, 'html');
        });
        
}
    
    
 function validarDatos(iter){
     var valido = true;
     formdata = new FormData();
     var idx_autor = -1;
     //validando la parte de autores
     for(i = 0; i < iter; i++){
        var idx = array_numeros[i];
        
        if($('input:radio[name=campo_responsable]:checked').val() == idx){
            formdata.append("responsable", i);
        }

        var nombre = $("#campo_"+idx+"_nombre").val();
        var msj_nombre = "";
        var apellido = $("#campo_"+idx+"_apellido").val();
        var msj_apellido = "";
        
        var genero;
        
        if($("#campo_"+idx+"_opcionRadio1").prop("checked"))
            genero = $("#campo_"+idx+"_opcionRadio1").val();
        if($("#campo_"+idx+"_opcionRadio2").prop("checked"))
            genero = $("#campo_"+idx+"_opcionRadio2").val();
        
        var pais = $("#campo_"+idx+"_pais").val();
        var msj_pais = "";
        var email = $("#campo_"+idx+"_email").val();
        var msj_email = "";
        
        var telefono = $("#campo_"+idx+"_telefono").val();
        var msj_telefono = "";
        
        var resumenBiografico = $("#campo_"+idx+"_resumenBiografico").val();

        var exp = /^[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?((|\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*$/;

        if(nombre == ""){
            msj_nombre = "El campo nombre est&aacute; vacio";
            valido = false;
        }
        else if(!exp.test(nombre)){
            msj_nombre = "El nombre no es v&aacute;lido";
            valido = false;
        }

        if(apellido == ""){
            msj_apellido = "El campo apellido est&aacute; vacio";
            valido = false;
        }
        else if(!exp.test(apellido)){
            msj_apellido = "El apellido no es v&aacute;lido";
            valido = false;
        }

        if(pais == 0) {
            msj_pais = "Debe seleccionar un pais";
            valido = false;
        }

        //validar email
        exp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;

        if(email == ""){
            msj_email = "El campo email est&aacute; vacio";
            valido = false;
        }
        else if(!exp.test(email)){
            msj_email = "El email no es v&aacute;lido";
            valido = false;
        }
        
        exp = /^\d{11,14}$/;
        
        if(telefono == ""){
            msj_telefono = "El campo telefono est&aacute; vacio";
            valido = false;
        }
        else if(!exp.test(telefono)){
            msj_telefono = "El n&uacute;mero de telefono no es v&aacute;lido";
            valido = false;
        }
        
        
        if(valido){
            if(idx != campo.autor){
                formdata.append("nombre"+i, nombre);
                formdata.append("apellido"+i, apellido);
                formdata.append("genero"+i, genero); 
                formdata.append("pais"+i, pais);
                formdata.append("email"+i, email);
                formdata.append("telefono"+i, telefono);
                formdata.append("resumenBiografico"+i, resumenBiografico);
            }else{
                idx_autor = i;
            }
            
        }

        $("#error_"+idx+"_nombre").html(msj_nombre);
        $("#error_"+idx+"_apellido").html(msj_apellido);
        $("#error_"+idx+"_pais").html(msj_pais);
        $("#error_"+idx+"_email").html(msj_email);
        $("#error_"+idx+"_telefono").html(msj_telefono);
    }
    
    //validando la seccion de manuscrito
    var titulo = $("#titulo").val();
    var msj_titulo = "";
    var resumen = $("#resumen").val();
    var msj_resumen = "";
    var revista = $("#revista").val();
    var msj_revista = "";
    var materia = $("#materia").val();
    var msj_materia = "";
    var idioma = $("#idioma").val();
    var msj_idioma = "";
    
    var palabrasClave = $("#palabrasClave").val();
    var msj_palabrasClave = "";
    
    var archivo = $("#archivo").val();
    var msj_archivo = "";
    
    if(titulo == ""){
        msj_titulo = "El campo titulo est&aacute; vacio";
        valido = false;
    }
    
    if(resumen == ""){
        msj_resumen = "El campo resumen est&aacute; vacio";
        valido = false;
    }
    
    if(revista == 0){
        msj_revista = "Debe seleccionar una revista";
        valido = false;
    }
    
    if(materia == 0){
        msj_materia = "Debe seleccionar una materia";
        valido = false;
    }
    
    if(idioma == 0){
        msj_idioma = "Debe seleccionar un idioma";
        valido = false;
    }
    
    if(palabrasClave == ""){
        msj_palabrasClave = "No ha especificado palabras clave";
        valido = false;
    }
    
    
   extensiones_permitidas = new Array(".doc", ".docx"); 
   
   if (!archivo) {
       msj_archivo = "No has seleccionado ningún archivo";
       valido = false;
   }else{
      //recupero la extensión de este nombre de archivo
      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
      //alert (extension);
      //compruebo si la extensión está entre las permitidas
      permitida = false;
      for (var i = 0; i < extensiones_permitidas.length; i++) {
         if (extensiones_permitidas[i] == extension) {
         permitida = true;
         break;
         }
      }
      if (!permitida) {
         msj_archivo = "Comprueba la extensión de los archivos a subir. Sólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
         valido = false;
       }
   }
   
    if(valido){
        
        formdata.append("titulo", titulo);
        formdata.append("resumen", resumen);
        formdata.append("revista", revista);
        formdata.append("materia", materia);
        formdata.append("idioma", idioma);
        formdata.append("palabrasClave", palabrasClave);
        formdata.append("iter", iter);
        
        formdata.append("idx_autor", idx_autor); 
        
        var file = document.getElementById("archivo").files[0];
        
        formdata.append("archivo", file);
    }
   
   $("#error_titulo").html(msj_titulo);
   $("#error_resumen").html(msj_resumen);
   $("#error_revista").html(msj_revista);
   $("#error_materia").html(msj_materia);
   $("#error_idioma").html(msj_idioma);
   $("#error_palabrasClave").html(msj_palabrasClave);
   $("#error_archivo").html(msj_archivo);
   
   if(!$('#checkbox').prop('checked'))
       alert('No ha aceptado las politicas.');
    
     return valido;
     
 }