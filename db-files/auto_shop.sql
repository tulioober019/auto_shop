####################################
# ** BASE DE DATOS DE AUTO_SHOP ** #
####################################

###################################################
# ** CREACION DE LA BASE DE DATOS Y LAS TABLAS ** #
###################################################

DROP SCHEMA IF EXISTS auto_shop;
CREATE SCHEMA IF NOT EXISTS auto_shop DEFAULT CHARACTER SET utf8mb4;
USE auto_shop;

CREATE TABLE Persona (
	id_persona INT AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido1 VARCHAR(50) NOT NULL,
    apellido2 VARCHAR(50),
    telefono CHAR(9),
    dni CHAR(9) UNIQUE NOT NULL,
    correo VARCHAR(100) NOT NULL,
    nombre_usuario VARCHAR(100) UNIQUE NOT NULL,
    avatar VARCHAR(500),
    contrasena VARCHAR(500) NOT NULL,
    saldo DOUBLE DEFAULT 0.00,
    rol ENUM("Admin","Cliente") DEFAULT "Cliente",
    direccion INT,
    CONSTRAINT pk_cliente PRIMARY KEY (id_persona)
);

CREATE TABLE Direccion (
	id_direccion INT AUTO_INCREMENT,
    tipo ENUM("Rua","Calle","Avenida","Plaza","Travesia") NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    portal VARCHAR(4),
    andar VARCHAR(4),
    puerta VARCHAR(4),
    ciudad VARCHAR(50),
    provincia VARCHAR(50),
	CONSTRAINT pk_direccion PRIMARY KEY (id_direccion)
);

ALTER TABLE Persona ADD CONSTRAINT fk_cliente_direccion 
FOREIGN KEY (direccion) REFERENCES Direccion (id_direccion) 
ON UPDATE CASCADE ON DELETE CASCADE;

CREATE TABLE Marca (
	id_marca INT AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    logo VARCHAR(500) NOT NULL,
    CONSTRAINT pk_marca PRIMARY KEY (id_marca)
);

