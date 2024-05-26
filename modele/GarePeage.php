<?php

	class GarePeage implements JsonSerializable {
		private int $id;
		private string $GarePeage;
		private string $nomPeage;
		function __construct() { }

		public static function createFromArray($row) : GarePeage {
			$GarePeage = new GarePeage();
			$GarePeage->id = intval($row->id);
			$GarePeage->GarePeage = $row->GarePeage;
			$GarePeage->nomPeage = $row->nomPeage;
			return $GarePeage;
		}

		public static function create(string $GarePeage, string $nomPeage) : GarePeage {
                        $newGarePeage = new GarePeage();
                        $newGarePeage->GarePeage = $GarePeage;
                        $newGarePeage->nomPeage = $nomPeage;
                        return $newGarePeage;
                }

		// Si $id < 1 -> null sera mis
		public static function createWithId(int $id, string $GarePeage, string $nomPeage) : GarePeage {
                        $newGarePeage = new GarePeage();
			$newGarePeage->id = $id < 1 ? null : $id;
                        $newGarePeage->GarePeage = $GarePeage;
                        $newGarePeage->nomPeage = $nomPeage;
                        return $newGarePeage;
                }

		public function jsonSerialize() {
			$vars = get_object_vars($this);
			return $vars;
		}

		public function setId(int $_id) {
			$this->id = $_id;
		}
		public function setGarePeage(string $_GarePeage) {
			$this->GarePeage = $_GarePeage;
		}
		public function setNomPeage(string $_nomPeage) {
			$this->nomPeage = $_nomPeage;
		}

		public function getId() : int {
			return $this->id;
		}
		public function getGarePeage() : string {
			return $this->GarePeage;
		}
		public function getNomPeage() : string {
			return $this->nomPeage;
		}
	}

?>
