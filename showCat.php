<?php require 'Include/security.php';require_once 'Include/Funciones.php';

$SectionID = $_GET['sectID'];
$articles = GetCatalogue($SectionID);
SetSectionDetails($SectionID);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_SESSION['Sección']['SectName']; ?></title>
	<link rel="stylesheet" href="Bootstrap/CSS/bootstrap.css">
    <link rel="stylesheet" href="Fonts/style.css"/>
    <script src="JS/jquery-3.3.1.js"></script>
    <script src="Bootstrap/JS/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            var title = $('head').find('title').text();
            $('#sections a').each(function() {
                if ($('#sections a').hasClass('active')) {
                $(this).removeClass('active');
            }
            });

            $('#sections a').each(function() {
                if ($(this).text() == title) {
                    $(this).addClass('active');
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
                <?php DisplaySections(); ?>
            </aside>
            <section class="col-lg-9">
<?php
if (!$articles) {
    print('<h3 class="text-center mt-4">No hay productos en esta sección.</h3>');
} else {
    print('<ul class="list-group mt-4">');
    foreach ($articles as $art) {
        print('
                <li class="list-group-item">
                    <h4 class="list-group-item-heading d-block"><a href="showArt.php?artID=' . $art["ID"] . '">' . $art["Name"] . '</a> <small>por ' . $art["MadeBy"] . '</small></h4>
                    <p class="list-group-item-text">' . $art["Description"] . '</p>
                </li>
        ');
    }
    print('</ul>');
}
?>
            </section>
        </div>
	</div>
</body>
</html>