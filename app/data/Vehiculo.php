<?php
    class Vehiculo {
        private $id_vehiculo;

        private $conexion_bbdd;

        public function __construct($id_vehiculo,$conexion_bbdd) {

            $this->id_vehiculo = $id_vehiculo;

            $this->conexion_bbdd = $conexion_bbdd;
        }

        public function getNombre() {
            $query = "SELECT nombre FROM Vehiculo WHERE id_vehiculo = " . $this->id_vehiculo . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["nombre"];
        }

        public function getAnoFabricacion() {
            $query = "SELECT ano_fabricacion FROM Vehiculo WHERE id_vehiculo = " . $this->id_vehiculo . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["ano_fabricacion"];
        }

        public function getPrecio() {
            $query = "SELECT precio FROM Vehiculo WHERE id_vehiculo = " . $this->id_vehiculo . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["precio"];
        }

        public function getStock() {
            $query = "SELECT stock FROM Vehiculo WHERE id_vehiculo = " . $this->id_vehiculo . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["stock"];
        }

        public function getImagen() {
            $query = "SELECT imagen FROM Vehiculo WHERE id_vehiculo = " . $this->id_vehiculo . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["imagen"];
        }

        public function getDescripcion() {
            $query = "SELECT descripcion FROM Vehiculo WHERE id_vehiculo = " . $this->id_vehiculo . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["descripcion"];
        }

        public function getNombreMarca() {
            $query = "SELECT nombre FROM Marca WHERE id_marca = (SELECT marca FROM Vehiculo WHERE id_vehiculo =" . $this->id_vehiculo . ");";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["nombre"];
        }
    }