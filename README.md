# onyx-manager-backend

## Dependencia

### Docker

* Docker
* Docker compose

### Local

* PHP v8.3.9
* Composer v2.7.6
* php-pgsql

## Configuracion

* Copiamos el .env.sample a .env
* Elegimos el entorno de la app
* Configuramos las credenciales de la db

## Migraciones

* Crear migracion:

    ```bash
    php spark make:migration <nombre_migracion> --namespace "<namespace donde va el archivo>"

    # ejemplo
    php spark make:migration create_users_table --namespace "Modules/User"
    ```
    Luego hay que hacer a mano la migracion.

* Hacer migracion:

    ```bash
    php spark migrate --all 
    ```
    Esto hace todas las migraciones que encuentre en App\

* Deshacer ultima migración:

    ```bash
    php spark migrate:roolback
    ```

* Ver migraciones:

    ```bash
    php spark migrate:status
    ```

## Seeders

* Crear seeder:

    ```bash
    php spark make:seeder NombreDelSeeder

    # ejemplo
    php spark make:seeder UserSeeder
    ```
* Hacer seeder:

    ```bash
    php spark db:seed UserSeeder
    ```

## Cache

* Limpiar cahe:

    ```bash
    php spark cache:clear
    ```
* Información:

    ```bash
    php spark cache:info
    ```

## Keys

* Generar key:

    ```bash
    php spark key:generate 
    ```

## Encender para dev con docker

```bash
docker compose up -d dev
```

## Apagar para dev con docker

```bash
docker compose down dev
```

## Encender para dev local

```bash
php spark serve
```
