<?php

//Creamos la clase
class ControladorCategorias{

    //Crear Categoria
    static public function ctrCrearCategoria(){
        if(isset($_POST["nuevaCategoria"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoria"])){
                $tabla ="categorias";
                $datos = $_POST["nuevaCategoria"];
                $respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);
                if($respuesta == "ok"){
                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡La categoria se creo correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="categorias";
                            }
                        });
                    </script>';
                }

            }else{
                echo '<script>
                        swal({
                            type: "error",
                            title: "¡Error la categoria no puede ir en blanco o contener caracteres especiales!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="categorias";
                            }
                        });
                    </script>';
            }
        }
    }

    //Mostrar Categorias

    static public function ctrMostrarCategorias($item, $valor){
        $tabla = "categorias";
        $respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);
        return $respuesta;
    }

    //Editar Categoria
    static public function ctrEditarCategoria(){
        if(isset($_POST["editarCategoria"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoria"])){
                $tabla ="categorias";
                $datos = array("categoria" => $_POST["editarCategoria"], "id" => $_POST["idCategoria"]);
                $respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);
                if($respuesta == "ok"){
                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡La categoria se edito correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="categorias";
                            }
                        });
                    </script>';
                }

            }else{
                echo '<script>
                        swal({
                            type: "error",
                            title: "¡Error la categoria no puede ir en blanco o contener caracteres especiales!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="categorias";
                            }
                        });
                    </script>';
            }
        }
    }

    //Eliminar Categorias
    static public function ctrBorrarCategoria(){
        if(isset($_GET["idCategoria"])){
            $tabla = "categorias";
            $datos = $_GET["idCategoria"];

            $respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

            if($respuesta == "ok"){
                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡Se elimino la categoria correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="categorias";
                            }
                        });
                    </script>';
            
            }
        }
    }

}

?>