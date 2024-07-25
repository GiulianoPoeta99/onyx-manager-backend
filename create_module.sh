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

cd ./app/Modules

# Solicitar el nombre del módulo en snake_case
read -p "Ingrese el nombre del módulo en snake_case (por ejemplo, project_management): " MODULE_NAME_SNAKE

# Convertir a PascalCase
MODULE_NAME=$(to_pascal_case "$MODULE_NAME_SNAKE")

# Crear la estructura de directorios
mkdir -p "$MODULE_NAME"
mkdir -p "$MODULE_NAME/Config"
mkdir -p "$MODULE_NAME/Controllers"
mkdir -p "$MODULE_NAME/Database/Migrations"
mkdir -p "$MODULE_NAME/Entities"
mkdir -p "$MODULE_NAME/Models"
mkdir -p "$MODULE_NAME/Repositories"
mkdir -p "$MODULE_NAME/Services"

# Crear archivos con contenido básico
create_file "$MODULE_NAME/Config/Routes.php" "<?php

\$routes->group('$MODULE_NAME_SNAKE', ['namespace' => 'Modules\\\\$MODULE_NAME\\\\Controllers'], function(\$routes) {
    \$routes->get('', '${MODULE_NAME}Controller::index');
    \$routes->get('(:num)', '${MODULE_NAME}Controller::show/\$1');
    \$routes->post('', '${MODULE_NAME}Controller::create');
    \$routes->put('(:num)', '${MODULE_NAME}Controller::update/\$1');
    \$routes->delete('(:num)', '${MODULE_NAME}Controller::delete/\$1');
});"

create_file "$MODULE_NAME/Controllers/${MODULE_NAME}Controller.php" "<?php namespace Modules\\$MODULE_NAME\Controllers;

use Core\Controllers\BaseController;
use Modules\\$MODULE_NAME\Services\\${MODULE_NAME}Service;
use Modules\\$MODULE_NAME\Repositories\\${MODULE_NAME}Repository;
use Modules\\$MODULE_NAME\Models\\$MODULE_NAME;

class ${MODULE_NAME}Controller extends BaseController
{
    protected function initService(): void
    {
        \$this->service = new ${MODULE_NAME}Service(new ${MODULE_NAME}Repository(new $MODULE_NAME(), \Config\Services::validation()));
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

create_file "$MODULE_NAME/Entities/${MODULE_NAME}Entity.php" "<?php namespace Modules\\$MODULE_NAME\Entities;

use Core\Entities\BaseEntity;
use Core\Attributes\GetSet;

class ${MODULE_NAME}Entity extends BaseEntity
{
    protected \$casts = [
        'id' => 'integer',
    ];
}"

create_file "$MODULE_NAME/Models/${MODULE_NAME}.php" "<?php namespace Modules\\$MODULE_NAME\Models;

use Core\Models\BaseModel;
use Modules\\$MODULE_NAME\Entities\\${MODULE_NAME}Entity;

class $MODULE_NAME extends BaseModel
{
    protected \$table = '$MODULE_NAME_SNAKE';
    protected \$primaryKey = 'id';
    protected \$useAutoIncrement = true;
    protected \$returnType = ${MODULE_NAME}Entity::class;
    protected \$allowedFields = ['name']; // Ajusta según tus necesidades

    protected \$validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
    ];

    protected \$validationMessages = [
        'name' => [
            'required' => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 255 caracteres.'
        ],
    ];

    protected \$skipValidation = false;
}"

create_file "$MODULE_NAME/Repositories/${MODULE_NAME}Repository.php" "<?php namespace Modules\\$MODULE_NAME\Repositories;

use CodeIgniter\Validation\Validation;
use Core\Repositories\BaseRepository;
use Modules\\$MODULE_NAME\Models\\$MODULE_NAME;

class ${MODULE_NAME}Repository extends BaseRepository
{
    public function __construct($MODULE_NAME \$model, Validation \$validator)
    {
        parent::__construct(\$model, \$validator);
    }
}"

create_file "$MODULE_NAME/Services/${MODULE_NAME}Service.php" "<?php namespace Modules\\$MODULE_NAME\Services;

use Core\Services\BaseService;
use Modules\\$MODULE_NAME\Repositories\\${MODULE_NAME}Repository;
use Modules\\$MODULE_NAME\Entities\\${MODULE_NAME}Entity;

class ${MODULE_NAME}Service extends BaseService
{
    public function __construct(${MODULE_NAME}Repository \$repository)
    {
        parent::__construct(\$repository);
    }
}"

echo "Módulo $MODULE_NAME creado con éxito."

cd ../..