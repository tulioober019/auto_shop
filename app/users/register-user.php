<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
        $config_file_path = "../config.json"; # Especifica la ruta del fichero de configuración del JSON.

        $contenidos_fichero = file_get_contents($config_file_path); # Obtiene los datos del config.json y los procesa en una cadena JSON.

        $param = json_decode($contenidos_fichero,true); # Descodifica todos los datos del config.json en un array.

        try {

            $conexion = new mysqli(
                $param["db"]["db_host"], # Nombre del host de la base de datos.
                $param["db"]["db_username"], # Nombre del usuario de la base de datos.
                $param["db"]["db_password"], # Contraseña de la base de datos.
                $param["db"]["db_schema_name"], # Nombre del esquema de la base de datos.
                $param["db"]["db_port"] # Nombre del puerto del base de datos.
            );

            $nombre = filter_input(INPUT_POST,"nombre",FILTER_SANITIZE_STRING);

            $apellido1 = filter_input(INPUT_POST,"apellido1",FILTER_SANITIZE_STRING);

            $apellido2 = filter_input(INPUT_POST,"apellido2",FILTER_SANITIZE_STRING);

            $telefono = filter_input(INPUT_POST,"telefono",FILTER_SANITIZE_STRING);

            $dni = filter_input(INPUT_POST,"dni",FILTER_SANITIZE_STRING);

            $correo = filter_input(INPUT_POST,"correo",FILTER_SANITIZE_EMAIL);

            $nombre_usuario = filter_input(INPUT_POST,"nombre_usuario",FILTER_SANITIZE_STRING);

            $contrasena = filter_input(INPUT_POST,"contrasena1",FILTER_SANITIZE_STRING);

            $query = "CALL alta_usuario(\"" . $nombre . "\",\"" . $apellido1 . "\",\"" . $apellido2 . "\",\"" . $telefono . "\",\"" . $dni . "\",\"" . $correo . "\",\"" . $nombre_usuario . "\",\"" . $contrasena . "\");";

            $conexion->query($query);

            $query = "SELECT verificar_usuario(\"" . $nombre_usuario . "\",\"" . $contrasena . "\") as usuario;"; # Consulta de verificacion.

            $resultado = $conexion->query($query); # Almacenamiento del resultado del query.

            $flag = 0; # Indica si el usuario existe o no

            # ** Procesamiento del resultado ** #
            while ($fila = $resultado->fetch_assoc()) {

                $flag = $fila["usuario"];

            }
            
            if ($flag == 1) {
                
                $query = "SELECT * FROM Persona WHERE nombre_usuario = \"" . $nombre_usuario . "\";";

                $datos_usuario = $conexion->query($query)->fetch_assoc();

                # ** Establecimiento de las variables de sessión ** #

                session_start();

                $_SESSION["id_persona"] = $datos_usuario["id_persona"];

                # ** Acciones a realizar ** #

                header("Location: ../session.php");
            
            }

            $conexion->close();

        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }