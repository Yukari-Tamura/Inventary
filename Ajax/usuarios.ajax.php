<?php
require_once "../Controladores/usuarios.controlador.php";
require_once "../Modelos/usuarios.modelo.php";
class AjaxUsuarios{

    //Editar Usuarios
    public $idUsuario;

    public function ajaxEditarUsuario(){
        $item = "id";
        $valor = $this->idUsuario;
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
    
        echo json_encode($respuesta);
    }

    //Activar Usuarios
    public $activarUsuario;
    public $activarId;

    public function ajaxActivarUsuario(){
        $tabla = "usuarios";
        $item1 = "estado";
        $valor1=$this->activarUsuario;
        $item2 = "id";
        $valor2 = $this->activarId;
        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
    }

    //Validar Usuarios existentes
    public $validarUsuario;

    public function ajaxValidarUsuario(){
        $item = "usuario";
        $valor = $this->validarUsuario;
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
    
        echo json_encode($respuesta);
    }
}

if(isset($_POST["idUsuario"])){
    $editar = new AjaxUsuarios();
    $editar ->idUsuario = $_POST["idUsuario"];
    $editar -> ajaxEditarUsuario();
}

//Activar Usuario
if(isset($_POST["activarUsuario"])){
  $activarUsuario = new ajaxUsuarios();
  $activarUsuario -> activarUsuario = $_POST["activarUsuario"];  
  $activarUsuario -> activarId = $_POST["activarId"];
  $activarUsuario -> ajaxActivarUsuario();
}

//Validar Usuarios "Objeto"
if(isset($_POST["validarUsername"])){
    $valUsuario = new AjaxUsuarios();
    $valUsuario -> validarUsuario = $_POST["validarUsername"];
    $valUsuario -> ajaxValidarUsuario();
}

?>