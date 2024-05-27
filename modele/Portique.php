<?php

	class Portique implements JsonSerializable {
		private int $id;
		private int $isEntrer;
		private int $noPortique;
        private int $fkGarePeage;
		private String $nomPeage;
		function __construct() { }

		public static function createFromArray($row) : Portique {
			$portique = new Portique();
			$portique->id = intval($row->id);
			$portique->isEntrer = $row->isEntrer;
			$portique->noPortique = $row->noPortique;
            $portique->fkGarePeage = $row->fkGarePeage;
			$portique->nomPeage = $row->nomPeage;
			return $portique;
		}

		public static function create(int $isEntrer, int $noPortique, int $fkGarePeage) : Portique {
                        $newPortique = new Portique();
                        $newPortique->isEntrer = $isEntrer;
                        $newPortique->noPortique = $noPortique;
                        $newPortique->fkGarePeage = $fkGarePeage;
                        return $newPortique;
                }

		// Si $id < 1 -> null sera mis
		public static function createWithId(int $id, int $isEntrer, int $noPortique, int $fkGarePeage) : Portique {
                        $newPortique = new Portique();
			$newPortique->id = $id < 1 ? null : $id;
                        $newPortique->isEntrer = $isEntrer;
                        $newPortique->noPortique = $noPortique;
                        $newPortique->fkGarePeage = $fkGarePeage;
                        return $newPortique;
                }

		public function jsonSerialize() {
			$vars = get_object_vars($this);
			return $vars;
		}

		public function setId(int $_id) {
			$this->id = $_id;
		}
		public function setIsEntrer(int $_isEntrer) {
			$this->isEntrer = $_isEntrer;
		}
		public function setNoPortique(int $_noPortique) {
			$this->noPortique = $_noPortique;
		}
        public function setFkGarePeage(int $_fkGarePeage) {
			$this->fkGarePeage = $_fkGarePeage;
		}

		public function getId() : int {
			return $this->id;
		}
		public function getIsEntrer() : int {
			return $this->isEntrer;
		}
		public function getNoPortique() : int {
			return $this->noPortique;
		}
        public function getFkGarePeage() : int {
			return $this->fkGarePeage;
		}
	}

?>
