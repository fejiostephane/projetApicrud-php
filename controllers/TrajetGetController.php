<?php
	require_once(ROOT . "/utils/IController.php");
	require_once(ROOT . "/utils/AbstractController.php");
	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/services/TrajetService.php");

	class TrajetGetController extends AbstractController implements IController {

		private TrajetService $service;
		private $trajets;
		private $id;
        

		public function __construct($form, $controllerName) {
                        parent::__construct($form, $controllerName);
                        $this->service = new TrajetService();
                }

		function checkForm() {
			if ( isset($this->form['id']) ) {
				$this->id = $this->form['id'];
			}
		}

                function checkCybersec() {
			if ( isset( $this->id) ) {
				if ( ctype_digit( $this->form['id'] ) ) {
					$this->id = intval($this->form['id']);
				} else {
					_400_Bad_Request("Bad value for id " . $this->form['id'] );
				}
			}
		}

                function checkRights() {
			error_log(__FUNCTION__);
		}

                function processRequest() {
			if ( isset( $this->id) ) {
				$this->trajets = $this->service->findById($this->id);
			} else {
				$this->trajets = $this->service->findAll();
			}
		}

                function processResponse() {
			if ( isset( $this->id) ) {
				if ($this->trajets == null) {
					_404_Not_Found("Portique id = " . $this->id);
				} else {
					echo json_encode($this->trajets);
				}
			} else {
				echo json_encode($this->trajets);
			}
		}

	}
?>
