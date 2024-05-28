<?php

class Trajet implements JsonSerializable {
    private int $id;
    private string $dateEntrer;
    private string $dateSortie;
    private int $fkPortiqueEntrer;
    private int $fkPortiqueSortie;
    private int $fkBadge;

    public function __construct(
        int $id = 0,
        string $dateEntrer = '',
        string $dateSortie = '',
        int $fkPortiqueEntrer = 0,
        int $fkPortiqueSortie = 0,
        int $fkBadge = 0
    ) {
        $this->id = $id;
        $this->dateEntrer = $dateEntrer;
        $this->dateSortie = $dateSortie;
        $this->fkPortiqueEntrer = $fkPortiqueEntrer;
        $this->fkPortiqueSortie = $fkPortiqueSortie;
        $this->fkBadge = $fkBadge;
    }

    public static function createFromArray($row): Trajet {
        return new Trajet(
            isset($row->id) ? intval($row->id) : 0,
            isset($row->dateEntrer) ? $row->dateEntrer : '',
            isset($row->dateSortie) ? $row->dateSortie : '',
            isset($row->fkPortiqueEntrer) ? intval($row->fkPortiqueEntrer) : 0,
            isset($row->fkPortiqueSortie) ? intval($row->fkPortiqueSortie) : 0,
            isset($row->fkBadge) ? intval($row->fkBadge) : 0
        );
    }

    public static function create(string $dateEntrer, string $dateSortie, int $fkPortiqueEntrer, int $fkPortiqueSortie, int $fkBadge): Trajet {
        return new Trajet(0, $dateEntrer, $dateSortie, $fkPortiqueEntrer, $fkPortiqueSortie, $fkBadge);
    }

    public static function createWithId(int $id, string $dateEntrer, string $dateSortie, int $fkPortiqueEntrer, int $fkPortiqueSortie, int $fkBadge): Trajet {
        return new Trajet($id, $dateEntrer, $dateSortie, $fkPortiqueEntrer, $fkPortiqueSortie, $fkBadge);
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function setId(int $_id) {
        $this->id = $_id;
    }

    public function setDateEntrer(string $_dateEntrer) {
        $this->dateEntrer = $_dateEntrer;
    }

    public function setDateSortie(string $_dateSortie) {
        $this->dateSortie = $_dateSortie;
    }

    public function setFkPortiqueEntrer(int $_fkPortiqueEntrer) {
        $this->fkPortiqueEntrer = $_fkPortiqueEntrer;
    }

    public function setFkPortiqueSortie(int $_fkPortiqueSortie) {
        $this->fkPortiqueSortie = $_fkPortiqueSortie;
    }

    public function setFkBadge(int $_fkBadge) {
        $this->fkBadge = $_fkBadge;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDateEntrer(): string {
        return $this->dateEntrer;
    }

    public function getDateSortie(): string {
        return $this->dateSortie;
    }

    public function getFkPortiqueEntrer(): int {
        return $this->fkPortiqueEntrer;
    }

    public function getFkPortiqueSortie(): int {
        return $this->fkPortiqueSortie;
    }

    public function getFkBadge(): int {
        return $this->fkBadge;
    }
}
?>
