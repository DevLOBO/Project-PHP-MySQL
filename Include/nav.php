<header>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">Proyecto Final</a>

		<div class="btn-group" role="group">
			<?php
			if ($_SESSION['tipo'] == 'Customer') {
				print('
					<button class="btn btn-dark" type="button"><span class="icon-user"></span> $' . $_SESSION["Wallet"] . '</button>
					<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $_SESSION["usuario"] . '</button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="actions.php?pay=1">Abonar</a>
						<a class="dropdown-item" href="actions.php?history=1">Historial de compras</a>
					</div>
				');
			}
			?>
		</div>

		<div class="btn-group ml-auto" role="group">
			<?php
			if ($_SESSION['tipo'] == 'Customer') {
				print('
					<button type="button" class="btn btn-dark">' . $_SESSION["items"] . '  items</button>
					<button type="button" class="btn btn-dark">$' . $_SESSION["total"] . '</button>
					<a href="showCar.php" class="btn btn-danger"><span class="icon-cart"></span></a>
				');
			} ?>
			<a href="close.php" class="btn btn-info"><span class="icon-exit"></span></a>
		</div>
    </nav>
</header>