<?php
global $tplData;

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

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2">
                <div class="p-5">
                    <img class="img-fluid rounded-circle" src="../image/dite.jpg" alt="Dítě">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="p-5">
                    <h2 class="display-4">Dětský den s vodáky</h2>
                    <p>Tento rok se konal 3. ročník dětského dne s vodáky. Pro děti bylo připraveno herní odpoledne na vodě a pro rodiče sud piva.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="p-5">
                    <img class="img-fluid rounded-circle" src="../image/vodaci.jpg" alt="Loď">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-5">
                    <h2 class="display-4">35. ročník vodácké soutěže</h2>
                    <p>V červenci tohoto roku se uskutečnil 35. ročník vodácké souteže pro dospělé. Jak je již známo soutěžilo se o nejrychlejšího jedince na vodě.</p>                </div>
            </div>
        </div>
    </div>
</section>

<?php
$tplHeaders->createFooter();
?>
</body>
