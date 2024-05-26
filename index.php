<?php
	define("ROOT", dirname(__FILE__));
	require_once(ROOT . '/utils/functions.php');
	$FORM = extractForm();
	$ROUTE = extractRoute($FORM);
	// on va construire le controlleur de manière dynamique
	// Il devra implementer l'interface IController
	$controller = createController($FORM, $ROUTE);
	$controller->execute();
// var_dump($FORM);
// echo "OK";
?>
