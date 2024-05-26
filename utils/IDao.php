<?php
	interface IDao {
		function findAll();
		function findById(int $id);
		function insert($entity);
		function update($entity);
		function delete(int $id);
	}
?>

