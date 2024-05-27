<?php
require_once(ROOT . "/utils/IDao.php");
require_once(ROOT . "/utils/AbstractDao.php");
require_once(ROOT . "/utils/BddSingleton.php");
require_once(ROOT . "/modele/Portique.php");

class PortiqueDao extends AbstractDao implements IDao {

    public function findAll() {
        $pdo = BddSingleton::getInstance()->getPdo();
        $sql = "SELECT autoroute.portique.id, autoroute.portique.isEntrer, autoroute.portique.noPortique, autoroute.garepeage.id AS fkGarePeage, autoroute.garepeage.nomPeage
                FROM autoroute.portique 
                INNER JOIN autoroute.garepeage 
                ON autoroute.portique.fkGarePeage = autoroute.garepeage.id";
        $query = $pdo->query($sql);
        $resultSet = $query->fetchAll(PDO::FETCH_OBJ);
        $Portiques = array();
        foreach ($resultSet as $row) {
            $Portique = Portique::createFromArray($row);
            array_push($Portiques, $Portique);
        }
        return $Portiques;
    }

    public function findById(int $id) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $stmt = $pdo->prepare("SELECT autoroute.portique.id, autoroute.portique.isEntrer, autoroute.portique.noPortique, autoroute.garepeage.id AS fkGarePeage, autoroute.garepeage.nomPeage
                               FROM autoroute.portique 
                               INNER JOIN autoroute.garepeage 
                               ON autoroute.portique.fkGarePeage = autoroute.garepeage.id 
                               WHERE autoroute.portique.id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Portique");
        $stmt->execute();
        $Portique = $stmt->fetch();
        return $Portique ? $Portique : null;
    }

    public function insert($entity) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $stmt = $pdo->prepare("INSERT INTO portique (isEntrer, noPortique, fkGarePeage) VALUES (?, ?, ?)");
        $isEntrer = $entity->getIsEntrer();
        $noPortique = $entity->getNoPortique();
        $fkGarePeage = $entity->getFkGarePeage();
        $stmt->bindParam(1, $isEntrer, PDO::PARAM_INT);
        $stmt->bindParam(2, $noPortique, PDO::PARAM_INT);
        $stmt->bindParam(3, $fkGarePeage, PDO::PARAM_INT);
        $stmt->execute();
        $entity->setId($pdo->lastInsertId());
        return $entity;
    }

    public function update($entity) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $sql = "UPDATE portique SET isEntrer = :isEntrer, noPortique = :noPortique, fkGarePeage = :fkGarePeage WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':isEntrer', $entity->getIsEntrer(), PDO::PARAM_INT);
        $stmt->bindValue(':noPortique', $entity->getNoPortique(), PDO::PARAM_INT);
        $stmt->bindValue(':fkGarePeage', $entity->getFkGarePeage(), PDO::PARAM_INT);
        $stmt->execute();
        return $entity;
    }

    public function delete(int $id) {
        $pdo = BddSingleton::getInstance()->getPdo();
        $stmt = $pdo->prepare("DELETE FROM portique WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
