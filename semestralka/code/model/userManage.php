<?php


class userManage
{

    /** @var string $userSessionKey  Klicem pro data uzivatele, ktera jsou ulozena v session. */
    private $userSessionKey = "current_user_id";
    /**
     * @var MyDatabase
     */
    private $db;
    /**
     * @var MySession
     */
    private $mySession;

    public function __construct(){
        require_once("MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once("MySessions.class.php");
        $this->mySession = new MySession();
    }

    ///////////////////  Sprava prihlaseni uzivatele  ////////////////////////////////////////

    /**
     * Overi, zda muse byt uzivatel prihlasen a pripadne ho prihlasi.
     *
     * @param string $email
     * @param string $heslo Heslo uzivatele.
     * @return bool             Byl prihlasen?
     */
    public function userLogin(string $email, string $heslo): bool
    {
        // ziskam uzivatele z DB - primo overuju login i heslo
        $where = "email='$email' AND password='$heslo'";
        $user = $this->db->selectFromTable(TABLE_USER, $where);
        // ziskal jsem uzivatele
        if(count($user)){
            // ziskal - ulozim ho do session
            $_SESSION[$this->userSessionKey] = $user[0]['id_user']; // beru prvniho nalezeneho a ukladam jen jeho ID
            return true;
        } else {
            // neziskal jsem uzivatele
            return false;
        }
    }

    /**
     * Odhlasi soucasneho uzivatele.
     */
    public function userLogout(){
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Test, zda je nyni uzivatel prihlasen.
     *
     * @return bool     Je prihlasen?
     */
    public function isUserLogged(): bool
    {
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Pokud je uzivatel prihlasen, tak vrati jeho data,
     * ale pokud nebyla v session nalezena, tak vypisu chybu.
     *
     * @return mixed|null   Data uzivatele nebo null.
     */
    public function getLoggedUserData(){
        if($this->isUserLogged()){
            // ziskam data uzivatele ze session
            $userId = $_SESSION[$this->userSessionKey];
            // pokud nemam data uzivatele, tak vypisu chybu a vynutim odhlaseni uzivatele
            if($userId == null) {
                // nemam data uzivatele ze session - vypisu jen chybu, uzivatele odhlasim a vratim null
                echo "SEVER ERROR: Data přihlášeného uživatele nebyla nalezena, a proto byl uživatel odhlášen.";
                $this->userLogout();
                // vracim null
                return null;
            } else {
                // nactu data uzivatele z databaze
                $userData = $this->db->selectFromTable(TABLE_USER, "id_user=$userId");
                // mam data uzivatele?
                if(empty($userData)){
                    // nemam - vypisu jen chybu, uzivatele odhlasim a vratim null
                    echo "ERROR: Data přihlášeného uživatele se nenachází v databázi (mohl být smazán), a proto byl uživatel odhlášen.";
                    $this->userLogout();
                    return null;
                } else {
                    // protoze DB vraci pole uzivatelu, tak vyjmu jeho prvni polozku a vratim ziskana data uzivatele
                    return $userData[0];
                }
            }
        } else {
            // uzivatel neni prihlasen - vracim null
            return null;
        }
    }

    ///////////////////  KONEC: Sprava prihlaseni uzivatele  ////////////////////////////////////////


}