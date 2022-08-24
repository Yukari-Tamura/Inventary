//Cargar la tabla dinamica de productos
$.ajax({
url: "ajax/datatable-productos.ajax.php",
success:function(respuesta){
    console.log(respuesta);
}
});

var perfilOculto = $("#perfilOculto").val();
console.log(perfilOculto);
$('.tablaProductos').DataTable({
    "ajax": "ajax/datatable-productos.ajax.php?perfilOculto="+perfilOculto,
    "deferRender":true,
    "retrieve": true,
    "processing": true,
    "language": {
        "sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}
    }
});

//Capturando la categoria para asignar codigo

$("#nuevaCategoria").change(function(){
	var idCategoria = $(this).val();

	var datos = new FormData();
	datos.append("idCategoria", idCategoria);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			
			if(!respuesta){
				var nuevoCodigo = idCategoria+"01";
				$("#nuevoCodigo").val(nuevoCodigo);
			}else{
				var nuevoCodigo = Number(respuesta["codigo"]) + 1;
				$("#nuevoCodigo").val(nuevoCodigo);
			}
		}
	});
});


//Agregar precio de venta
$("#nuevoPrecioCompra, #editarPrecioCompra").change(function(){
if($(".porcentaje").prop("checked")){
	var valorPorcentaje = $(".nuevoPorcentaje").val();
	console.log(valorPorcentaje);
	var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100))+Number($("#nuevoPrecioCompra").val());
	var editarporcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100))+Number($("#editarPrecioCompra").val());

	$("#nuevoPrecioVenta").val(porcentaje);
	$("#nuevoPrecioVenta").prop("readonly",true);

	$("#editarPrecioVenta").val(editarporcentaje);
	$("#editarPrecioVenta").prop("readonly",true);
}
});

//Cambio de porcentaje

$(".nuevoPorcentaje").change(function(){
	if($(".porcentaje").prop("checked")){
		var valorPorcentaje = $(this).val();
		console.log(valorPorcentaje);
		var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100))+Number($("#nuevoPrecioCompra").val());

		var editarporcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100))+Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);

		$("#editarPrecioVenta").val(editarporcentaje);
		$("#editarPrecioVenta").prop("readonly",true);
	}
});

$(".porcentaje").on("ifUnchecked", function(){
	$("#nuevoPrecioVenta").prop("readonly",false);
	$("#editarPrecioVenta").prop("readonly",false);
});

$(".porcentaje").on("ifChecked", function(){
	$("#nuevoPrecioVenta").prop("readonly",true);
	$("#editarPrecioVenta").prop("readonly",true);
});

//Imagen de los productos
$(document).on("change", ".nuevaImagen",function(){

	var imagen = this.files[0];

	if(imagen["type"] != "image/jpeg" && imagen["type"] != "imagen/png"){
		$(".nuevaImagen").val("");
		swal({
			type: "error",
			title: "Error al cargar imagen",
			text: "¡La imagen deve estar en formato compatible!",
			confirmButtonText: "¡Cerar!" 
		});
	}else if(imagen["size"] > 2000000){
		$(".nuevaImagen").val("");
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

//Editar productos
$(".tablaProductos tbody").on("click","button.btnEditarProducto", function(){

	var idProducto = $(this).attr("idProducto");
	

	var datos = new FormData();
	datos.append("idProducto", idProducto);

	
	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			var datosCategoria = new FormData();
			datosCategoria.append("idCategoria", respuesta["id_categoria"]);

			$.ajax({

				url: "ajax/categorias.ajax.php",
				method: "POST",
				data: datosCategoria,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					$("#editarCategoria").val(respuesta["id"]);
					$("#editarCategoria").html(respuesta["categoria"]);
					

				}
			});
			
			$("#editarCodigo").val(respuesta["codigo"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);
			$("#editarStock").val(respuesta["stock"]);
			$("#editarPrecioCompra").val(respuesta["precio_compra"]);
			$("#editarPrecioVenta").val(respuesta["precio_venta"]);
			if(respuesta["image"] != ""){
				$("#imagenActual").val(respuesta["imagen"]);
				$(".previsualizar").attr("src", respuesta["imagen"]);
			}
		}
	});
});

//Eliminar producto
$(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function(){
	var idProducto = $(this).attr("idProducto");
	var codigo = $(this).attr("codigo");
	var imagen = $(this).attr("imagen");
	console.log("idProducto", idProducto);
	swal({
        title: '¿Estas seguro de borrar el producto?',
        text: "¡Si no lo está puede cancelar la acción",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: '¡Eliminar Producto!'
    }).then((result)=> {
        if(result.value){
            window.location = "index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;
        }
    });
});

