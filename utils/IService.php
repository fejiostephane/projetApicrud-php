<?php
	require_once(ROOT . "/utils/IDao.php");

	interface IService {
		function findAll();
		function findById(int $id);
		function getDao() : IDao;
		function insert($entity);
		function update($entity);
		function delete(int $id);
	}
?>
