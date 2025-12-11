# API REST - Sistema de Autenticación y Gestión de Productos

API REST desarrollada en PHP para gestionar el registro e inicio de sesión de usuarios con autenticación segura mediante encriptación de contraseñas, además de un sistema completo de gestión de productos (CRUD).

## 📋 Tabla de Contenidos

- [Características](#características)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Endpoints](#endpoints)
- [Ejemplos de Uso](#ejemplos-de-uso)

## ✨ Características

- 🔐 Registro de usuarios con contraseñas encriptadas (BCrypt)
- 🔑 Sistema de inicio de sesión seguro con redirección al panel de administración
- 📦 CRUD completo de productos (Crear, Leer, Actualizar, Eliminar)
- 🏠 Panel de administración (home.php) con menú de gestión de productos
- 📊 Arquitectura MVC (Model-View-Controller)
- 🗄️ Conexión a base de datos MySQL mediante PDO
- ⚡ Respuestas en formato JSON
- 🛡️ Manejo de errores y validaciones
- 🔄 Soporte para métodos GET y POST en endpoints de productos

## 📁 Estructura del Proyecto

```
APIREST/
│
├── app/
│   ├── ModelUser.php          # Modelo de usuario con lógica de negocio
│   └── ModelProductos.php     # Modelo de productos con operaciones CRUD
│
├── config/
│   └── db.php                 # Configuración de conexión a base de datos
│
├── endpoints/
│   ├── login.php              # Endpoint de inicio de sesión
│   ├── register.php           # Endpoint de registro de usuarios
│   ├── home.php               # Panel de administración de productos
│   ├── produc/
│   │   ├── listar.php         # Listar todos los productos
│   │   ├── insertar.php       # Crear nuevo producto
│   │   ├── obtener.php        # Obtener producto por ID (POST)
│   │   ├── obtener_get.php    # Obtener producto por ID (GET)
│   │   ├── actualizar.php     # Actualizar producto existente
│   │   ├── eliminar.php       # Eliminar producto (POST)
│   │   └── eliminar_get.php   # Eliminar producto (GET)
│   └── user/
│
├── sql/
│   └── db.sql                 # Script de creación de base de datos
│
├── index.php                  # Archivo principal con información de la API
└── README.md                  # Documentación del proyecto
```

## 🔧 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- XAMPP, WAMP o similar (para desarrollo local)
- Extensión PDO de PHP habilitada

## 🚀 Instalación

### 1. Clonar o descargar el proyecto

```bash
git clone <url-del-repositorio>
cd APIREST
```

### 2. Configurar el servidor

Coloca el proyecto en la carpeta `htdocs` de XAMPP:
```
C:\xampp\htdocs\APIREST
```

### 3. Crear la base de datos

Abre phpMyAdmin (http://localhost/phpmyadmin) y ejecuta el script SQL ubicado en `sql/db.sql`:

```sql
CREATE DATABASE db_test;
USE db_test;

-- Tabla de usuarios
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(100) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL
);

-- Tabla de productos
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario de ejemplo (contraseña: password)
INSERT INTO usuarios (usuario, contrasena) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, stock) VALUES
('Laptop HP', 'Laptop HP Core i5, 8GB RAM, 256GB SSD', 2500.00, 10),
('Mouse Logitech', 'Mouse inalámbrico Logitech M185', 45.00, 50),
('Teclado Mecánico', 'Teclado mecánico RGB retroiluminado', 150.00, 25);
```

## ⚙️ Configuración

### Archivo `config/db.php`

Configura los parámetros de conexión a la base de datos:

```php
private $host = "localhost";
private $db_name = "db_test";
private $username = "root";
private $password = "";
```

## 🌐 Endpoints

### Endpoints de Autenticación

#### 1. Registro de Usuario

**URL:** `POST /endpoints/register.php`

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "usuario": "nombre_usuario",
  "contrasena": "contraseña123"
}
```

**Respuestas:**

- ✅ **201 Created** - Usuario registrado correctamente
```json
{
  "mensaje": "Usuario registrado correctamente."
}
```

- ❌ **400 Bad Request** - Faltan datos requeridos
```json
{
  "mensaje": "Faltan datos requeridos."
}
```

- ❌ **409 Conflict** - Usuario ya existe
```json
{
  "mensaje": "El usuario ya está registrado."
}
```

- ❌ **500 Internal Server Error** - Error en el servidor
```json
{
  "error": "Mensaje de error"
}
```

#### 2. Inicio de Sesión

**URL:** `POST /endpoints/login.php`

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "usuario": "nombre_usuario",
  "contrasena": "contraseña123"
}
```

**Respuestas:**

- ✅ **200 OK** - Autenticación exitosa
```json
{
  "mensaje": "Autenticación satisfactoria.",
  "redirigir": "/APIREST/endpoints/home.php",
  "usuario": "nombre_usuario"
}
```

- ❌ **400 Bad Request** - Faltan datos requeridos
```json
{
  "mensaje": "Faltan datos requeridos."
}
```

- ❌ **401 Unauthorized** - Credenciales incorrectas
```json
{
  "mensaje": "Error en la autenticación."
}
```

- ❌ **500 Internal Server Error** - Error en el servidor
```json
{
  "error": "Mensaje de error"
}
```

#### 3. Panel de Administración

**URL:** `GET /endpoints/home.php`

Muestra el menú completo con todos los endpoints disponibles para la gestión de productos.

### Endpoints de Productos

#### 4. Listar Todos los Productos

**URL:** `GET /endpoints/produc/listar.php`

**Respuesta exitosa (200 OK):**
```json
[
  {
    "producto": {
      "id": 1,
      "nombre": "Laptop HP",
      "descripcion": "Laptop HP Core i5",
      "precio": "2500.00",
      "stock": 10
    },
    "acciones": {
      "obtener": {
        "metodo": "GET",
        "url": "http://localhost/APIREST/endpoints/produc/obtener_get.php?id=1"
      },
      "actualizar": {
        "metodo": "POST",
        "url": "/APIREST/endpoints/produc/actualizar.php"
      },
      "eliminar": {
        "metodo": "GET",
        "url": "http://localhost/APIREST/endpoints/produc/eliminar_get.php?id=1"
      }
    }
  }
]
```

#### 5. Insertar Nuevo Producto

**URL:** `POST /endpoints/produc/insertar.php`

**Body (JSON):**
```json
{
  "nombre": "Producto nuevo",
  "descripcion": "Descripción del producto",
  "precio": 100.00,
  "stock": 50
}
```

**Respuesta exitosa (201 Created):**
```json
{
  "mensaje": "Producto insertado correctamente.",
  "producto": {
    "id": 4,
    "nombre": "Producto nuevo",
    "descripcion": "Descripción del producto",
    "precio": "100.00",
    "stock": 50
  }
}
```

#### 6. Obtener Producto por ID

**URL (POST):** `POST /endpoints/produc/obtener.php`

**Body (JSON):**
```json
{
  "id": 1
}
```

**URL (GET):** `GET /endpoints/produc/obtener_get.php?id=1`

**Respuesta exitosa (200 OK):**
```json
{
  "id": 1,
  "nombre": "Laptop HP",
  "descripcion": "Laptop HP Core i5",
  "precio": "2500.00",
  "stock": 10
}
```

#### 7. Actualizar Producto

**URL:** `POST /endpoints/produc/actualizar.php`

**Body (JSON):**
```json
{
  "id": 1,
  "nombre": "Laptop HP Actualizada",
  "descripcion": "Nueva descripción",
  "precio": 2800.00,
  "stock": 15
}
```

**Respuesta exitosa (200 OK):**
```json
{
  "mensaje": "Producto actualizado correctamente.",
  "producto": {
    "id": 1,
    "nombre": "Laptop HP Actualizada",
    "descripcion": "Nueva descripción",
    "precio": "2800.00",
    "stock": 15
  }
}
```

#### 8. Eliminar Producto

**URL (POST):** `POST /endpoints/produc/eliminar.php`

**Body (JSON):**
```json
{
  "id": 1
}
```

**URL (GET):** `GET /endpoints/produc/eliminar_get.php?id=1`

**Respuesta exitosa (200 OK):**
```json
{
  "mensaje": "Producto eliminado correctamente.",
  "producto_eliminado": {
    "id": 1,
    "nombre": "Laptop HP",
    "descripcion": "Laptop HP Core i5",
    "precio": "2500.00",
    "stock": 10
  }
}
```

## 📝 Ejemplos de Uso

### Usando cURL

**Registro:**
```bash
curl -X POST http://localhost/APIREST/endpoints/register.php \
  -H "Content-Type: application/json" \
  -d '{"usuario":"john_doe","contrasena":"password123"}'
```

**Login:**
```bash
curl -X POST http://localhost/APIREST/endpoints/login.php \
  -H "Content-Type: application/json" \
  -d '{"usuario":"john_doe","contrasena":"password123"}'
```

**Listar Productos:**
```bash
curl http://localhost/APIREST/endpoints/produc/listar.php
```

**Insertar Producto:**
```bash
curl -X POST http://localhost/APIREST/endpoints/produc/insertar.php \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Tablet","descripcion":"Tablet Android 10 pulgadas","precio":350.00,"stock":20}'
```

**Obtener Producto (GET):**
```bash
curl http://localhost/APIREST/endpoints/produc/obtener_get.php?id=1
```

**Actualizar Producto:**
```bash
curl -X POST http://localhost/APIREST/endpoints/produc/actualizar.php \
  -H "Content-Type: application/json" \
  -d '{"id":1,"nombre":"Laptop HP Premium","descripcion":"Actualizada","precio":2999.00,"stock":8}'
```

**Eliminar Producto (GET):**
```bash
curl http://localhost/APIREST/endpoints/produc/eliminar_get.php?id=1
```

### Usando Postman

1. **Método:** POST
2. **URL:** `http://localhost/APIREST/endpoints/register.php` o `login.php`
3. **Headers:** 
   - Key: `Content-Type`
   - Value: `application/json`
4. **Body:** Selecciona `raw` y `JSON`, luego ingresa:
```json
{
  "usuario": "test_user",
  "contrasena": "mypassword"
}
```

### Usando JavaScript (Fetch API)

**Registro:**
```javascript
fetch('http://localhost/APIREST/endpoints/register.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    usuario: 'nuevo_usuario',
    contrasena: 'password123'
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Login con redirección:**
```javascript
fetch('http://localhost/APIREST/endpoints/login.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    usuario: 'nuevo_usuario',
    contrasena: 'password123'
  })
})
.then(response => response.json())
.then(data => {
  console.log(data);
  if (data.redirigir) {
    window.location.href = data.redirigir;
  }
})
.catch(error => console.error('Error:', error));
```

**Listar Productos:**
```javascript
fetch('http://localhost/APIREST/endpoints/produc/listar.php')
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Insertar Producto:**
```javascript
fetch('http://localhost/APIREST/endpoints/produc/insertar.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    nombre: 'Tablet Samsung',
    descripcion: 'Tablet 10 pulgadas',
    precio: 450.00,
    stock: 15
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Actualizar Producto:**
```javascript
fetch('http://localhost/APIREST/endpoints/produc/actualizar.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    id: 1,
    nombre: 'Laptop HP Actualizada',
    descripcion: 'Nueva descripción',
    precio: 2800.00,
    stock: 12
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

## 🔒 Seguridad

- Las contraseñas se almacenan encriptadas usando **BCrypt** (PASSWORD_BCRYPT)
- Se utiliza **PDO con prepared statements** para prevenir inyección SQL
- Validación de datos de entrada en todos los endpoints
- Manejo apropiado de errores sin exponer información sensible

## 🏗️ Arquitectura

### Modelos

#### ModelUser.php
Gestiona la lógica de negocio relacionada con usuarios:
- **Constructor:** Inicializa la conexión a la base de datos
- **insertar($array):** Registra un nuevo usuario con contraseña encriptada
- **verificar($usuario, $contrasena):** Verifica las credenciales de un usuario

#### ModelProductos.php
Gestiona la lógica de negocio relacionada con productos:
- **obtenerTodos():** Obtiene todos los productos de la base de datos
- **obtenerPorId($id):** Obtiene un producto específico por su ID
- **insertar($array):** Inserta un nuevo producto
- **actualizar($array):** Actualiza un producto existente
- **eliminar($id):** Elimina un producto por su ID

### Configuración (db.php)

Clase Database que maneja la conexión a MySQL mediante PDO con:
- Manejo de errores mediante try-catch
- Modo de error PDO en modo excepción
- Respuestas JSON en caso de error de conexión

### Endpoints

#### Autenticación (login.php, register.php, home.php)
Controladores que:
- Reciben peticiones POST con datos JSON
- Validan los datos recibidos
- Interactúan con el modelo para realizar operaciones
- Retornan respuestas HTTP apropiadas en formato JSON
- Redirigen al panel de administración tras login exitoso

#### Gestión de Productos (produc/*)
Controladores CRUD que:
- Soportan métodos GET y POST según el endpoint
- Validan datos de entrada
- Realizan operaciones CRUD en la base de datos
- Incluyen enlaces HATEOAS en el listado
- Retornan datos completos del producto en cada operación

## 🛠️ Desarrollo

### Agregar nuevos endpoints

1. Crear archivo en `endpoints/` o en una subcarpeta apropiada
2. Incluir el modelo necesario desde `app/`
3. Implementar validaciones de datos
4. Manejar respuestas con códigos HTTP apropiados
5. Retornar siempre respuestas en formato JSON

### Extender los modelos

**Ejemplo - Agregar método en ModelUser.php:**
```php
public function obtenerPorId($id) {
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
```

**Ejemplo - Agregar método en ModelProductos.php:**
```php
public function buscarPorNombre($nombre) {
    $sql = "SELECT * FROM productos WHERE nombre LIKE :nombre";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':nombre' => "%$nombre%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 👨‍💻 Autores

**Desarrollado por:**
- Arnaldo Pushaina
- Elkin Granados
- Juan Pablo Hernandez

**ADSO - GRUPO 5 FICHA 3070294**

**Evidencias:**
- RAP 17: GA7-220501096-AA5-EV01 - Diseño y desarrollo de servicios web
- RAP17_GA7_AA5_EV02_IVO - API

---

## 🚀 Mejoras Futuras

Para un entorno de producción, considera implementar:
- ✅ Tokens JWT para autenticación persistente
- ✅ Middleware de autenticación en endpoints de productos
- ✅ Rate limiting para prevenir abuso
- ✅ HTTPS obligatorio
- ✅ Logs de actividad y auditoría
- ✅ Validaciones más robustas con librerías especializadas
- ✅ Paginación en listado de productos
- ✅ Búsqueda y filtros avanzados
- ✅ Subida de imágenes de productos
- ✅ Sistema de roles y permisos

---

**Nota:** Este proyecto es para fines educativos y de desarrollo. Desarrollado con ❤️ para aprender desarrollo de APIs REST en PHP.