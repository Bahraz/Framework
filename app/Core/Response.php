<?php

namespace Bahraz\Framework\Core;

class Response
{
    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    public static function success(array $data = [], string $message = 'OK', int $status = 200): void
    {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
    
    public static function error(array $data = [], string $message = 'NOK', int $status = 400): void
    {
        self::json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}