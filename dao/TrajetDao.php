<?php
require_once(ROOT . "/utils/IDao.php");
require_once(ROOT . "/utils/AbstractDao.php");
require_once(ROOT . "/utils/BddSingleton.php");
require_once(ROOT . "/modele/Trajet.php");

class TrajetDao extends AbstractDao implements IDao {

    public function findAll() {
        $pdo = BddSingleton::getInstance()->getPdo();
        $sql = "SELECT * FROM trajet";
        $query = $pdo->query($sql);
        $resultSet = $query->fetchAll(PDO::FETCH_OBJ);
        $Trajets = array();
        foreach ($resultSet as $row) {
            $Trajet = Trajet::createFromArray($row);
            array_push($Trajets, $Trajet);
        }
        return $Trajets;
    }

    public function findById(int $id) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM trajet WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if ($row) {
            return Trajet::createFromArray($row);
        } else {
            return null;
        }
    }

    public function insert($entity) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $stmt = $pdo->prepare("INSERT INTO trajet (dateEntree, dateSortie, fkPortiqueEntree, fkPortiqueSortie, fkBadge) VALUES (?, ?, ?, ?, ?)");
        $dateEntrer = $entity->getDateEntrer();
        $dateSortie = $entity->getDateSortie();
        $fkPortiqueEntrer = $entity->getFkPortiqueEntrer();
        $fkPortiqueSortie = $entity->getFkPortiqueSortie();
        $fkBadge = $entity->getFkBadge();
        $stmt->bindParam(1, $dateEntrer, PDO::PARAM_STR);
        $stmt->bindParam(2, $dateSortie, PDO::PARAM_STR);
        $stmt->bindParam(3, $fkPortiqueEntrer, PDO::PARAM_INT);
        $stmt->bindParam(4, $fkPortiqueSortie, PDO::PARAM_INT);
        $stmt->bindParam(5, $fkBadge, PDO::PARAM_INT);
        $stmt->execute();
        $entity->setId($pdo->lastInsertId());
        return $entity;
    }

    public function update($entity) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $sql = "UPDATE trajet SET dateEntree = :dateEntree, dateSortie = :dateSortie, fkPortiqueEntree = :fkPortiqueEntree, fkPortiqueSortie = :fkPortiqueSortie, fkBadge = :fkBadge WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':dateEntree', $entity->getDateEntrer(), PDO::PARAM_STR);
        $stmt->bindValue(':dateSortie', $entity->getDateSortie(), PDO::PARAM_STR);
        $stmt->bindValue(':fkPortiqueEntree', $entity->getFkPortiqueEntrer(), PDO::PARAM_INT);
        $stmt->bindValue(':fkPortiqueSortie', $entity->getFkPortiqueSortie(), PDO::PARAM_INT);
        $stmt->bindValue(':fkBadge', $entity->getFkBadge(), PDO::PARAM_INT);
        $stmt->execute();
        return $entity;
    }

    public function delete(int $id) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $stmt = $pdo->prepare("DELETE FROM trajet WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
