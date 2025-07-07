# Lista de Tareas Interactiva con Roles

Este proyecto es una aplicación web desarrollada en PHP, MySQL, HTML, CSS y JavaScript, que permite gestionar tareas con control de usuarios y roles.

## Características
- Registro e inicio de sesión de usuarios
- Roles: `admin` (gestiona todas las tareas) y `usuario` (gestiona solo sus tareas)
- Agregar, eliminar y marcar tareas como completadas
- Interfaz moderna y responsive
- Almacenamiento de datos en MySQL

## Instalación local (XAMPP)
1. Clona este repositorio:
   ```
   git clone https://github.com/DaniloRMC/roles.docentes.git
   ```
2. Copia la carpeta a `C:/xampp/htdocs/`
3. Crea la base de datos `tareas_db` y ejecuta el script SQL para las tablas:
   ```sql
   CREATE TABLE usuarios (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       rol ENUM('admin', 'usuario') NOT NULL
   );
   CREATE TABLE tareas (
       id INT AUTO_INCREMENT PRIMARY KEY,
       descripcion VARCHAR(255) NOT NULL,
       completada BOOLEAN DEFAULT 0,
       usuario_id INT,
       FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
   );
   ```
4. Inicia Apache y MySQL en XAMPP
5. Accede a [http://localhost/roles.docentes/index.php](http://localhost/roles.docentes/index.php)

## Despliegue temporal en la web (ngrok)
1. Instala [ngrok](https://ngrok.com/)
2. Autentica con tu token:
   ```
   ngrok config add-authtoken TU_TOKEN_AQUI
   ```
3. Ejecuta:
   ```
   ngrok http 80
   ```
4. Comparte la URL pública que te da ngrok

## Autor
Danilo Muenala

---

> **Nota:** GitHub Pages no soporta PHP. Para ver la app funcionando, usa XAMPP o un hosting con soporte PHP/MySQL.
