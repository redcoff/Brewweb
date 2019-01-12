<!-- REGISTRAČNÍ FORMULÁŘ -->

<?php

/**
 * Class register
 */
class register {
    /**
     * @var string
     */
    private $email = "";
    /**
     * @var string
     */
    private $password = "";
    /**
     * @var string
     */
    private $msg = "";

    /**
     * register constructor.
     */
    function __construct() {
        global $db_connect;
        global $alert;

        $registerFormSent = isset($_POST);
        $emailValid = false;
        $emailAvaliable = false;
        $passValid = false;
        $passEquals = false;


        //Odeslání formuláře
        if($registerFormSent) {
            $emailAvaliable = isset($_POST["email"]);

            //Je správně zadané heslo?
            $passValid = isset($_POST["password"]) && strlen($_POST["password"]) > 5;
            if( isset($_POST["password"]) && strlen($_POST["password"]) < 5){
               $msg = "Heslo musí být delší než 5 znaků.";

                $alert = new Alert(false);
                $alert->setMsg($msg);
                $alert->setType('warning');
                $alert->setToRender(true);
                return;
            }

            //Shodují se zadaná hesla?
            $passEquals = isset($_POST["password"]) && isset($_POST["passwordAgain"]) &&
                $_POST["password"] == $_POST["passwordAgain"];
            if (isset($_POST["password"]) && isset($_POST["passwordAgain"]) && $_POST["password"] != $_POST["passwordAgain"]) {
                    $msg = "Zadané hesla se neshodují.";

                    $alert = new Alert(false);
                    $alert->setMsg($msg);
                    $alert->setType('danger');
                    $alert->setToRender(true);
                    return;
                }

            //Form je validní, když je zadaný email, hesla a pokud se hesla shodují
            $formValid = $emailAvaliable && $passValid && $passEquals;


            if($formValid) {
                //Propojení s DB, escapování speciálních znaků
                $this->email = mysqli_real_escape_string($db_connect, $_POST["email"]);
                $this->password = passwordHash(mysqli_real_escape_string($db_connect, $_POST["password"]));

                // Kontrola zda uzivatel (email) jiz existuje v DB
                $query = "SELECT * FROM `users` WHERE email = '$this->email'";
                $result = mysqli_query($db_connect, $query);

                //Pokud už takový řádek v tabulce existuje
                if($result->num_rows != 0){
                    $msg = "Email je uz zabraný.";
                    $this->password = '';

                    $alert = new Alert(false);
                    $alert->setMsg($msg);
                    $alert->setType('warning');
                    $alert->setToRender(true);
                    return;
                }

                //Přidání uživatele do DB
                $query = "INSERT INTO `users` (`email`, `password`) VALUES('$this->email', '$this->password')";
                $result = mysqli_query($db_connect, $query);

                //Úspešné zapsání do DB
                if ($result) {
                    // $msg = "Uživatel byl zaregistrován.";
                    $this->password = '';
                    // $alert = new Alert(false);
                    // $alert->setMsg($msg);
                    // $alert->setType('success');
                    // $alert->setToRender(true);

                    $msg = [
                        'type' => 'success',
                        'msg' => 'Uživatel byl zaregistrován.'
                    ];
                    $msg = http_build_query($msg);
                    header('Location: /?'.$msg);
                    die();
                    return;
                }
                //Neúspěšné zapsání do DB
                else {
                    $msg = "Nepodařilo se uživatele zaregistrovat. Prosím, zkontrolujte údaje.";
                    
                    $alert = new Alert(false);
                    $alert->setMsg($msg);
                    $alert->setType('danger');
                    $alert->setToRender(true);
                    return;
                }
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

                    <!-- Registační formulář -->
                    <form class="form-signin" method="POST" onsubmit="return validateRegisterForm()" name="registerForm">
                        <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                        <h1 class="h3 mb-3 font-weight-normal">Registrační formulář</h1>
                        <!-- Textové pole pro email -->
                        <label for="inputEmail" class="sr-only">Email</label>
                        <input name="email" type="email" id="inputEmail" class="form-control mb-3" placeholder="Email address" required autofocus value="<?= htmlspecialchars($this->email) ?>">
                        <!-- Textové pole pro heslo -->
                        <label for="inputPassword" class="sr-only">Heslo</label>
                        <input name="password" type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" required  value="<?= htmlspecialchars($this->password) ?>">
                        <!-- Textové pole pro validaci hesla -->
                        <label for="inputPasswordAgain" class="sr-only">Heslo znovu</label>
                        <input name="passwordAgain" type="password" id="inputPasswordVerify" class="form-control mb-3" placeholder="Repeat password" required  value="<?= htmlspecialchars($this->password) ?>">

                        <!-- Tlačítko pro registraci -->
                        <button class="btn btn-lg btn-primary btn-block mb-2" type="submit" name="register">Registrovat</button>

                    </form>
                </div>
            </div>
        </div>
    <?php
    }
}
