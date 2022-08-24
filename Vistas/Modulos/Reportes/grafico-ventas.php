<?php
 error_reporting(0);
if(isset($_GET["fechaInicial"])){
   
    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];
  }else{
    $fechaInicial = null;
    $fechaFinal = null;
  }

      $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

      $arrayFechas = array();
      $arrayVentas = array();
      $sumaPagoMes = array();
      foreach($respuesta as $key => $value){
        $fecha = substr($value["fecha"],0,7);

        //Introducimos las fechas en el array
        array_push($arrayFechas, $fecha);
        //capturamos las ventas
        $arrayVentas = array($fecha => $value["total"]);
        
        //sumamos los pagos que ocurrieron en el mismo mes
        foreach($arrayVentas as $key => $value){
            $sumaPagoMes[$key] += $value;
            
        }
        
      }
      
      $noRepetirFecha = array_unique($arrayFechas);
      
?>

<!--Grafico de ventas-->
<div class="box box-solid" style="background:#34495E ;">
      <div class="box-header" style="color:#ffffff;">
        <i class="fa fa-th"></i>
        <h3 class="box-title">Gráfico de ventas</h3>
      </div>
      <div class="box-body border-radius-none nuevoGraficoVentas">
        <div class="chart" id="line-chart-ventas" style="height: 250px">
        
        </div>
      </div>
</div>
<script>
 var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [
        <?php
        if($noRepetirFecha != null){
            foreach($noRepetirFecha as $key){
                echo 
                "{ y: '".$key."', ventas: ".$sumaPagoMes[$key]." },";
            }
            echo "
                { y: '".$key."', ventas: ".$sumaPagoMes[$key]." }";
        }else{
            echo "{ y: '0', ventas: '0' }";
        }
        
      
        ?>
    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['ventas'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : '$',
    gridTextSize     : 10
  });
</script>