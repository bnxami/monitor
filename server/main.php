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
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <style>
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
    
  </style>
  <style type="text/css">
${demo.css}
</style>

</head>
<body>
		
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>

<?php
$token = $_GET['e'];
	
  $bd = mysqli_connect("localhost","asix2_bnxa","bnxami","asix2-02_monitor","3306");

		$consulta = "SELECT * FROM equipos";
		$resultado = mysqli_query($bd,$consulta);

		$totalRegistros = mysqli_num_rows($resultado);
		$fila = mysqli_fetch_row($resultado);
		
		$consulta2 = "SELECT * FROM registros WHERE token = '".$token."' AND hora = (SELECT MAX(hora) FROM registros where token ='".$token."')";
		$resultado2 = mysqli_query($bd,$consulta2);
		$totalRegistros2 = mysqli_num_rows($resultado2);
		$row = mysqli_fetch_row($resultado2);
	   
	    	
			
		$consulta3 = "SELECT * FROM registros WHERE token ='".$token."' AND hora = (SELECT MAX(hora) FROM registros)";
		$resultado3 = mysqli_query($bd,$consulta3);
		$totalRegistros3 = mysqli_num_rows($resultado3);
		$fila3 = mysqli_fetch_row($resultado3);
		$disks = $fila3[25];

?>
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
<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="perfil.php"><span class="glyphicon glyphicon-menu-hamburger"></span>Monitor</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="perfil.php"> Perfil</a></li>
        <li><a href="#">Gender</a></li>
        <li><a href="#">Geo</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-2 sidenav hidden-xs">
      <h2>Monitor</h2>
      <ul class="nav nav-pills nav-stacked">
        <li class="active" ><a href="perfil.php?"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
        <li></li>
        <li><a href="#section3"></a></li>
        <li><a href="#section3"></a></li>
      </ul><br>
    </div>
    <br>
    <div class="col-sm-10">
      <div class="well">
		<div><h1><span style="float:right" id="liveclock"></span> Hola <?php echo $_SESSION["usuario"]; ?>!</h1></div> 
         <div class="table-responsive">          
			  <table class="table table-striped">
				<thead>
				  <tr>
					<th>Nombre del equipo: <?php echo "$row[2]"; ?></th>
				
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td><b>Procesador</b></td>
					<td><?php echo "$row[7]"; ?></td>
					<td><b>IP Pública</b></td>
					<td><?php echo "$row[6]"; ?></td>
				  </tr>
			       <tr>
					<td><b>RAM</b></td>
					<td><?php echo "$row[14] MB";?></td>
					<td><b>Usuarios</b></td>
					<td><?php echo "$row[3]"; ?></td>
				   </tr>
				    <tr>
					<td><b>Tiempo encendido</b></td>
					<td><?php echo "$row[4]  min";?></td>
					<td><b>Último inicio del sistema</b></td>
				    <td><?php echo "$row[5]"; ?></td>
					
				  </tr>
				</tbody>
			  </table>
  		</div>	
	  </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="well">
			  <h2>Memoria RAM</h2>        
			  <div class="table table-hover">          
				  <table class="table table-hover">
					<thead>
					  <tr>
						<th></th>
						<th>Total</th>
						<th>Usada</th>
						<th>Libre</th>
						<th>Disponible</th>
						<th>Memoria Caché</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td><b>Memoria</b></td>
						<td><?php echo "$row[14] MB"; ?></td>
						<td><?php echo "$row[15] MB"; ?></td>
						<td><?php echo "$row[16] MB"; ?></td>
						<td><?php echo "$row[17] MB"; ?></td>
						<td><?php echo "$row[18] MB"; ?></td>
					 </tr>	  
					 <tr>	  
						<td><b>Swap</b></td>
						<td><?php echo "$row[19] MB"; ?></td>
						<td><?php echo "$row[20] MB"; ?></td>
						<td><?php echo "$row[21] MB"; ?></td>
					  </tr>
					 <tr>	  
						<td><b>Total</b></td>
						<td><b><?php echo "$row[22] MB"; ?></b></td>
						<td><b><?php echo "$row[23] MB"; ?></b></td>
						<td><b><?php echo "$row[24] MB"; ?></b></td>
					  </tr>
					</tbody>
				  </table>
				  </div>
          </div>
        </div>
        
		  <div class="col-sm-4">
          	<div class="well" >
			   <h2>Discos</h2>
			   <div><span style="float:right">Total:500GB</span>/dev/sda1</div>
      				<div class="progress">
        				 <div class="progress-bar progress-bar-success" role="progressbar" style="width:43%">43%</div>
     				 </div>
			  <div><span style="float:right">Total:1TB</span>/dev/sda2</div>
      				<div class="progress">
        				 <div class="progress-bar progress-bar-success" role="progressbar" style="width:70%">70%</div>
     				 </div>
		  </div>
        </div>
      </div>
		
      <div class="row">
		   	
        <div class="col-sm-8">
			<div class="well">
			<h2>Red</h2>
          <div id="container" style="min-width: 150px; height: 300px; margin: 0 auto"></div>
            <h4>Tráfico</h4>
            <p>Tráfico subida y bajada</p> 
          </div>
		
		</div>
        <div class="col-sm-4">
          <div class="well" id="discos">
			 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="well">
            
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <p>Text</p> 
          </div>
        </div>
      </div>
		  </div>
    </div>
	  
  </div>

	<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Tráfico de red:'
    },
    subtitle: {
        text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">' +
            'thebulletin.metapress.com</a>'
    },
    xAxis: {
        allowDecimals: false,
        labels: {
            formatter: function () {
                return this.value; // clean, unformatted number for year
            }
        }
    },
    yAxis: {
        title: {
            text: 'Nuclear weapon states'
        },
        labels: {
            formatter: function () {
                return this.value / 1000 + 'k';
            }
        }
    },
    tooltip: {
        pointFormat: '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
    },
    plotOptions: {
        area: {
            pointStart: 1940,
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
        name: 'Bajada',
        data: [null, null, null, null, null, 6, 11, 32, 110, 235, 369, 640,
            1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
            27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342, 26662,
            26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
            24304, 23464, 23708, 24099, 24357, 24237, 24401, 24344, 23586,
            22380, 21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950,
            10871, 10824, 10577, 10527, 10475, 10421, 10358, 10295, 10104]
    }, {
        name: 'Subida',
        data: [null, null, null, null, null, null, null, null, null, null,
            5, 25, 50, 120, 150, 200, 426, 660, 869, 1060, 1605, 2471, 3322,
            4238, 5221, 6129, 7089, 8339, 9399, 10538, 11643, 13092, 14478,
            15915, 17385, 19055, 21205, 23044, 25393, 27935, 30062, 32049,
            33952, 35804, 37431, 39197, 45000, 43000, 41000, 39000, 37000,
            35000, 33000, 31000, 29000, 27000, 25000, 24000, 23000, 22000,
            21000, 20000, 19000, 18000, 18000, 17000, 16000]
    }]
});
		</script>
</body>
</html>
<?php
}  
else{
   header("Location: index.html"); 
}
?>