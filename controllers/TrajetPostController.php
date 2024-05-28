<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/TrajetService.php");

class TrajetPostController extends AbstractController implements IController {

    private TrajetService $service;
    private string $dateEntrer; 
    private string $dateSortie;
    private int $fkPortiqueEntrer;
    private int $fkPortiqueSortie;
    private int $fkBadge;
    private Trajet $newTrajet;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new TrajetService();
    }

    function checkForm() {
        if (!isset($this->form['dateEntrer']) || !isset($this->form['dateSortie']) || !isset($this->form['fkPortiqueEntrer']) || !isset($this->form['fkPortiqueSortie']) || !isset($this->form['fkBadge'])) {
            _400_Bad_Request("Missing required fields");
        }

        $this->dateEntrer = $this->form['dateEntrer'];
        $this->dateSortie = $this->form['dateSortie'];
        $this->fkPortiqueEntrer = intval($this->form['fkPortiqueEntrer']);
        $this->fkPortiqueSortie = intval($this->form['fkPortiqueSortie']);
        $this->fkBadge = intval($this->form['fkBadge']);
    }

    function checkCybersec() {
        if (!strtotime($this->dateEntrer)) { // Vérifie si la date est valide
            _400_Bad_Request("Invalid dateEntrer format");
        }
        if (!strtotime($this->dateSortie)) { // Vérifie si la date est valide
            _400_Bad_Request("Invalid dateSortie format");
        }
        if (!is_int($this->fkPortiqueEntrer) || !is_int($this->fkPortiqueSortie) || !is_int($this->fkBadge)) {
            _400_Bad_Request("Portique and Badge values must be integers");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        $this->newTrajet = Trajet::create($this->dateEntrer, $this->dateSortie, $this->fkPortiqueEntrer, $this->fkPortiqueSortie, $this->fkBadge);
        try {
            $this->newTrajet = $this->service->insert($this->newTrajet);
        } catch (PDOException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                headerAndDie("HTTP/1.1 499 Entity duplicated Badge " . $this->dateEntrer);
            }
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode($this->newTrajet);
    }
}
?>