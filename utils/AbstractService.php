<?php
	require_once(ROOT . "/utils/IService.php");
	require_once(ROOT . "/utils/IDao.php");

	abstract class AbstractService implements IService {

		abstract function getDao() : IDao;

		function findAll() {
			return $this->getDao()->findAll();
		}

		function findById(int $id) {
                        return $this->getDao()->findById($id);
                }

		function insert($entity) {
			return $this->getDao()->insert($entity);
		}

	}
?>
