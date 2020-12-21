<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("",$tplData['title']);
?>
<script src="view/objednavky.js" async></script>
<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
} ?>

<div class="container">
	<h1>Vaše uživatelské údaje</h1>
	<div class="row pl-3">
		<h3>Email  ---> </h3> <p class="pt-2 pl-5"><b><?php echo $tplData['email']?> </b></p>
	</div>
	<div class="row pl-3">
		<h3>Jméno  ---> </h3> <p class="pt-2 pl-4">&nbsp;&nbsp;<b><?php echo $tplData['username']?> </b></p>
	</div>
	<div class="row pl-3">
		<h3>Heslo  ---> </h3> <p class="pt-2 pl-5"><b><?php echo $tplData['password']?> </b></p>
	</div>
	<br>
	<br>
</div>



<h2 class="pl-2">Vaše dosavadní objednávky</h2>
<table class="table table-dark table-hover ml-2" style="width: 98%">
	<thead>
	<tr>
		<th></th>
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
	$objednavky = $tplData['exactUserObj'];
	foreach ($objednavky as $objednavka){?>
		<tr>
			<td><b>+</b></td>
			<td><?php echo $objednavka["id_objednavky"];?></td>
			<td><?php echo $objednavka["USER_id_user"];?></td>
			<td><?php echo $objednavka["REKY_id_reky"];?></td>
			<td><?php echo $objednavka["datum_vytvoreni"];?></td>
			<td><?php echo $objednavka["datum_vraceni"];?></td>
			<td><?php echo $objednavka["schvalena"];?></td>
		</tr>

		<tr class="hide-n-seek">
			<td colspan="8">
				<table class="ml-5">
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

</body>
