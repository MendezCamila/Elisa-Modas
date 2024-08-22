# Elisa Modas

Tienda de moda y accesorios que opera presencialmente, ofreciendo a los clientes una experiencia de compra personalizada con asesoramiento de empleados capacitados.

## Requisitos

- PHP >= 8.2.12
- Laravel Framework >= 11.10.0
- MariaDB >= 10.4.32
- Node.js >= v20.13.1
- Composer >= version 2.7.6

## Instalación

A continuación se detallan los pasos necesarios para instalar y configurar el proyecto.

### Paso 1: Clonar el Repositorio (si es aplicable)

```bash
git clone https://github.com/MendezCamila/Elisa-Modas
cd ElisaModas
```

### Paso 2: Instalar Dependencias de PHP con Composer
```
composer install
```

### Paso 3: Configurar la Base de Datos
Asegúrate de tener MariaDB instalado y configurado. Luego, crea una base de datos para el proyecto y actualiza las variables de entorno en el archivo .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elisamodas
DB_USERNAME=root
DB_PASSWORD=
```


### Paso 4: Instalar Dependencias de Node.js (si es aplicable)
```
npm install
```
### Paso 5: Ejecutar Migraciones y Semillas (si es aplicable)
```
php artisan migrate --seed
```




