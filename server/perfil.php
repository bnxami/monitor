<?php
session_start();

if(isset($_SESSION['usuario'])){

error_reporting(E_ALL);
ini_set("display_errors", 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
  <script language="JavaScript" type="text/javascript">
   
     function show5(){
         if (!document.layers&&!document.all&&!document.getElementById)
         return

          var Digital=new Date()
          var hours=Digital.getHours()
          var minutes=Digital.getMinutes()
          var seconds=Digital.getSeconds()

         var dn="PM"
         if (hours<12)
         dn="AM"
         if (hours>12)
         hours=hours-12
         if (hours==0)
         hours=12

          if (minutes<=9)
          minutes="0"+minutes
          if (seconds<=9)
          seconds="0"+seconds
         //change font size here to your desire
         myclock="<font size='4' face='Arial' ><b>"+hours+":"+minutes+":"
          +seconds+" "+dn+"</b></font>"
         if (document.layers){
         document.layers.liveclock.document.write(myclock)
         document.layers.liveclock.document.close()
         }
         else if (document.all)
         liveclock.innerHTML=myclock
         else if (document.getElementById)
         document.getElementById("liveclock").innerHTML=myclock
         setTimeout("show5()",1000)
          }


         window.onload=show5
    
   </script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>	
    <div class="col-sm-8 text-left"> 
      <div><h1><span style="float:right" id="liveclock"></span> Hola <?php echo $_SESSION["usuario"]; ?>!</h1></div>

      <hr>
      <h3>Tus equipos:</h3>
      <table class="table table-striped">
    <thead>
      <tr>
        <th>Nombre del equipo</th>
        <th>Fecha registro</th>
        <th>Último inicio del sistema</th>
		<th>Email</th>
      </tr>
    </thead>
    <tbody>
		<?php
	   $bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");
    		$consulta2 = "SELECT * FROM usuarios WHERE nombre ='".$_SESSION["usuario"]."' AND password ='".SHA1($_SESSION["password"])."'";
			$resultado2 = mysqli_query($bd,$consulta2);
			$totalRegistros2 = mysqli_num_rows($resultado2);
			$fila2 = mysqli_fetch_row($resultado2);
			$id = $fila2[0];
    	
	
    		$consulta = "SELECT * FROM equipos WHERE id ='".$id."'";
    		$result = mysqli_query($bd,$consulta);
    		$totalRegistros = mysqli_num_rows($result);
 
			if ($totalRegistros < 1) {
				
		        echo'<tr>
					<td>Aún no tienes ningún equipo registrado. Descargate la herramienta de registro. <a href="descarga.php?archivo=registro.sh"><span class="glyphicon glyphicon-download-alt"></span></a></td>	    
					 
					</tr>';
  			
			}else{

	
				for ($x = 1; $x <= $totalRegistros; $x++) {
					$row = mysqli_fetch_row($result);
					$nombre = $row[2];
					$fecha_registro = $row[3];
					$token = $row[0];
		?>
      <tr>
		
		<td><?php echo "$row[2]";?></td>
        <td><?php echo "$row[3]";?></td>
        <td></td>
		<td></td>
		<td><a href="main.php?e=<?php echo "$token";?>"><span class="glyphicon glyphicon-share-alt"></span></a></td>
      </tr>
	  <?php }} ?>
    </tbody>
  </table>
    </div>
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>Herramienta de registro</p>
		  <a href="descarga.php?archivo=registro.sh"><span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
<?php
}
?>