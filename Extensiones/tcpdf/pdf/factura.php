<?php
require_once "../../../Controladores/ventas.controlador.php";
require_once "../../../Modelos/ventas.modelo.php";
require_once "../../../Controladores/clientes.controlador.php";
require_once "../../../Modelos/clientes.modelo.php";
require_once "../../../Controladores/usuarios.controlador.php";
require_once "../../../Modelos/usuarios.modelo.php";
require_once "../../../Controladores/productos.controlador.php";
require_once "../../../Modelos/productos.modelo.php";

class imprimirFactura{
public $codigo;

public function traerImpresionFactura(){
//Traemos la informacion de la venta
$itemVenta = "codigo";
$valorVenta = $this->codigo;
$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);

//Traemos la informacion del cliente
$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];
$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//Traemos la informacion del vendedor
$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];
$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);


require_once('tcpdf_include.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

//primer bloque de maquetacion
$bloque1 = <<<EOF

	<div style="width: 540px; background-color: #820024; color: #fff; font-size: 14px; text-align:center">
		<br>
		<span style="font-weight:bold">FACTURACIÓN ELECTRONICA</span>
		<br>
	</div>
	<br>
	<table>
		<tr>
			<td style="width:150px;border-bottom: solid 1px #820024">
				<img src="https://sakura-hikkoshi.sakura.ne.jp/common/images/shop_logo.gif">
			</td>
			<td style="background-color:white; width:140px; border: solid 1px #F8F9F9;border-bottom: solid 1px #820024">
				<div style="font-size:8.5px; text-align:right; line-height:15px">
					<br>
					NIT: 71.759.963-9
					<br>
					Dirección: San Francisco California
				</div>	
			</td>
			<td style="background-color:white; width:140px; border: solid 1px #F8F9F9; border-bottom: solid 1px #820024">
				<div style="font-size:8.5px; text-align:right; line-height:15px">
					<br>
					Teléfono : +593 98 439 3362
					<br>
					Correo : lifeshoft-code@gmail.com
				</div>	
			</td>
			<td style="background-color:white; width:110px; border: solid 1px #F8F9F9;border-bottom: solid 1px #820024">
				<div style="font-size:8.5px; text-align:center; line-height:15px; color:red;">
					<br>
					<span style="font-weight: bold;color:red;">FACTURA N°</span>
					<br>$valorVenta 
				</div>	
			</td>
		</tr>
	</table>

EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');

//Segundo Bloque
$bloque2 = <<<EOF
	<br>
	<br>
	<table style="font-size:10px; padding:5px 10px;border: solid 1px #F8F9F9">
		<tr>
			<td style="border: 1px solid #F8F9F9; background-color:white; width:390px">
			Cliente : $respuestaCliente[nombre]
			</td>
			<td style="border: 1px solid #F8F9F9; background-color:white; width:150px">
				Fecha : $fecha
			</td>
		</tr>
		<tr>
		<td style="border: 1px solid #F8F9F9; background-color:white; width:540px">
		Dirección : $respuestaCliente[direccion]
		</td>
		</tr>
		<tr>
		<td style="border: 1px solid #F8F9F9; background-color:white; width:540px">
		Télefono : $respuestaCliente[telefono]
		</td>
		</tr>
		<tr>
		<td style="border: 1px solid #F8F9F9; background-color:white; width:540px;">
		Correo : $respuestaCliente[email]
		</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');

//Bloque 3
$bloque3 = <<<EOF
<br>
<br>
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:100px;background-color: #820024; color: #fff;font-weight:bold;text-align:center;">Cantidad</td>
			<td style="width:240px;background-color: #820024; color: #fff;font-weight:bold;text-align:center;">Producto</td>
			<td style="width:100px;background-color: #820024; color: #fff;font-weight:bold;text-align:center;">valor Unitario</td>
			<td style="width:100px;background-color: #820024; color: #fff;font-weight:bold;text-align:center;">Valor Total</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
foreach($productos as $key => $item){
$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;
$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);
$valorUnitario = number_format($respuestaProducto["precio_venta"],2);
$precioTotal = number_format($item["total"],2);
//Bloque 4
$bloque4 = <<<EOF
<table style="font-size:11px; padding:5px 10px;">
<tr>
<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;">$item[cantidad]</td>
<td style="width:240px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0; ">$item[descripcion]</td>
<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0; ">$valorUnitario</td>
<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;">$precioTotal</td>

</tr>
</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
//Bloque 5
$bloque5 = <<<EOF
<br>
<br>
<table style="font-size:11px;padding:5px 10px;">
	<tr>
	<td style="width:340px;text-align:center;border: solid 1px #FFFFFF;border-right:solid 1px #E5E7E9;margin: 30px 0;"></td>
	<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;font-weight:bold;">Neto</td>
	<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;">$neto</td>
	</tr>
	<tr>
	<td style="width:340px;text-align:center;border: solid 1px #FFFFFF;border-right:solid 1px #E5E7E9;margin: 30px 0;"></td>
	<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;font-weight:bold;">Impuesto</td>
	<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;">$impuesto</td>
	</tr>
	<tr>
	<td style="width:340px;text-align:center;border: solid 1px #FFFFFF;border-right:solid 1px #E5E7E9;margin: 30px 0;"></td>
	<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;font-weight:bold;">Total</td>
	<td style="width:100px;text-align:center;border: solid 1px #E5E7E9;margin: 30px 0;">$total</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque5, false, false, false, false, '');
//Bloque 6

$pdf->Output('factura.pdf');

}
}
$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();
?>