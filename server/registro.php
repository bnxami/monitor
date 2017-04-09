<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

if(isset($_POST['entrar'])){

    $_SESSION["usuario"] = $_REQUEST["user"];
    $_SESSION["password"] = $_REQUEST["password"];
	  
    
    $bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");
		

		$consulta = "SELECT nombre FROM usuarios WHERE nombre ='".$_SESSION["usuario"]."' AND password ='".SHA1($_SESSION["password"])."'";
		$resultado = mysqli_query($bd,$consulta);
		$totalRegistros = mysqli_num_rows($resultado);
        $fila = mysqli_fetch_row($resultado);
				$_SESSION["id"] = $fila[0];
            if($totalRegistros == 1)
            {
				
              
				header("Location: perfil.php");
                
            }
            else
            {
                
               header("Location: index.html");
                
            }
	
mysql_close($db);
}

if(isset($_POST['registrar'])){
	
	$usuario = $_REQUEST["user"];
	$password = $_REQUEST["password"];
	$email = $_REQUEST["email"];
	
	
//Comprobar si existe el usuario:
	
	$bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");
	
	$consulta = "SELECT * FROM usuarios WHERE nombre ='".$usuario."' OR email ='".$email."'";
		$resultado = mysqli_query($bd,$consulta);
    
		$totalRegistros = mysqli_num_rows($resultado);
        
			if($totalRegistros == 0) {
				$consulta = "INSERT INTO usuarios (nombre, email, password) VALUES ('".$usuario."','".$email."','".SHA1($password)."')";
			  
			   $resultado = mysqli_query($bd,$consulta);
               
				header("Location: index.html?reg=ok");
               
            }
			else{
                
              echo '<script language="javascript">alert("El usuario ya existe.");</script>'; 
				
			
            }

//mysql_close($db);
   
}
		
?>

