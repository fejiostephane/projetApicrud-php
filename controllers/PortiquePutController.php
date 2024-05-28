<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/PortiqueService.php");
require_once(ROOT . "/modele/Portique.php"); // Assurez-vous d'inclure le modèle Portique

class PortiquePutController extends AbstractController implements IController {

    private PortiqueService $service;
    private int $isEntrer;
    private int $isEntrerId;
    private int $noPortique;
    private int $fkGarePeage;
    private Portique $newPortique;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new PortiqueService();
    }

    private function notAlphaNum($string) {
        return !ctype_alnum($string);
    }

    private function stringNotValid($string) {
        return empty($string) || !ctype_print($string);
    }

    function checkForm() {
        if (!isset($this->form['id']) || !isset($this->form['isEntrer']) || !isset($this->form['noPortique']) || !isset($this->form['fkGarePeage'])) {
            error_log("Missing parameters: " . json_encode($this->form));
            _400_Bad_Request("Missing id, isEntrer, noPortique or fkGarePeage");
        }
        $this->isEntrerId = $this->form['id'];
        $this->isEntrer = $this->form['isEntrer'];
        $this->noPortique = $this->form['noPortique'];
        $this->fkGarePeage = $this->form['fkGarePeage'];
        error_log("Form data: id=$this->isEntrerId, isEntrer=$this->isEntrer, noPortique=$this->noPortique, fkGarePeage=$this->fkGarePeage");
    }

    function checkCybersec() {
        if (!ctype_digit((string) $this->isEntrer)) {
            error_log("Invalid isEntrer value: " . $this->isEntrer);
            _400_Bad_Request("Bad syntaxe entrer = " . $this->isEntrer);
        }
        if (!ctype_digit((string) $this->noPortique)) {
            error_log("Invalid noPortique value: " . $this->noPortique);
            _400_Bad_Request("Bad syntaxe portique = " . $this->noPortique);
        }
        if (!ctype_digit((string) $this->fkGarePeage)) {
            error_log("Invalid fkGarePeage value: " . $this->fkGarePeage);
            _400_Bad_Request("Bad syntaxe gare = " . $this->fkGarePeage);
        }

        $this->isEntrer = intval($this->isEntrer);
        $this->noPortique = intval($this->noPortique);
        $this->fkGarePeage = intval($this->fkGarePeage);

        if (!($this->isEntrer === 1 || $this->isEntrer === 0)) {
            error_log("Invalid isEntrer value, must be 0 or 1: " . $this->isEntrer);
            _400_Bad_Request("Bad syntaxe entrer doit être soit 0 soit 1");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        $this->newPortique = Portique::createWithId($this->isEntrerId, $this->isEntrer, $this->noPortique, $this->fkGarePeage);
        try {
            $this->newPortique = $this->service->update($this->newPortique);
        } catch (PDOException $ex) {
            error_log("Database error: " . $ex->getMessage());
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode($this->newPortique);
    }
}
?>
