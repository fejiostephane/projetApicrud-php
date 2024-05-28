<?php
	require_once(ROOT . "/utils/IService.php");
	require_once(ROOT . "/utils/AbstractService.php");
	require_once(ROOT . "/utils/IDao.php");
	require_once(ROOT . "/dao/TrajetDao.php");

	class TrajetService extends AbstractService
				implements IService {
		private TrajetDao $dao;

		function __construct() {
			$this->dao = new TrajetDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}
		public function findById(int $id) {
			return $this->dao->findById($id);
		}
		public function update($Trajet) {
			return $this->dao->update($Trajet);
		}

		public function delete(int $id) {
			return $this->dao->delete($id);
		}

	}

?>
