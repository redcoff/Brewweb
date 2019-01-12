<?php

/**
 * Class api
 */
class api {
    /**
     * @var mysqli
     */
    private $db_connect;

    /**
     * api constructor.
     */
    function __construct() {
		global $db_connect;
		$this->db_connect = $db_connect;    //ukládáme do privátní proměnné
        //Odstranění redundantní cesty z proměnné $PATH
		$request  = $_SERVER['REQUEST_URI'];
        // Rozdělení cesty podle "/"
		$params = explode("/", $request);
		if(isset($params[2])){
			if(
				$params[2] == 'user-info' &&
				$this->userCheck()
			){
				$json = [
					'valid' => $_SESSION['valid'],
					'email' => $_SESSION['email'],
					'isAdmin' => $_SESSION['isAdmin']
				];
				header('Content-type: application/json');
				echo json_encode($json);
				die();
			}

			// Přidat, vytvořit marker
			if(isset($params[3])){
			    if(
					$params[2] == 'map' && 
					$params[3] == 'add' &&
					$this->userCheck()    //kontrolujeme, zda je to admin
				){

					$result = $this->addMarker();   //vrací json
					header('Content-type: application/json');
					echo json_encode(["success" => $result]);
					die();
				}
			}

			// Remove marker - Delete
			if(isset($params[3])){
				if(
					$params[2] == 'map' &&
					$params[3] == 'remove' &&
					$this->accessCheck()
				){
					$result = $this->removeMarker();
					header('Content-type: application/json');
					echo json_encode(["success" => $result]);
					die();
				}
			}

			// Čtení markerů
			if($params[2] == 'map') {
				$this->getMarkers();
				die();
			}
		}

		// nevalidni request
		die();
	}

    /**
     *
     */
    private function getMarkers(){
		$query = 'SELECT * FROM `markers`';
		$result = mysqli_query($this->db_connect, $query);
		// Return json
		header('Content-type: application/json');
		$markers = $result->fetch_all( MYSQLI_ASSOC ); //asociativní pole markeru
		echo json_encode( $markers );
	}

    /**
     * @return bool|mysqli_result
     */
    private function addMarker(){
		if(
			!(
				isset($_POST['lng']) &&
				isset($_POST['lat']) &&
				isset($_POST['name']) &&
				isset($_POST['description'])
			)
		){
			return false;
		}
		$lng = mysqli_real_escape_string($this->db_connect, $_POST['lng']);
		$lat = mysqli_real_escape_string($this->db_connect, $_POST['lat']);
		$name = mysqli_real_escape_string($this->db_connect, $_POST['name']);
		$description = mysqli_real_escape_string($this->db_connect, $_POST['description']);
		$query = "INSERT INTO `markers`(lng, lat, name, description) VALUES ($lng, $lat, '$name', '$description')"; //přidáváme do DB
        return mysqli_query($this->db_connect, $query);
	}

    /**
     * @return bool|mysqli_result
     */
    private function removeMarker() {
		if(
			!(
				isset($_POST['lng']) &&
				isset($_POST['lat']) &&
				isset($_POST['name'])
			)
		){
			return false;
		}
		$lng = mysqli_real_escape_string($this->db_connect, $_POST['lng']);
		$lat = mysqli_real_escape_string($this->db_connect, $_POST['lat']);
		$name = mysqli_real_escape_string($this->db_connect, $_POST['name']);
		$query = "DELETE FROM `markers` 
			WHERE
				lng = $lng AND
				lat = $lat AND
				name = '$name'
		";
		// var_dump($query);
		// die();
		return mysqli_query($this->db_connect, $query);
		
	}

    /**
     * @return mixed
     */
    private function userCheck(){
		return $_SESSION['valid'];
	}

    /**
     * @return mixed
     */
    private function accessCheck() {
		return $_SESSION['isAdmin'];
	}
}