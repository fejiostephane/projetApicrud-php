<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/BadgeService.php");

class BadgeDeleteController extends AbstractController implements IController{
    private BadgeService $service;
    private $badgeId;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new BadgeService();
    }

    function checkForm() {
        if (!isset($this->form['id'])) {
            $this->_400_Bad_Request("Missing id");
        }
        $this->badgeId = $this->form['id'];
    }

    function checkCybersec() {
        if (!ctype_digit($this->badgeId)) {
            $this->_400_Bad_Request("Invalid id value");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        try {
            $this->service->delete((int)$this->badgeId);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode(['status' => 'Badge deleted']);
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
