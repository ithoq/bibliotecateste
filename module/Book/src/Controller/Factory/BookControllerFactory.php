<?php

namespace Book\Controller\Factory;

use Book\Controller\BookController;
use Book\Service\BookManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class BookControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bookManager = $container->get(BookManager::class);

        return new BookController($entityManager, $bookManager);
    }
}