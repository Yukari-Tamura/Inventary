<?php

require_once "../../Controladores/ventas.controlador.php";
require_once "../../Modelos/ventas.modelo.php";
require_once "../../Controladores/clientes.controlador.php";
require_once "../../Modelos/clientes.modelo.php";
require_once "../../Controladores/usuarios.controlador.php";
require_once "../../Modelos/usuarios.modelo.php";
$reporte = new ControladorVentas();
$reporte -> ctrDescargarReporte();





?>