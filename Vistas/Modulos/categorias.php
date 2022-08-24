<?php
if($_SESSION["perfil"] == "Vendedor"){
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
        <h1>Catégorias del Sistema</h1>
        <ol class="breadcrumb">
            <li>
                <a href="inicio">
                    <i class="fa fa-dashboard"></i>
                    Inicio
                </a>
            </li>
            <li class="active">
                <a href="">Administrar Categorías</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategorias">Agregar Categoria</button>
            
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $item = null;
                          $valor = null;
                          
                          $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                          

                          foreach ($categorias as $key => $value){
                            echo '
                            <tr>
                            <td>'.($key+1).'</td>
                            <td>'.$value['categoria'].'</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarCategoria" idCategoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>';
                                    if($_SESSION["perfil"] == "Administrador"){
                                      echo '
                                    <button class="btn btn-danger btnEliminarCategoria" idCategoria="'.$value["id"].'" >
                                    <i class="fa fa-times"></i>
                                    </button>';
                                    }
                                    echo '
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

<!--Modal para agregar categorias-->
<!-- Modal -->
<div id="modalAgregarCategorias" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form role="form" method="POST">
      <div class="modal-header bg-primary text-white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight:bold;">Categorias</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <span style="font-weight:bold;" class="mb-2">Categoria</span>
            <input type="text" class="form-control mt-2" placeholder="Ingrese Categoria" name="nuevaCategoria">
        </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Agregar</button>
      </div>
      <?php
        $crearCategoria = new ControladorCategorias();
        $crearCategoria -> ctrCrearCategoria();
      ?>
    </form>
    </div>
  </div>
</div>
<!--Modal para editar categorias-->
<!-- Modal -->
<div id="modalEditarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form role="form" method="POST">
      <div class="modal-header bg-primary text-white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight:bold;">Categorias</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <span style="font-weight:bold;" class="mb-2">Categoria</span>
            <input type="text" class="form-control mt-2" placeholder="Ingrese Categoria" name="editarCategoria" id="editarCategoria">
            <input type="hidden"  name="idCategoria" id="idCategoria">
        </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Editar</button>
      </div>
      <?php
        $editarCategoria = new ControladorCategorias();
        $editarCategoria -> ctrEditarCategoria();
      ?>
    </form>
    </div>

  </div>
</div>
<!--Eliminar categoria-->

<?php
$BorrarCategoria = new ControladorCategorias();
$BorrarCategoria -> ctrBorrarCategoria();
?>