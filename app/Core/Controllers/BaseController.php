<?php namespace Core\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Core\Traits\RequestTrait;
use Core\Services\BaseService;

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
            return $this->respondNotFound('No se encontró el recurso');
        }
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->getRequestInput();
        $result = $this->service->create($data);
        if ($result === null) {
            return $this->respondValidationErrors($this->service->getErrors());
        }
        return $this->respondCreated($result);
    }

    public function update($id = null)
    {
        $data = $this->getRequestInput();
        $result = $this->service->update($id, $data);
        if ($result === null) {
            return $this->respondValidationErrors($this->service->getErrors());
        }
        return $this->respond($result);
    }

    public function delete($id = null)
    {
        $result = $this->service->delete($id);
        if (!$result) {
            return $this->respondError('No se pudo eliminar el recurso');
        }
        return $this->respondNoContent();
    }
}