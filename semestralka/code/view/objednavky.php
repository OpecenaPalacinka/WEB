<?php
global $tplData;

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
<form method="post">
<table class="table table-dark table-hover">
    <thead>
    <tr>
        <th></th>
        <th>ID objednávky</th>
        <th>Username</th>
        <th>Jméno řeky</th>
        <th>Datum vypůjčení</th>
        <th>Datum vrácení</th>
        <th>Schváleno</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $objednavky = $tplData['objednavky'];
    foreach ($objednavky as $objednavka){?>
        <tr>
            <td><b>+</b></td>
            <td><?php echo $objednavka["id_objednavky"];?></td>
            <td><?php echo $objednavka["USER_id_user"];?></td>
            <td><?php echo $objednavka["REKY_id_reky"];?></td>
            <td><?php echo $objednavka["datum_vytvoreni"];?></td>
            <td><?php echo $objednavka["datum_vraceni"];?></td>
            <td><?php echo $objednavka["schvalena"];?></td>
            <td><button class="btn btn-primary" type="submit" value="<?php echo $objednavka["id_objednavky"];?>" name="Schvalit" id="<?php echo $objednavka["id_objednavky"];?>">Schval</button></td>
        </tr>

        <tr class="hide-n-seek">
            <td colspan="8">
                <table>
                    <tr>
                        <th>Název</th>
                        <th>Počet</th>
                    </tr>

                     <?php
                     foreach ($tplData["lode".$objednavka["id_objednavky"]] as $exactObjednavkaLode){ ?>
                    <tr>
                         <td><?php echo $exactObjednavkaLode['LODE_id_lod'];?> </td> <td> <?php echo $exactObjednavkaLode['pocet'];?></td>
                    </tr>
                     <?php } ?>

                    <?php
                    foreach ($tplData["prislu".$objednavka["id_objednavky"]] as $exactObjednavkaPrislu){ ?>
                            <tr>
                                <td><?php echo $exactObjednavkaPrislu['PRISLUSENSTVI_id_prislusenstvi'];?></td> <td><?php echo $exactObjednavkaPrislu['pocet'];?></td>
                        </tr>
                    <?php } ?>


             </table>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
</form>

</body>
