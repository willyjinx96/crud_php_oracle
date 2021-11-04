# crud_php_oracle
A simple CRUD, developed in Oracle Database 10g+PHP 7.1, with XAMPP
## Requisitos

* Oracle Database 10g
* PHP v7.1
* XAMPP configurado para conexion a Oracle (***visitar el siguiente [blog](url) para la configuracion del XAMPP***)

## Estructura del proyecto

El proyecto CRUD debe estar en la siguiente ruta para su debido funcionamiento:

```
C:
|---->xampp
        |--->htdocs
                |---->config.php
                |---->create.php
                |---->read.php
                |---->update.php
                |---->delete.php
                |---->index.php
                |---->error.php
```
## Para correr el proyecto
En Oracle, crear un usario con el nombre "***db_crud***" con contraseña "***db_crud***" (_Puede ser creado mediante linea de comando o desde el **Oracle Express**_), dentro de este usuario, crear la tabla ***EMPLEADOS***, con el siguiente script

```sql
CREATE TABLE empleados
(
   id          INT PRIMARY KEY,
   nombre      VARCHAR (100),
   direccion   VARCHAR (100),
   salario     INT
);
```
Crear una **Secuencia** para crear un **auto_increment**, que ayudara a asignar una ID, de manera automatica.
```sql
--Auto_increment
CREATE SEQUENCE emp_seq START WITH 1;
```
Para que "**emp_seq**" funcione correctamente, se debe crear un **_trigger_** que dispare esta secuencia cada vez que se inserte un nuevo registro.
```sql
--Creamos un trigger para ejectura el sequence
CREATE OR REPLACE TRIGGER emp_insert
   BEFORE INSERT
   ON empleados
   FOR EACH ROW
BEGIN
   SELECT emp_seq.NEXTVAL INTO :new.id FROM DUAL;
END;
```
> _Adicionalmente, se puede insertar algunos registros de prueba para probar el CRUD_
> ```sql
> INSERT INTO empleados
>     VALUES (1,
>             'Juan Perez',
>             'Z/ Cementerio C/ Gandarillas #45',
>             6000);
>
>INSERT INTO empleados
>     VALUES (2,
>             'Belen Cusi',
>             'Z/ Miraflores Av/ Busch #122',
>             5000);
>
>INSERT INTO empleados
>     VALUES (3,
>             'Fernando Loza',
>             'Z/ San Pedro C/ Loayza #344',
>             7000);
> ```

Una vez copiado los archivos segun la estructura del proyecto, iniciar **XAMPP** y correr el servicio Apache, luego dar click en el boton **Admin**, si todo esta bien el CRUD, deberia correr sin problemas.

![Apache service](https://user-images.githubusercontent.com/53346419/140339185-44f04634-746c-483c-b6d2-bcd89a29cddf.png)

#### Creditos

Desarrolado por Willy Fer
