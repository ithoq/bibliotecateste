<?php
/**
 * Created by PhpStorm.
 * User: rafaelmoriya
 * Date: 04/09/17
 * Time: 10:14
 */

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a user.
 * @ORM\Entity
 * @ORM\Table(name="book_category")
 */
class BookCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="deleted_at")
     */
    protected $deleted_at;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Book", mappedBy="books")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_book_category")
     */
    protected $books;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\UserLog", mappedBy="logs")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_book_category")
     */
    protected $logs;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * Returns books for this book category.
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * Adds a book to this book category.
     * @param $book
     */
    public function addBook($book)
    {
        $this->books[] = $book;
    }

    /**
     * Returns logs for this book category.
     * @return ArrayCollection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Adds a new log to this book category.
     * @param $log
     */
    public function addLog($log)
    {
        $this->logs[] = $log;
    }

}