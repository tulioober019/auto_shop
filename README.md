# Auto Shop!. Una tienda e-commerce.
Este proyecto es un ejemplo que demuestra el funcionamiento básico de una tienda e-commerce en un servidor LAMP. Esta escrito prinicipalmente en lenguaje PHP.  La aplicación se puede correr tanto en una máquina física con algunos requisitos de software específicos o en un contenedor Docker.

Nota: Esto no es una tienda real. Es utilizado para demostrar como se puede contruido una tienda utilizando HTML, CSS, PHP y MySQL.

## 1. Requisitos previos.
* En el caso de una instalación de un servidor físico:
  * Una distribución Linux, preferentemente Ubuntu.
  * Apache2
  * PHP con los siguientes paquetes **no superior a 8.1**
  * MySQL.
 * En el caso de una instalación de docker:
   * Tener docker instalado.

## 2. Instalación en docker.
Utilizar el siguiente comando:
```bash
$ docker compose up -d
```

Puede darse el caso en que no está inicializado la base de datos, para eso haced lo seguiente:

```bash
$ docker exec -it mysql-001 bash
```
```bash
$ cd /docker-entrypoint-initdb.d/
$ mysql -u root -pautoshop --local-infile=1 < auto_shop.sql
```
Para entrar en el sitio web y comprobar su correcto funcionamiento, ir al siguiente enlace http://localhost:8080/index.php.

## 3.- Uso de la aplicación web.
Al entrar, debería aparecer una página como esta:
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/24740c5c-1285-46f3-ae21-292ced63f596)

### 3.1.- Autenticación.
Al lanzar la aplicación, por defecto crea un usuario admin con contraseña abc123.. Todas las contraseñas en la base de datos están almacenados en hashes sha-512 para preservar su confidencialidad. Para logearse, débese pulsar en el boton "Iniciar sessión" en la esquina superior derecha. Al pulsar aparecerá una ventana de login con botones de inciar sessión y registrarse. 
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/f478f390-994d-400b-9dbe-d2f883b13b3b)

Al iniciar sessión correctamente, aparererá una ventana como este:
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/09aaef1e-5236-4481-bba3-8a27b2069b41)

### 3.2.- Vista detallada de productos.
Al pulsar en ver producto, se puede obtener una vista detallada de los productos de este modo:
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/bbacabdc-e0ad-4bfa-a330-9a58d1693968)

### 3.3.- Carro de compra y procesamiento de pedido.
Vista del carrito:
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/12cac226-e390-4d95-8d94-c497c14ed1b7)

Compra del producto: Pulsar en comprar. Para el procesamiento del pedido, se ejecutará un serie de sentencias php y SQL utilizando transacciones y procedimientos almacenados y tablas temporales. Para chequar un pedido, aparecerá una pantalla como este:
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/e5a87f37-8bd3-4709-bb36-1fd799aeaf73)

### 3.4.- Acceso al carrito y los pedidos.
![imagen](https://github.com/tulioober019/auto_shop/assets/134515143/3160d81e-343a-450e-be6c-2a5cbedf8343)

