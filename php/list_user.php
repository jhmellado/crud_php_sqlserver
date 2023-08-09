<?php
// Si por algún motivo $pagina <= 0 entonces $inicio = 0
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

// Consultas a la DB dependiendo si hay una inserción en el campo de busqueda o no
[$consulta_datos, $consulta_total] = (isset($busqueda) && $busqueda != "") ?
    [
        "SELECT * FROM usuario WHERE ((id != '" . $_SESSION['id'] . "') 
                     AND (name LIKE '%$busqueda%' OR lastname LIKE '%$busqueda%' 
                     OR username LIKE '%$busqueda%' OR email LIKE '%$busqueda%')) 
                     ORDER BY name ASC LIMIT $inicio,$registros"
        ,
        "SELECT COUNT(id) FROM usuario WHERE ((id!='" . $_SESSION['id'] . "') 
                     AND (name LIKE '%$busqueda%' OR lastname LIKE '%$busqueda%' 
                     OR username LIKE '%$busqueda%' OR email LIKE '%$busqueda%'))"
    ]
    :
    [
        "SELECT * FROM usuario WHERE id!='" . $_SESSION['id'] . "' 
                    ORDER BY name ASC LIMIT $inicio,$registros"
        ,
        "SELECT COUNT(id) FROM usuario WHERE id!='" . $_SESSION['id'] . "'"
    ];

// Conexión a la DB y ejecución de las consultas
$conexion = conectar();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll(); // Almacenamiento de los registros

$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn(); // Almacenamiento del total de registros

// Total de páginas
$Npaginas = ceil($total / $registros); // ceil() redondea hacia arriba

// Cadena vacía para generar el listado de usuarios
$tabla = "";

$tabla .= '
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach ($datos as $rows) {
        $tabla .= '
				<tr class="has-text-centered" >
					<td>' . $contador . '</td>
                    <td>' . $rows['name'] . '</td>
                    <td>' . $rows['lastname'] . '</td>
                    <td>' . $rows['username'] . '</td>
                    <td>' . $rows['email'] . '</td>
                    <td>
                        <a href="index.php?view=user_update&user_id_up=' . $rows['id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="' . $url . $pagina . '&user_id_del=' . $rows['id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
				<tr class="has-text-centered" >
					<td colspan="7">
						<a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
    } else {
        $tabla .= '
				<tr class="has-text-centered" >
					<td colspan="7">
						No hay registros en el sistema
					</td>
				</tr>
			';
    }
}


$tabla .= '</tbody></table></div>';

if ($total > 0 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando usuarios <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
}

// Cerrar la conexión a la DB
$conexion = null;

// Se muestra la tabla de usuarios
echo $tabla;

// Se muestra el paginador
if ($total >= 1 && $pagina <= $Npaginas) {
    echo pagination_tables($pagina, $Npaginas, $url, 7);
}