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
$ mysql -u root -pautoshop < auto_shop.sql
```
