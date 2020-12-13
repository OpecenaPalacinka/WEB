<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/carousel.css","Půjčovna lodí");
?>
<body>
<?php
$tplHeaders->createNav();
?>
<!-- Místo pro sekci o nás-->
<p>Ahoj, tady je sekce o nás</p>
<?php
$tplHeaders->createFooter();
?>
</body>
