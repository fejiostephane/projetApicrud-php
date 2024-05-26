<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/GarePeageService.php");

class GarePeagePutController extends AbstractController implements IController {

    private GarePeageService $service;
		private string $GarePeage;
        private string $GarePeageId;
		private string $nomPeage;
		private GarePeage $newGarePeage;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new GarePeageService();
    }

    private function notAlphaNum($string) {
        return !ctype_alnum($string);
    }

    private function stringNotValid($string) {
        return empty($string) || !ctype_print($string);
    }

    function checkForm() {
        if (!isset($this->form['id']) || !isset($this->form['GarePeage']) || !isset($this->form['nomPeage'])) {
            _400_Bad_Request("Missing id, GarePeage or nomPeage");
        }
        $this->GarePeageId = $this->form['id'];
        $this->GarePeage = $this->form['GarePeage'];
        $this->nomPeage = $this->form['nomPeage'];
    }

    function checkCybersec() {
        if (notAlphaNum($this->GarePeage)) {
            _400_Bad_Request("Invalid badge value");
        }
        if (stringNotValid($this->nomPeage)) {
            _400_Bad_Request("Invalid nom value");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        $this->newGarePeage = GarePeage::createWithId($this->GarePeageId,$this->GarePeage, $this->nomPeage);
        try {
            $this->newGarePeage = $this->service->update($this->newGarePeage);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode($this->newGarePeage);
    }

    
}
?>
