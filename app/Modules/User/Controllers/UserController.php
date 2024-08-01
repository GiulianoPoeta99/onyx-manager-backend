<?php

namespace Modules\User\Controllers;

use Libraries\BaseController;
use Modules\User\Entities\User;
use Firebase\JWT\JWT;

class UserController extends BaseController
{
    protected $modelName = 'Modules\User\Models\UserModel';

    public function index()
    {
        return $this->respondSuccess($this->model->findAll());
    }

    public function show($id = null)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->respondNotFound('Usuario no encontrado');
        }
        return $this->respondSuccess($model);
    }

    public function create()
    {
        $data = $this->getRequestInput();

        $entity = new User($data);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'Usuario creado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();

        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Usuario no encontrado');
        }

        $entity = new User($data);
        $entity->setId($id);

        if ($this->model->save($entity)) {
            return $this->respondSuccess($entity, 'Usuario actualizado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $existingEntity = $this->model->find($id);
        if ($existingEntity === null) {
            return $this->respondNotFound('Usuario no encontrado');
        }

        if ($this->model->delete($id)) {
            return $this->respondSuccess(null, 'Usuario eliminado exitosamente');
        }

        return $this->respondServerError('Error al eliminar el usuario');
    }

    public function register()
    {
        $data = $this->getRequestInput();

        $entity = new User($data);
        $entity->setPassword($data['password']);

        if ($this->model->save($entity)) {
            return $this->respondCreated($entity, 'Usuario registrado exitosamente');
        }

        return $this->respondValidationErrors($this->model->errors());
    }

    public function login()
    {
        $data = $this->getRequestInput();

        $user = $this->model->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user->getPassword())) {
            return $this->respondUnauthorized('Credenciales inválidas');
        }

        $key = getenv('JWT_SECRET');
        $payload = [
            'iss' => 'onyx',
            'aud' => 'backend',
            'iat' => time(),
            'exp' => time() + 3600,
            'uid' => $user->getId(),
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respondSuccess(['token' => $token], 'Login exitoso');
    }
}
