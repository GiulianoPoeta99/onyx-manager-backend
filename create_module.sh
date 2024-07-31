#!/bin/bash

# Función para convertir snake_case a PascalCase
to_pascal_case() {
    echo "$1" | sed -r 's/(^|_)([a-z])/\U\2/g'
}

# Función para crear un archivo con contenido básico
create_file() {
    local file_path="$1"
    local file_content="$2"
    mkdir -p "$(dirname "$file_path")"
    echo "$file_content" > "$file_path"
}

# Directorio base del proyecto
BASE_DIR="./app/Modules"

# Verificar si el directorio base existe
if [ ! -d "$BASE_DIR" ]; then
    echo "Error: El directorio $BASE_DIR no existe."
    exit 1
fi

# Cambiar al directorio base
cd "$BASE_DIR" || exit 1

# Solicitar el nombre del módulo en snake_case
read -p "Ingrese el nombre del módulo en snake_case (por ejemplo, user): " MODULE_NAME_SNAKE

# Validar la entrada
if [[ ! $MODULE_NAME_SNAKE =~ ^[a-z_]+$ ]]; then
    echo "Error: El nombre del módulo debe estar en snake_case (solo letras minúsculas y guiones bajos)."
    exit 1
fi

# Convertir a PascalCase
MODULE_NAME=$(to_pascal_case "$MODULE_NAME_SNAKE")

# Crear archivos con contenido básico
create_file "$MODULE_NAME/Config/Routes.php" "<?php

\$routes->group('$MODULE_NAME_SNAKE', ['namespace' => 'Modules\\\\$MODULE_NAME\\\\Controllers'], function(\$routes) {
    \$routes->get('', '${MODULE_NAME}Controller::index');
    \$routes->get('(:num)', '${MODULE_NAME}Controller::show/\$1');
    \$routes->post('', '${MODULE_NAME}Controller::create');
    \$routes->put('(:num)', '${MODULE_NAME}Controller::update/\$1');
    \$routes->delete('(:num)', '${MODULE_NAME}Controller::delete/\$1');
});"

create_file "$MODULE_NAME/Controllers/${MODULE_NAME}Controller.php" "<?php

namespace Modules\\$MODULE_NAME\Controllers;

use Libraries\BaseController;
use Modules\\$MODULE_NAME\Entities\\$MODULE_NAME;

class ${MODULE_NAME}Controller extends BaseController
{
    protected \$modelName = 'Modules\\\\$MODULE_NAME\\\\Models\\\\${MODULE_NAME}Model';

    public function index()
    {
        return \$this->respondSuccess(\$this->model->findAll());
    }

    public function show(\$id = null)
    {
        \$model = \$this->model->find(\$id);
        if (\$model === null) {
            return \$this->respondNotFound('$MODULE_NAME no encontrado');
        }
        return \$this->respondSuccess(\$model);
    }

    public function create()
    {
        \$data = \$this->getRequestInput();

        \$entity = new $MODULE_NAME(\$data);

        if (\$this->model->save(\$entity)) {
            return \$this->respondCreated(\$entity, '$MODULE_NAME creado exitosamente');
        }

        return \$this->respondValidationErrors(\$this->model->errors());
    }

    public function update(\$id = null)
    {
        \$data = \$this->getRequestInput();

        \$existingEntity = \$this->model->find(\$id);
        if (\$existingEntity === null) {
            return \$this->respondNotFound('$MODULE_NAME no encontrado');
        }

        \$entity = new $MODULE_NAME(\$data);
        \$entity->setId(\$id);

        if (\$this->model->save(\$entity)) {
            return \$this->respondSuccess(\$entity, '$MODULE_NAME actualizado exitosamente');
        }

        return \$this->respondValidationErrors(\$this->model->errors());
    }

    public function delete(\$id = null)
    {
        \$existingEntity = \$this->model->find(\$id);
        if (\$existingEntity === null) {
            return \$this->respondNotFound('$MODULE_NAME no encontrado');
        }

        if (\$this->model->delete(\$id)) {
            return \$this->respondSuccess(null, '$MODULE_NAME eliminado exitosamente');
        }

        return \$this->respondServerError('Error al eliminar el $MODULE_NAME_SNAKE');
    }
}"

create_file "$MODULE_NAME/Database/Migrations/$(date +%Y-%m-%d-%H%M%S)_Create${MODULE_NAME}Table.php" "<?php

namespace Modules\\$MODULE_NAME\Database\Migrations;

use CodeIgniter\Database\Migration;

class Create${MODULE_NAME}Table extends Migration
{
    public function up()
    {
        // Lógica para crear la tabla
    }

    public function down()
    {
        // Lógica para eliminar la tabla
    }
}"

create_file "$MODULE_NAME/Entities/${MODULE_NAME}.php" "<?php 

namespace Modules\\$MODULE_NAME\Entities;

use CodeIgniter\Entity\Entity;

class $MODULE_NAME extends Entity
{
    protected \$casts = [
        'id' => 'integer',
        // Completar con los casts necesarios
    ];

    public function getId()
    {
        return \$this->attributes['id'] ?? null;
    }

    public function setId(int \$id)
    {
        \$this->attributes['id'] = \$id;
    }
}"

create_file "$MODULE_NAME/Models/${MODULE_NAME}Model.php" "<?php 

namespace Modules\\$MODULE_NAME\Models;

use CodeIgniter\Model;
use Modules\\$MODULE_NAME\Entities\\$MODULE_NAME;

class ${MODULE_NAME}Model extends Model
{
    protected \$table = '$MODULE_NAME_SNAKE';
    protected \$primaryKey = 'id';
    protected \$useAutoIncrement = true;
    protected \$returnType = $MODULE_NAME::class;
    protected \$allowedFields = []; // Completar con los campos permitidos

    protected \$validationRules = [];

    protected \$validationMessages = [];

    protected \$skipValidation = false;
}"

echo "Módulo $MODULE_NAME creado con éxito."

cd ../..