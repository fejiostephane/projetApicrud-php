<?php
        require_once(ROOT . "/utils/IDao.php");
        require_once(ROOT . "/utils/AbstractDao.php");
        require_once(ROOT . "/utils/BddSingleton.php");
        require_once(ROOT . "/modele/Badge.php");

        class BadgeDao extends AbstractDao implements IDao {
		function findAll() {
			$pdo = BddSingleton::getinstance()->getPdo();
			$sql = "SELECT * FROM badge";
			$query = $pdo->query($sql);
			$resultSet = $query->fetchAll(PDO::FETCH_OBJ);
			$badges = array();
			// Boucle pour transferer le resultSet dans mon tableau de Badges
			foreach ($resultSet as $row) {
				$badge = Badge::createFromArray($row);
				array_push($badges, $badge);
			}
			return $badges;
		}

		function findById(int $id) {
			$pdo = BddSingleton::getinstance()->getPdo();
			$stmt = $pdo->prepare("SELECT * FROM badge WHERE id = ?");
			$stmt->bindParam(1, $id);
			$stmt->setFetchMode(PDO::FETCH_CLASS, "badge");
			$stmt->execute();
			$badge = $stmt->fetch();
			return $badge ? $badge : null;
		}

		function insert($entity) {
			$pdo = BddSingleton::getinstance()->getPdo();
			$stmt = $pdo->prepare("INSERT INTO badge (badge, nom) VALUES (?, ?)");
			$badge = $entity->getBadge();
			$nom = $entity->getNom();
			$stmt->bindParam(1, $badge);
			$stmt->bindParam(2, $nom);
			$stmt->execute();
			$entity->setId($pdo->lastInsertId());
			return $entity;
		}
		public function update($badge) {
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "UPDATE badge SET badge = :badge, nom = :nom WHERE id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':id', $badge->getId(), PDO::PARAM_INT);
			$stmt->bindValue(':badge', $badge->getBadge());
			$stmt->bindValue(':nom', $badge->getNom());
			$stmt->execute();
			return $badge;
		}

		public function delete(int $id) {
			$pdo = BddSingleton::getInstance()->getPdo();
			$stmt = $pdo->prepare("DELETE FROM badge WHERE id = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
        }

?>
