<div class="content-wrapper">
    <section class="content-header">
        <h1>Crear Ventas</h1>
        <ol class="breadcrumb">
            <li>
                <a href="inicio">
                    <i class="fa fa-dashboard"></i>
                    Inicio
                </a>
            </li>
            <li class="active">
                <a href="">Administrar Ventas</a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
        <!--Formulario-->
            <div class="col-lg-5 col-xs-12">
                <div class="box box-success">
                    <div class="box-header width-border"></div>
                    <form  role="form" method="POST" action="" class="formularioVenta">
                    <div class="box-body">
                        
                            <div class="box">
                            <?php
                                        $item = "id";
                                        $valor = $_GET["idVenta"];

                                        $venta = ControladorVentas::ctrMostrarVentas($item, $valor);
                                        $itemUsuario = "id";
                                        $valorUsuario = $venta["id_vendedor"];

                                        $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                                        $itemCliente = "id";
                                        $valorCliente = $venta["id_cliente"];

                                        $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                                        $porcentajeImpuesto = $venta["impuesto"] * 100 / $venta["neto"];
                            ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="nuevoVendedor" name="nuevoVendedor" value="<?php  echo $vendedor["nombre"] ?>" readonly>
                                        <input type="hidden" name="idVendedor" value="<?php  echo $vendedor["id"] ?>">
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-key"></i>
                                        </span>
                                            <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php  echo $venta["codigo"] ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <select class="form-control" name="seleccionarCliente" id="seleccionarCliente" required>
                                            <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["nombre"]; ?></option>
                                            <?php
                                               $item = null;
                                               $valor = null;
       
                                               $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                                               foreach ($clientes as $key => $value){
                                                   echo '
                                                    <option value="'.$value["id"].'">'.$value["nombre"].'</option>
                                                   ';
                                               } 

                                            ?>
                                        </select>
                                        <span class="input-group-addon">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Clientes</button>
                                        </span>
                                       
                                    </div>
                                </div>
                                <!--entrada de productos-->
                                <div class="form-group row nuevoProducto">
                                    <?php
                                    $listaProducto = json_decode($venta["productos"], true);

                                    foreach($listaProducto as $key => $value){
                                        $item = "id";
                                        $valor = $value["id"];
                                        $orden = "id";
                                        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                                        $stockAntiguo = $respuesta["stock"] +  $value["cantidad"];
                                        echo '
                                        <div class="row" style="padding:5px 15px">
                                            <div class="col-xs-6" style="padding-right:0px">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </span>
                                                    <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto"  value="'.$value["descripcion"].'"  readonly required>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" placeholder="0" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>
                                            </div>
                                            <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
                                                <div class="input-group">
                                                    <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_venta"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
                                                    <span class="input-group-addon">
                                                        <i class="ion ion-social-usd"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            </div>
                                        ';
                                    }

                                    ?>
                                </div>
                                <!--Lista de los productos a guardar en la base-->
                                <input type="hidden" id="listaProductos" name="listaProductos">
                                <button type="button" class="btn btn-primary hidden-lg btnAgregarProducto">Agregar Producto</button>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-8 pull-right">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Impuesto</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width:50%">
                                                        <div class="input-group">
                                                        <input type="number" class="form-control" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php echo $porcentajeImpuesto;  ?>" min="0" placeholder="0" required>
                                                        <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $venta["impuesto"]; ?>">
                                                        <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $venta["neto"]; ?>" required>
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-percent"></i>
                                                        </span>
                                                        </div>
                                                    </td>
                                                    <td style="width:50%">
                                                        <div class="input-group">
                                                        <input type="text" class="form-control" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $venta["neto"]; ?>" min="0" value="<?php echo $venta["total"]; ?>"required>
                                                        <input type="hidden" id="totalVenta" name="totalVenta" value="<?php echo $venta["total"]; ?>">
                                                        <span class="input-group-addon">
                                                            <i class="ion ion-social-usd"></i>
                                                        </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--Formas de pago-->
                                <br>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <select class="form-control" name="nuevoMetodoPago" id="nuevoMetodoPago" required>
                                                <option value="">Seléccione método de pago</option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="TC">Tarjeta Crédito</option>
                                                <option value="TD">Tarjeta Débito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cajasMetodoPago">
                                    
                                    </div>
                                    <!--Lista metodo de pago-->
                                    <input type="hidden" name="listaMetodoPago" id="listaMetodoPago" required>
                                </div> 
                            </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Guardar Cambios</button>
                    </div>
                    </form>
                    <?php
                        $editarVenta = new ControladorVentas();
                        $editarVenta -> ctrEditarVenta();
                    ?>
                </div>
            </div>
         <!--Tabla de productos-->
            <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
                <div class="box box-warning">
                    <div class="box-header width-border"></div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped dt-responsive tablaVentas" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:10px">#</th>
                                    <th>Imagen</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
                <input type="text" class="form-control" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
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