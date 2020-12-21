<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("",$tplData['title']);
?>

<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
}
?>

<div class="row justify-content-center" style="width: 100%">
	<?php
	if(isset($_POST['registruj']) || isset($_POST['pridejReku']) || isset($_POST['pridejLod']) || isset($_POST['pridejPrislu'])){
		if($tplData['povedloSe']){
			?>
			<script type="text/javascript">
                Swal.fire({
                    icon: 'success',
                    title: '<?php echo $tplData['login'] ?>',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: `OK`,
                    customClass: {
                        confirmButton: 'order-1',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace("index.php?page=pridaniProduktu");
                    }
                });
			</script>
		<?php
		} else {
		?>
			<script type="text/javascript">
                Swal.fire({
                    icon: 'error',
                    title: '<?php echo $tplData['login'] ?>',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: `OK`,
                    customClass: {
                        confirmButton: 'order-1',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace("index.php?page=pridaniProduktu");
                    }
                });
			</script>
			<?php
		}
	}
	?>
	<form class="text-center" method="post">
		<h2>Přidej nového zaměstnance</h2>
	<label for="inputEmail" class=""></label>
	<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Zadejte email">

	<label for="inputUsername" class=""></label>
	<input type="text" name="username" id="inputUsername" class="form-control" placeholder="Zadejte uživatelské jméno">

	<label for="inputPassword" class=""></label>
	<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Heslo">
	<br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" name="registruj" value="registruj">Registruj</button>

	<br>
	<h2>Přidej novou řeku</h2>

		<label for="inputNazevReky" class=""></label>
		<input type="text" name="nazevReky" id="inputNazevReky" class="form-control" placeholder="Zadejte název řeky">

		<label for="inputID" class=""></label>
		<input type="text" name="idReky" id="inputID" class="form-control" value="<?php echo $tplData['lastIndexRekyPlusOne']?>" readonly>

		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="pridejReku" value="pridejReku">Přidej řeku</button>

	<br>

	<h2>Přidej novou loď</h2>
	<label for="inputNazevLodi" class=""></label>
	<input type="text" name="nazevLodi" id="inputNazevLodi" class="form-control" placeholder="Zadejte název lodi">

	<label for="inputID" class=""></label>
	<input type="text" name="idLodi" id="inputID" class="form-control" value="<?php echo $tplData['lastIndexLodiPlusOne']?>" readonly>

	<label for="inputCenaLodi" class=""></label>
	<input type="number" name="cenaLodi" id="inputCenaLodi" class="form-control" placeholder="Zadejte cenu lodi">

	<br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" name="pridejLod" value="pridejLod">Přidej loď</button>

	<br>
	<h2>Přidej nové příslušenství</h2>
		<label for="inputNazevPrislu" class=""></label>
		<input type="text" name="nazevPrislu" id="inputNazevPrislu" class="form-control" placeholder="Zadejte název příslušenství">

		<label for="inputID" class=""></label>
		<input type="text" name="idPrislu" id="inputID" class="form-control" value="<?php echo $tplData['lastIndexPrisluPlusOne']?>" readonly>

		<label for="inputCenaPrislu" class=""></label>
		<input type="number" name="cenaPrislu" id="inputCenaPrislu" class="form-control" placeholder="Zadejte cenu příslušenství">

		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="pridejPrislu" value="pridejPrislu">Přidej příslušenství</button>

	</form>


</div>
</body>
