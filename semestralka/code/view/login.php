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

      <h1 class="h3 mb-4 font-weight-normal">Přihlaště se prosím</h1>

         <label for="inputEmail" class=""></label>
         <input type="email" id="inputEmail" class="form-control" placeholder="Zadejte emailovou adresu" required autofocus>

         <label for="inputPassword" class=""></label>
         <input type="password" id="inputPassword" class="form-control" placeholder="Heslo" required>

  <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fas fa-sign-in-alt 9"></i> Přihlaš se</button>
        </div>
</form>
</body>

