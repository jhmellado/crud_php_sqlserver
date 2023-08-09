<?php
require_once('./config/database/DataBase.php');
require_once 'main.php';

// Almacenar datos

$usuario = clean_string($_POST['usuario']);
$password = clean_string($_POST['password']);

// Verificando campos obligatorios

if ($usuario == "" || $password == "") {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
    exit();
}

// Verficando Usuario

if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
    exit();
}

// Verificando Password


if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $password)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES no coinciden con el formato solicitado
        </div>
    ';
    exit();
}
$conexion = new DataBase;
$check_usuario = $conexion->conectar();
$check_usuario = $check_usuario->query("SELECT * FROM usuario 
                                          WHERE username = '$usuario'
                                        ");
if ($check_usuario->rowCount() == 1) {
    $check_usuario = $check_usuario->fetch();
    if ($check_usuario['username'] == $usuario &&
        password_verify($password, $check_usuario['password'])) {

            $_SESSION['id'] = $check_usuario['id'];
            $_SESSION['usuario'] = $check_usuario['username'];
            $_SESSION['nombre'] = $check_usuario['name'];
            $_SESSION['apellido'] = $check_usuario['lastname'];
            $_SESSION['email'] = $check_usuario['email'];

            if (headers_sent()) {
                echo "<script>window.location.href='index.php?view=home'</script>";
            } else {
                header("Location: index.php?view=home");
            }
            
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            USUARIO o CLAVE incorrectos
        </div>
    ';
    }
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            USUARIO o CLAVE incorrectos
        </div>
    ';
}
$check_usuario = null;