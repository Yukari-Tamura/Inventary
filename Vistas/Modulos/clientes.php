<?php
if($_SESSION["perfil"] == "Especial"){
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
    <h1>Administrar clientes</h1>
    <ol class="breadcrumb">  
      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li class="active">Administrar Clientes</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
          Agregar cliente
        </button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
            <thead>
                 <tr>
                    <th style="width:10px">#</th>
                    <th>Nombre</th>
                    <th>Documento ID</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Fecha nacimiento</th> 
                    <th>Total compras</th>
                    <th>Última compra</th>
                    <th>Ingreso al sistema</th>
                    <th>Acciones</th>
                </tr> 
            </thead>

            <tbody>
                <?php
                    $item = null;
                    $valor = null;
                    $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                    foreach ($clientes as $key => $value) {
    
                    echo '<tr>
                            <td>'.($key+1).'</td>
                            <td>'.$value["nombre"].'</td>
                            <td>'.$value["documento"].'</td>
                            <td>'.$value["email"].'</td>
                            <td>'.$value["telefono"].'</td>
                            <td>'.$value["direccion"].'</td>
                            <td>'.$value["fecha_nacimiento"].'</td>             
                            <td>'.$value["compras"].'</td>
                            <td>'.$value["ultima_compra"].'</td>
                            <td>'.$value["fecha"].'</td>
                            <td>
                            <div class="btn-group">
                                <button class="btn btn-warning btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';
                                if($_SESSION["perfil"] == "Administrador"){
                                  echo '
                                  <button class="btn btn-danger btnEliminarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>
                                  ';
                                }
                                echo '
                            </div>  
                            </td>
                        </tr>';
            }
        ?>
            </tbody>
        </table>
        </div>
        </div>
  </section>
</div>

<!--Modal de agregar clientes-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar cliente</h4>
        </div>
         <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
                <span>Nombre</span> 
                <input type="text" class="form-control" name="nuevoCliente" placeholder="Ingresar nombre" required>
            </div>
            <div class="form-group">
                <span>Documento</span> 
                <input type="number" min="0" class="form-control" name="nuevoDocumentoId" placeholder="Ingresar documento" required>
            </div>
            <div class="form-group">
                <span>Email</span>
                <input type="email" class="form-control" name="nuevoEmail" placeholder="Ingresar email" required>
            </div>
            <div class="form-group">
                <span>Teléfono</span> 
                <input type="text" class="form-control" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 99-999-9999'" data-mask required>
            </div>
            <div class="form-group">
                <span>Dirección</span> 
                <input type="text" class="form-control" name="nuevaDireccion" placeholder="Ingresar dirección" required>
            </div>
            <div class="form-group">
                <span>Fecha Nacimiento</span>
                <input type="text" class="form-control" name="nuevaFechaNacimiento" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
      </form>
      <?php
        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();
      ?>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR CLIENTE
======================================-->

<div id="modalEditarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar cliente</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
                <span>Nombre</span> 
                <input type="text" class="form-control" name="editarCliente" id="editarCliente" required>
                <input type="hidden" id="idCliente" name="idCliente">
            </div>
            <div class="form-group">
                <span>Documento</span> 
                <input type="number" min="0" class="form-control" name="editarDocumentoId" id="editarDocumentoId" required>
            </div>
            <div class="form-group">
                <span>Email</span> 
                <input type="email" class="form-control" name="editarEmail" id="editarEmail" required>
            </div>
            <div class="form-group">
                <span>Teléfono</span> 
                <input type="text" class="form-control" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
            </div>
            <div class="form-group">
                <span>Dirección</span> 
                <input type="text" class="form-control" name="editarDireccion" id="editarDireccion"  required>
            </div>
            <div class="form-group">
                <span>Fecha Nacimiento</span> 
                <input type="text" class="form-control" name="editarFechaNacimiento" id="editarFechaNacimiento"  data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
      <?php
        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarCliente();
      ?>
    </div>
  </div>
</div>
<?php
  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarCliente();

?>