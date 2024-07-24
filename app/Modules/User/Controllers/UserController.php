<?php namespace Modules\User\Controllers;

use Core\Controllers\BaseController;
use Modules\User\Services\UserService;
use Modules\User\Repositories\UserRepository;
use Modules\User\Models\User;

class UserController extends BaseController
{
    protected function initService(): void
    {
        $this->service = new UserService(new UserRepository(new User(), \Config\Services::validation()));
    }

    public function register()
    {
        $data = $this->getRequestInput();
        $user = $this->service->create($data);

        if ($user === null) {
            return $this->respondValidationErrors($this->service->getErrors());
        }

        return $this->respondCreated($user);
    }

    public function login()
    {
        $data = $this->getRequestInput();
        $user = $this->service->authenticateUser($data['email'] ?? '', $data['password'] ?? '');

        if ($user === null) {
            return $this->respondUnauthorized('Credenciales inválidas');
        }

        // Aquí podrías generar un token JWT si estás usando autenticación basada en tokens
        return $this->respondSuccess(['user' => $user, 'token' => 'JWT_TOKEN_HERE']);
    }
}