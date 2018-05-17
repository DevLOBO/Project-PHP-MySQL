<?php require_once 'Include/Funciones.php'; session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="Bootstrap/CSS/bootstrap.css">
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
</head>
<body>
    <div class="container mt-4" style="margin-top:15px;">
<?php
if (isset($_POST['Enviar'])) {
    $usuario = $_POST['user'];
    $clave   = $_POST['pass'];
    $tipo    = $_POST['type'];

    if ($usuario != '' and $clave != '') {
        $datos = SearchUser($tipo, $usuario, $clave);
        if ($datos[0]) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['tipo']    = $tipo;
            $_SESSION['id']      = $datos[0];
            $_SESSION['Wallet']  = (float) $datos[1];
            if ($tipo == 'Customer') {
                $_SESSION['total'] = 0;
                $_SESSION['items'] = 0;
            }
            header('location:index.php');
        } else {
            print('
                <div class="row col-lg-3">
                    <span class="text-warning" style="margin-bottom:5px;">Usuario y/o contraseña incorrectos. Inténtalo de nuevo.</span><br/>
                <span style="color: blue; margin-bottom: 5px">¿No eres un usuario? <a href="sign.php">Regístrate aquí.</a></span>
                </div>
                ');
        }
    } else {
        print('
                <div class="row col-lg-3">
                    <span class="text-warning" style="margin:bottom:5px;">Ingrese datos válidos</span><br/>
                </div>
            ');
    }
}
?>
        <form action="login.php" method="POST">
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
            <div class="form-group">
                <div class="form-check row col-lg-3">
                    <input class="form-check-input" type="radio" name="type" value="Customer" checked/>
                    <label for="type" class="form-check-label">Usuario</label>
                </div>
                <div class="form-check row col-lg-3">
                    <input class="form-check-input" type="radio" name="type" value="Administrator" />
                    <label for="type" class="form-check-label">Administrador</label>
                </div>
            </div>
            <button class="btn btn-primary row col-lg-3" type="submit" name="Enviar">Enviar</button>
        </form>
    </div>
</body>
</html>