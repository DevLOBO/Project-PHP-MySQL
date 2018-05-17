<?php require 'Include/security.php'; require_once 'Include/Funciones.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Página de Inicio</title>
	<link rel="stylesheet" href="Bootstrap/CSS/bootstrap.min.css">
	<link rel="stylesheet" href="Fonts/style.css"/>
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="JS/jquery.validate.JS"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
    <script>
    	$(document).ready(function() {
    		$('#formArt').validate();
    		$('#submitArt').on('click', function() {
    			$('#formArt').submit();
    		});

    		$('#search').on('input', function() {
    			var text = $(this).val();
    			if (text != '') {
    				$.ajax({
    					url: 'process.php',
    					method: 'POST',
    					data: {search:text},
    					dataType: 'text',
    					success: function(data) {
    						$('#result').empty();
    						$('#result').html(data);
    						$('button.edit').on('click', function() {
    							var id = $(this).closest('tr').attr('id');
    							var cell = $('#' + id + ' td:nth-child(5)');
    							var stock = $('#' + id + ' td:nth-child(5)').text();
    							cell.empty();
    							cell.append('<input type="number" class="form-control form-control-sm quant" name="quant" value="" />').css('width', '75px');
    							$('.quant').focus();
    							$('.quant').keypress(function(e) {
    								if (e.which === 13) {
    									var newStock = $(this).val();
    									var number = parseInt(stock, 10) + parseInt(newStock, 10);
    									$.ajax({
    										url: 'process.php',
    										dataType: 'text',
    										data: {newStock: number, ID: id},
    										success: function(data) {
    											$('.quant').remove();
    											cell.text(number);
    										}
    									});
    								} else if (e.which == 0) {
    									$('.quant').remove();
    									cell.text(stock);
    								}
    							});
    						});
    						$('button.delete').on('click', function() {
								var id = $(this).closest('TR').attr('id');
								$('#confirm').modal('show');
								$('#deleteArt').on('click', function() {
					    			$.ajax({
					    				url: 'process.php',
					    				method: 'POST',
					    				data: {deleteArt: id},
					    				dataType: 'text',
					    				success: function(data) {
					    					$('#confirm').modal('hide');
					    					$('#result').empty();
					    					$('#result').html(data);
					    				}
					    			});
    		});
							});
    					}
    				});
    			} else {
    				$('#result').empty();
    			}
    		});
    	});
    </script>
</head>
<body>
	<?php include_once 'Include/nav.php'; ?>
	<section class="main container mt-3">
		<div class="row">
			<?php if ($_SESSION['tipo'] == 'Customer') {?>
			<aside class="col-lg-3">
				<?php DisplaySections(); ?>
			</aside>
			<section class="col-lg-9">
				<?php DisplaySlideshow(); ?>
			</section>
			<?php } else { ?>
			<section class="col-lg-12">
				<h2 class="mb-5">Hola, <?php echo $_SESSION['usuario']; ?><br/><small>Hay mucho trabajo hoy</small></h2>
				<div class="input-group input-group-lg my-3">
					<div class="input-group-prepend">
						<span class="icon-search btn btn-primary"></span>
					</div>
					<input type="text" class="form-control" id="search" placeholder="Buscar producto">
					<div class="input-group-append">
						<span class="btn btn-success icon-box-add" data-toggle="modal" data-target="#formAdd"> Nuevo producto</span>
					</div>
				</div>
				<div id="result"></div>
				<div class="modal fade" id="confirm" tabindex="-1" role="modal" aria-hidden="true">
		            <div class="modal-dialog modal-dialog-centered" role="document">
		                <div class="modal-content">
		                    <div class="modal-header">
		                        <h5 class="modal-title">Confirmar</h5>
		                        <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
		                    </div>
		                    <div class="modal-body">¿Está seguro qué quiere eliminar el producto?</div>
		                    <div class="modal-footer">
		                        <button class="btn btn-primary" data-dismiss="modal">No</button>
		                        <button class="btn btn-secondary" id="deleteArt" type="button">Sí</button>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="modal fade" id="formAdd" tabindex="-1" role="modal" aria-hidden="true">
		            <div class="modal-dialog modal-dialog-centered" role="document">
		                <div class="modal-content">
		                    <div class="modal-header">
		                        <h5 class="modal-title">Agregar producto</h5>
		                        <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
		                    </div>
		                    <div class="modal-body">
		                    	<form action="
		                    	process.php" method="POST" id="formArt">
		                    		<div class="form-group">
		                    			<label for="ID">ID del producto</label>
		                    			<input type="text" class="form-control" maxlength="16" name="ID" required>
		                    		</div>
		                    		<div class="form-group">
		                    			<label for="Name">Nombre del producto</label>
		                    			<input type="text" name="Name" class="form-control" required>
		                    		</div>
		                    		<div class="form-group">
		                    			<label for="MadeBy">Hecho por:</label>
		                    			<input type="text" class="form-control" name="MadeBy" required>
		                    		</div>
		                    		<div class="form-group">
		                    			<label for="Image">Ruta de la imagen:</label>
		                    			<input type="text" class="form-control" name="Image">
		                    		</div>
		                    		<div class="form-group">
		                    			<label for="Description">Descripción:</label>
		                    			<textarea name="Description" class="form-control" rows="3"></textarea>
		                    		</div>
		                    		<div class="form-group">
		                    			<label for="Price">Precio:</label>
		                    			<input type="number" class="form-control" name="Price">
		                    		</div>
		                    		<div class="form-group">
		                    			<label for="Stock">Existencias</label>
		                    			<input type="number" class="form-control" name="Stock">
		                    		</div>
		                    		<div class="form-group">
		                    			<select name="Section" class="custom-select" required>
		                    				<option value="" selected>Selecciona una sección</option>
		                    				<?php $sect = GetSections();
		                    				foreach ($sect as $sec) {
			                    				print('
													<option value="' . $sec["SectID"] . '">' . $sec["SectName"] . '</option>
			                    				');
		                    				}
		                    				?>
		                    			</select>
		                    		</div>
		                    	</form>
		                    </div>
		                    <div class="modal-footer">
		                        <button class="btn btn-primary" id="submitArt" type="button">Agregar producto</button>
		                    </div>
		                </div>
		            </div>
		        </div>
			</section>
			<?php } ?>
		</div>
	</section>
</body>
</html>