# Railway Deployment Guide

## Variables de Entorno Requeridas

En Railway, debes configurar las siguientes variables de entorno:

### Base de Datos MySQL
1. `DB_HOST` - Host de la base de datos (ejemplo: `containers-us-west-123.railway.app`)
2. `DB_NAME` - Nombre de la base de datos (ejemplo: `railway`)
3. `DB_USER` - Usuario de la base de datos
4. `DB_PASSWORD` - Contraseña de la base de datos

## Pasos para Desplegar en Railway

### 1. Preparar el Repositorio
```bash
git init
git add .
git commit -m "Initial commit for Railway deployment"
```

### 2. Crear Proyecto en Railway
1. Ve a [Railway.app](https://railway.app)
2. Haz clic en "New Project"
3. Selecciona "Deploy from GitHub repo"
4. Autoriza Railway y selecciona tu repositorio

### 3. Añadir Base de Datos MySQL
1. En tu proyecto de Railway, haz clic en "+ New"
2. Selecciona "Database" → "Add MySQL"
3. Railway creará automáticamente las variables de entorno

### 4. Configurar Variables de Entorno
Railway automáticamente crea:
- `MYSQL_URL`
- `MYSQL_HOST` (úsala como `DB_HOST`)
- `MYSQL_DATABASE` (úsala como `DB_NAME`)
- `MYSQL_USER` (úsala como `DB_USER`)
- `MYSQL_PASSWORD` (úsala como `DB_PASSWORD`)

O configura manualmente en Settings → Variables:
```
DB_HOST=containers-us-west-123.railway.app
DB_NAME=railway
DB_USER=root
DB_PASSWORD=tu_password_generado
```

### 5. Crear las Tablas en la Base de Datos

Conéctate a tu base de datos de Railway y ejecuta:

```sql
-- Tabla de usuarios
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(100) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

-- Usuario de ejemplo (usuario: admin, contraseña: password)
INSERT INTO usuarios (usuario, contrasena) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, stock) VALUES
('Laptop HP', 'Laptop HP Core i5, 8GB RAM, 256GB SSD', 2500.00, 10),
('Mouse Logitech', 'Mouse inalámbrico Logitech M185', 45.00, 50),
('Teclado Mecánico', 'Teclado mecánico RGB retroiluminado', 150.00, 25);
```

### 6. Desplegar
Railway automáticamente detectará el `Dockerfile` y construirá tu aplicación.

## Endpoints en Producción

Una vez desplegado, tus endpoints serán:

```
https://tu-app.railway.app/
https://tu-app.railway.app/endpoints/login.php
https://tu-app.railway.app/endpoints/register.php
https://tu-app.railway.app/endpoints/home.php
https://tu-app.railway.app/endpoints/produc/listar.php
```

## Probar la API en Producción

```bash
# Registrar usuario
curl -X POST https://tu-app.railway.app/endpoints/register.php \
  -H "Content-Type: application/json" \
  -d '{"usuario":"testuser","contrasena":"test123"}'

# Login
curl -X POST https://tu-app.railway.app/endpoints/login.php \
  -H "Content-Type: application/json" \
  -d '{"usuario":"testuser","contrasena":"test123"}'

# Listar productos
curl https://tu-app.railway.app/endpoints/produc/listar.php
```

## Solución de Problemas

### Error de Conexión a Base de Datos
- Verifica que las variables de entorno estén configuradas correctamente
- Asegúrate de que el servicio MySQL esté activo
- Revisa los logs en Railway: Settings → Deployments → View Logs

### Puerto Incorrecto
- Railway asigna automáticamente el puerto mediante la variable `$PORT`
- El `docker-entrypoint.sh` maneja esto automáticamente

### Archivos No Encontrados
- Verifica que el `.htaccess` esté incluido en el repositorio
- Asegúrate de que la estructura de carpetas sea correcta

## Monitoreo

Railway proporciona:
- Logs en tiempo real
- Métricas de uso de recursos
- Estado del deployment
- Variables de entorno

## Costos

Railway ofrece:
- Plan gratuito con $5 de crédito mensual
- Uso por minuto de CPU y memoria
- Base de datos MySQL incluida en el plan

## Actualizar la Aplicación

```bash
git add .
git commit -m "Update features"
git push origin main
```

Railway automáticamente detectará los cambios y redesplegará la aplicación.
