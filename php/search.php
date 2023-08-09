<?php
	// La variable $modulo_buscador se usa para determinar en que tabla se realizará la búsqueda
	$modulo_buscador = clean_string($_POST['modulo_buscador']);
	
	// $modulos se utiliza para almacenar todos los nombres de tablas de la base de datos
	$modulos = ["usuario","categoria","producto"];

	//Se verifica que el value de $modulo_buscador esté dentro de $modulos
	// Dado que el input type = "hidden" se podría manipular
	if(in_array($modulo_buscador, $modulos)){
		
		// $modulos_url es un array que contiene los nombres de las vistas de la aplicacion
		// en las cuales según su key se mostraran los registros posteriomente
		$modulos_url = [
			"usuario"=>"user_search",
			"categoria"=>"category_search",
			"producto"=>"product_search"
		];

		// Se reasigna la variable $modulos_url a la vista correspondiente
		$modulos_url = $modulos_url[$modulo_buscador];

		// Se reasigna la variable $modulo_buscador
		// ej: si $modulo_buscador = "usuario" entonces $modulo_buscador = "busqueda_usuario"
		$modulo_buscador = "busqueda_".$modulo_buscador;


		// Buscar si $_POST['txt_buscador'] está definido 
		// es decir si el usuario ha presionado el botón buscar
		if(isset($_POST['txt_buscador'])){

			$txt = clean_string($_POST['txt_buscador']);

			if($txt == ""){
				echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                Introduce el termino de busqueda
		            </div>
		        ';
			} elseif (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. ]{1,30}", $txt))
			{
				echo '
					<div class="notification is-danger is-light">
						<strong>¡Ocurrio un error inesperado!</strong><br>
						El termino de búsqueda no coincide con el formato solicitado
					</div>
				';
			}else{
				// Aquí es donde se definen variables como $_SESSION['busqueda_usuario']
				// Es lo que permite almacenar el termino de búsqueda
				// Y posteriormente poder mostrarlos en la vista correspondiente
				$_SESSION[$modulo_buscador] = $txt;
				// Definido el valor se redirige a la vista correspondiente
				header("Location: index.php?view=$modulos_url",true,303); 
				exit();  
			}
			
		}


		// Eliminar busqueda si $_POST['eliminar_buscador'] está definido
		// Se define al presionar el botón Eliminar búsqueda
		if(isset($_POST['eliminar_buscador'])){
			unset($_SESSION[$modulo_buscador]);
			header("Location: index.php?view=$modulos_url",true,303); 
 			exit();
		}

	}else{
		echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos procesar la peticion
            </div>
        ';
	}