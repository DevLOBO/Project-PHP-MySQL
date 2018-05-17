<?php
session_start();
if (empty($_SESSION['usuario']) and empty($_SESSION['clave']) and empty($_SESSION['tipo']) and empty($_SESSION['id'])) {
    header('location:login.php');
}