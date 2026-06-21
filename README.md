# SURDEV - Sistema de Gestión de Flota Industrial

SURDEV es una aplicación web desarrollada como Proyecto Integrador Final para la Tecnicatura Superior en Desarrollo de Software del IFTS N° 29.

El sistema permite administrar equipos industriales, registrar horómetros, mantenimientos preventivos, órdenes de reparación, órdenes de trabajo, presupuestos, facturas, costos, indisponibilidades y reportes económicos.

## Tecnologías utilizadas

* PHP 8.2
* MySQL / MariaDB
* Apache
* XAMPP
* HTML5
* CSS3
* Bootstrap 5
* JavaScript
* Composer
* PHPUnit 11.5.55

## Requisitos previos

Antes de ejecutar el proyecto se debe contar con:

* XAMPP instalado.
* Apache y MySQL disponibles.
* Composer instalado.
* Navegador web actualizado.

## Instalación del proyecto

1. Descargar o clonar el repositorio.

2. Copiar la carpeta del proyecto dentro del directorio:

```text
C:\xampp\htdocs\
```

La ruta final debería quedar:

```text
C:\xampp\htdocs\surdev
```

3. Iniciar Apache y MySQL desde el panel de control de XAMPP.

## Configuración de la base de datos

1. Abrir phpMyAdmin desde el navegador:

```text
http://localhost/phpmyadmin
```

2. Crear una base de datos llamada:

```text
surdev_db
```

3. Importar el archivo SQL incluido en la entrega:

```text
surdev_db_final.sql
```

## Configuración de conexión

Verificar el archivo:

```text
config/database.php
```

Configuración esperada para XAMPP local:

```php
$host = "localhost";
$dbname = "surdev_db";
$user = "root";
$password = "";
```

## Instalación de dependencias

Abrir una terminal dentro de la carpeta raíz del proyecto:

```text
C:\xampp\htdocs\surdev
```

Ejecutar:

```bash
composer install
```

Este comando instalará las dependencias necesarias definidas en `composer.json`.

## Ejecución del sistema

Una vez completada la instalación, acceder desde el navegador a:

```text
http://localhost/surdev
```

## Credenciales de prueba

```text
Usuario: admin@surdev.com
Contraseña: admin123
```

## Pruebas unitarias

El proyecto incluye pruebas unitarias implementadas con PHPUnit.

Para ejecutarlas, abrir una terminal en la raíz del proyecto y ejecutar:

```bash
C:\xampp\php\php.exe vendor\phpunit\phpunit\phpunit
```

Resultado esperado:

```text
OK (10 tests, 10 assertions)
```

## Estructura general del proyecto

```text
surdev/
├── assets/
├── config/
├── controllers/
├── helpers/
├── middleware/
├── modules/
├── partials/
├── tests/
├── tools/
├── views/
├── composer.json
├── composer.lock
├── phpunit.xml
└── index.php
```

## Módulos principales

* Gestión de equipos.
* Gestión de operaciones, negocios, sites y proveedores.
* Registro de horómetros.
* Gestión de mantenimientos preventivos.
* Órdenes de reparación.
* Órdenes de trabajo.
* Presupuestos y facturas.
* Costos operativos.
* Indisponibilidades.
* Reportes económicos.
* Configuraciones generales.

## Documentación

La entrega incluye documentación en PDF con:

* Manual Técnico.
* Manual de Usuario.
* DER.
* Evidencia de pruebas unitarias.
* Evidencia de pruebas de integración.
* Instrucciones de instalación y puesta en marcha.

## Observación

La carpeta `assets/uploads/` se entrega sin archivos sensibles. Los documentos e imágenes cargados por usuarios se generan durante el uso del sistema.
