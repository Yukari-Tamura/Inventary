<?php
require_once "../Controladores/categorias.controlador.php";
require_once "../Modelos/categorias.modelo.php";

class AjaxCategorias{

    //Editar Categorias
    public $idCategoria;
    public function ajaxEditarCategoria(){
        $item = "id";
        $valor = $this->idCategoria;
        $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

        echo json_encode($respuesta);
    }

}

//Creamos los objetos
if(isset($_POST["idCategoria"])){
    $categoria = new AjaxCategorias();
    $categoria -> idCategoria = $_POST["idCategoria"];
    $categoria -> ajaxEditarCategoria();

}


?>