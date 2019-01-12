<?php

/**
 * Class mapadd
 */
class mapadd {
    /**
     * mapadd constructor.
     */
    function __construct() {
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
    }

    //render mapy

    /**
     *
     */
    function render() {
        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-4">
                    <div id="mapid"></div>
                </div>
            </div>
        </div>
        <script src="../add_map_script.js" type="text/javascript"></script>
        <?php
    }
}