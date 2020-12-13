<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/cenik.css","Půjčovna lodí");
?>

<body>
<?php
$tplHeaders->createNav();
?>
<div class="background">

<div class="container">
    <br>
    <h1>Ceník</h1>
    <br>
    <h2>Lodě</h2>

    <table class="table table-dark table-hover">
        <thead>
        <tr>
            <th>Loď</th>
            <th class="text-right">Cena</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $lode = $tplData['lode'];
        foreach ($lode as $lod){?>
            <tr>
                <td><?php echo $lod["typ_lode"];?></td>
                <td class="text-right"><?php echo $lod["cena"];?> Kč</td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
    <br>
    <h2>Příslušenství</h2>
    <table class="table table-dark table-hover">
        <thead>
        <tr>
            <th>Příslušenství</th>
            <th class="text-right">Cena</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $prislusenstvi = $tplData['prislusenstvi'];
        foreach ($prislusenstvi as $prislu){?>
            <tr>
                <td><?php echo $prislu["nazev_prislusen"];?></td>
                <td class="text-right"><?php echo $prislu["cena"];?> Kč</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br>

</div>
</div>

</body>
