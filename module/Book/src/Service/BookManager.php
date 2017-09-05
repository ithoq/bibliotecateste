<?php

namespace Book\Service;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class BookManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

}