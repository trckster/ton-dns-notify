<?php

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

function env(string $envKey): ?string
{
    return $_ENV[$envKey] ?? null;
}

function getDatabaseEnv(bool $forDoctrine = false): array
{
    $config = [
        'host' => env('MYSQL_HOST'),
        'port' => env('MYSQL_PORT'),
        'user' => env('MYSQL_USER'),
        'password' => env('MYSQL_PASSWORD'),
        'database' => env('MYSQL_DATABASE'),
    ];

    if ($forDoctrine) {
        $config['driver'] = 'pdo_mysql';
        $config['dbname'] = $config['database'];
    }

    return $config;
}

function getBaseDir(string $subDir = ''): string
{
    return __DIR__ . '/../../' . $subDir;
}

function getEntityManager(): EntityManager
{
    $modelsDirectories = [getBaseDir('app/Models')];
    $config = ORMSetup::createAttributeMetadataConfiguration($modelsDirectories, true);

    return EntityManager::create(getDatabaseEnv(true), $config);
}
