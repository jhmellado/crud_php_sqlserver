<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">  
    <?php
        require_once "./php/main.php";

        // Eliminar usuario que se obtiene a través de la url
        //'.$url.$pagina.'&user_id_del='.$rows['id'].'
        if(isset($_GET['user_id_del'])){
            require_once "./php/delete_user.php";
        }  

        /* Establecer paginador en la primera pagína
           siempre y cuando no se haya pasado por la url
           "index.php?view=user_list&page=" */
        $pagina = !isset($_GET['page']) ? 1 // Si no está definida $_GET['page'] se asigna pag 1
                                        :
                                         max(1, (int)$_GET['page']); // Si está definida pero podria ser 
                                                                    // un valor negativo, por lo que se asigna 1

        $pagina=clean_string($pagina);
        $url="index.php?view=user_list&page=";
        $registros=1;
        $busqueda="";

        # Paginador usuario #
        require_once "./php/list_user.php";
    ?>
</div>