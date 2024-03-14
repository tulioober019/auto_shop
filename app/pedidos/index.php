<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #ffffd0;
        }

        header {
            background-color: yellowgreen;
            max-height: 60px;
        }

        #site-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        nav {
            height: 60px;
            background-color: lightgreen;
        }

        .search-bar {
            margin-top: 10px;
            margin-bottom: 10px; 
            height: 40px;
            margin-right: 10px;
        }

        .login-element {
            margin-bottom: 5px;
        }

        .articulo {
            border: 1px solid lightgray;
            border-radius: 5%;
            margin: 10px;
            padding: 1px;
            transition: transform 0.3s;
            box-shadow: 0 0 20px yellow;
            background-color: lightyellow;
        }

        .articulo:hover {
            transform:scale(1.10);
            background-color: white;
        }

        .articulo-imagen {
            height: 250px;
            border-radius: 5%;
        }

        .ver-articulo {
            margin: 2px;
        }

        ul {
            list-style: none;
        }

        .user-avatar {
            margin-top: 10px;
            margin-bottom: 10px;
            height: 40px;
            width: auto;
            float: right; 
            margin-right: 10px;
            border-radius: 50%;
        }

        .dropdown {
            position: relative;
            display: block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            /*min-width: 160px;*/
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 10;
        } 

        .dropdown-content li {
            color: black;
            padding: 10px 10px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid lightgray;
        }

        .dropdown-content li:hover {
            background-color: yellow;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .producto {
            width: 100%;
            border: 1px solid black;
            border-radius: 1%;
            margin: 10px;
        }

        .producto img {
            width: 100%;
        }

        #eliminar_carro {
            float: right;
            margin-bottom: 5px;
            margin-right: 5px;
        }

        .total {
            float: right;
        }

        #tramitir_pedido {
            float: right;
        }

        .name h3 {
            display: inline-block;
        }

        /*.name h3#left {
            float: left;
        }*/

        .name h3#right {
            float: right;
        }
    </style>
</head>
<body>
<?php
        include "../data/Persona.php";

        include "../data/Pedido.php";

        //include "data/Vehiculo.php";

        session_start();

        ob_start();

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
    ?>
    <div class="container-fluid">
        <header class="row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                <img src="../logos/site-logo.png" id="site-logo">
            </div>
            <div class="col-lg-9 col-md-8 col-sm-6 col-5">
                <h1 style="margin-left: 0px; font-weight: bold;">Auto Shop!</h1>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                <div class="row dropdown">
                    <div class="row">
                        <div class="col-12 dropbtn">
                            <img src=".<?php echo $persona->getAvatar(); ?>" class="user-avatar">
                        </div>
                    </div>
                    <div class="row">
                        <ul class="col-12 dropdown-content">
                            <li>Hola! <?php echo $persona->getNombreReal() . " " . $persona->getPrimerApellido() . " " . $persona->getSegundoApellido();?></li>
                            <li><a href="../session.php"> Volver a la tienda</a></li>
                            <li><a href="../users/logout.php">Cerrar sessión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <nav class="row">
            <div class="col-12">
                <h2><strong>Mis pedidos</strong></h2>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
        <?php 
            $pedido_usuario = new Pedido($_SESSION["id_persona"],$conexion);

            foreach ($pedido_usuario->getPedidos() as $pedido) {
                ?>
                    <div class="pedido">
                        <div class="row">
                            <div class="col-8">
                                <div class="name">
                                    <h3 id="left">Pedido Nº<?php echo $pedido;?></h3>
                                    <h3 id="right">Fecha entrega: <?php if ($pedido_usuario->getFechaEntrega($pedido) == date("M j")) {echo "Entregado";} else { echo $pedido_usuario->getFechaEsperada($pedido);}?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <?php 
                                foreach ($pedido_usuario->getVehiculosPedido($pedido) as $producto) {
                                    ?>
                                    <div class="producto">
                                        <div class="row">
                                            <div class="col-5">
                                                <img src=".<?php echo $producto["imagen"]?>">
                                            </div>
                                            <div class="col-7">
                                                <div class="name">
                                                    <h3 id="left"><?php echo $producto["nombre"];?></h3>
                                                </div>
                                                <hr>
                                                <table class="table" style="width: 70%;">
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Marca</th>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $producto["cantidad"];?></td>
                                                        <td><?php echo $producto["marca"];?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php

            }


            
        ?>
    </div>
</body>
</html>