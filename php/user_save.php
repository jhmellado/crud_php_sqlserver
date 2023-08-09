<?php

require_once "main.php";

// Almacenando datos
$nombre = clean_string($_POST['usuario_nombre']);
$apellido = clean_string($_POST['usuario_apellido']);
$usuario = clean_string($_POST['usuario_usuario']);
$email = clean_string($_POST['usuario_email']);
$password_1 = clean_string($_POST['usuario_clave_1']);
$password_2 = clean_string($_POST['usuario_clave_2']);


// Verificando campos obligatorios 
if ($nombre == "" || $apellido == "" || $usuario == "" || $password_1 == "" || $password_2 == "") {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
    exit();
}


/*== Verificando integridad de los datos ==*/
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
            </div>
        ';
    exit();
}

if (
    verificar_datos(
        "[a-zA-Z0-9$@.-]{7,100}",
        $password_1
    ) ||
    verificar_datos(
        "[a-zA-Z0-9$@.-]{7,100}",
        $password_2
    )
) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVES no coinciden con el formato solicitado
            </div>
        ';
    exit();
}

/*== Verificando claves ==*/
if ($password_1 != $password_2) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVES que ha ingresado no coinciden
            </div>
        ';
    exit();
} else {
    $clave = password_hash($password_1, PASSWORD_BCRYPT, ["cost" => 10]);
}

/*== Verificando email ==*/
if ($email != "") {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conectar();
        $check_email = $check_email->query("SELECT email FROM usuario WHERE email='$email'");
        if ($check_email->rowCount() > 0) {
            echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
            exit();
        }
        $check_email = null;
    } else {
        echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
        exit();
    }
}


/*== Verificando usuario ==*/
$check_usuario = conectar();
$check_usuario = $check_usuario->query("SELECT username FROM usuario WHERE username='$usuario'");
if ($check_usuario->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
    exit();
}
$check_usuario = null;


/*== Guardando datos ==*/
$guardar_usuario = conectar();
$guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario(name,lastname,username,password,email) 
                                              VALUES(:nombre,:apellido,:usuario,:clave,:email)");

$marcadores = [
    ":nombre" => $nombre,
    ":apellido" => $apellido,
    ":usuario" => $usuario,
    ":clave" => $clave,
    ":email" => $email
];

$guardar_usuario->execute($marcadores);

if ($guardar_usuario->rowCount() == 1) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO REGISTRADO!</strong><br>
                El usuario se registro con exito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el usuario, por favor intente nuevamente
            </div>
        ';
}
$guardar_usuario = null;