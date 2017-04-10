<?php
session_start();

if(isset($_SESSION['usuario'])){
  
error_reporting(E_ALL);
ini_set("display_errors", 1);


/*
Comentaris:
He llevat tot el bootstrap i demés perquè no és un php per a fer una web. En aquest cas, sols ha de retornar un json 
En el teu codi fas 3 consultes, sols cal fer una completa. 
Com que es guarda en json, he transformat el que no en json i afegit les coses que ja estaven en eixe format
*/

$token = $_GET['e'];
	
  $bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");

		
		$consulta2 = "SELECT * FROM registros WHERE token = '".$token."' AND hora = (SELECT MAX(hora) FROM registros where token ='".$token."')";
		$resultado2 = mysqli_query($bd,$consulta2);
		//$totalRegistros2 = mysqli_num_rows($resultado2);
		$row = mysqli_fetch_assoc($resultado2);
	    $toteslesdades=$row;
	unset($row['discos']);
	unset($row['tarjetas']);
	
	    echo "{ \"datos\": ".json_encode($row);
	    echo ", \"discos\": ".$toteslesdades['discos'];
	    echo ", \"tarjetas\": ".$toteslesdades['tarjetas']." }";
}
?>
