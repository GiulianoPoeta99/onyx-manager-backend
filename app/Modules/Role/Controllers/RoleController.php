<?php

namespace Modules\Role\Controllers;

use Libraries\BaseController;
use Modules\Role\Entities\Role;

class RoleController extends BaseController
{
    protected $modelName = 'Modules\Role\Models\RoleModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('Role no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new Role($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'Role creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Role no encontrado');
        }

        $entity = new Role($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'Role actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Role no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'Role eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el role');
    }
}
