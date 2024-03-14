<?php 

    session_start();

    ob_start();

    include "../data/Persona.php";

    $pedido = $_SESSION["carro"];

    $_SESSION["carro"] = array();
    
    $config_file_path = "../config.json";

    $config_file_contents = file_get_contents($config_file_path);

    $param = json_decode($config_file_contents, true);

    $conexion = new mysqli(
        $param["db"]["db_host"],
        $param["db"]["db_username"],
        $param["db"]["db_password"],
        $param["db"]["db_schema_name"],
        $param["db"]["db_port"]
    );

    $persona = new Persona($_SESSION["id_persona"],$conexion);

    $conexion->query("CREATE TEMPORARY TABLE Carro (id_vehiculo INT, precio DOUBLE, cantidad INT);");

    foreach ($pedido as $producto) {
        
        $conexion->query("INSERT INTO Carro SET id_vehiculo = " . $producto["id_vehiculo"] . ", cantidad = " . $producto["cantidad"] . ", precio = " . $producto["precio"] . ";");

        #echo "INSERT INTO Carro SET id_vehiculo = " . $producto["id_vehiculo"] . ", stock = " . $producto["stock"] . ", precio = " . $producto["precio"] . ";";
    }

    // Ejecucción de la transacción.
    $conexion->query("CALL tramitar_pedido(" . $_SESSION["id_persona"] . ");");

    header("Location: index.php");

    $conexion->close();

