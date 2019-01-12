<?php

/**
 * Class homepagePage
 */
class homepagePage {
    /**
     * @var bool
     */
    private $valid = false;

    /**
     * homepagePage constructor.
     */
    function __construct() {
            if(isset($_SESSION['valid']) && $_SESSION['valid']){
                $this->valid = true;
            }
        }

    /**
     *
     */
    function render() {
        ?>
            <!-- Hlavní stránka -->
            <div class="cover-container d-flex w-100 h-100 m-5 p-5 mx-auto flex-column flex-wrap align-content-center ">
                <main>
                    <div class="row">
                        <div role="main" class="inner col-12">
                            <!-- Úvodní text -->
                            <h1 class="cover-heading">Svět filtrované kávy</h1>
                            <p class="lead">Vstupte do světa nových chutí kávy. Naučte se o aletrnativních metodách přípravy kávy, o přípravách doma a nalezněte kavárny, které tyto přípravy  poskytují.</p>
                            <p class="lead">
                                <a href="/coffee" class="btn btn-lg btn-secondary">Více o filtrované kávě</a>
                            </p>
                        </div>

                        <div class="content col-12">
                            <!-- Stručný popis webové aplikace -->
                            <h2> Co je to BrewWeb?</h2>
                            <p>BrewWeb je internetová stránka, která milovníkům kávy představuje aleternativní metody přípravy kávy.
                                Zde naleznete jaké takové přípravy mohou být, jejic průběh a seznámení se s potřebnýma pomůckama.
                                Obsahem stránky je i mapa kaváren, kde se tyto aletrnativy vyskytují a jejich recenze.</p>
                        </div>
                        <?php if($this->valid): ?>
                        <div class="content col-12">
                            <a class='btn btn-primary' href="/stylechange">
                                Změnit pozadí
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </main>
            </div>
        <?php
        }
    }
?>