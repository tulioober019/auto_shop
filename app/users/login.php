<?php

    include "../data/Persona.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        # ** Obtención de los parámetros de configuración ** #

        $config_file_path = "../config.json"; # Especifica la ruta del fichero de configuración del JSON.

        $contenidos_fichero = file_get_contents($config_file_path); # Obtiene los datos del config.json y los procesa en una cadena JSON.

        $param = json_decode($contenidos_fichero,true); # Descodifica todos los datos del config.json en un array.

        # ** Inicialización de la conexion ** #
        try {
            $conexion = new mysqli(
                $param["db"]["db_host"], # Nombre del host de la base de datos.
                $param["db"]["db_username"], # Nombre del usuario de la base de datos.
                $param["db"]["db_password"], # Contraseña de la base de datos.
                $param["db"]["db_schema_name"], # Nombre del esquema de la base de datos.
                $param["db"]["db_port"] # Nombre del puerto del base de datos.
            );

            # ** Realización de la consulta de verificación ** #

            $username = filter_input(INPUT_POST,"nombre_usuario",FILTER_SANITIZE_STRING);
            
            $password = filter_input(INPUT_POST,"contrasenha",FILTER_SANITIZE_STRING);

            $query = "SELECT verificar_usuario(\"" . $username . "\",\"" . $password . "\") as usuario;"; # Consulta de verificacion.

            $resultado = $conexion->query($query); # Almacenamiento del resultado del query.

            $flag = 0; # Indica si el usuario existe o no

            # ** Procesamiento del resultado ** #
            while ($fila = $resultado->fetch_assoc()) {

                $flag = $fila["usuario"];

            }
            
            if ($flag == 1) {
                
                $query = "SELECT * FROM Persona WHERE nombre_usuario = \"" . $username . "\";";

                $datos_usuario = $conexion->query($query)->fetch_assoc();

                # ** Establecimiento de las variables de sessión ** #

                session_start();

                $_SESSION["id_persona"] = $datos_usuario["id_persona"];

                $_SESSION["id_session"] = session_id();

                $_SESSION["carro"] = array();

                # ** Acciones a realizar ** #
                
                session_write_close();

                header("Location: ../session.php");
            
            } else {

                $log_status = "FAILED";

                header("Location: ../index.php");

            }

            $conexion->close();

        } catch (Exception $e) {
            die($e->getMessage());
        }

    }