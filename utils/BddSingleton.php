<?php
	// Le principe de ce design pattern est de garantir que dans toute mon application
	// Je n'aurai qu'une seule instance de la connexion a la base de donnees
	class BddSingleton {
		private static $_INSTANCE = null; // l'unique instance de mon singleton
		private $pdo;			  // La connexion a ma BDD par pdo

		// Le constructeur cree la connexion pdo
		private function __construct() {
			$DSN = 'mysql:host=localhost;port=3306;dbname=autoroute'; // Data Source Name
			try {
				$this->pdo = new PDO($DSN, 'autoroute', 'autoroute-34');
				// Activation des erreurs pdo en cas de problemes de syntaxe
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) { // Probleme lors de la connexion
				die("Database connection Error : " . $e->getMessage());
			}
		}

		public function getPdo() {
			return $this->pdo; // Retourne mon objet pdo
		}

		// pour acceder a mon singleton, je devrais obligatoirement passer par ici
		// je suis sur de retourner TOUT LE TEMPS la meme instance
		public static function getInstance() {
			// si mon instance est nulle, alors je la cree
			// pattern de lazy initialization : je cree a la volee et qu'une seule fois
			if (is_null(self::$_INSTANCE) ) {
				self::$_INSTANCE = new BddSingleton();
			}
			return self::$_INSTANCE;
		}

		// A la fin de la requete HTTP, cette fonction sera appelee automatiquement
		// le pdo sera detruit (sinon risque de fuite memoire)
		function __destruct() {
			unset($this->pdo);
		}
	}

?>
