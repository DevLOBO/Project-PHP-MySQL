<?php require 'Include/security.php'; require_once 'Include/Funciones.php'; CalculateTotalItems();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Carro de compra</title>
	<link rel="stylesheet" href="Bootstrap/CSS/bootstrap.css">
    <link rel="stylesheet" href="Fonts/style.css"/>
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            var indicador = false;
            $('.check').change(function() {
               $('.check').each(function() {
                    if ($(this).prop('checked')) {
                        indicador = true;
                        return false;
                    } else {
                        indicador = false;
                    }
                });
                if (indicador) {
                    $('#Cancel').removeAttr('disabled');
                } else {
                    $('#Cancel').prop('disabled', 'disabled');
                }
            });

            $('#submit').click(function() {
                $('#form').submit();
            });
        });
    </script>
</head>
<body>
    <?php include_once 'Include/nav.php'; ?>
	<div class="container mt-3">
<?php
if (isset($_SESSION['Cart']) and count($_SESSION['Cart']) != 0) {
	print('
		<form id="form" action="process.php" method="POST">
		<table class="table table-hover">
            <tr>
            	<th>Cancelar</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
       	');
    foreach ($_SESSION['Cart'] as $art) {
        print('
            <tr>
                <td><input type="checkbox" class="check" name="CancelArt[]" value="' . $art["ID"] . '"></td>
                <td>' . $art["Name"] . '</td>
                <td>$' . $art["Price"] . '</td>
                <td>' . $art["Quantity"] . '</td>
                <td>$' . ($art["Quantity"] * $art["Price"]) . '</td>
            </tr>
        ');
    }
    print('
		</table>
		<div class="btn-group btn-group-lg">
	        <button class="btn btn-danger" type="button" id="Cancel" data-toggle="modal" data-target="#confirm" disabled>Cancelar producto(s)</button>
	        <a class="btn btn-secondary" href="index.php">Seguir comprando</a>
	        <a class="btn btn-primary" href="buy.php">Comprar</a>
       	</form>
    	</div>
    ');
} else {
    print('<h3 class="text-center mt-4">No has añadido ningún producto</h3>');
}
?>
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
                        <button class="btn btn-primary" id="submit" type="button">Sí</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
</body>
</html>

