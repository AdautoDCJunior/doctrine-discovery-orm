<?php

namespace Alura\Doctrine\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class EntityManagerCreator
{
    public static function createEntityManager(): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . '/..'),
            isDevMode: true,
        );

        $consoleOutput = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
        $consoleLogger = new ConsoleLogger($consoleOutput);
        $logMiddleware = new Middleware($consoleLogger);
        $config->setMiddlewares([$logMiddleware]);

        $conn = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../../db.sqlite',
        ], $config);

        return new EntityManager($conn, $config);
    }
}
