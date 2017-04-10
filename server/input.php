<?php   

if(isset($_POST['token'])){

	$token = $_POST['token'];
	$hora = $_POST['hora'];

//DATOS EQUIPO
	$nombre = $_POST['nombre'];
	$usuarios = $_POST['usuarios'];
	$tiempo_encendido = $_POST['tiempo_encendido'];
	$arranque_sistema = $_POST['arranque_sistema'];
	$ip_publica = $_POST['ip_publica'];

//CPU
	$procesador = $_POST['procesador'];
	$cache_procesador = $_POST['cache_procesador'];
	$nucleos = $_POST['nucleos'];
	$ghz_procesador = $_POST['ghz_procesador'];
	$direc_fisic = $_POST['direc_fisic'];
	$direc_logic = $_POST['direc_logic'];
	$uso_cpu = $_POST['uso_cpu'];
//RAM
	$mem_total = $_POST['mem_total']; 
	$mem_usada = $_POST['mem_usada']; 
	$mem_libre = $_POST['mem_libre']; 
	
	$mem_disponible = $_POST['mem_disponible']; 
	$mem_cache = $_POST['mem_cache']; 
	
	$swap_total = $_POST['swap_total']; 
	$swap_usada = $_POST['swap_usada'];  
	$swap_libre = $_POST['swap_libre']; 
	
	$mem_swap_total = $_POST['mem_swap_total']; 
	$mem_usada_total = $_POST['mem_usada_total']; 
	$mem_libre_total = $_POST['mem_libre_total']; 
	
//DISCOS
	$discos = json_encode($_POST['discos']);

//TARJETAS_RED
	$tarjetas = json_encode($_POST['tarjetas']);

	
	$bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");
	
	//$consulta = "INSERT INTO equipo (token,hora,discos,tarjetas) VALUES ('".$token."','".$hora."','".$discos."','".$tarjetas."')";
	$consulta = "INSERT INTO registros 			(token,hora,nombre,usuarios,tiempo_encendido,arranque_sistema,ip_publica,procesador,cache_procesador,nucleos,ghz_procesador,direc_fisic,direc_logic,uso_cpu,mem_total,mem_usada,mem_libre,mem_disponible,mem_cache,swap_total,swap_usada,swap_libre,mem_swap_total,mem_usada_total,mem_libre_total,discos,tarjetas) VALUES ('".$token."','".$hora."','".$nombre."','".$usuarios."','".$tiempo_encendido."','".$arranque_sistema."','".$ip_publica."','".$procesador."','".$cache_procesador."','".$nucleos."','".$ghz_procesador."','".$direc_fisic."','".$direc_logic."','".$uso_cpu."','".$mem_total."','".$mem_usada."','".$mem_libre."','".$mem_disponible."','".$mem_cache."','".$swap_total."','".$swap_usada."','".$swap_libre."','".$mem_swap_total."','".$mem_usada_total."','".$mem_libre_total."','".$discos."','".$tarjetas."')";
	$resultado = mysqli_query($bd,$consulta);
	
	/*$consulta2 = "SELECT * FROM equipo WHERE token ='$token' AND hora = (SELECT MAX(hora) FROM equipo)";
	$resultado2 = mysqli_query($bd,$consulta2);
	$totalRegistros2 = mysqli_num_rows($resultado2);
		$fila2 = mysqli_fetch_row($resultado2);
		$disks = $fila2[2];
	
	var_dump(json_decode($disks));*/
}

?>
