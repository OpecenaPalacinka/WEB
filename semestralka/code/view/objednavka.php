<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("","Půjčovna lodí");
?>

<body>
<?php
$tplHeaders->createNav();
?>


<div class="container">
    <div class="py-5 text-center">
        <i class="fas fa-water" style="font-size: xxx-large;color: #3b3be2"></i>
        <h2>Rezervace lodi/í</h2>
        <p class="lead">Při úspěšné rezervaci budete registrování do naší databáze pokud ještě nejste.
        Pokud již máte váš účet, přihlašte se nebo vyplntě vaše přihlašovací údaje.</p>
    </div>


    <!--------- Nákupní vozík ----------->
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Product name</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">$12</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Second product</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">$8</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Third item</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>$20</strong>
                </li>
            </ul>
        </div>


        <div class="col-md-8 order-md-1">

                <div class="row text-center d-flex justify-content-around">
                <div class="form-group pl-3">
                <label for="dat-vyp" class="col-form-label">Datum vypůjčení</label>
                    <input type="date" class="form-control" name="dat-vyp" id="dat-vyp" required>
                </div>
                <div class="form-group pl-3">
                <label for="dat-vra" class="col-form-label">Datum vrácení</label>
                    <input type="date" class="form-control" name="dat-vra" id="dat-vra" required>
                </div>
                </div>
                <br>

                <div class="form-group row">
                <label class="col-form-label col-sm-3" for="lod1">Samba 2-m</label>
                    <input type="number" class="form-control col-sm-2" name="lod1" id="lod1" min="0" value="0">
                <span class="col-sm-2"></span>
                <label class="col-form-label col-sm-3" for="padlo1">Počet pádel k lodi</label>
                    <input type="number" class="form-control col-sm-2" name="padlo1" id="padlo1" min="0" value="0">
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-3" for="lod2">Samba 3-m</label>
                    <input type="number" class="form-control col-sm-2" name="lod1" id="lod2" min="0" value="0">
                    <span class="col-sm-2"></span>
                    <label class="col-form-label col-sm-3" for="padlo2">Počet pádel k lodi</label>
                    <input type="number" class="form-control col-sm-2" name="padlo1" id="padlo2" min="0" value="0">
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-3" for="lod3">Colorado 4-m</label>
                    <input type="number" class="form-control col-sm-2" name="lod1" id="lod3" min="0" value="0">
                    <span class="col-sm-2"></span>
                    <label class="col-form-label col-sm-3" for="padlo3">Počet pádel k lodi</label>
                    <input type="number" class="form-control col-sm-2" name="padlo1" id="padlo3" min="0" value="0">
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-3" for="lod4">Colorado 6-m</label>
                    <input type="number" class="form-control col-sm-2" name="lod4" id="lod4" min="0" value="0">
                    <span class="col-sm-2"></span>
                    <label class="col-form-label col-sm-3" for="padlo4">Počet pádel k lodi</label>
                    <input type="number" class="form-control col-sm-2" name="padlo1" id="padlo4" min="0" value="0">
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-3" for="lod5">Kajak</label>
                    <input type="number" class="form-control col-sm-2" name="lod5" id="lod5" min="0" value="0">
                    <span class="col-sm-2"></span>
                    <label class="col-form-label col-sm-3" for="padlo5">Počet pádel k lodi</label>
                    <input type="number" class="form-control col-sm-2" name="padlo5" id="padlo5" min="0" value="0">
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-form-label col-sm-3" for="vesta-dosp">Počet vest - dospělý</label>
                    <input type="number" class="form-control col-sm-2" name="vesta-dosp" id="vesta-dosp" min="0" value="0">
                    <span class="col-sm-2"></span>
                    <label class="col-form-label col-sm-3" for="vesta-dite">Počet vest - dítě</label>
                    <input type="number" class="form-control col-sm-2" name="vesta-dite" id="vesta-dite" min="0" value="0">
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-3" for="barel">Barel</label>
                    <input type="number" class="form-control col-sm-2" name="barel" id="barel" min="0" value="0">
                    <span class="col-sm-2"></span>
                    <label class="col-form-label col-sm-3" for="pumpa">Pumpa k raftu</label>
                    <input type="number" class="form-control col-sm-2" name="pumpa" id="pumpa" min="0" value="0">
                </div>
                <div class="form-group row">
                <label class="col-form-label col-sm-6" for="reka">Vyberte řeku, kterou chcete sjíždět</label>
                    <input class="form-control col-sm-6" name="reka" id="reka" list="reky" required>
                    <datalist id="reky">
                        <?php
                        $reky = $tplData['reky'];
                        foreach ($reky as $reka){ ?>
                        <option><?php echo $reka['nazev']?></option>
                        <?php } ?>
                    </datalist>
               </div>

            <hr class="mb-4">

            <h4 class="mb-3">Uživatelské údaje</h4>
                <form class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">Uživatelské jméno</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Zadejte vaše uživatelské jméno.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Heslo</label>
                            <input type="password" class="form-control" id="lastName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Zadejte vaše heslo.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
                        <div class="invalid-feedback">
                            Prosím zadejte váš validní email.
                        </div>
                    </div>
                <hr class="mb-4">
                <div class="row justify-content-center">
                <button class="btn btn-lg btn-primary font-weight-bold" type="submit">Rezervuj ihned</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2020 Půjčovna lodí</p>
    </footer>
</div>

</body>