<?php
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/signin.css","Půjčovna lodí");
?>

<body>
<?php
$tplHeaders->createNav();
?>

<form class="form-signin text-center d-flex">
    <div class="row justify-content-center align-self-center">

    <h1 class="h3 mb-4 font-weight-normal">Registrace</h1>

    <label for="inputEmail" class=""></label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Zadejte email" required autofocus>

    <label for="inputUsername" class=""></label>
    <input type="text" id="inputUsername" class="form-control" placeholder="Zadejte uživatelské jméno" required>

    <label for="inputPassword" class=""></label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Heslo" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Registruj se</button>
    </div>
</form>

</body>

