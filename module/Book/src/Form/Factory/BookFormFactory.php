<?php

namespace Book\Form\Factory;

use Book\Form\BookForm;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class BookFormFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return RegisterForm
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var LanguageMapper $mapper */
        $mapper = $container->get(LanguageMapper::class);
        $languages = $mapper->findAllAsArray();

        return new BookForm($languages);
    }
}