<?php
require_once "../Controladores/productos.controlador.php";
require_once "../Modelos/productos.modelo.php";

class AjaxProductos{

    //Metodo crear codigo del producto
    public $idCategoria;
    public $traerProductos;
    public $nombreProducto;

    public function ajaxCrearCodigoProducto(){
        $item = "id_categoria";
        $valor = $this->idCategoria;
        $orden = "id";
        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
        echo json_encode($respuesta);
        
    }

    //editar productos
    public $idProducto;
    public function ajaxEditarProducto(){
        if($this->traerProductos == "ok"){
            $item = null;
            $valor = null;
            $orden = "id";
            $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
            echo json_encode($respuesta);  
        }else if($this->nombreProducto != ""){
            $item = "descripcion";
            $valor = $this->nombreProducto;
            $orden = "id";
            $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
            echo json_encode($respuesta);
        }
        
        
        else{
            $item = "id";
            $valor = $this->idProducto;
            $orden = "id";
            $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
            echo json_encode($respuesta);
        }

       
    }
}

if(isset($_POST["idCategoria"])){
    $codigoProducto = new AjaxProductos();
    $codigoProducto -> idCategoria = $_POST["idCategoria"];
    $codigoProducto -> ajaxCrearCodigoProducto();
}


//editar productos
if(isset($_POST["idProducto"])){
    $editarProducto = new AjaxProductos();
    $editarProducto -> idProducto = $_POST["idProducto"];
    $editarProducto -> ajaxEditarProducto();
}

//traer productos
if(isset($_POST["traerProductos"])){
    $traerProductos = new AjaxProductos();
    $traerProductos -> traerProductos = $_POST["traerProductos"];
    $traerProductos -> ajaxEditarProducto();
}

//nombre productos
if(isset($_POST["nombreProducto"])){
    $nombreProducto = new AjaxProductos();
    $nombreProducto -> nombreProducto = $_POST["nombreProducto"];
    $nombreProducto -> ajaxEditarProducto();
}

?>