CREATE TABLE Vehiculo (
	id_vehiculo INT AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    marca INT,
    ano_fabricacion INT(4) CHECK (1970 <= ano_fabricacion <= 2024),
    precio DOUBLE DEFAULT 0.00,
    stock INT DEFAULT 0,
    imagen VARCHAR(500) NOT NULL,
    categoria ENUM("Coche","Camión","Autobús") DEFAULT "Coche",
    descripcion TEXT,
    CONSTRAINT pk_vehiculo PRIMARY KEY (id_vehiculo),
    CONSTRAINT fk_vehiculo_marca FOREIGN KEY (marca) 
    REFERENCES Marca(id_marca) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Pedido (
	id_pedido INT,
    cliente INT,
    vehiculo INT,
    cantidad INT NOT NULL,
    fecha_pedido DATE NOT NULL,
    fecha_entrega DATE,
    fecha_esperada DATE NOT NULL,
    CONSTRAINT pk_pedido PRIMARY KEY (id_pedido,cliente,vehiculo),
    CONSTRAINT fk_pedido_cliente FOREIGN KEY (cliente) 
    REFERENCES Persona(id_persona) 
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_pedido_vehiculo FOREIGN KEY (vehiculo) 
    REFERENCES Vehiculo(id_vehiculo) 
    ON UPDATE CASCADE ON DELETE CASCADE
);

#############################
# ** INSERCCION DE DATOS ** #
#############################

INSERT INTO Direccion (tipo,nombre,portal,andar,puerta,ciudad,provincia) VALUES ("Avenida","Castelao","35","3","B","Santiago de Compostela","A Coruña"),
("Rua","Rosalia de Castro","10","9","C","Milladoiro","A Coruña"),
("Avenida","Lugo","76","4","C","Santiago de Compostela","A Coruña"),
("Avenida","Lugo","77","4","C","Santiago de Compostela","A Coruña");

INSERT INTO Persona (nombre, apellido1, apellido2, telefono, dni, correo, nombre_usuario, avatar, contrasena, saldo,rol,direccion) 
VALUES 
('Tulio', 'Fernández', 'Bernier', '611308630', '54656788W', 'tuliofb_20@proton.me', 'admin',"./avatars/unknown.jpg", sha2("abc123.",512) , 1000000.00,"Admin",1),
('Juan', 'Gómez', 'Pérez', '617090801', '11111111A', 'juan@gmail.com', 'juanito123',"./avatars/unknown.jpg", sha2("abc123.",512) , 1000.00,"Cliente",2),
("Isabella","Torres","Garcia",'618919292','22222222A','igarcia@gmail.com','isagarcia',"./avatars/unknown.jpg",sha2("abc123.",512),1000.00,"Cliente",3),
("Perry","The","Platypus",'716829282','33333333A','agentep@gmail.com','agentep',"./avatars/unknown.jpg",sha2("abc123.",512),5000.00,"Cliente",4); 

SET GLOBAL local_infile = ON;

LOAD DATA LOCAL INFILE "data/marcas.csv" INTO TABLE Marca COLUMNS TERMINATED BY ",";

LOAD DATA LOCAL INFILE "data/vehiculos.csv" INTO TABLE Vehiculo COLUMNS TERMINATED BY ",";

#INSERT INTO Marca (nombre,logo) VALUES ("Isuzu","./pics/brand/1.png");
#INSERT INTO Marca (nombre,logo) VALUES ("Mercedes Benz","./pics/brand/2.png");
#INSERT INTO Marca (nombre,logo) VALUES ("Ford","./pics/brand/3.png");

#INSERT INTO Vehiculo (nombre,marca,ano_fabricacion,precio,stock,imagen,categoria,descripcion) VALUES ("Isuzu Turquise Class II",1,2022,12000.00,12,"./pics/1.png","Autobús","Sin descripción");
#INSERT INTO Vehiculo (nombre,marca,ano_fabricacion,precio,stock,imagen,categoria,descripcion) VALUES ("Mercedes Benz Clase E Berlina",2,2023,8000.50,12,"./pics/2.png","Coche","Sin descripción");
#INSERT INTO Vehiculo (nombre,marca,ano_fabricacion,precio,stock,imagen,categoria,descripcion) VALUES ("Ford Kuga SUV Híbrido",3,2019,7929.99,19,"./pics/3.png","Coche","Sin descripcion");
################################################
# ** CREACION DE PROCEDIMIENTOS ALMACENADOS ** #
################################################

DELIMITER $$
CREATE PROCEDURE alta_usuario (
	IN v_nombre VARCHAR(50),
    IN v_apellido1 VARCHAR(50),
    IN v_apellido2 VARCHAR(50),
    IN v_telefono CHAR(9),
    IN v_dni CHAR(9),
    IN v_correo VARCHAR(100),
    IN v_nombre_usuario VARCHAR(100),
    IN v_contrasena VARCHAR(100)
)
BEGIN
	# ENCRIPTACIÓN DE LA CONSTRASENA.
	DECLARE contrasena_encriptada VARCHAR(500);
    SET contrasena_encriptada = sha2(v_contrasena,512); # UTILIZAMOS HASHING SHA-512.
    
    # INSERCCION DE LOS DATOS DEL ALTA DEL CLIENTE.
    INSERT INTO Persona SET nombre = v_nombre,
		apellido1 = v_apellido1,
        apellido2 = v_apellido2,
        telefono = v_telefono,
        dni = v_dni,
        correo = v_correo,
        nombre_usuario = v_nombre_usuario,
        contrasena = contrasena_encriptada,
        avatar = "./avatars/unknown.jpg";
END$$

CREATE FUNCTION verificar_usuario (v_nombre_usuario VARCHAR(100),v_contrasena VARCHAR(100)) RETURNS BOOL DETERMINISTIC
BEGIN
	DECLARE user_match INT;
    DECLARE flag INT DEFAULT false;
	SET user_match = (SELECT COUNT(nombre_usuario) as cantidad_usuarios
		FROM Persona WHERE nombre_usuario = v_nombre_usuario
        AND contrasena = sha2(v_contrasena,512)
	);
    IF (user_match = 1)
    THEN
		SET flag = true;
	END IF;
    RETURN flag;
END$$

CREATE FUNCTION verificar_contrasena (
	v_contrasena1 VARCHAR(500),
    v_contrasena2 VARCHAR(500)
) RETURNS BOOL DETERMINISTIC
BEGIN
	IF (sha2(v_contrasena1,512) = sha2(v_contrasena2,512))
	THEN
		RETURN true;
	ELSE
		RETURN false;
	END IF;
END$$

CREATE PROCEDURE cambiar_contrasena (
	IN v_nombre_usuario VARCHAR(100),
	IN v_contrasena_actual VARCHAR(500),
    IN v_nueva_contrasena VARCHAR(500),
    IN v_nueva_contrasena_confirmada VARCHAR(500)
) BEGIN
	# VERIFICACION DEL USUARIO
	IF (verificar_usuario(v_nombre_usuario,v_contrasena_actual) = true)
	THEN
		IF (verificar_contrasena(v_nueva_contrasena,v_nueva_contrasena_confirmada) = true)
		THEN
			UPDATE Persona SET contrasena = sha2(v_nueva_contrasena,512)
            WHERE nombre_usuario = v_nombre_usuario;
        END IF;
	END IF;
END$$

CREATE FUNCTION get_precio_cantidad_productos (
	v_id_vehiculo INT,
    v_cantidad INT
) RETURNS DOUBLE DETERMINISTIC BEGIN
	DECLARE v_precio_producto DOUBLE;
    DECLARE v_precio_total DOUBLE;
    SET v_precio_producto = (SELECT precio 
		FROM Vehiculo 
        WHERE id_vehiculo = v_id_vehiculo
	);
    SET v_precio_total = v_precio_producto * v_cantidad;
    RETURN v_precio_total;
END$$

CREATE FUNCTION saldo_suficiente (
	v_id_cliente INT,
    v_precio DOUBLE
) RETURNS BOOL DETERMINISTIC BEGIN
	DECLARE v_saldo_cliente DOUBLE;
    DECLARE flag BOOL DEFAULT false;
    SET v_saldo_cliente = (SELECT saldo 
		FROM Persona
        WHERE id_persona = v_id_cliente
	);
    IF (v_saldo_cliente - v_precio < 0.00)
    THEN
		SET flag = false;
	ELSE
		SET flag = true;
	END IF;
    RETURN flag;
END$$
CREATE PROCEDURE comprar_vehiculo (
	IN v_id_cliente INT,
	IN v_id_vehiculo INT,
    IN v_cantidad INT
)
BEGIN
    DECLARE v_precio_total DOUBLE;
    # 1º HALLAR PRECIO TOTAL.
    SET v_precio_total = get_precio_cantidad_productos(v_id_vehiculo,v_cantidad);
    
    # 2º COMPROBAR SI SE PUEDE PAGAR
    
END$$

CREATE PROCEDURE listar_vehiculos (IN v_marca VARCHAR(50) )
BEGIN
	IF (v_marca = "" OR v_marca NOT IN (SELECT nombre FROM Marca)) THEN
		SELECT id_vehiculo,imagen,nombre,precio FROM Vehiculo;
    ELSE
		SELECT id_vehiculo,imagen,nombre,precio FROM Vehiculo WHERE marca = (
			SELECT id_marca FROM Marca WHERE nombre = v_marca
		);
	END IF;
END$$

CREATE PROCEDURE listar_vehiculo (IN v_id_vehiculo INT)
BEGIN
    SELECT v.nombre as nom_vehiculo,ano_fabricacion,precio,stock,imagen,categoria,descripcion,m.nombre as nombre_marca FROM Vehiculo v INNER JOIN Marca m ON (m.id_marca=v.marca) WHERE id_vehiculo = v_id_vehiculo;
END$$

CREATE FUNCTION nombre_vehiculo (v_id_vehiculo INT) RETURNS VARCHAR(50) DETERMINISTIC
BEGIN
	RETURN (SELECT nom_vehiculo FROM Vehiculo WHERE id_vehiculo = v_id_vehiculo);
END$$

CREATE PROCEDURE tramitar_pedido (v_id_persona INT)
BEGIN
    DECLARE total_pedido DOUBLE;
    DECLARE v_id_pedido INT;
    DECLARE v_id_vehiculo INT;
    DECLARE precio_producto DOUBLE;
    DECLARE v_cantidad INT;
    DECLARE end_of_list BOOLEAN DEFAULT false;
    DECLARE productos CURSOR FOR SELECT * FROM Carro;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET end_of_list = true;

    SET v_id_pedido = (SELECT COUNT(DISTINCT id_pedido)+1 FROM Pedido); # Establece el id del pedido
    SET AUTOCOMMIT = 0; # Deshabilita el autocomit.
    START TRANSACTION;

    # 1º PASO: Computar o total a pagar.
    SET total_pedido = (SELECT SUM(precio*cantidad) FROM Carro);

    # 2º PASO: Comprobar que o cliente tiene suficiente saldo.
    IF (SELECT saldo_suficiente(v_id_persona,total_pedido) = true)
    THEN
        # 3º PASO: Insertar los datos en la tabla pedido

        OPEN productos;

            read_loop: LOOP
                # 4º PASO: Obtencion de los datos.
                FETCH productos INTO v_id_vehiculo,precio_producto,v_cantidad;

                IF (end_of_list = true) THEN LEAVE read_loop;
                END IF;

                # 5º PASO: Generacion de los pedidos.
                INSERT INTO Pedido SET id_pedido = v_id_pedido,
                    cliente = v_id_persona,
                    vehiculo = v_id_vehiculo,
                    cantidad = v_cantidad,
                    fecha_pedido = CURDATE(),
                    fecha_entrega = DATE_ADD(CURDATE(),INTERVAL 2 DAY),
                    fecha_esperada = DATE_ADD(CURDATE(),INTERVAL 2 DAY);

                # 6º PASO: Actualización de la cantidad.
                UPDATE Vehiculo SET stock = stock - v_cantidad WHERE id_vehiculo = v_id_vehiculo;

            END LOOP;

        CLOSE productos;
        
        # 7º PASO: Substraer saldo del cliente. 
        UPDATE Persona SET saldo = saldo - total_pedido WHERE id_persona = v_id_persona;
    END IF;
    COMMIT;
    SET AUTOCOMMIT = 1;
END$$

CREATE FUNCTION estado_entrega(v_id_pedido INT) RETURNS VARCHAR(50) DETERMINISTIC
BEGIN
    DECLARE f_pedido DATE;
    DECLARE f_esperada DATE;
    DECLARE estado_entrega ENUM("Entregado","En transporte","Con retraso");

    SET f_pedido = (SELECT DISTINCT fecha_pedido FROM Pedido WHERE id_pedido = v_id_pedido);
    SET f_esperada = (SELECT DISTINCT fecha_esperada FROM Pedido WHERE id_pedido = v_id_pedido);

    IF (CURDATE() = f_esperada ) THEN SET estado_entrega = "Entregado";
    ELSEIF (CURDATE() != f_esperada && f_esperada = DATE_ADD(CURDATE(),INTERVAL 2 DAY) && f_esperada = DATE_ADD(CURDATE(),INTERVAL 1 DAY)) THEN SET estado_entrega = "En transporte";
    ELSE SET estado_entrega = "Con retraso";
    END IF;

    RETURN estado_entrega;
END$$

#CREATE PROCEDURE consulta_pedido(IN v_id_pedido INT)
#BEGIN
#    SELECT v.nombre,v.imagen,m.nombre as marca,p.cantidad FROM Vehiculo v INNER JOIN Marca m ON (v.marca = m.id_marca) INNER JOIN Pedido p ON (p.vehiculo = v.id_vehiculo) WHERE id_vehiculo IN (SELECT vehiculo FROM Pedido WHERE id_pedido = v_id_pedido);
#END$$

DELIMITER ;