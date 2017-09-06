<?php

namespace Book\Controller\Factory;

use Book\Controller\BookCategoryController;
use Book\Service\BookCategoryManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class BookCategoryControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bookManager = $container->get(BookCategoryManager::class);

        return new BookCategoryController($entityManager, $bookManager);
    }
}