<?php require_once 'Include/Funciones.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Registro</title>
    <link rel="stylesheet" href="Bootstrap/CSS/bootstrap.css">
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
</head>
<body>
    <div class="container mt-4">
<?php
if (isset($_POST['Enviar'])) {
    $usuario = $_POST['user'];
    $clave   = $_POST['pass'];
    $clave2  = $_POST['conf_pass'];
    $tipo = $_POST['type'];
    if ($usuario != '' and $clave != '') {
        if ($clave == $clave2) {
            $registro = SignUser($tipo, $usuario, $clave);
            if ($registro) {
                print('
                    <div vlass="row col-lg-3">
                        <span class="text-success">Se agregó correctamente al usuario.</span><br/>
                        <span><a class="btn btn-outline-success col-lg-3" style="margin:15px 0;" href="login.php">Inicia sesión ahora</a></span>
                    </div>
                ');
            } else {
                print('
                        <div class="row col-lg-3">
                            <span class="text-danger" style="margin-bottom:5px;">Hubo un problema con el registro del usuario.</span><br/>
                        </div>
                ');
            }
        } else {
            print('
                <div class="row col-lg-3">
                    <span class="text-warning" style="margin:bottom:5px;">Confire correctamente su contrseña</span><br/>
                </div>
            ');
        }
    } else {
        print('
                <div class="row col-lg-3">
                    <span class="text-warning" style="margin-bottom:5px;">Ingrese datos válidos.</span>
                </div>
        ');
    }
}
?>
        <form action="sign.php" method="POST">
            <div class="form-group row">
                <label for="user" class="col-lg-1 col-form-label">Usuario:</label>
                <div class="col-lg-2">
                    <input class="form-control" type="text" placeholder="Juan Pérez" name="user">
                </div>
            </div>
            <div class="form-group row">
                <label for="pass" class="col-form-label col-lg-1">Contraseña:</label>
                <div class="col-lg-2">
                    <input class="form-control" type="password" placeholder="Contraseña" name="pass">
                </div>
            </div>
            <div class="form-group row">
                <label for="conf_pass" class="col-form-label col-lg-1">Confirmar:</label>
                <div class="col-lg-2">
                    <input class="form-control" type="password" placeholder="Contraseña" name="conf_pass">
                </div>
            </div>
            <div class="form-group">
                <div class="form-check row col-lg-3">
                    <input class="form-check-input" type="radio" name="type" value="Customer" checked/>
                    <label for="type" class="form-check-label">Usuario</label>
                </div>
                <div class="form-check row col-lg-3">
                    <input class="form-check-input" type="radio" name="type" value="Aministrator" />
                    <label for="type" class="form-check-label">Administrador</label>
                </div>
            </div>
            <button class="btn btn-primary row col-lg-3" type="submit" name="Enviar">Enviar</button>
        </form>
    </div>
</body>
</html>