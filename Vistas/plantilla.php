<?php

session_start();
?>


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="Vistas/img/plantilla/icono-negro.png">
    
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="Vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="Vistas/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="Vistas/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="Vistas/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="Vistas/dist/css/skins/_all-skins.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
     <!-- DataTables -->
    <link rel="stylesheet" href="Vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="Vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <!--Mis estilos-->
    <link rel="stylesheet" href="Vistas/css/style.css">
    <!--Plugin de check-->
    <link rel="stylesheet" href="Vistas/plugins/iCheck/all.css">
    <!--Daterangepicker-->
    <link rel="stylesheet" href="Vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="Vistas/bower_components/morris.js/morris.css">

    
    <!-- jQuery 3 -->
    <script src="Vistas/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="Vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="Vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="Vistas/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="Vistas/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- DataTables -->
    <script src="Vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="Vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="Vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="Vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <!-- SweetAlert 2 -->
    <script src="Vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
    <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!--Plugin de check-->
    <script src="Vistas/plugins/iCheck/icheck.min.js"></script>
    
    <!-- InputMask -->
    <script src="Vistas/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="Vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="Vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!--Jquery number-->
    <script src="Vistas/plugins/jqueryNumber/jquery.number.js"></script>
    <!--daterabgepicker-->
    <script src="Vistas/bower_components/moment/min/moment.min.js"></script>
    <script src="Vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
    <script src="Vistas/bower_components/raphael/raphael.min.js"></script>
    <script src="Vistas/bower_components/morris.js/morris.min.js"></script>

    <!-- ChartJS http://www.chartjs.org/-->
    <script src="Vistas/bower_components/chart.js/Chart.js"></script>
 

</head>
<body class="hold-transition skin-blue  sidebar-mini login-page">
<!-- Site wrapper -->

<?php
if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok")
    {
    echo '<div class="wrapper">';
    //Cabecera
    include "Modulos/cabezote.php";
    //Menu lateral
    include "Modulos/menu.php";
    //Contenido
    if(isset($_GET["ruta"])){

        if($_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "categorias" ||
        $_GET["ruta"] == "productos" ||
        $_GET["ruta"] == "clientes" ||
        $_GET["ruta"] == "ventas" ||
        $_GET["ruta"] == "crear-ventas" ||
        $_GET["ruta"] == "editar-ventas" ||
        $_GET["ruta"] == "reportes" ||
        $_GET["ruta"] == "salir"){

        include "Modulos/".$_GET["ruta"].".php";

        }else{
            include "Modulos/404.php";
        }
    }else{
        include "Modulos/inicio.php";
    }

    //Footer
    include "Modulos/footer.php";
    echo '</div>';
}else{
    include "Modulos/login.php";
}
?>
 

</body>
<script src="Vistas/js/plantilla.js"></script>
<script src="Vistas/js/usuarios.js"></script>
<script src="Vistas/js/categorias.js"></script>
<script src="Vistas/js/productos.js"></script>
<script src="Vistas/js/clientes.js"></script>
<script src="Vistas/js/ventas.js"></script>
<script src="Vistas/js/reportes.js"></script>
<!-- ./wrapper -->
