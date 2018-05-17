<?php
include 'Include/Funciones.php'; require 'Include/security.php';

if (isset($_POST['ID'], $_POST['Name'], $_POST['MadeBy'], $_POST['Price'], $_POST['Stock'], $_POST['Section'], $_POST['Image'], $_POST['Description'])) {
	InsertArticle($_POST['ID'], $_POST['Name'], $_POST['MadeBy'], $_POST['Image'], $_POST['Description'], $_POST['Price'], $_POST['Stock'], $_POST['Section']);
	header('location:index.php');
}

if (isset($_POST['deleteArt'])) {
	DeleteArticle($_POST['deleteArt']);
}

if (isset($_POST['ID'], $_POST['newStock'])) {
	UpdateStock($_POST['ID'], $_POST['newStock']);
}

if (isset($_POST['search'])) {
	GetResult($_POST['search']);
}

if (isset($_GET['artID'])) {
    AddToCar($_GET['artID'], $_GET['quan']);
    var_dump($_SESSION['Cart'], $_GET['artID'], $_GET['quan']);
    header('location:showCar.php');
}

if (isset($_POST['CancelArt'])) {
	CancelArticle($_POST['CancelArt']);
	header('location:showCar.php');
}
