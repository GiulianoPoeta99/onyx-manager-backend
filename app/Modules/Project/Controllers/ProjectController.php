<?php

namespace Modules\Project\Controllers;

use Libraries\BaseController;
use Modules\Project\Entities\Project;

class ProjectController extends BaseController
{
    protected $modelName = 'Modules\Project\Models\ProjectModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('Proyecto no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new Project($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'Proyecto creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Proyecto no encontrado');
        }

        $entity = new Project($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'Proyecto actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Proyecto no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'Proyecto eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el usuario');
    }
}
