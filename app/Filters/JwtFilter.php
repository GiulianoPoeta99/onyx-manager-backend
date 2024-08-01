<?php

namespace Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('JWT_SECRET');
        $header = $request->getHeaderLine("Authorization");
        $token = null;

        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        if (is_null($token) || empty($token)) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Token no proporcionado'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $request->decoded = $decoded;
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Token inválido'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
