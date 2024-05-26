<?php
	require_once(ROOT . "/utils/IService.php");
	require_once(ROOT . "/utils/AbstractService.php");
	require_once(ROOT . "/utils/IDao.php");
	require_once(ROOT . "/dao/GarePeageDao.php");

	class GarePeageService extends AbstractService
				implements IService {
		private GarePeageDao $dao;

		function __construct() {
			$this->dao = new GarePeageDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}
		public function findById(int $id) {
			return $this->dao->findById($id);
		}
		public function update($GarePeage) {
			return $this->dao->update($GarePeage);
		}

		public function delete(int $id) {
			return $this->dao->delete($id);
		}

	}

?>
