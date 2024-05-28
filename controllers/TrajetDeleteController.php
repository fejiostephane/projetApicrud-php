<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/TrajetService.php");

class TrajetDeleteController extends AbstractController implements IController{
    private TrajetService $service;
    private $dateEntrerId;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new TrajetService();
    }

    function checkForm() {
        if (!isset($this->form['id'])) {
            $this->_400_Bad_Request("Missing id");
        }
        $this->dateEntrerId = $this->form['id'];
    }

    function checkCybersec() {
        if (!ctype_digit($this->dateEntrerId)) {
            $this->_400_Bad_Request("Invalid id value");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        try {
            $this->service->delete((int)$this->dateEntrerId);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode(['status' => 'Trajet deleted']);
    }

    private function _400_Bad_Request($message) {
        header("HTTP/1.1 400 Bad Request");
        die(json_encode(["error" => $message]));
    }

    private function headerAndDie($header) {
        header($header);
        die();
    }
}
?>
