<?php
	require_once(ROOT . "/utils/IService.php");
	require_once(ROOT . "/utils/AbstractService.php");
	require_once(ROOT . "/utils/IDao.php");
	require_once(ROOT . "/dao/PortiqueDao.php");

	class PortiqueService extends AbstractService
				implements IService {
		private PortiqueDao $dao;

		function __construct() {
			$this->dao = new PortiqueDao();
		}

		function getDao() : IDao {
			return $this->dao;
		}
		public function findById(int $id) {
			return $this->dao->findById($id);
		}
		public function update($Portique) {
			return $this->dao->update($Portique);
		}

		public function delete(int $id) {
			return $this->dao->delete($id);
		}

	}

?>
