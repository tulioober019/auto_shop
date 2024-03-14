<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../logos/site-logo.png">
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

        .button{
            margin-top: 10px;
            margin-bottom: 10px; 
            height: 40px;
            width: auto;
            float: right; 
            margin-right: 10px;
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

        .nom_vehiculo {
            margin-top: 10px;
            border-bottom: 1px solid lightgray;
        }

        .info_producto {

        }

        #carro {
            height: 30px;
            width: 30px;
        }

        #boton_carro {
            float: right;
        }
    </style>
    <title>Auto Shop!</title>
</head>
<body>
    <?php 

        $config_file_path = "../../config.json";

        $config_file_contents = file_get_contents($config_file_path);

        $param = json_decode($config_file_contents, true);

        try {
            $conexion = new mysqli(
                $param["db"]["db_host"],
                $param["db"]["db_username"],
                $param["db"]["db_password"],
                $param["db"]["db_schema_name"],
                $param["db"]["db_port"]
            );

            

    ?>
    <div class="container-fluid">
        <header class="row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                <img src="../../logos/site-logo.png" id="site-logo">
            </div>
            <div class="col-lg-9 col-md-8 col-sm-6 col-5">
                <h1 style="margin-left: 0px; font-weight: bold;">Auto Shop!</h1>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                <button type="button" class="button btn btn-primary" data-bs-toggle="modal" data-bs-target="#login-user">Iniciar sessión</button>
                <!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="login-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="exampleModalLabel" style="text-align: center;">Iniciar Sessión</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="../../users/login.php" class="container-fluid">
                                <div class="modal-body">
                                    <div class="login-element row">
                                        <label class="col-5" >Nombre usuario: </label>
                                        <input class="col-7" type="text" name="nombre_usuario">
                                    </div>
                                    <div class="login-element row">
                                        <label class="col-5">Contraseña: </label>
                                        <input class="col-7" type="password" name="contrasenha">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="./users/register.php"><button type="button" class="btn btn-secondary">Registrar</button></a>
                                    <button type="submit" class="btn btn-primary" id="iniciar_session">Iniciar Sessión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <nav class="row">
            <div class="col-12">
                <h2><strong>Información producto</strong></h2>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
        <?php
            $id_vehiculo = $_GET["id_vehiculo"]??"";

            $query = "CALL listar_vehiculo(" . $id_vehiculo . ")";

            $datos_producto = $conexion->query($query)->fetch_assoc();
        ?>
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <img src="../.<?php echo $datos_producto["imagen"];?>" width="100%">
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="row">
                    <h3 class="nom_vehiculo"><?php echo $datos_producto["nom_vehiculo"];?></h3>
                </div>
                <div class="row">
                    <table class="info_producto table table-striped">
                        <tr>
                            <th>Nombre</th>
                            <td><?php echo $datos_producto["nom_vehiculo"];?></td>
                        </tr>
                        <tr>
                            <th>Marca</th>
                            <td><?php echo $datos_producto["nombre_marca"];?></td>
                        </tr>
                        <tr>
                            <th>Año fabricación</th>
                            <td><?php echo $datos_producto["ano_fabricacion"];?></td>
                        </tr>
                        <tr>
                            <th>Categoría</th>
                            <td><?php echo $datos_producto["categoria"];?></td>
                        </tr>
                        <tr>
                            <th>Descripción</th>
                            <td><?php echo $datos_producto["descripcion"];?></td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td><?php echo $datos_producto["stock"];?></td>
                        </tr>
                        <tr>
                            <th>Precio</th>
                            <td><?php echo $datos_producto["precio"] . " €";?></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-9"></div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-secondary" id="boton_carro"><img src="../../logos/cart.png" id="carro"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
            } catch (Exception $e) {

                echo "". $e->getMessage() ."";

            }

            $conexion->close(); // Cierre de la conexión
        ?>
</body>
</html>