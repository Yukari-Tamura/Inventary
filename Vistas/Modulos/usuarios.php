<?php
if($_SESSION["perfil"] == "Vendedor" || $_SESSION["perfil"] == "Especial"){
  echo '
  <script>
  window.location = "inicio";
  </script>
  ';
  return;
}

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Inicio</h1>
        <ol class="breadcrumb">
            <li>
                <a href="inicio">
                    <i class="fa fa-dashboard"></i>
                    Inicio
                </a>
            </li>
            <li class="active">
                <a href="">Administrar Usuarios</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuarios">Agregar</button>
            
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Nombre</th>
                            <th>Username</th>
                            <th>Foto</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Ultimo Inicio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $item = null;
                            $valor = null;
                            $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                            
                            foreach($usuarios as $key => $value){
                                echo '
                                <tr>
                                    <td>'.($key+1).'</td>
                                    <td>'.$value["nombre"].'</td>
                                    <td>'.$value["usuario"].'</td>';
                                    if($value["foto"] != ""){
                                     echo '
                                     <td>
                                        <img src="'.$value["foto"].'" class="img-thumbnail" width="70px" alt="">
                                    </td>
                                     ';
                                    }else{
                                        echo '
                                        <td>
                                        <img src="Vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="70px" alt="">
                                    </td>
                                        ';
                                    }
                                    echo '
                                    <td>'.$value["perfil"].'</td>';
                                    if($value["estado"] == 1){
                                        echo '
                                        <td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="0">Activo</button></td>
                                        ';
                                    }else{
                                        echo '
                                        <td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="1">Inactivo</button></td>
                                        ';
                                    }
                                    echo '
                                    <td>'.$value["ultimo_login"].'</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-warning btneditarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuarios">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                ';
                            }
                        ?>
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!--Ventan Modal para crear usuarios-->
<div id="modalAgregarUsuarios"  class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content"> 
        <form role="form" method="POST" enctype="multipart/form-data">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight:bold;">Agregar Usuarios</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="card-group">
                        <div class="card col-md-6">
                            <div class="form-group">
                                <img src="Vistas/img/plantilla/noimage.png" class="previsualizar img-thumbnail" width="400px" alt="">
                                <div class="panel" style="font-weight:bold;color:#4e4e4e;">
                                    Foto
                                </div>
                                <input type="file" class="nuevaFoto form-control" name="nuevaFoto">
                                <p class="help-block">Peso maximo 200MB</p>
                            </div>
                        </div>
                        <div class="card col-md-6">
                            <div class="form-group">
                                <span class="mb-2" style="font-weight:bold;color:#4e4e4e;">Nombre</span>     
                                <input class="form-control" type="text" name="nuevoNombre" placeholder="Ingrese Nombre" required>
                            </div>
                            <div class="form-group">
                                <span class="mb-2" style="font-weight:bold;color:#4e4e4e;">Nick/Username</span>
                                <input class="form-control" type="text" id="nuevoUsername" name="nuevoUsername" placeholder="Ingrese Username" required>
                            </div>
                            <div class="form-group">
                                <span class="mb-2" style="font-weight:bold;color:#4e4e4e;">Contraseña</span>
                                <input class="form-control" type="password" name="nuevoPassword" placeholder="Ingrese Contraseña" required>
                                
                            </div>
                            <div class="form-group">
                                <span style="font-weight:bold;color:#4e4e4e;">Perfil</span>
                                    <select class="form-control mt-2" name="nuevoPerfil" id="">
                                        <option value="">Seléccionar Perfil</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Especial">Especial</option>
                                        <option value="Vendedor">Vendedor</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>

            <?php
                $crearUsuario = new ControladorUsuarios();
                $crearUsuario -> ctrCrearUsuario();
            ?>
        </form>
    </div>
</div>
</div>
<!--Editar Usuarios-->
<!--Ventan Modal para editar usuarios-->
<div id="modalEditarUsuarios"  class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content"> 
        <form role="form" method="POST" enctype="multipart/form-data">
            <div class="modal-header cabecera">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight:bold;">Editar Usuarios</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="card-group">
                        <div class="card col-md-6">
                            <div class="form-group">
                                <img src="Vistas/img/plantilla/noimage.png" class="previsualizar img-thumbnail" style="width: 400px; height: 320px;" alt="">
                                <div class="panel" style="font-weight:bold;color:#4e4e4e;">
                                    Foto
                                </div>
                                <input type="file" class="nuevaFoto form-control" name="editarFoto">
                                <p class="help-block">Peso maximo 200MB</p>
                                <input type="hidden" id="fotoActual" name="fotoActual">
                            </div>
                        </div>
                        <div class="card col-md-6">
                            <div class="form-group">
                                <span class="mb-2" style="font-weight:bold;color:#4e4e4e;">Nombre</span>     
                                <input class="form-control" type="text" id="editarNombre" name="editarNombre" value="" required>
                            </div>
                            <div class="form-group">
                                <span class="mb-2" style="font-weight:bold;color:#4e4e4e;">Nick/Username</span>
                                <input class="form-control" type="text" id="editarUsername" name="editarUsername" value="" readonly>
                            </div>
                            <div class="form-group">
                                <span class="mb-2" style="font-weight:bold;color:#4e4e4e;">Contraseña</span>
                                <input class="form-control" type="password"  name="editarPassword" placeholder="Ingrese nueva contraseña" required >
                                <input type="hidden" id="passwordActual" name="passwordActual">
                                
                            </div>
                            <div class="form-group">
                                <span style="font-weight:bold;color:#4e4e4e;">Perfil</span>
                                    <select class="form-control mt-2" name="editarPerfil" id="">
                                        <option value="" id="editarPerfil"></option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Especial">Especial</option>
                                        <option value="Vendedor">Vendedor</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer cabecera">
                <button type="button" class="btn cabecera pull-left" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn cabecera">Editar</button>
            </div>
            <?php
                $editarUsuario = new ControladorUsuarios();
                $editarUsuario -> ctrEditarUsuario();

            ?>
           
        </form>
    </div>
  </div>
</div>

<!--Objeto de borrar Usuarios-->
<?php
$borrarUsuario = new ControladorUsuarios();
$borrarUsuario -> ctrBorrarUsuario();

?>