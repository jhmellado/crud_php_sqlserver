<script>
    $(document).ready(function() {
        $('#casosDataList').DataTable({
            "ajax": "server_side/server_processing.php",
            "processing": true,
            "serverSide": true,
        })
    })
</script>

<div class="container">
    <table id="casosDataList" class="display" style="width:80%">
        <thead>
            <tr>
                <th>#</th>
                <th>USUARIO</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>GENERO</th>
            </tr>
        </thead>
    </table>
</div>

<?php
// $json_data_ReporteCasos = file_get_contents('server_side/data-primeros-casos.json');


// $dataArrayReporteCasos = json_decode($json_data_ReporteCasos, true);

// // print_r($dataArrayReporteCasos['rows']);

// usort($dataArrayReporteCasos['rows'], function($a, $b) {
//     return strtotime($a['creation_date']) - strtotime($b['creation_date']);
// });

// // Recorrer el array ordenado con un bucle foreach
// echo "Reporte Casos<br>";
// $numeroCasos = count($dataArrayReporteCasos['rows']);
// echo "Numero de Casos: $numeroCasos<br>";
// foreach ($dataArrayReporteCasos['rows'] as $item) {
//     $leadId = $item['leadId'];
//     $creationDate = date('Y-m-d',strtotime($item['creation_date']));
//     $lastDate = date('Y-m-d',strtotime($item['last_date']));
//     $closingDate = date('Y-m-d',strtotime($item['closing_date']));
//     $idAgente = $item['id_agent'];
    

//     echo "Caso: $leadId,Fecha Creación: $creationDate, Fecha Última Actualización: $lastDate, Fecha Cierre: $closingDate, ID Agente: $idAgente<br>";
// }
?>