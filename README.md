# 📌 Asaderos Online

## 📝 Descripción
Gestor de Asaderos Online Web - CRUD.

## 🔸 Captura de la página principal
![imagen](https://user-images.githubusercontent.com/74573542/214897302-28bda8ef-b592-4f3d-8f4c-499b83092bf8.png)

## 📋 Instalación
1. Clonar el repositorio `git clone https://github.com/Edvintrabajo/asaderosonline.git`
2. Crear la base de datos, el archivo sql está en 'database/asaderos-online.sql'
3. Crear el archivo .env en el directorio raiz del proyecto con las variables de entorno para la conexión a la base de datos, un ejemplo del contenido del archivo .env sería el siguiente:
```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=asaderosonline
```
4. Instalar las dependencias con `composer install` (Este comando lo tienes que ejecutar en la raiz del proyecto)
5. Iniciar el servidor con `php -S localhost:8000` (Este comando lo tienes que ejecutar en la raiz del proyecto)
6. Abrir el navegador en la url `http://localhost:8000`

Hay que tener en cuenta que para que funcione el proyecto, tienes que tener instalado PHP, Composer GIT y MySQL.

También hay que tener la base de datos activa con xaamp o wamp, o cualquier otro programa que te permita tener una base de datos activa.

## 📌 Uso de la aplicación (no administrador)
1. Para acceder a la página principal, hay que rellenar el formulario de registro e iniciar sesión.
2. En la página principal se muestran los asaderos que se encuentran en la base de datos.
3. Para inscrirse en un asadero, se debe hacer click en un asadero y darle click al botón 'Reservar'.
4. Para ver los asaderos en donde te has inscrito, se debe dar click al botón 'Mis reservas' en la parte inferior de la sección de asaderos.
5. Para eliminar una reserva, se debe dar click a a una reserva en la sección 'Mis reservas' y darle click al botón 'Eliminar'.
6. Para enviar un mensaje al administrador, se debe rellenar el formulario de contacto y darle click al botón 'Enviar'.

## 📌 Uso de la aplicación (administrador)
1. Para acceder a la página principal como administrador, hay que tener una cuenta con rol de administrador.
2. Para acceder al panel de administrador, se debe dar click al avatar de la página principal.
3. En el panel de administrador se pueden ver, crear, editar y eliminar asaderos.
4. En el panel de administrador se pueden ver y eliminar reservas.
5. En el panel de administrador se pueden ver y eliminar usuarios (las contraseñas de los usuarios están encriptadas).

## 📌 Tecnologías utilizadas
- HTML
- CSS
- JavaScript
- MySql
- PHP
- Composer
- Bootstrap
- PHPMailer
- Dotenv

## 📌 Contribuciones
Las contribuciones son bienvenidas. Para contribuir, sigue los siguientes pasos:
1. Haz un fork del proyecto.
2. Crea una rama para tu contribución `git checkout -b contribucion/NombreContribucion`
3. Haz tus cambios y confirma los cambios `git commit -m 'Agregué una contribución'`
4. Haz push a la rama `git push origin contribucion/NombreContribucion`.
5. Abre un pull request.

## 📌 Nota
Este proyecto es para clase, no es un proyecto real.

## 📌 Licencia
[MIT](https://choosealicense.com/licenses/mit/)

## 📌 Autor
- [Edvin Freyer Ortega](https://github.com/Edvintrabajo)