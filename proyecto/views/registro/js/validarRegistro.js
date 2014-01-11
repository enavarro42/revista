$(document).ready(function(){
    
    $('input#usuario').keydown(function(event){ 
       if(event.keyCode != 8)
           $("label#error_usuario").text("");
    });
    
    $("input#pass").keyup(function(event){
       if(event.keyCode != 8)
           $("label#error_pass").text("");
    });
    
    $("input#confirmar").keyup(function(event){
       if(event.keyCode != 8)
           $("label#error_confir").text("");
    });
    
    $("input#nombre").keyup(function(event){
       if(event.keyCode != 8)
           $("label#error_nombre").text("");
    });
    
    $("input#apellido").keyup(function(event){
       if(event.keyCode != 8)
           $("label#error_apellido").text("");
    });
    
    $("input#email").keyup(function(event){
       if(event.keyCode != 8)
           $("label#error_email").text("");
    });
    
    $("input#telefono").keyup(function(event){
       if(event.keyCode != 8)
           $("label#error_telefono").text("");
    });
    
    $("select#pais").change(function(){
       if($("select#pais").val() != "")
           $("label#error_pais").text("");
    });
    
    
});


