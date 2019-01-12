<?php
class Alert {
	private $msg;
	private $type;
	private $toRender = true;

	function __construct($standart = true) {
		if($standart){ //standartní průběh
			if(!(isset($_GET['type']) && isset($_GET['msg']))){ //pokud není zadán typ, ale je zadána zpráva
				$this->toRender = false; //nevyrenderuje se alert
				return;
			}

			$this->type = htmlspecialchars($_GET['type']); //převedení speciálních znaků na entity
			$this->msg = htmlspecialchars($_GET['msg']);

			$this->type = $this->findType($this->type);
		}
	}

	//Nastav zprávu
	public function setMsg($msg) {
		$this->msg = $msg;
	}

	//Nastav typ alertu (success, danger, warning, light)
	public function setType($type) {
		$this->type = $type;
	}

	//Nastav, jestli se to zobrazí
	public function setToRender($toRender) {
		$this->toRender = $toRender;
	}

	//Render
	function render() {
		if(!$this->toRender){
			return;
		}
		?>
		<div class="alert alert-<?php echo "$this->type" ?>" role="alert">
		  <span><?php echo "$this->msg" ?></span>
		</div>
		<?php
	}

	//Nastav typ
	function findType($type){
		switch ($type) {
			case 'success':
				return 'success';
				break;
			
			case 'danger':
				return 'danger';
				break;
			
			case 'warning':
				return 'warning';
				break;

			default:
				return 'light';
				break;
		}
	}
}