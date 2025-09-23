<?php

namespace Bahraz\Framework\Core;

class Path
{
    public static function app(string $path = ''): string
    {
        return dirname(__DIR__, 1) . ($path ? '/' . ltrim($path, '/') : '');
    }
}
