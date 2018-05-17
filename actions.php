<?php require 'Include/security.php'; include_once 'Include/Funciones.php';
if (isset($_GET['pay'])) {
	$title = 'Abonar';
} else {
	$title = 'Historial de compras';
}
if (isset($_POST['Abonar'])) {
	UpdateWallet($_POST['Saldo'] + $_SESSION['Wallet']);
	header('location:actions.php?pay=1');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="Bootstrap/CSS/bootstrap.min.css">
	<link rel="stylesheet" href="Fonts/style.css"/>
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
    <script>
    	$(document).ready(function() {
    		var title = $('title').text();
    		$('#actions a').each(function() {
    			if ($(this).hasClass('active')) {
    				$(this).removeClass('active');
    			}
    			if ($(this).text() == title) {
    				$(this).addClass('active');
    			}
    		});
    	});
    </script>
</head>
<body>
	<?php include_once 'Include/nav.php'; ?>
	<div class="container">
		<div class="row">
			<aside class="col-lg-3 mt-3 main">
				<nav id="actions" class="nav nav-pills flex-column nav-justified">
        			<a class="nav-item nav-link" href="index.php"><span class="icon-home"></span></a>
        			<a href="actions.php?pay=1" class="nav-item nav-link">Abonar</a>
        			<a href="actions.php?history=1"  class="nav-item nav-link">Historial de compras</a>
        		</nav>
			</aside>
			<section class="col-lg-9">
			<?php
			if ($title == 'Abonar') { ?>
			<form actions="actions.php" method="POST">
				<h3 class="mb-3">Tu saldo es: $<?php echo $_SESSION['Wallet']; ?></h3>
				<div class="input-group input-group-lg">
					<div class="input-group-prepend">
						<span class="input-group-text">$</span>
					</div>
					<input type="number" class="form-control col-lg-4" name="Saldo"/>
					<div class="input-group-append">
						<button class="btn btn-primary" type="submit" name="Abonar">Abonar saldo</button>
					</div>
				</div>
			</form>
			<?php } else if ($title == 'Historial de compras') {
			$info = GetTickets();
			if (!$info) {
				print('<h3 class="text-center">No tienes compras recientes</h3>');
			} else { ?>
			<table class="table table-hover">
				<tr>
					<th>ID del Ticket</th>
					<th>Fecha de compra</th>
					<th>Total</th>
				</tr>
			<?php
			foreach ($info as $ticket) {
				print('
					<tr>
						<td>' . $ticket[0] . '</td>
						<td>' . $ticket[2] . '</td>
						<td>' . $ticket[1] . '</td>
					</tr>
				');
			}
			?>
			</table>
			<?php }} ?>
			</section>
		</div>
	</div>
</body>
</html>