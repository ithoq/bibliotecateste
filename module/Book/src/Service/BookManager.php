<?php

namespace Book\Service;

use Book\Entity\Book;
use Book\Entity\BookCategory;

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

    /**
     * This method adds a new user.
     */
    public function addBook($data)
    {
        // Do not allow several users with the same email address.
        if ($this->checkBookExists($data['name'])) {
            throw new \Exception("User with name address " . $data['$name'] . " already exists");
        }

        // Create new User entity.
        $book = new Book();
        $book->setName($data['name']);

        $bookCategory = $this->entityManager->getRepository(BookCategory::class)->find($data['id_book_category']);
        $book->setBookCategory($bookCategory);

        // Add the entity to the entity manager.
        $this->entityManager->persist($book);

        // Apply changes to database.
        $this->entityManager->flush();

        return $book;
    }

    /**
     * This method updates data of an existing user.
     */
    public function updateBook($book, $data)
    {
        // Do not allow to change user email if another user with such email already exits.
        if ($book->getName() != $data['name'] && $this->checkBookExists($data['name'])) {
            throw new \Exception("Another user with name address " . $data['name'] . " already exists");
        }

        $book->setName($data['name']);

        $bookCategory = $this->entityManager->getRepository(BookCategory::class)->find($data['id_book_category']);
        $book->setBookCategory($bookCategory);

        // Apply changes to database.
        $this->entityManager->flush();
        return true;
    }

    /**
     * Delete
     * @param $book
     * @return bool
     */
    public function deleteBook($book)
    {
        // Do not allow to change user email if another user with such email already exits.
        $book->setDeletedAt(date('Y-m-d H:i:s'));

        // Apply changes to database.
        $this->entityManager->flush();
        return true;
    }


    /**
     * Checks whether an active user with given email address already exists in the database.
     */
    public function checkBookExists($name)
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['name' => $name, 'deleted_at' => null]);

        return $book !== null;
    }
}