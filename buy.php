<?php require_once 'Include/security.php'; require_once 'Include/Funciones.php';
	if (isset($_GET['Cancel'])) {
		unset($_SESSION['Cart']);
		$_SESSION['total'] = 0;
		$_SESSION['items'] = 0;
		header('location:index.php');
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Compra</title>
	<link rel="stylesheet" href="Bootstrap/CSS/bootstrap.min.css">
	<link rel="stylesheet" href="Fonts/style.css"/>
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
</head>
<body>
	<?php include 'Include/nav.php'; ?>
	<div class="container mt-3">
<?php
if ($Error = ErrorBuy()) {
	print('
		<h3 class="text-center mt-4">No se ha podido realizar la compra porque ' . $Error["Message"] . '</h3>
	');
	if (isset($Error['Articles'])) {
		print('
			<table class="table table-hover mt-5">
				<th>Producto</th>
				<th>Quiso comprar</th>
				<th>Existencias disponibles</th>
		');
		foreach($Error['Articles'] as $art) {
			foreach($_SESSION['Cart'] as $pro) {
				if ($art == $pro['Name']) {
					print('
						<tr>
							<td>' . $pro["Name"] . '</td>
							<td>' . $pro["Quantity"] . '</td>
							<td>' . $pro["Stock"] . '</td>
						</tr>
					');
				}
			}
		}
		print('</table>
			<div class="toolbar mt-2">
				<div class="btn-group btn-group-lg">
					<button role="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm">Cancelar compra</button>
					<a href="showCar.php" class="btn btn-info"><span class="icon-cart"></span></a>
				</div>
			</div>
		');
	} else {
		print('
			<div class="toolbar row">
				<div class="btn-group btn-group-lg mx-auto mt-2">
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm">Cancelar compra</button>
					<a href="actions.php?pay=1" class="btn btn-success mx-auto"><span class="icon-credit-card"></span></a>
					<a href="showCar.php" class="btn btn-info"><span class="icon-cart"></span></a>
				</div>
			</div>
		');
	}
} else {
	if (!empty($_SESSION['Cart'])) {
		$info = CreateTicket();
		print('<h3 class="text-center mt-4">Compra exitosa, tu ticket es: sección.</h3>
			<table class="table my-2">
				<tr>
					<th>ID del Ticket</th>
					<th>Fecha de compra</th>
					<th>Total</th>
				</tr>
				<tr>
					<td>' . $info[0][0] . '</td>
					<td>' . $info[0][2] . '</td>
					<td>$' . $info[0][1] . '</td>
				</tr>
			</table>
			<table class="table table-hover">
				<tr>
					<th>ID</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Subtotal</th>
				</tr>
		');
		foreach ($info as $pro) {
			print('
				<tr>
					<td>' . $pro[3] . '</td>
					<td>' . $pro[4] . '</td>
					<td>' . $pro[6] . '</td>
					<td>' . $pro[5] . '</td>
				</tr>
			');
		}
		print('</table>');
	}
}
?>
	</div>
	<div class="modal fade" id="confirm" tabindex="-1" role="modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar</h5>
                    <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">¿Está seguro de quitar elementos de su compra?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    <a class="btn btn-primary" href="buy.php?Cancel=1" role="button">Sí</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>