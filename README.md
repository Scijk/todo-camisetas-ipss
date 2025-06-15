# API TodoCamisetas

API para la gestión de clientes, camisetas y tallas en un entorno B2B. 
Desarrollada en PHP puro con base de datos MySQL, pensada para ser ejecutada localmente con XAMPP.

## 📁 Estructura del Proyecto

* /todo-camisetas-ipss/
* ├── controller/
* │ ├── CamisetaController.php
* │ ├── ClienteController.php
* │ └── TallaController.php
* ├── mapper/
* │ └── EntityMapper.php
* ├── models/
* │ ├── Camiseta.php
* │ ├── Cliente.php
* │ └── Talla.php
* ├── api-docs/ (documentación OpenAPI)
* │ ├── index.html
* │ ├── swagger.yaml
* │ ├── swagger-initializer.js
* │ └── ...
* ├── .htaccess
* ├── db.php
* ├── index.php
* ├── README.md
* ├── routes.php
* └── utils.php

## ⚙️ Requisitos

- [XAMPP](https://www.apachefriends.org/index.html) instalado con:
    - Apache
    - MySQL

## 🚀 Instalación y ejecución local

### 1. **Clona o copia el proyecto en tu carpeta de XAMPP**
    git clone https://github.com/Scijk/todo-camisetas-ipss.git

### 2. **Ruta sugerida, si se instala en otra ruta, es necesario actualizar rutas dentro del proyecto**
    \htdocs\ipss\desaBackend\examen\todo-camisetas-ipss

### 3. **Crea la base de datos**

    Abre http://localhost/phpmyadmin
    
    Crea una nueva base de datos, por ejemplo todo-camisetas-ipss y un usuario para la misma
    
    Ejecuta los scripts de tablas y datos iniciales
    [todo_camisetas_ipss.sql](bd/todo_camisetas_ipss.sql)

    Configura conexión a la base de datos con los parámetros anteriores en el archivo db.php

    $host = 'localhost';
    $db = 'todo_camisetas_ipss';
    $user = 'user_ex';
    $pass = 'user_ex';
       

# 4. Inicia el servidor Apache desde XAMPP

    Asegúrate de que Apache y MySQL estén activos.
    Accede a la API desde:
    http://localhost/ipss/desaBackend/examen/todo-camisetas-ipss/

# 5. (Opcional Recomendado) Accede a la documentación Swagger
    Para revisar la documentación de swagger, se puede acceder desde:
    http://localhost/ipss/desaBackend/examen/todo-camisetas-ipss/api-docs/


## 🧩 Controladores y Endpoints
🔸 ClienteController
* Maneja creación, actualización, búsqueda y eliminación de clientes.

| Método | Endpoint        | Descripción                      |
| ------ |-----------------| -------------------------------- |
| POST   | `/clientes`     | Crear un nuevo cliente           |
| POST   | `/clientes/ver` | Buscar cliente por RUT           |
| PUT    | `/clientes`     | Actualizar cliente completamente |
| PATCH  | `/clientes`     | Actualización parcial            |
| DELETE | `/clientes`     | Eliminar cliente por RUT         |
| GET    | `/clientes`     | Listar todos los clientes        |


🔸 TallaController
* Gestión de tallas y su asignación a camisetas.

| Método | Endpoint           | Descripción                              |
|--------|--------------------| ---------------------------------------- |
| GET    | `/tallas`          | Obtener todas las tallas                 |
| POST   | `/tallas`          | Crear una nueva talla                    |
| PATCH  | `/tallas`          | Actualizar una talla                     |
| DELETE | `/tallas`          | Eliminar una talla                       |


🔸 CamisetaController (en desarrollo o ya implementado)
* Gestión de camisetas disponibles en stock.

| Método | Endpoint            | Descripción                                      |
|--------|---------------------|--------------------------------------------------|
| GET    | `/camisetas`        | Listar camisetas                                 |
| POST   | `/camisetas`        | Crear nueva camiseta                             |
| PUT    | `/camisetas`        | Actualizar camiseta                              |
| DELETE | `/camisetas`        | Eliminar camiseta                                |
| PATCH  | `/camisetas`        | Actualizar parcialmente camiseta                 |
| POST   | `/camisetas/ver`    | Obtener camiseta por código                      |
| POST   | `/camisetas/precio` | Obtiene camiseta con su precio final por cliente |
| POST   | `/camisetas/tallas` | Asignar tallas a una camiseta                    |
| DELETE | `/camisetas/tallas` | Eliminar tallas asignadas a una camiseta         |


## 🧪 Pruebas
    Puedes probar los endpoints usando Postman (https://www.postman.com/) o swagger desde la documentacion

