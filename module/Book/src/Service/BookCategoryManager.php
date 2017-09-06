<?php

namespace Book\Service;

use Book\Entity\BookCategory;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class BookCategoryManager
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

    /**
     * This method adds a new user.
     */
    public function addBook($data)
    {
        // Do not allow several users with the same email address.
        if ($this->checkBookCategoryExists($data['name'])) {
            throw new \Exception("Livro com o nome '" . $data['name'] . "' já existente");
        }

        // Create new User entity.
        $book = new BookCategory();
        $book->setName($data['name']);

        // Add the entity to the entity manager.
        $this->entityManager->persist($book);

        // Apply changes to database.
        $this->entityManager->flush();

        return $book;
    }

    /**
     * This method updates data of an existing user.
     */
    public function updateBook($bookCategory, $data)
    {
        // Do not allow to change user email if another user with such email already exits.
        if ($bookCategory->getName() != $data['name'] && $this->checkBookCategoryExists($data['name'])) {
            throw new \Exception("Another user with name address " . $data['name'] . " already exists");
        }

        $bookCategory->setName($data['name']);

        // Apply changes to database.
        $this->entityManager->flush();
        return true;
    }

    /**
     * Delete categoria
     * @param $bookCategory
     * @return bool
     */
    public function deleteBookCategory($bookCategory)
    {
        // Do not allow to change user email if another user with such email already exits.
        $bookCategory->setDeletedAt(date('Y-m-d H:i:s'));

        // Apply changes to database.
        $this->entityManager->flush();
        return true;
    }

    /**
     * Checks whether an active user with given email address already exists in the database.
     */
    public function checkBookCategoryExists($name)
    {
        $book = $this->entityManager->getRepository(BookCategory::class)->findOneBy(['name' => $name, 'deleted_at' => null]);
        return $book !== null;
    }
}