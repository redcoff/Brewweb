<?php
//Změna pozadí webové stránky

/**
 * Class stylechange
 */
class stylechange{

    /**
     * stylechange constructor.
     */
    public function __construct(){
        if(isset($_SESSION['valid']) && $_SESSION['valid']) {

        } else {
            $msg = [
                'type' => 'warning',
                'msg' => 'Musíte být přihlašen do systému.'
            ];
            $msg = http_build_query($msg);
            header('Location: /?'.$msg);
            die();
        }
        
        if(isset($_POST["background"])){
            setcookie("background", $_POST["background"], time() + (86400 * 30), "/"); //nastav Cookie
            header("Location: /stylechange"); // reload stránky
            die();
        }
    }

    /**
     *
     */
    public function render(){
        ?>
        <div class="container">
            <div class="row">
                <div class="col-12 form-group">
                    <form method="POST" action="">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="background" checked value="bg1">
                            <label class="custom-control-label" for="customControlValidation2">V60</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" class="custom-control-input" id="customControlValidation3" name="background"  value="bg2">
                            <label class="custom-control-label" for="customControlValidation3">Coffee</label>
                        </div>
                        <button class="btn btn-primary" type="submit">Změnit pozadí</button>
                    </form>
                </div>
            </div>
        </div>
    <?php



    }
}



