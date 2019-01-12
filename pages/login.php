<?php

/**
 * Class login
 */
class login{
    //Deklarace proměnných
    /**
     * @var string
     */
    private $msg = '';
    /**
     * @var string
     */
    private $email = '';
    /**
     * @var string
     */
    private $password = '';

    /**
     * login constructor.
     */
    function __construct() {
        global $db_connect;
        global $alert;

        //Pokud jsou zadané údaje
        if (isset($_POST['email']) && !empty($_POST['email'])
            && !empty($_POST['password'])) {
            $this->email = mysqli_real_escape_string($db_connect ,$_POST['email']);          //escape nebezpečných znaků
            $this->password = mysqli_real_escape_string($db_connect, $_POST['password']);    //escape nebezpečných znaků
            $sql = "SELECT * FROM users WHERE email = '$this->email' ";     //Hledání v DB, jestli takový email je registrovaný
            $result = mysqli_query($db_connect, $sql); //výsledek hledání v našem DB
            $row = mysqli_fetch_array($result, MYSQLI_BOTH); //Zpracování jednoho řádku výsledku příkazu, vrací asociativní i číselné pole.
            if ($row != null && //Pokud řádek není prázdný, tzn. získáme jak email, tak i přiřazené heslo
                $_POST['email'] == $row['email'] && //Pokud se zadaný email shoduje s nalezeným emailem
                passwordVerify($_POST['password'], $row['password'])) { //Pokud se zadané heslo shoduje s nalezeným heslem
                //Nastavení sessionu
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['email'] = $row['email'];
                $_SESSION['isAdmin'] = $row['isAdmin'];


            }else{
                // $this->msg = 'Wrong username or password';

                //Když se nenajdou údaje v DB, tzn. uživatel zadává nezaregistrovaný email nebo email nebo heslo zadává špatně
                //+ warning alert
                $alert = new Alert(false);
                $alert->setMsg('Špatně zadaný email nebo heslo.');
                $alert->setType('warning');
                $alert->setToRender(true);
                return;
            }

            //Pokud byl session nastaven a je validní, tak přesměruje na hlavní stránku a vypíše alert zprávu (alert v index.php)
            if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {
                $msg = urlencode('Vítejte zpět');
                header("Location: /?type=success&msg=$msg");
                die();
            }
        }
    }

    /**
     *
     */
    function render() {
        ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Přihlašovací formulář -->
                        <form class="form-signin" method="POST" onsubmit="return validateLoginForm()" name="loginForm">
                            <h1 class="h3 mb-3 font-weight-normal">Přihlásit se</h1>
                            <!-- Textové pole pro email -->
                            <label for="inputEmail" class="sr-only">Email</label>
                            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus required value="<?= htmlspecialchars($this->email) ?>">
                            <!-- Textové pole pro heslo -->
                            <label for="inputPassword" class="sr-only">Heslo</label>
                            <input name="password" type="password" id="inputPassword" class="form-control mt-3" placeholder="Password" required value="<?= htmlspecialchars($this->password) ?>">

                            <!-- Tlačítko pro přihlášení -->
                            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Přihlásit</button>

                            <!-- Odkaz na registraci -->
                            <label class="mt-3">
                                Nejste ještě zaregistrovaní? Zaregistrujte se <a href="/register">zde</a>.
                            </label>
                    </div>
                </div>
            </div>
        <?php
    }
}
?>
