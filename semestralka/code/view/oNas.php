<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/carousel.css",$tplData['title']);
?>
<body>
<?php
if (!$tplData['userLogged']) {
    $tplHeaders->createNav($tplData['pravo']);
} else {
    $tplHeaders->createNav($tplData['pravo'],"odhlaseni");
}
?>
<!-- Místo pro sekci o nás-->
<p>Ahoj, tady je sekce o nás</p>
<?php
$tplHeaders->createFooter();
?>
</body>
