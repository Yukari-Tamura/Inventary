/*Subir la foto del usuario*/

$(document).on("change", ".nuevaFoto",function(){

        var imagen = this.files[0];

        if(imagen["type"] != "image/jpeg" && imagen["type"] != "imagen/png"){
            $(".nuevaFoto").val("");
            swal({
                type: "error",
                title: "Error al cargar imagen",
                text: "¡La imagen deve estar en formato compatible!",
                confirmButtonText: "¡Cerar!" 
            });
        }else if(imagen["size"] > 2000000){
            $(".nuevaFoto").val("");
            swal({
                type: "error",
                title: "Error al cargar imagen",
                text: "¡El tamaño de la imagen supera el limite!",
                confirmButtonText: "¡Cerar!" 
            });  
        }else{
            var datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);

            $(datosImagen).on("load", function(event){
                var rutaImagen = event.target.result;
                console.log(rutaImagen);
                $(".previsualizar").attr("src", rutaImagen);
            })
        }
        
});


$(document).on("click", ".btneditarUsuario",function(){
var idUsuario = $(this).attr("idUsuario");
var datos = new FormData();
datos.append("idUsuario", idUsuario);
$.ajax({
    url:"Ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
        console.log("respuesta", respuesta);
        $("#editarNombre").val(respuesta["nombre"]);
        $("#editarUsername").val(respuesta["usuario"]);
        $("#editarPerfil").html(respuesta["perfil"]);
        $("#editarPerfil").val(respuesta["perfil"]);
        $("#passwordActual").val(respuesta["password"]);
        $("#fotoActual").val(respuesta["foto"]);

        if(respuesta["foto"] != ""){
            $(".previsualizar").attr("src", respuesta["foto"]);
        }

    }

});
});

//Activar usuarios
$(document).on("click", ".btnActivar",function(){
    var idUsuario = $(this).attr("idUsuario");
    var estadoUsuario = $(this).attr("estadoUsuario");

    var datos = new FormData();
    datos.append("activarId", idUsuario);
    datos.append("activarUsuario", estadoUsuario);

    $.ajax({
        url:"ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
            if(window.matchMedia("(max-width:767px)").matches){
                swal({
                    title: "El usuario ha sido actualizado",
                    type: "success",
                    confirmButtonText: "¡Cerrar!"
                }).then (function(result){
                    if(result.value){
                        window.location="usuarios";
                    }
                });
            }
        }
    });

    if(estadoUsuario == 0){
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('Inactivo');
        $(this).attr('estadoUsuario', 1);
    }else{
        $(this).addClass('btn-success');
        $(this).removeClass('btn-danger');
        $(this).html('Activo');
        $(this).attr('estadoUsuario', 0);
    }
});

//Revisar si el usuario ya esta registrado
$(document).on("change", "#nuevoUsername",function(){
    $(".alert").remove();

    var usuario = $(this).val();

    var datos = new FormData();
    datos.append("validarUsername", usuario);

    $.ajax({
        url:"ajax/usuarios.ajax.php",
        method:"POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){
            if(respuesta){
                $("#nuevoUsername").parent().after('<div class="alert alert-warning">Este usuario ya existe</div>');
                $("#nuevoUsername").val("");
            }

        }
    });
});

//Eliminar Usuario
$(document).on("click", ".btnEliminarUsuario",function(){

    var idUsuario = $(this).attr("idUsuario");
    var fotoUsuario = $(this).attr("fotoUsuario");
    var usuario = $(this).attr("usuario");
    swal({
        title: '¿Estas seguro de borrar el usuario?',
        text: "¡Si no lo está puede cancelar la acción",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar Usuario!'
    }).then((result)=> {
        if(result.value){
            window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
        }
    });
});
