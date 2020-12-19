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
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <svg class="bd-placeholder-img" width="100%" height="100%" focusable="false"><img
                        src="../image/litpom.jpg" height="512" width="1920" alt="litpom"/></svg>
                <div class="container">
                    <div class="carousel-caption text-left">
                        <h1>Zarezervujte si loď.</h1>
                        <p class="highlight">Zarezervujte si loď ještě dnes a zažijte nejlepší dobrodružství na vlnách s naší půjčovnou! Půjčujeme na více než 5 řekách.</p>
                        <p><a class="btn btn-lg btn-primary" href="index.php?page=objednavka" role="button">Rezervuj teď</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" focusable="false" ><img
                            src="../image/Rainforest-River-Travel.jpg" height="512" width="1920" alt="Rainforest-River-Travel"/></svg>
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Krátké střípky z našeho života</h1>
                        <p class="highlight">Prohlédněte si naše vodácké album, můžete být zde i VY! </p>
                        <p><a class="btn btn-lg btn-primary" href="index.php?page=oNas" role="button">Přečtěte si více</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" focusable="false" ><img
                        src="../image/River-Rafting-Falls-Belize.jpg" height="512" width="1920" alt="River-Rafting-Falls-Belize"/></svg>
                <div class="container">
                    <div class="carousel-caption text-right text-dark">
                        <h1 class="font-weight-bolder">Staňte se jedním z nás</h1>
                        <p class="highlight font-weight-bold">Založte si účet u naší půjčovny a mějte tak nové informace u sebe jako první. Ulehčí Vám to také vyplňování rezervace.</p>
                        <p><a class="btn btn-lg btn-primary" href="index.php?page=registrace" role="button">Založte si účet</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container marketing">

    <!-- 2 sloupečky pod carouselem -->

    <div class="row pt-5 pb-5">
        <div class="col-lg-6">
            <img class="rounded-circle" src="../image/dite.jpg" width="170" height="170" alt="dite"/>
            <h2>Dětský den s vodáky</h2>
            <p>Tento rok se konal 3. ročník dětského dne s vodáky. Pro děti bylo připraveno herní odpoledne na vodě a pro rodiče sud piva.</p>
            <p><a class="btn btn-primary" href="index.php?page=oNas" role="button">Dozvědět se více &raquo;</a></p>
        </div>

        <div class="col-lg-6">
            <img class="bd-placeholder-img rounded-circle" src="../image/vodaci.jpg" width="182" height="170" alt="vodaci"/>
            <h2>35. ročník vodácké soutěže</h2>
            <p>V červenci tohoto roku se uskutečnil 35. ročník vodácké souteže pro dospělé. Jak je již známo soutěžilo se o nejrychlejšího jedince na vodě.</p>
            <p><a class="btn btn-primary" href="index.php?page=oNas" role="button">Dozvědět se více &raquo;</a></p>
        </div>
    </div>
    </div>
<?php
$tplHeaders->createFooter();
?>
</body>
