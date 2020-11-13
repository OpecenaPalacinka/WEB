<?php
    // nacteni souboru s funkcemi loginu (prace se session)
    require_once("MyLogin.class.php");
    $login = new MyLogin;
    
    // nacteni souboru s funkce pro nakup automobilu (prace s cookie)
    require_once("MyNakupAuta.class.php");
    $nakup = new MyNakupAuta;

    // byl odeslan formular s akci?
    if(isset($_POST["action"])){
        // je pozadavek na ulozeni?
        if( $_POST["action"]=="ulozit"){
            $nakup->createCar($_POST["kola"], $_POST["barva"]);
        }
        // je pozadavek na mazani?
        else if($_POST["action"]=="smazat"){
            $nakup->deleteCar();
        }
        // znovu nactu web, abych mohl cookie primo cist
        header("Refresh:0");
    }
?>
<!doctype html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <title>Nákup automobilu</title>
    </head>
    <body>
        <h1>Nákup automobilu</h1>
<?php
   ///////////// PRO NEPRIHLASENE UZIVATELE /////////////// 
    if(!$login->isUserLoged()){
?>
        Na tuto stránku mají přístup pouze přihlášení uživatelé.<br>
        Přihlašte se prosím: <a href="login-reseni.php">Přihlášení</a>.
        
<?php
   ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////
    } else {
   ///////////// PRO PRIHLASENE UZIVATELE ///////////////                
?>
        <b>Přihlášený uživatel</b><br>
        <?php echo $login->getUserInfo(); ?>
        <br>
        
        Menu: <a href="login-reseni.php">Úvodní stránka s přihlášením uživatele</a><br><br>

        <form method="POST">
            <fieldset>
                <legend>Nákup automobilu</legend>
                <table>
                    <tr><td>
                            <label for="kola">Počet kol:</label>
                        </td>
                        <td>
                            <select name="kola" id="kola">
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>
                            <label for="barva">Barva:</label>
                        </td>
                        <td><input type="color" name="barva" id="barva"></td>
                    </tr>
                    <tr><td colspan="2">
                            <button type="submit" name="action" value="ulozit">
                                Uložit data
                            </button>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
        <br>

        <form method="post">
            <fieldset>
                <legend>Smazat uložené informace</legend>
                <button type="submit" name="action" value="smazat">
                    Smazat data
                </button>
            </fieldset>
        </form>
        
        <br><br>
        Vybraný automobil:<br>        
<?php
        // je v cookie ulozena informace o vybranem automobilu?
        if($nakup->isSelectedCar()){
            echo $nakup->getInfo();
        } else {
            echo "<i>Uživatel nemá uložena data.</i>";
        }
   ///////////// KONEC: PRO PRIHLASENE UZIVATELE /////////////// 
    }
?>
    
    </body>
</html>
