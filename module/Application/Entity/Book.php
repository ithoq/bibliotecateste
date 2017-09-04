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
 * @ORM\Table(name="book")
 */
class Book
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
     * @ORM\OneToMany(targetEntity="\Application\Entity\UserLog", mappedBy="logs")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_book")
     */
    protected $logs;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Rental", mappedBy="rentals")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_book")
     */
    protected $rentals;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\BookCategory", inversedBy="books")
     * @ORM\JoinColumn(name="id_book_category", referencedColumnName="id")
     */
    protected $book_category;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->rentals = new ArrayCollection();
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
     * Returns logs for this book.
     * @return ArrayCollection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Adds a new log to this book.
     * @param $log
     */
    public function addLog($log)
    {
        $this->logs[] = $log;
    }

    /**
     * Returns rentals for this book.
     * @return ArrayCollection
     */
    public function getRentals()
    {
        return $this->rentals;
    }

    /**
     * Adds a new rental to this book.
     * @param $rental
     */
    public function addRental($rental)
    {
        $this->rentals[] = $rental;
    }

    /**
     * Returns associated book category.
     * @return \Application\Entity\BookCategory
     */
    public function getBookCategory()
    {
        return $this->book_category;
    }

    /**
     * Sets associated book category.
     * @param \Application\Entity\BookCategory $book_category
     */
    public function setBookCategory($book_category)
    {
        $this->book_category = $book_category;
        $book_category->addBook($this);
    }
}