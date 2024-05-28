<?php
	require_once(ROOT . "/utils/IService.php");
	require_once(ROOT . "/utils/AbstractService.php");
	require_once(ROOT . "/utils/IDao.php");
	require_once(ROOT . "/dao/TarificationDao.php");

	class TarificationService extends AbstractService
				implements IService {
		private TarificationDao $dao;

		function __construct() {
			$this->dao = new TarificationDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}
		public function findById(int $id) {
			return $this->dao->findById($id);
		}
		public function update($Tarification) {
			return $this->dao->update($Tarification);
		}

		public function delete(int $id) {
			return $this->dao->delete($id);
		}

	}

?>
