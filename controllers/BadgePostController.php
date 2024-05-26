<?php
	require_once(ROOT . "/utils/IController.php");
	require_once(ROOT . "/utils/AbstractController.php");
	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/services/BadgeService.php");

	class BadgePostController extends AbstractController implements IController {

		private BadgeService $service;
		private string $badge;
		private string $nom;
		private Badge $newBadge;

		public function __construct($form, $controllerName) {
                        parent::__construct($form, $controllerName);
                        $this->service = new BadgeService();
                }

		function checkForm() {
			if ( ! isset($this->form['badge']) && ! isset($this->form['nom']) ) {
				_400_Bad_Request();
			}
			$this->badge = $this->form['badge'];
			$this->nom = $this->form['nom'];
		}

                function checkCybersec() {
			if (notAlphaNum($this->badge)) { // default length 4
				_400_Bad_Request();
			}
			if (stringNotValid($this->nom) ) {
				_400_Bad_Request();
			}
		}

                function checkRights() {
			error_log(__FUNCTION__);
		}

                function processRequest() {
			$this->newBadge = Badge::create($this->badge, $this->nom);
			try {
				$this->newBadge = $this->service->insert($this->newBadge);
			} catch (PDOException $ex) {
				if ($ex->errorInfo[1] == 1062) {
					headerAndDie("HTTP/1.1 499 Entity duplicated Badge " . $this->badge);
				}
				throw $ex;
			}
		}

                function processResponse() {
			echo json_encode($this->newBadge);
		}

	}
?>
