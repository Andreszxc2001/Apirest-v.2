# API REST - Sistema de Autenticación de Usuarios

API REST desarrollada en PHP para gestionar el registro e inicio de sesión de usuarios con autenticación segura mediante encriptación de contraseñas.

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
- 🔑 Sistema de inicio de sesión seguro
- 📊 Arquitectura MVC (Model-View-Controller)
- 🗄️ Conexión a base de datos MySQL mediante PDO
- ⚡ Respuestas en formato JSON
- 🛡️ Manejo de errores y validaciones

## 📁 Estructura del Proyecto

```
APIREST/
│
├── app/
│   └── ModelUser.php          # Modelo de usuario con lógica de negocio
│
├── config/
│   └── db.php                 # Configuración de conexión a base de datos
│
├── endpoints/
│   ├── login.php              # Endpoint de inicio de sesión
│   └── register.php           # Endpoint de registro de usuarios
│
├── sql/
│   └── db.sql                 # Script de creación de base de datos
│
├── index.php                  # Archivo principal
└── README.MD                  # Documentación del proyecto
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

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(100) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL
);

-- Usuario de ejemplo
INSERT INTO usuarios (usuario, contrasena) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
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

### 1. Registro de Usuario

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

### 2. Inicio de Sesión

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
  "mensaje": "Autenticación satisfactoria."
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

**Login:**
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
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

## 🔒 Seguridad

- Las contraseñas se almacenan encriptadas usando **BCrypt** (PASSWORD_BCRYPT)
- Se utiliza **PDO con prepared statements** para prevenir inyección SQL
- Validación de datos de entrada en todos los endpoints
- Manejo apropiado de errores sin exponer información sensible

## 🏗️ Arquitectura

### Modelo (ModelUser.php)

Gestiona la lógica de negocio relacionada con usuarios:

- **Constructor:** Inicializa la conexión a la base de datos
- **insertar($array):** Registra un nuevo usuario con contraseña encriptada
- **verificar($usuario, $contrasena):** Verifica las credenciales de un usuario

### Configuración (db.php)

Clase Database que maneja la conexión a MySQL mediante PDO con:
- Manejo de errores mediante try-catch
- Modo de error PDO en modo excepción
- Respuestas JSON en caso de error de conexión

### Endpoints (login.php y register.php)

Controladores que:
- Reciben peticiones POST con datos JSON
- Validan los datos recibidos
- Interactúan con el modelo para realizar operaciones
- Retornan respuestas HTTP apropiadas en formato JSON

## 🛠️ Desarrollo

### Agregar nuevos endpoints

1. Crear archivo en `endpoints/`
2. Incluir el modelo necesario
3. Implementar validaciones
4. Manejar respuestas con códigos HTTP apropiados

### Extender el modelo

Agregar nuevos métodos en `app/ModelUser.php`:

```php
public function obtenerPorId($id) {
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
```

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 👨‍💻 Autor

Desarrollado con ❤️ para aprender desarrollo de APIs REST en PHP.

---

**Nota:** Este proyecto es para fines educativos y de desarrollo. Para producción, considera implementar:
- Tokens JWT para autenticación
- Rate limiting
- HTTPS obligatorio
- Logs de actividad
- Validaciones más robustas