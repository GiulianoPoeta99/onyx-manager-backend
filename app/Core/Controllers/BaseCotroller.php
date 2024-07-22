<?php namespace App\Core\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Core\Traits\RequestTrait;
use App\Core\Services\BaseService;

abstract class BaseController extends ResourceController
{
    use RequestTrait;

    protected $format = 'json';
    protected BaseService $service;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $this->initService();
    }

    abstract protected function initService(): void;

    public function index()
    {
        $data = $this->service->getAll();
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->service->getById($id);
        if ($data === null) {
            return $this->failNotFound('No se encontró el recurso');
        }
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->getRequestInput();
        $result = $this->service->create($data);
        if ($result === false) {
            return $this->fail($this->service->getErrors());
        }
        return $this->respondCreated($result);
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();
        $result = $this->service->update($id, $data);
        if ($result === false) {
            return $this->fail($this->service->getErrors());
        }
        return $this->respond($result);
    }

    public function delete($id = null)
    {
        $result = $this->service->delete($id);
        if ($result === false) {
            return $this->fail($this->service->getErrors());
        }
        return $this->respondDeleted(['id' => $id]);
    }

    protected function failValidation(array $errors)
    {
        return $this->fail($errors, 422);
    }
}