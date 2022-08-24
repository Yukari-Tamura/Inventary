
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
        <h1>Administrar Productos</h1>
        <ol class="breadcrumb">
            <li>
                <a href="inicio">
                    <i class="fa fa-dashboard"></i>
                    Inicio
                </a>
            </li>
            <li class="active">
                <a href="">Administrar Productos</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProductos">Agregar Productos</button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablaProductos" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th style="width:10px">Categoria</th>
                            <th style="width:10px">Stock</th>
                            <th >Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
                <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
            </div>
        </div>
    </section>
</div>
<!--Modal para agregar productos-->
<!-- Modal -->
<div id="modalAgregarProductos" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="font-weight:bold;">Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="card col-xs-12">
                        <!--Seccion categorias -->
                        <div class="form-group">
                            <span style="font-weight:bold;color:#4e4e4e;">Categoria</span>
                                <select class="form-control mt-2" id="nuevaCategoria" name="nuevaCategoria">
                                    <option value="">Seléccionar Categoria</option>
                                    <?php
                                        $item = null;
                                        $valor = null;
                                        
                                        $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                                        foreach ($categorias as $key => $value){
                                            echo '
                                            <option value="'.$value["id"].'">'.$value["categoria"].'</option>
                                            ';
                                        }
                                    ?>
                                </select>
                        </div>
                        <!--Seccion Codigo-->
                        <div class="form-group">
                            <span style="font-weight:bold;" class="mb-2">Codigo</span>
                            <input type="text" class="form-control mt-2" placeholder="Ingrese Codigo" name="nuevoCodigo" id="nuevoCodigo" readonly>
                        </div>
                        <!--Seccion Descripción-->
                        <div class="form-group">
                            <span style="font-weight:bold;" class="mb-2">Descripción</span>
                            <input type="text" class="form-control mt-2" placeholder="Ingrese Descripción" name="nuevaDescripcion">
                        </div>
                        <!--Seccion Stock-->
                        <div class="form-group">
                                    <span>Stock</span>
                                    <input type="text" name="nuevoStock" id="nuevoStock" class="form-control">
                        </div>
                    </div>
                    <div class="card-group col-xs-12 col-sm-12" style="padding:0">
                        <!--Seccion Precio Compra-->
                        <div class="card col-xs-6 col-sm-6">
                            <div class="form-group">
                                <span>Precio Compra</span>
                                <input type="text" id="nuevoPrecioCompra" step="any" name="nuevoPrecioCompra" class="form-control">
                            </div>
                        </div>
                        <!--Seccion Precio venta-->
                        <div class="card col-xs-6 col-sm-6">
                            <div class="form-group">
                                <span>Precio Venta</span>
                                <input type="text" step="any" id="nuevoPrecioVenta" name="nuevoPrecioVenta" class="form-control">
                            </div>
                            <div class="card-group col-xs-12 col-sm-12" style="padding:0">
                                <div class="card col-xs-5 col-sm-5">
                                    <div class="form-group">
                                        
                                        <input type="checkbox" class="minimal porcentaje" checked>
                                        <span>Utilizar Porcentaje</span>
                                    </div>
                                </div>
                                <div class="card col-xs-7 col-sm-7">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                                        <span class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--Seccion Imagen del producto-->
                    <div class="form-group" style="text-align:center; border:solid 1px #F2F3F4;">
                        <img src="Vistas/img/plantilla/noimage.png" class="previsualizar img-thumbnail" width="350px" alt="">
                        <div class="panel" style="font-weight:bold;color:#4e4e4e;">
                            Imagen de Producto
                        </div>
                        <input type="file" class="nuevaImagen form-control" name="nuevaImagen">
                        <p class="help-block">Peso maximo 20MB</p>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
            <?php
                $crearProducto = new ControladorProductos();
                $crearProducto -> ctrCrearProducto();
            ?>
        </div>
    </div>
</div>

<!--Modal para editar productos-->
<!-- Modal -->
<div id="modalEditarProductos" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="font-weight:bold;">Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="card col-xs-12">
                        <!--Seccion categorias -->
                        <div class="form-group">
                            <span style="font-weight:bold;color:#4e4e4e;">Categoria</span>
                                <select class="form-control mt-2"  name="editarCategoria" readonly required>
                                    <option id="editarCategoria"></option>
                                   
                                </select>
                        </div>
                        <!--Seccion Codigo-->
                        <div class="form-group">
                            <span style="font-weight:bold;" class="mb-2">Codigo</span>
                            <input type="text" class="form-control mt-2" placeholder="Ingrese Codigo" name="editarCodigo" id="editarCodigo" readonly>
                        </div>
                        <!--Seccion Descripción-->
                        <div class="form-group">
                            <span style="font-weight:bold;" class="mb-2">Descripción</span>
                            <input type="text" class="form-control mt-2" placeholder="Ingrese Descripción" name="editarDescripcion" id="editarDescripcion">
                        </div>
                        <!--Seccion Stock-->
                        <div class="form-group">
                                    <span>Stock</span>
                                    <input type="text" name="editarStock" id="editarStock" class="form-control">
                        </div>
                    </div>
                    <div class="card-group col-xs-12 col-sm-12" style="padding:0">
                        <!--Seccion Precio Compra-->
                        <div class="card col-xs-6 col-sm-6">
                            <div class="form-group">
                                <span>Precio Compra</span>
                                <input type="text" id="editarPrecioCompra" step="any" name="editarPrecioCompra" class="form-control">
                            </div>
                        </div>
                        <!--Seccion Precio venta-->
                        <div class="card col-xs-6 col-sm-6">
                            <div class="form-group">
                                <span>Precio Venta</span>
                                <input type="text" step="any" id="editarPrecioVenta" name="editarPrecioVenta" class="form-control" readonly>
                            </div>
                            <div class="card-group col-xs-12 col-sm-12" style="padding:0">
                                <div class="card col-xs-5 col-sm-5">
                                    <div class="form-group">
                                        
                                        <input type="checkbox" class="minimal porcentaje" checked>
                                        <span>Utilizar Porcentaje</span>
                                    </div>
                                </div>
                                <div class="card col-xs-7 col-sm-7">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                                        <span class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--Seccion Imagen del producto-->
                    <div class="form-group" style="text-align:center; border:solid 1px #F2F3F4;">
                        <img src="Vistas/img/plantilla/noimage.png" class="previsualizar img-thumbnail" width="350px" alt="">
                        <div class="panel" style="font-weight:bold;color:#4e4e4e;">
                            Imagen de Producto
                        </div>
                        <input type="file" class="nuevaImagen form-control" name="editarImagen">
                        <input type="hidden" name="imagenActual" id="imagenActual">
                        <p class="help-block">Peso maximo 20MB</p>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Editar</button>
                </div>
            </form>
            <?php
                $editarProducto = new ControladorProductos();
                $editarProducto -> ctrEditarProducto();
            ?>
        </div>
    </div>
</div>
<!--Eliminar producto-->
<?php
    $eliminarProducto = new ControladorProductos();
    $eliminarProducto -> ctrEliminarProducto();
?>