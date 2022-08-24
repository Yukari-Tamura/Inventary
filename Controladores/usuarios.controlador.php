<?php

class ControladorUsuarios{


    static public function ctrIngresoUsuario(){
        if(isset($_POST["ingUsuario"])){
            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
                $encriptar = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');
                $tabla = "usuarios";
                $item = "usuario";
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
                if($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar){

                    if($respuesta["estado"] == 1){
                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["perfil"] = $respuesta["perfil"];
                        $_SESSION["foto"] = $respuesta["foto"];

                        //Captura la fecha y hora del ultimo inicio de sesion
                        date_default_timezone_set('America/Bogota');

                        $fecha = date('Y-m-d');
                        $hora = date('H:i:s');

                        $fechaActual = $fecha.' '.$hora;
                        $item1 = "ultimo_login";
                        $valor1 = $fechaActual;

                        $item2="id";
                        $valor2= $respuesta["id"];

                        $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
                        if($ultimoLogin == "ok"){
                            //Enviar el mensaje y direccionar al inicio
                                echo '<script>
                                        window.location = "inicio";
                                    </script>';

                        }

                    } else{
                        echo '<div class="alert alert-danger">El usuario no esta activo</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger">Usuario no encontrado</div>';
                }
            }
        }
    }

    static public function ctrCrearUsuario(){
        if(isset($_POST["nuevoNombre"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsername"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){
                
                $ruta ="";
                //Validacion de foto jpeg
                if(isset($_FILES["nuevaFoto"]["tmp_name"])){
                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    //Creamos el directorio de la imagen
                    $directorio = "Vistas/img/usuarios/".$_POST["nuevoUsername"];
                    mkdir($directorio, 0755);

                    //De acuerdo al tipo de imagenes aplicamos las funciones por defecto de php
                    if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "Vistas/img/usuarios/".$_POST["nuevoUsername"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);

                    }
                    if($_FILES["nuevaFoto"]["type"] == "image/png"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "Vistas/img/usuarios/".$_POST["nuevoUsername"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);

                    }

                }

                $tabla ="usuarios";
                //Encryptar contraseña
                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$usesomesillystringforsalt$');

                $datos = array("nombre" => $_POST["nuevoNombre"],
                "usuario" => $_POST["nuevoUsername"],
                "password" => $encriptar,
                "perfil" => $_POST["nuevoPerfil"],
                "foto" => $ruta);

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                        type: "success",
                        title: "¡El usuario se guardo correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                </script>';
                }
            }else{
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡El usuario no puede ir vacío o llevar caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                </script>';
            }
        }
    }

    //Mostrar Usuarios
    static public function ctrMostrarUsuarios($item, $valor){

        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
        return $respuesta;
    }

    //Editar Usuarios
    static public function ctrEditarUsuario(){
        if(isset($_POST["editarUsername"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){
                $ruta = $_POST["fotoActual"];
                //Validacion de foto jpeg
                if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){
                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    //Creamos el directorio de la imagen
                    $directorio = "Vistas/img/usuarios/".$_POST["editarUsername"];


                    //primero preguntamos si existe la imagen en la base de datos

                    if(!empty($_POST["fotoActual"])){
                        unlink($_POST["fotoActual"]);
                    }else{
                        mkdir($directorio, 0755);
                    }

                    //De acuerdo al tipo de imagenes aplicamos las funciones por defecto de php
                    if($_FILES["editarFoto"]["type"] == "image/jpeg"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "Vistas/img/usuarios/".$_POST["editarUsername"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);

                    }
                    if($_FILES["editarFoto"]["type"] == "image/png"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "Vistas/img/usuarios/".$_POST["editarUsername"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);

                    }

                }
                $tabla = "usuarios";
                if($_POST["editarPassword"] != ""){
                    if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){
                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$usesomesillystringforsalt$');
                    }else{
                        echo '<script>
                        swal({
                            type: "error",
                            title: "¡El usuario no puede ir vacío o llevar caracteres especiales",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="usuarios";
                            }
                        });
                    </script>';
                    }
                }else{
                    $encriptar = $passwordActual;
                }
                $datos = array("nombre" => $_POST["editarNombre"],
                "usuario" => $_POST["editarUsername"],
                "password" => $encriptar,
                "perfil" => $_POST["editarPerfil"],
                "foto" => $ruta);

                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                        type: "success",
                        title: "¡El usuario se edito correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                </script>';
                }
            }else{
                echo '<script>
                        swal({
                            type: "error",
                            title: "¡El usuario no puede ir vacío o llevar caracteres especiales",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false 
                        }).then((result)=>{
                            if(result.value){
                                window.location="usuarios";
                            }
                        });
                    </script>';
            }
        }
    }

    //Borrar usuarios
    static function ctrBorrarUsuario(){
        if(isset($_GET["idUsuario"])){
            $tabla = "usuarios";
            $datos = $_GET["idUsuario"];

            if($_GET["fotoUsuario"] != ""){
                unlink($_GET["fotoUsuario"]);
                rmdir('Vistas/img/usuarios/'.$_GET["usuario"]);
            }

            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            if($respuesta == "ok"){
                echo '<script>
                swal({
                    type: "success",
                    title: "¡El usuario se elimino correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false 
                }).then((result)=>{
                    if(result.value){
                        window.location="usuarios";
                    }
                });
            </script>';
            }
        }
        
    }
   
}




?>