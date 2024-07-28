<?php

namespace Helpers;

use CodeIgniter\HTTP\ResponseInterface;

trait RequestTrait
{
    protected function getRequestInput()
    {
        return $this->request->getJSON(true);
    }

    private function sendResponse(bool $success, $data = null, ?string $message = null, int $code = 200): ResponseInterface
    {
        $response = [
            'status' => $success ? 'success' : 'error',
            'message' => $message,
            'data' => $data
        ];

        // Eliminar campos nulos
        $response = array_filter($response, function ($value) {
            return $value !== null;
        });

        return $this->response->setStatusCode($code)->setJSON($response);
    }

    protected function respondSuccess($data = null, ?string $message = null, int $code = 200): ResponseInterface
    {
        return $this->sendResponse(true, $data, $message, $code);
    }

    protected function respondError($data = null, string $message, int $code = 400,): ResponseInterface
    {
        return $this->sendResponse(false, $data, $message, $code);
    }

    protected function respondCreated($data = null, ?string $message = 'Resource created successfully'): ResponseInterface
    {
        return $this->sendResponse(true, $data, $message, 201);
    }

    protected function respondNoContent(?string $message = 'No content'): ResponseInterface
    {
        return $this->sendResponse(true, null, $message, 204);
    }

    protected function respondNotFound(?string $message = 'Resource not found'): ResponseInterface
    {
        return $this->sendResponse(false, null, $message, 404);
    }

    protected function respondValidationErrors(array $errors): ResponseInterface
    {
        return $this->sendResponse(false, $errors, 'Validation errors', 422);
    }

    protected function respondForbidden(?string $message = 'Forbidden'): ResponseInterface
    {
        return $this->sendResponse(false, null, $message, 403);
    }

    protected function respondUnauthorized(?string $message = 'Unauthorized'): ResponseInterface
    {
        return $this->sendResponse(false, null, $message, 401);
    }

    protected function respondServerError(?string $message = 'Internal server error'): ResponseInterface
    {
        return $this->sendResponse(false, null, $message, 500);
    }
}
