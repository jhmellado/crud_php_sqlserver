<?php

require_once "../php/main.php";

//Almacenando datos del formulario
$nombre = clean_string($_POST['nombre']);
$ubicacion = clean_string($_POST['ubicacion']);

//verificando que no haya campos vacios
if ($nombre == "" || $ubicacion == "") {
    echo '
        <div class="notification is-danger is-light" role="alert">
            <strong>¡Ha ocurrido un error inesperado!</strong> <br>
            No has llenado todos los campos obligatorios.
        </div>
    ';
    exit();
};

// Verificando integridad de datos
if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){

}
