<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/signin.css",$tplData['title']);
?>

<body>
<?php
if (!$tplData['userLogged']) {
    $tplHeaders->createNav($tplData['pravo']);
} else {
    $tplHeaders->createNav($tplData['pravo'],"odhlaseni");
}
?>

<table class="table table-dark table-hover">
    <thead>
    <tr>
        <th>ID objednávky</th>
        <th>Username</th>
        <th>Jméno řeky</th>
        <th>Datum vypůjčení</th>
        <th>Datum vrácení</th>
        <th>Schváleno</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $objednavky = $tplData['objednavky'];
    foreach ($objednavky as $objednavka){?>
        <tr>
            <td><?php echo $objednavka["id_objednavky"];?></td>
            <td><?php echo $objednavka["USER_id_user"];?></td>
            <td><?php echo $objednavka["REKY_id_reky"];?></td>
            <td><?php echo $objednavka["datum_vytvoreni"];?></td>
            <td><?php echo $objednavka["datum_vraceni"];?></td>
            <td><?php echo $objednavka["schvalena"];?></td>
        </tr>
    <?php } ?>

    </tbody>
</table>


</body>
