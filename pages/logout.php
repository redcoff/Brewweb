<?php
//Odhlášení

/**
 * Class logout
 */
class logout {
    /**
     * logout constructor.
     */
    function __construct() {
		$_SESSION['valid'] = false; //Znevalidnění sessionu
		header("Location: /"); //Přesměrování na hlavní stránku
		die();
	}

    /**
     *
     */
    function render() {
		
	}
}