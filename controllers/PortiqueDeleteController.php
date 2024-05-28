<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/PortiqueService.php");

class PortiqueDeleteController extends AbstractController implements IController{
    private PortiqueService $service;
    private $isEntrerId;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new PortiqueService();
    }

    function checkForm() {
        if (!isset($this->form['id'])) {
            $this->_400_Bad_Request("Missing id");
        }
        $this->isEntrerId = $this->form['id'];
    }

    function checkCybersec() {
        if (!ctype_digit($this->isEntrerId)) {
            $this->_400_Bad_Request("Invalid id value");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        try {
            $this->service->delete((int)$this->isEntrerId);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode(['status' => 'Portique deleted']);
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
