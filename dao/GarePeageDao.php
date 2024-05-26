<?php
        require_once(ROOT . "/utils/IDao.php");
        require_once(ROOT . "/utils/AbstractDao.php");
        require_once(ROOT . "/utils/BddSingleton.php");
        require_once(ROOT . "/modele/GarePeage.php");

        class GarePeageDao extends AbstractDao implements IDao {
		function findAll() {
			$pdo = BddSingleton::getinstance()->getPdo();
			$sql = "SELECT * FROM garepeage";
			$query = $pdo->query($sql);
			$resultSet = $query->fetchAll(PDO::FETCH_OBJ);
			$GarePeages = array();
			// Boucle pour transferer le resultSet dans mon tableau de Badges
			foreach ($resultSet as $row) {
				$GarePeage = GarePeage::createFromArray($row);
				array_push($GarePeages, $GarePeage);
			}
			return $GarePeages;
		}

		function findById(int $id) {
			$pdo = BddSingleton::getinstance()->getPdo();
			$stmt = $pdo->prepare("SELECT * FROM garepeage WHERE id = ?");
			$stmt->bindParam(1, $id);
			$stmt->setFetchMode(PDO::FETCH_CLASS, "garepeage");
			$stmt->execute();
			$GarePeage = $stmt->fetch();
			return $GarePeage ? $GarePeage : null;
		}

		function insert($entity) {
			$pdo = BddSingleton::getinstance()->getPdo();
			$stmt = $pdo->prepare("INSERT INTO garepeage (GarePeage, nomPeage) VALUES (?, ?)");
			$GarePeage = $entity->getGarepeage();
			$nomPeage = $entity->getNomPeage();
			$stmt->bindParam(1, $GarePeage);
			$stmt->bindParam(2, $nomPeage);
			$stmt->execute();
			$entity->setId($pdo->lastInsertId());
			return $entity;
		}
		public function update($entity) {
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "UPDATE garepeage SET GarePeage = :GarePeage, nomPeage = :nomPeage WHERE id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
			$stmt->bindValue(':GarePeage', $entity->getGarepeage());
			$stmt->bindValue(':nomPeage', $entity->getNomPeage());
			$stmt->execute();
			return $entity;
		}

		public function delete(int $id) {
			$pdo = BddSingleton::getInstance()->getPdo();
			$stmt = $pdo->prepare("DELETE FROM garepeage WHERE id = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
        }

?>
