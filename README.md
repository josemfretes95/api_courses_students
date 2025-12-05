## Requisitos

- PHP, cualquier version entre 8.2 y 8.5 (compatible con laravel 12).
- PostgreSQL 15 o superior.

## Configuración

Instalar dependencias
``` bash
composer install
```

Hacer una copia del archivo **.env.example** y renombrar a **.env**. Reemplazar los valores de las siguientes variables por los de la base de datos que se va a usar.
```
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
```

Migrar base de datos
``` bash
php artisan migrate
```

Generar clave de aplicación
``` bash
php artisan key:generate
```

Levantar el proyecto en modo desarrollo
``` bash
php artisan serve
```

Generar datos de prueba.
``` bash
php artisan db:seed
```

## Pruebas

Crear una base de datos de prueba. Hacer una copia del archivo **.env.example** y renombrar a **.env.testing**. Reemplazar los valores de las siguientes variables por los de la base de datos que se va a usar.
```
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
```

Ejecutar tests.
``` bash
php artisan test
```