<?php
class Pedido {

    private $id_persona;

    private $conexion;

    public function __construct($id_persona,$conexion) {

        $this->id_persona = $id_persona;

        $this->conexion = $conexion;
    }

    public function getPedidos() {
        // Este metodo devuelve un array de pedidos al usuario.
        $query = "SELECT DISTINCT id_pedido FROM Pedido WHERE cliente = " . $this->id_persona . ";";

        $array = array();

        foreach($this->conexion->query($query) as $row) {

            array_push($array, $row["id_pedido"]);

        }

        return $array;
    }

    public function getVehiculosPedido($id_pedido) {
        // Este método devuelve un array de los ids de vehiculos para luego obtener sus detalles.
        
        $query = "SELECT v.nombre,v.imagen,m.nombre as marca,p.cantidad FROM Vehiculo v INNER JOIN Marca m ON (v.marca = m.id_marca) INNER JOIN Pedido p ON (p.vehiculo = v.id_vehiculo) WHERE id_vehiculo IN (SELECT vehiculo FROM Pedido WHERE id_pedido = " . $id_pedido . ");";

        return $this->conexion->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getFechaEntrega($id_pedido) {

        $query = "SELECT DISTINCT fecha_entrega FROM Pedido WHERE id_pedido = " . $id_pedido . ";";

        return date("M j",strtotime($this->conexion->query($query)->fetch_assoc()["fecha_entrega"]));
    }

    public function getFechaPedido($id_pedido) {

        $query = "SELECT DISTINCT fecha_pedido FROM Pedido WHERE id_pedido = " . $id_pedido . ";";

        return $this->conexion->query($query)->fetch_assoc()["fecha_pedido"];
    }

    public function getFechaEsperada($id_pedido) {
        $query = "SELECT DISTINCT fecha_esperada FROM Pedido WHERE id_pedido = " . $id_pedido . ";";

        return date("M j",strtotime($this->conexion->query($query)->fetch_assoc()["fecha_esperada"]));
    }

}