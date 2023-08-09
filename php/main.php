<?php

// Crear una conexión a la RDMS con la clase PDO
function conectar(){
    try {
        $conn = new PDO("mysql:host=localhost;dbname=inventario", 'root', '');
        // Establecer el modo de error para PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
    return $conn;
}
//
// Verificar datos
function verificar_datos($filtro, $cadena){
    if (preg_match("/^".$filtro."$/",$cadena)) {
        return false;
    } else {
        return true;
    } 
}
//

// Función para evitar SQL Injection y limpiar cadenas de texto
function clean_string($cadena){
    $cadena = trim($cadena); // Elimina espacios antes y después de la cadena
    $cadena = stripslashes($cadena); // Elimina backslashes
    $cadena = str_ireplace("<script>", "", $cadena); // Elimina las etiquetas <script>"); // 
    $cadena = str_ireplace("</script>", "", $cadena); // Elimina las etiquetas </script>
    $cadena = str_ireplace("<script src=", "", $cadena); // Elimina las etiquetas <script src="
    $cadena = str_ireplace("<script type=", "", $cadena); // Elimina las etiquetas <script type="
    $cadena = str_ireplace("SELECT * FROM", "", $cadena); // Elimina las etiquetas SELECT * FROM
    $cadena = str_ireplace("DELETE FROM", "", $cadena); // Elimina las etiquetas DELETE FROM
    $cadena = str_ireplace("INSERT INTO", "", $cadena); // Elimina las etiquetas INSERT INTO
    $cadena = str_ireplace("DROP TABLE", "", $cadena); // Elimina las etiquetas DROP TABLE
    $cadena = str_ireplace("DROP DATABASE", "", $cadena); // Elimina las etiquetas DROP DATABASE
    $cadena = str_ireplace("UPDATE", "", $cadena); // Elimina las etiquetas UPDATE
    $cadena = str_ireplace("TRUNCATE", "", $cadena); // Elimina las etiquetas TRUNCATE
    $cadena = str_ireplace("SHOW TABLES", "", $cadena); // Elimina las etiquetas SHOW TABLES
    $cadena = str_ireplace("SHOW DATABASES", "", $cadena); // Elimina las etiquetas SHOW DATABASES
    $cadena = str_ireplace("<?php", "", $cadena); // Elimina las etiquetas <?php
    $cadena = str_ireplace("?>", "", $cadena); // Elimina las etiquetas ? > (sin espacio)
    $cadena = str_ireplace("?", "", $cadena); // Elimina las etiquetas ?
    $cadena = str_ireplace("'", "", $cadena); // Elimina las comillas
    $cadena = str_ireplace('"', "", $cadena); // Elimina las comillas
    $cadena = str_ireplace("--", "", $cadena); // Elimina los --
    $$cadena = str_ireplace("<", "", $cadena); // Elimina los <
    $cadena = str_ireplace("^", "", $cadena); // Elimina los ^
    $cadena = str_ireplace("]", "", $cadena); // Elimina los ]
    $cadena = str_ireplace("[", "", $cadena); // Elimina los [
    $cadena = str_ireplace("==", "", $cadena); // Elimina los =="
    $cadena = str_ireplace(";","",$cadena); // Elimina los ;
    $cadena = str_ireplace("::","",$cadena); // Elimina los ::
    return $cadena;
};

// Renombrar imagenes
function rename_images($name){
    $name = str_ireplace(" ", "_", $name);
    $name = str_ireplace(".", "_", $name);
    $name = str_ireplace(",", "_", $name);
    $name = str_ireplace("-", "_", $name);
    $name = str_ireplace("/", "_", $name);
    $name = str_ireplace("\\", "_", $name);
    $name = str_ireplace("#", "_", $name);
    $name = str_ireplace("$","_",$name);
    $name = $name ."_".rand(0,100);
    return $name;
}

// Pagination of tables
function pagination_tables($pagina, $paginas, $url, $botones){
    $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

        $tabla .= ($pagina <= 1) ? '<a class="pagination-previous is-disabled" disabled>Anterior</a>
                                    <ul class="pagination-list">'
                                 : '<a class="pagination-previous" href="'.$url.($pagina-1).'">Anterior</a>
                                    <ul class="pagination-list">
                                        <li><a class="pagination-link" href='.$url."1".'>1</a></li>
                                        <li><span class="pagination-ellipsis">&hellip;</span></li>';
  
        
        // Generando los botones de la paginación
        $ci = 0;
        for ($i=$pagina; $i <= $paginas ; $i++) { 
            if ($ci >= $botones) {
                break;
            }
            $tabla .= ($pagina == $i) ? '<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>'
                                      : '<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';

            $ci++;
        }
        //

        $tabla .= ($pagina == $paginas) ? ' 
                                    </ul>
                                    <a class="pagination-next is-disabled" disabled>Siguiente</a>'
                                    : '
                                        <li><span class="pagination-ellipsis">&hellip;</span></li>
                                        <li><a class="pagination-link" href="'.$url.$paginas.'">'.$paginas.'</a></li>
                                    </ul>
                                    <a href="'.$url.($pagina+1).'" class="pagination-next">Siguiente</a>';  

    $tabla.= '</nav>';
    return $tabla;
}


