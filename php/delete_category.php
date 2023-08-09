<?php
	/*== Almacenando datos ==*/
    $category_id_del=clean_string($_GET['category_id_del']);

    /*== Verificando usuario ==*/
    // Se crea una conexión para verificar la existencia de la categoría a eliminar
    $check_categoria=conectar();
    $check_categoria=$check_categoria->query("SELECT id FROM categoria WHERE id='$category_id_del'");
    // Si la categoria existe 
    if($check_categoria->rowCount()==1){
        // Se crea una conexión para verificar la existencia de productos asociados a la categoría a eliminar
        // Si existe un producto con esta categoria entonces no se puede eliminar
    	$check_productos=conectar();
    	$check_productos=$check_productos->query("SELECT category FROM productos WHERE category='$category_id_del' LIMIT 1");

    	if($check_productos->rowCount()<=0){

    		$eliminar_categoria=conectar();
	    	$eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM categoria WHERE id=:id");

	    	$eliminar_categoria->execute([":id"=>$category_id_del]);

	    	if($eliminar_categoria->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡CATEGORIA ELIMINADA!</strong><br>
		                Los datos de la categoría se eliminaron con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar la categoría, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_categoria=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar la categoría ya que tiene productos asociados
	            </div>
	        ';
    	}
    	$check_productos=null;
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CATEGORIA que intenta eliminar no existe
            </div>
        ';
    }
    $check_categoria=null;