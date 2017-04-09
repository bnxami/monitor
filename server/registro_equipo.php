<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

if(isset($_POST['token'])){
	
	$usuario = $_REQUEST["user"];
	$password = $_REQUEST["password"];
	$token = $_REQUEST["token"];
	$equipo = $_REQUEST["equipo"];
	
//Comprobar si existe el usuario:
	
	$bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");
	
		$consulta = "SELECT * FROM usuarios WHERE nombre ='".$usuario."' AND password ='".$password."'";
		$resultado = mysqli_query($bd,$consulta);
		$totalRegistros = mysqli_num_rows($resultado);
        
				
				 if($totalRegistros == 1){
					 echo "si";
					 
						$consulta = "SELECT * FROM equipos WHERE token ='$token'";
						$resultado = mysqli_query($bd,$consulta);
						$totalRegistros = mysqli_num_rows($resultado);		
					 		
					 		if($totalRegistros == 1){
								 echo "existe";	
		
							}
					 		else{
									$consulta = "SELECT * FROM usuarios WHERE nombre ='".$usuario."' AND password ='".$password."'";
									$resultado = mysqli_query($bd,$consulta);
									$totalRegistros = mysqli_num_rows($resultado);	
									$fila = mysqli_fetch_row($resultado);
									$id = $fila[0];
					 				$fecha = date("Y-m-d");
								
									$consulta2 = "INSERT INTO equipos (token,id,nom,fecha_registro) VALUES ('".$token."','".$id."','".$equipo."','".$fecha."')";
			  						$resultado2 = mysqli_query($bd,$consulta2);
							}
				 }
            	else
            	{
                
             	 echo "no";
                
            	}
			   
}else{

    $_usuario = $_REQUEST["user"];
    $_password = $_REQUEST["password"];
	   
    
    $bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");
		

		$consulta = "SELECT * FROM usuarios WHERE nombre ='".$_usuario."' AND password ='".$_password."'";
		
		$resultado = mysqli_query($bd,$consulta);
    
		$totalRegistros = mysqli_num_rows($resultado);
        
            if($totalRegistros == 1)
            {
               echo "si";
                
            }
            else
            {
                
              echo "no";
                
            }
	
}

?>
