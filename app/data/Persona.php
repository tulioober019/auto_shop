<?php
    class Persona {
        private $id_persona;

        private $conexion_bbdd;

        public function __construct($id_persona,$conexion_bbdd) {

            $this->id_persona = $id_persona;

            $this->conexion_bbdd = $conexion_bbdd;
        }

        public function getNombreReal() {

            $query = "SELECT nombre FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["nombre"];
        }

        public function getPrimerApellido() {

            $query = "SELECT apellido1 FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["apellido1"];
        }

        public function getSegundoApellido() {

            $query = "SELECT apellido2 FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["apellido2"];
        }

        public function getTelefono() {

            $query = "SELECT telefono FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["telefono"];
        }

        public function getDNI() {

            $query = "SELECT dni FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["dni"];
        }

        public function getCorreo() {

            $query = "SELECT correo FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["correo"];
        }

        public function getNombreUsuario() {

            $query = "SELECT nombre_usuario FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["nombre_usuario"];
        }

        public function getAvatar() {

            $query = "SELECT avatar FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["avatar"];
        }

        public function getSaldo() {

            $query = "SELECT saldo FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["saldo"];
        }

        public function getRol() {

            $query = "SELECT rol FROM Persona WHERE id_persona = " . $this->id_persona . ";";

            return $this->conexion_bbdd->query($query)->fetch_assoc()["rol"];
        }
    }
?>