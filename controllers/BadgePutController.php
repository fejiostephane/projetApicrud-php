<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/BadgeService.php");

class BadgePutController extends AbstractController implements IController {
    private BadgeService $service;
		private string $badge;
        private string $badgeId;
		private string $nom;
		private Badge $newBadge;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new BadgeService();
    }

    private function notAlphaNum($string) {
        return !ctype_alnum($string);
    }

    private function stringNotValid($string) {
        return empty($string) || !ctype_print($string);
    }

    function checkForm() {
        if (!isset($this->form['id']) || !isset($this->form['badge']) || !isset($this->form['nom'])) {
            _400_Bad_Request("Missing id, badge or nom");
        }
        $this->badgeId = $this->form['id'];
        $this->badge = $this->form['badge'];
        $this->nom = $this->form['nom'];
    }

    function checkCybersec() {
        if (notAlphaNum($this->badge)) {
            _400_Bad_Request("Invalid badge value");
        }
        if (stringNotValid($this->nom)) {
            _400_Bad_Request("Invalid nom value");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        $this->newBadge = Badge::createWithId($this->badgeId,$this->badge, $this->nom);
        try {
            $this->newBadge = $this->service->update($this->newBadge);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode($this->newBadge);
    }

    
}
?>
