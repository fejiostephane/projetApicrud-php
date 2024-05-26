<?php
	require_once(ROOT . "/utils/IController.php");
	require_once(ROOT . "/utils/AbstractController.php");
	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/services/GarePeageService.php");

	class GarePeagePostController extends AbstractController implements IController {

		private GarePeageService $service;
		private string $GarePeage;
		private string $nomPeage;
		private GarePeage $newGarePeage;

		public function __construct($form, $controllerName) {
                        parent::__construct($form, $controllerName);
                        $this->service = new GarePeageService();
                }

		function checkForm() {
			if ( ! isset($this->form['GarePeage']) && ! isset($this->form['nomPeage']) ) {
				_400_Bad_Request();
			}
			$this->GarePeage = $this->form['GarePeage'];
			$this->nomPeage = $this->form['nomPeage'];
		}

                function checkCybersec() {
			if (notAlphaNum($this->GarePeage)) { // default length 4
				_400_Bad_Request();
			}
			if (stringNotValid($this->nomPeage) ) {
				_400_Bad_Request();
			}
		}

                function checkRights() {
			error_log(__FUNCTION__);
		}

                function processRequest() {
			$this->newGarePeage = GarePeage::create($this->GarePeage, $this->nomPeage);
			try {
				$this->newGarePeage = $this->service->insert($this->newGarePeage);
			} catch (PDOException $ex) {
				if ($ex->errorInfo[1] == 1062) {
					headerAndDie("HTTP/1.1 499 Entity duplicated Badge " . $this->GarePeage);
				}
				throw $ex;
			}
		}

                function processResponse() {
			echo json_encode($this->newGarePeage);
		}

	}
?>
