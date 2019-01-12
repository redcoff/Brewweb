<?php

/**
 * Class map
 */
class map {

    /**
     * @var bool
     */
    private $valid = false;

    /**
     * map constructor.
     */
    function __construct() {
            if(isset($_SESSION['valid']) && $_SESSION['valid']){
                $this->valid = true;
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

                        <!-- For registered only -->
                        <?php
                        if($this->valid):
                        ?>
                        <div class='text-center'>
                            <a class='btn btn-primary mt-2 align-content-center' href="/mapadd">
                            Editace kaváren
                            </a>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <script src="../maps_script.js" type="text/javascript"></script>
        <?php
        }
    }