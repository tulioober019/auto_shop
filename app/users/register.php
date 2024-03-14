<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../logos/site-logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
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
        }

        .input-row {
            margin-bottom: 5px;
        }
    </style>
    <title>Auto Shop! - Registro</title>
</head>
<body>
    <div class="container-fluid">
        <header class="row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                <img src="../logos/site-logo.png" id="site-logo">
            </div>
            <div class="col-lg-11 col-md-11 col-sm-10 col-10">
                <h1 style="margin-left: 0px; font-weight: bold;">Auto shop!</h1>
            </div>
        </header>
    </div>
    <div class="container-fluid">
            <form method="post" action="register-user.php">
                <legend>Alta de usuario</legend>
                <br>
                <br>
                <fieldset>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">Nombre:</label>
                        <input type="text" placeholder="Su nombre" name="nombre" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">1º Apellido:</label>
                        <input type="text" placeholder="Su primer apellido" name="apellido1" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">2º Apellido:</label>
                        <input type="text" placeholder="Su segundo apellido" name="apellido2" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">Teléfono:</label>
                        <input type="text" placeholder="Introduzca un teléfono válido" name="telefono" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">DNI:</label>
                        <input type="text" placeholder="Introduzca su número de identidad" name="dni" class="col-5 col-md-6" length="9" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">Correo electrónico:</label>
                        <input type="text" placeholder="Introduzca un correo electrónico válido" name="correo" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">Nombre usuario:</label>
                        <input type="text" placeholder="Introduzca su nombre de usuario" name="nombre_usuario" class="col-5 col-md-6" length="9" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">Contraseña:</label>
                        <input type="password" placeholder="Introduzca su contraseña" name="contrasena1" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-5 col-lg-4">Confirmar contraseña:</label>
                        <input type="password" placeholder="Confirme su contraseña" name="contrasena2" class="col-5 col-md-6" required="true">
                    </div>
                    <div class="input-row row">
                        <label class="col-6 col-md-10 col-lg-4">He leido y acepto los terminos y condiciones:</label>
                        <input type="checkbox" class="col-1 col-md-1" name="seacepto" required="true" value="si">
                    </div>
                    <div class="input-row row">
                        <div class="col-8 col-lg-9"></div>
                        <button type="submit" class="col-3 col-md-2 col-lg-1 btn btn-primary">Regístrate</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>