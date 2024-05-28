<?php

	class Tarification implements JsonSerializable {
		private int $fkGarePeageSource;
		private int $fkGarePeageDestination;
        private float $tarif;
        private float $distance;
		function __construct() { }

		public static function createFromArray($row) : Tarification {
			$Tarification = new Tarification();
			$Tarification->fkGarePeageSource = intval($row->fkGarePeageSource);
            $Tarification->fkGarePeageDestination = intval($row->fkGarePeageDestination);
            $Tarification->tarif = floatval($row->tarif);
            $Tarification->distance = floatval($row->distance);
			return $Tarification;
		}

		public static function create(int $fkGarePeageSource,int $fkGarePeageDestination, float $tarif, float $distance) : Tarification {
                        $newTarificaftion = new Tarification();
                        $newTarificaftion->fkGarePeageSource = $fkGarePeageSource;
                        $newTarificaftion->fkGarePeageDestination = $fkGarePeageDestination;
                        $newTarificaftion->tarif = $tarif;
                        $newTarificaftion->distance = $distance;
                        return $newTarificaftion;
                }

		// Si $id < 1 -> null sera mis
		public static function createWithId(int $fkGarePeageSource,int $fkGarePeageDestination, float $tarif, float $distance) : Tarification {
                        $newTarification = new Tarification();
			$newTarification->fkGarePeageSource = $fkGarePeageSource < 1 ? null : $fkGarePeageSource;
            $newTarification->fkGarePeageDestination = $fkGarePeageDestination < 1 ? null : $fkGarePeageDestination;
                        $newTarification->tarif = $tarif;
                        $newTarification->distance = $distance;
                        return $newTarification;
                }

		public function jsonSerialize() {
			$vars = get_object_vars($this);
			return $vars;
		}

		public function setFkGarePeageSource(int $_fkGarePeageSource) {
			$this->fkGarePeageSource = $_fkGarePeageSource;
		}
		public function setFkGarePeageDestination(int $_fkGarePeageDestination) {
			$this->fkGarePeageDestination = $_fkGarePeageDestination;
		}
		public function setTarif(float $_tarif) {
			$this->tarif = $_tarif;
		}
        public function setDistance(float $_distance) {
			$this->distance = $_distance;
		}
        public function getFkGarePeageSource() : string {
			return $this->fkGarePeageSource;
		}
        public function getFkGarePeageDestination() : string {
			return $this->fkGarePeageDestination;
		}
		
		public function getTarif() : string {
			return $this->tarif;
		}
		public function getDistance() : string {
			return $this->distance;
		}
	}

?>
