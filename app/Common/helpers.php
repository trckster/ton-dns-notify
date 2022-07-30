<?php

function env(string $envKey): ?string
{
    return $_ENV[$envKey] ?? null;
}

function getDatabaseEnv(): array
{
    return [
        'host' => env('MYSQL_HOST'),
        'port' => env('MYSQL_PORT'),
        'user' => env('MYSQL_USER'),
        'password' => env('MYSQL_PASSWORD'),
        'database' => env('MYSQL_DATABASE'),
    ];
}

function getBaseDir(string $subDir = ''): string
{
    return __DIR__ . '/../../' . $subDir;
}