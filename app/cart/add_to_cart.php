<?php
    include "../data/Vehiculo.php";

    session_start();

    ob_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $cantidad = filter_input(INPUT_POST,"cantidad",FILTER_SANITIZE_STRING);

        $id_vehiculo = filter_input(INPUT_POST,"carrito",FILTER_SANITIZE_STRING);

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

        $vehiculo = new Vehiculo($id_vehiculo,$conexion);

        $posicion = 0;

        if (isset($_SESSION["carro"])) {

            $posicion = sizeof($_SESSION["carro"]); 

        }



        $_SESSION["carro"][$posicion] = array(

            "id_vehiculo"=>$id_vehiculo,

            "nom_vehiculo"=>$vehiculo->getNombre(),

            "imagen"=>$vehiculo->getImagen(),

            "precio"=>$vehiculo->getPrecio(),

            "stock"=>$vehiculo->getStock(),

            "cantidad"=>$cantidad

        );


        header("Location: ../session.php");

        $conexion->close();

    }