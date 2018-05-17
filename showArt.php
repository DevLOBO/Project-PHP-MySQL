<?php require 'Include/security.php'; require_once 'Include/Funciones.php';

$ArtID = $_GET['artID'];
$det = GetArticle($ArtID);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $det['Name']; ?></title>
	<link rel="stylesheet" href="Bootstrap/CSS/bootstrap.css">
	<link rel="stylesheet" href="Fonts/style.css"/>
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
    <script>
    	$(document).ready(function() {
    		$('#cantidad').on('input', function() {
    			var num = parseInt($(this).val(), 10);
    			if (num > 0) {
    				$('#send').attr('href', 'process.php?artID=<?php echo $ArtID; ?>&quan=' + num);
    				$('#send').removeClass('disabled');
    			} else {
    				$('#send').addClass('disabled');
    			}
    		});
    	});
    </script>
</head>
<body>
	<?php include_once 'Include/nav.php'; ?>
	<div class="container mt-3">
		<div class="row">
			<aside class="col-lg-3">
			<?php
			if ($_SESSION['tipo'] == 'Customer') {
			    DisplaySections();
			}
			?>
			</aside>
			<div class="col-lg-4">
				<img src="<?php echo $det['Image']; ?>" width="350ox; height:auto;"/>
			</div>
			<div class="col-lg-5 pl-5">
				<h2><?php echo $det['Name']; ?><br/><small>de <?php echo $det['MadeBy']; ?></small></h2>
				<h3 class="my-5">Precio: $<?php echo $det['Price']; ?></h3>
				<h3><?php echo $det['Description']; ?></h3>
			</div>
			<div class="btn-toolbar ml-auto">
				<div class="row btn-group btn-group-lg mt-5">
					<a class="btn btn-secondary" href="showCat?sectID=<?php echo $_SESSION['Sección']['ID']; ?>"><span class="icon-arrow-left"></span></a>
					<div class="input-group">
				    	<input type="number" class="form-control" style="width: 75px" value="1" id="cantidad">
				      	<span class="input-group-btn">
				        	<a class="btn btn-primary btn-lg" href="process?artID=<?php echo $ArtID; ?>&quan=1" id="send"><span class="icon-plus"></span></a>
				      	</span>
				  	</div>
				    <a class="btn btn-info" href="showCar"><span class="icon-cart"></span></a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>