<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateModule extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'make:module';
    protected $description = 'Crea un nuevo módulo para la aplicación';
    protected $aliases     = ['make:module'];

    public function run(array $params)
    {
        // Directorio base del proyecto
        $baseDir = APPPATH . 'Modules';

        // Verificar si el directorio base existe
        if (!is_dir($baseDir)) {
            CLI::error("Error: El directorio $baseDir no existe.");
            return;
        }

        // Solicitar el nombre del módulo en snake_case
        $moduleNameSnake = CLI::prompt('Ingrese el nombre del módulo en snake_case (por ejemplo, user)');

        // Validar la entrada
        if (!preg_match('/^[a-z_]+$/', $moduleNameSnake)) {
            CLI::error("Error: El nombre del módulo debe estar en snake_case (solo letras minúsculas y guiones bajos).");
            return;
        }

        // Convertir a PascalCase
        $moduleName = $this->toPascalCase($moduleNameSnake);

        // Crear archivos con contenido básico
        $this->createFile("$baseDir/$moduleName/Config/Routes.php", $this->getRoutesContent($moduleNameSnake, $moduleName));
        $this->createFile("$baseDir/$moduleName/Controllers/{$moduleName}Controller.php", $this->getControllerContent($moduleName, $moduleNameSnake));
        $this->createFile("$baseDir/$moduleName/Database/Migrations/" . date('Y-m-d-His') . "_Create{$moduleName}Table.php", $this->getMigrationContent($moduleName));
        $this->createFile("$baseDir/$moduleName/Entities/{$moduleName}.php", $this->getEntityContent($moduleName));
        $this->createFile("$baseDir/$moduleName/Models/{$moduleName}Model.php", $this->getModelContent($moduleName, $moduleNameSnake));
        $this->updateMainRoutes($moduleName);

        CLI::write("Módulo $moduleName creado con éxito.", 'green');
    }

    private function toPascalCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    private function createFile($filePath, $fileContent)
    {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($filePath, $fileContent);
    }

    private function getRoutesContent($moduleNameSnake, $moduleName)
    {
        return "<?php

\$routes->group('$moduleNameSnake', ['namespace' => 'Modules\\$moduleName\\Controllers', 'filter' => 'jwt'], function(\$routes) {
    \$routes->get('', '{$moduleName}Controller::index');
    \$routes->get('(:num)', '{$moduleName}Controller::show/$1');
    \$routes->post('', '{$moduleName}Controller::create');
    \$routes->put('(:num)', '{$moduleName}Controller::update/$1');
    \$routes->delete('(:num)', '{$moduleName}Controller::delete/$1');
});";
    }

    private function getControllerContent($moduleName, $moduleNameSnake)
    {
        return "<?php

namespace Modules\\$moduleName\Controllers;

use Libraries\BaseController;
use Modules\\$moduleName\Entities\\$moduleName;

class {$moduleName}Controller extends BaseController
{
    protected \$modelName = 'Modules\\$moduleName\\Models\\{$moduleName}Model';

    public function index()
    {
        return \$this->respondSuccess(\$this->model->findAll());
    }

    public function show(\$id = null)
    {
        \$model = \$this->model->find(\$id);
        if (\$model === null) {
            return \$this->respondNotFound('$moduleName no encontrado');
        }
        return \$this->respondSuccess(\$model);
    }

    public function create()
    {
        \$data = \$this->getRequestInput();

        \$entity = new $moduleName(\$data);

        if (\$this->model->save(\$entity)) {
            return \$this->respondCreated(\$entity, '$moduleName creado exitosamente');
        }

        return \$this->respondValidationErrors(\$this->model->errors());
    }

    public function update(\$id = null)
    {
        \$data = \$this->getRequestInput();

        \$existingEntity = \$this->model->find(\$id);
        if (\$existingEntity === null) {
            return \$this->respondNotFound('$moduleName no encontrado');
        }

        \$entity = new $moduleName(\$data);
        \$entity->setId(\$id);

        if (\$this->model->save(\$entity)) {
            return \$this->respondSuccess(\$entity, '$moduleName actualizado exitosamente');
        }

        return \$this->respondValidationErrors(\$this->model->errors());
    }

    public function delete(\$id = null)
    {
        \$existingEntity = \$this->model->find(\$id);
        if (\$existingEntity === null) {
            return \$this->respondNotFound('$moduleName no encontrado');
        }

        if (\$this->model->delete(\$id)) {
            return \$this->respondSuccess(null, '$moduleName eliminado exitosamente');
        }

        return \$this->respondServerError('Error al eliminar el $moduleNameSnake');
    }
}";
    }

    private function getMigrationContent($moduleName)
    {
        return "<?php

namespace Modules\\$moduleName\Database\Migrations;

use CodeIgniter\Database\Migration;

class Create{$moduleName}Table extends Migration
{
    public function up()
    {
        // Lógica para crear la tabla
    }

    public function down()
    {
        // Lógica para eliminar la tabla
    }
}";
    }

    private function getEntityContent($moduleName)
    {
        return "<?php 

namespace Modules\\$moduleName\Entities;

use CodeIgniter\Entity\Entity;

class $moduleName extends Entity
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
}";
    }

    private function getModelContent($moduleName, $moduleNameSnake)
    {
        return "<?php 

namespace Modules\\$moduleName\Models;

use CodeIgniter\Model;
use Modules\\$moduleName\Entities\\$moduleName;

class {$moduleName}Model extends Model
{
    protected \$table = '$moduleNameSnake';
    protected \$primaryKey = 'id';
    protected \$useAutoIncrement = true;
    protected \$returnType = $moduleName::class;
    protected \$allowedFields = []; // Completar con los campos permitidos

    protected \$validationRules = [];

    protected \$validationMessages = [];

    protected \$skipValidation = false;
}";
    }

    private function updateMainRoutes($moduleName)
    {
        $routesFile = APPPATH . 'Config/Routes.php';
        $content = file_get_contents($routesFile);

        // Buscar la última línea de require dentro del grupo 'api'
        $pattern = "/(\s+require ROOTPATH . 'app\/Modules\/.*\/Config\/Routes.php';)\n(\s*}\);)/";
        if (preg_match($pattern, $content, $matches)) {
            $lastRequire = $matches[1];
            $closing = $matches[2];

            // Crear la nueva línea a insertar
            $newLine = "\n    require ROOTPATH . 'app/Modules/$moduleName/Config/Routes.php';";

            // Reemplazar en el contenido
            $newContent = str_replace(
                $lastRequire . "\n" . $closing,
                $lastRequire . $newLine . "\n" . $closing,
                $content
            );

            // Escribir el contenido actualizado
            file_put_contents($routesFile, $newContent);

            CLI::write("Ruta del módulo añadida al archivo de rutas principal.", 'green');
        } else {
            CLI::error("No se pudo encontrar el lugar adecuado para insertar la nueva ruta en el archivo de rutas principal.");
        }
    }
}
