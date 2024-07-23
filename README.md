# onyx-manager-backend

## Dependencia

* PHP v8.3.6
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

## Encender para dev

```bash
php spark serve
```