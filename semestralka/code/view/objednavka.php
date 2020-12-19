<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("", $tplData['title']);
?>

<body>
<?php
if (!$tplData['userLogged']) {
	$tplHeaders->createNav($tplData['pravo']);
} else {
	$tplHeaders->createNav($tplData['pravo'], "odhlaseni");
}
?>


<div class="container">
	<div class="py-5 text-center">
		<i class="fas fa-water" style="font-size: xxx-large;color: #3b3be2"></i>

		<?php
		if (isset($_POST['rezervace'])) {
			if ($tplData['povedloSe']) {
				?>
				<script type="text/javascript">
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $tplData['uspech'] ?>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: `OK`,
                        customClass: {
                            confirmButton: 'order-1',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("index.php?page=uvod");
                        }
                    });
				</script>
			<?php
			} else {
			?>
				<script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: '<?php echo $tplData['uspech'] ?>',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: `OK`,
                        customClass: {
                            confirmButton: 'order-1',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("index.php?page=objednavka");
                        }
                    });
				</script>
				<?php
			}
		}
		?>

		<h2>Rezervace lodi/í</h2>
		<p class="lead">Při úspěšné rezervaci budete registrování do naší databáze pokud ještě nejste.
			Pokud již máte váš účet, přihlašte se nebo vyplntě vaše přihlašovací údaje.</p>
	</div>


	<!--------- Nákupní vozík ----------->
	<form class="needs-validation" method="post">
		<div class="row">

			<div class="col-md-4 order-md-2">
				<h4 class="d-flex justify-content-between align-items-center mb-3">
					<span class="text-muted">Váš vozík</span>
					<span class="badge badge-secondary badge-pill">0</span>
				</h4>

				<ul class="list-group mb-3">

					<!---------------------- Místo pro nákupní vozík -------->

				</ul>
				<div class="list-group-item d-flex justify-content-between">
					<span>Celková cena:</span>
					<strong class="cart-total">0</strong>
				</div>

			</div>


			<div class="col-md-8 order-md-1">
				<div class="row text-center d-flex justify-content-around">
					<div class="form-group pl-3">
						<label for="dat-vyp" class="col-form-label"><b>Datum vypůjčení</b></label>
						<input type="date" class="form-control" name="dat-vyp" id="dat-vyp" required>
					</div>
					<div class="form-group pl-3">
						<label for="dat-vra" class="col-form-label"><b>Datum vrácení</b></label>
						<input type="date" class="form-control" name="dat-vra" id="dat-vra" required>
					</div>
				</div>
				<br>

				<?php
				$jmenoProLode = ["lod12", "lod23", "lod34", "lod45", "lod56"];
				$jmenoProPrislu = ["padlo1", "vesta-dosp2", "vesta-dite3", "barel4", "pumpa5"];
				$lode = $tplData['lode'];
				$prislusenstvi = $tplData['prislusenstvi'];

				for ($c = 0; $c < count($lode); $c++) {
					?>
					<div class="form-group row">
						<label class="col-form-label col-sm-4" for="<?php echo $jmenoProLode[$c]; ?>">
							<b><span class="cart-item-name-l"><?php echo $lode[$c]['typ_lode']; ?></span> -> <span
										class="cart-item-price-l"><?php echo $lode[$c]['cena'] . " KČ"; ?></span></b></label>
						<input type="button" class="btn btn-primary col-md-2 shop-add-button-l"
						       name="<?php echo $jmenoProLode[$c]; ?>" id="<?php echo $jmenoProLode[$c]; ?>"
						       value="Přidej">
						<span class=""></span>
						<label class="col-form-label col-sm-4 font-weight-bold"
						       for="<?php echo $jmenoProPrislu[$c]; ?>">
							<span class="cart-item-name-p"><?php echo $prislusenstvi[$c]['nazev_prislusen']; ?></span>
							-> <span class="cart-item-price-p"><?php echo $prislusenstvi[$c]['cena'] . " KČ"; ?></span></label>
						<input type="button" class="btn btn-primary col-md-2 shop-add-button-p"
						       name="<?php echo $jmenoProPrislu[$c]; ?>" id="<?php echo $jmenoProPrislu[$c]; ?>"
						       value="Přidej">
					</div>
				<?php } ?>

				<br>

				<div class="form-group row">
					<label class="col-form-label col-sm-6" for="reka">Vyberte řeku, kterou chcete sjíždět</label>
					<input class="form-control col-sm-6" name="reka" id="reka" list="reky" required>
					<datalist id="reky">
						<?php
						$reky = $tplData['reky'];
						foreach ($reky as $reka) { ?>
							<option><?php echo $reka['nazev'] ?></option>
						<?php } ?>
					</datalist>
				</div>

				<hr class="mb-4">

				<h4 class="mb-3">Uživatelské údaje</h4>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="firstName">Uživatelské jméno</label>
						<input type="text" class="form-control" name="firstName" id="firstName" placeholder=""
						       value="<?php if ($tplData['userLogged']) {
							       echo $tplData['username'];
						       } else {
							       echo "";
						       } ?>" required>
						<div class="invalid-feedback">
							Zadejte vaše uživatelské jméno.
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<label for="password">Heslo</label>
						<input type="password" class="form-control" name="password" id="password" placeholder=""
						       value="<?php if ($tplData['userLogged']) {
							       echo $tplData['password'];
						       } else {
							       echo "";
						       } ?>" required>
						<div class="invalid-feedback">
							Zadejte vaše heslo.
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="you@example.com"
					       value="<?php if ($tplData['userLogged']) {
						       echo $tplData['email'];
					       } else {
						       echo "";
					       } ?>" required>
					<div class="invalid-feedback">
						Prosím zadejte váš validní email.
					</div>
				</div>
				<hr class="mb-4">
				<div class="row justify-content-center">
					<button class="btn btn-lg btn-primary font-weight-bold" type="submit" name="rezervace"
					        value="rezervace">Rezervuj ihned
					</button>
				</div>

			</div>
		</div>
	</form>
	<footer class="my-5 pt-5 text-muted text-center text-small">
		<p class="mb-1">&copy; 2017-2020 Půjčovna lodí</p>
	</footer>
</div>

</body>