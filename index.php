<?php
    require("./inc/session_start.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        include("./inc/head.php");
    ?>
</head>
<body> 
    <?php 
        include('./server_side/server_side_table.php');
    ?>
    <?php
        if (!isset($_GET['view']) || $_GET['view'] == "") {
            $_GET['view'] = "login";
        } 

        if(is_file("./view/" . $_GET['view'] . ".php") 
        && $_GET['view'] != "login"
        && $_GET['view'] != "404"){

            // Filtro de seguridad para usuarios no logueados
            if((!isset($_SESSION['id']) || $_SESSION['id'] == "" || $_SESSION['usuario'] == "")){
                include("./view/logout.php");
                exit();
            }
            //

            include("./inc/navbar.php");
            include("./view/" . $_GET['view'] . ".php");
            include("./inc/script.php");
        } elseif ($_GET['view'] == 'login') {
            include("./view/login.php");
        } else {
            include("./view/404.php");
        }
    ?>
</body>
</html>