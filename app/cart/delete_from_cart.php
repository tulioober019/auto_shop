<?php 

    session_start();

    ob_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $articulo = filter_input(INPUT_POST,"elimina",FILTER_SANITIZE_NUMBER_INT);

        unset($_SESSION["carro"][$articulo]);

        session_write_close();

        header("Location: index.php");
    }