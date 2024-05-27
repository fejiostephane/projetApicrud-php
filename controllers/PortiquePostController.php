<?php
require_once(ROOT . "/utils/IController.php");
require_once(ROOT . "/utils/AbstractController.php");
require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/services/PortiqueService.php");

class PortiquePostController extends AbstractController implements IController {

    private PortiqueService $service;
    private int $isEntrer;
    private int $noPortique;
    private int $fkGarePeage;
    private Portique $newPortique;

    public function __construct($form, $controllerName) {
        parent::__construct($form, $controllerName);
        $this->service = new PortiqueService();
    }

    function checkForm() {
        if (!isset($this->form['isEntrer']) || !isset($this->form['noPortique']) || !isset($this->form['fkGarePeage'])) {
            _400_Bad_Request("Paramètres manquants");
        }
        $this->isEntrer = $this->form['isEntrer'];
        $this->noPortique = $this->form['noPortique'];
        $this->fkGarePeage = $this->form['fkGarePeage'];
    }

    function checkCybersec() {
        // Vérification si les valeurs sont des chaînes de chiffres
        if (!ctype_digit((string) $this->isEntrer)) {
            _400_Bad_Request("Bad syntaxe entrer = " . $this->isEntrer);
        }
        if (!ctype_digit((string) $this->noPortique)) {
            _400_Bad_Request("Bad syntaxe portique = " . $this->noPortique);
        }
        if (!ctype_digit((string) $this->fkGarePeage)) {
            _400_Bad_Request("Bad syntaxe gare = " . $this->fkGarePeage);
        }

        // Conversion des valeurs en entiers
        $this->isEntrer = intval($this->isEntrer);
        $this->noPortique = intval($this->noPortique);
        $this->fkGarePeage = intval($this->fkGarePeage);

        // Vérification que isEntrer est soit 0 soit 1
        if (!($this->isEntrer === 1 || $this->isEntrer === 0)) {
            _400_Bad_Request("Bad syntaxe entrer doit être soit 0 soit 1");
        }
    }

    function checkRights() {
        error_log(__FUNCTION__);
    }

    function processRequest() {
        $this->newPortique = Portique::create($this->isEntrer, $this->noPortique, $this->fkGarePeage);
        try {
            $this->newPortique = $this->service->insert($this->newPortique);
        } catch (PDOException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                headerAndDie("HTTP/1.1 499 Entity duplicated Badge ");
            }
            throw $ex;
        }
    }

    function processResponse() {
        echo json_encode($this->newPortique);
    }
}
?>
