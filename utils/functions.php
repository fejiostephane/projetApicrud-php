<?php

	function headerAndDie($header) {
		header($header); // built in : écrit le header http
		die(); // built in : arrête le traitement de la requête
	}

	function _400_Bad_Request($msg = "") {
		headerAndDie("HTTP/1.1 400 Bad Request " . $msg);
	}

	function _404_Not_Found($msg = "") {
                headerAndDie("HTTP/1.1 404 Not Found " . $msg);
        }

	function _405_Method_Not_Allowed() {
		headerAndDie("HTTP/1.1 405 Method Not Allowed");
	}

	// Selon la méthode HTTP de la requête, renvoie le formulaire
	function extractForm() {
		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET' : return $_GET;
			case 'POST' : return $_POST;
			case 'DELETE' : return $_GET; // DELETE est une sorte de GET
			case 'PUT' : // Cas particulier pour le put
				$raw = file_get_contents('php://input'); // Php built in function
				$form = [];
				parse_str($raw, $form); // String Requete HTTP -> tabl2eau associatif
				return $form;
			default : _405_Method_Not_Allowed();
		}
	}

	function extractRoute($form) {
		if ( ! isset($form['route']) ) {
			return "Accueil";
		}
		$ROUTE = $form['route'];
		if (preg_match('/^[A-Za-z]{1,64}$/', $ROUTE)) {
			return $ROUTE;
		}
		_400_Bad_Request("route '" . $ROUTE . "'");
	}

	// On veut construire un truc du genre : RouteGetController.php
	function createController($form, $route) {
		$METHOD = strtolower( $_SERVER['REQUEST_METHOD'] ); // Tout en minuscule ex : get
		$METHOD = ucfirst($METHOD); // Puis la premiere lettre en majuscule : Get
		$FILE = ROOT . "/controllers/" . $route . $METHOD . "Controller.php";
		if ( ! file_exists($FILE) ) { // Mon controller n'existe pas, donc 404
			_404_Not_Found($route . $METHOD);
		}
		require($FILE); // Je sais que mon fichier existe donc je peux le require
		$className = $route . $METHOD . 'Controller'; // je construis le nom de la classe
		$controller = new $className($form, $route . $METHOD); // Que je peux utiliser pour creer une nouvelle instance
		return $controller; // Si tout se passe bien, il existe une instance que je retourne
	}

	function notAlphaNum(string $str, int $min = 4, int $max = 4) : bool {
		return ! preg_match('/^[A-Za-z0-9]{' . $min . ',' . $max . '}$/', $str);
	}

	function stringNotValid(string $str) {
		return false;
	}
?>
