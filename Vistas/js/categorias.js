//Editar categorias
$(document).on("click", ".btnEditarCategoria",function(){
    var idCategoria = $(this).attr("idCategoria");
    var datos = new FormData();
    datos.append("idCategoria", idCategoria);
    $.ajax({
        url:"Ajax/categorias.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            console.log("respuesta", respuesta);
            $("#editarCategoria").val(respuesta["categoria"]);
            $("#idCategoria").val(respuesta["id"]);
            
            
    
        }
    
    });
    });

    //Eliminar categoria
    //Eliminar Usuario
$(document).on("click", ".btnEliminarCategoria",function(){

    var idCategoria = $(this).attr("idCategoria");
    swal({
        title: '¿Estas seguro de borrar la categoria?',
        text: "¡Si no lo está puede cancelar la acción",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: '¡Eliminar Categoria!'
    }).then((result)=> {
        if(result.value){
            window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;
        }
    });
});
