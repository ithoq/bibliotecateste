<?php
/**
 * Created by PhpStorm.
 * User: rafaelmoriya
 * Date: 04/09/17
 * Time: 10:14
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a user log.
 * @ORM\Entity
 * @ORM\Table(name="user_log")
 */
class UserLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="action")
     */
    protected $action;

    /**
     * @ORM\Column(name="description")
     */
    protected $description;

    /**
     * @ORM\Column(name="created_at")
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\User", inversedBy="logs")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\BookCategory", inversedBy="logs")
     * @ORM\JoinColumn(name="id_book_category", referencedColumnName="id")
     */
    protected $book_category;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Book", inversedBy="logs")
     * @ORM\JoinColumn(name="id_book", referencedColumnName="id")
     */
    protected $book;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Rental", inversedBy="logs")
     * @ORM\JoinColumn(name="id_rental", referencedColumnName="id")
     */
    protected $rental;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Renter", inversedBy="logs")
     * @ORM\JoinColumn(name="id_renter", referencedColumnName="id")
     */
    protected $renter;

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
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Returns associated user.
     * @return \Application\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets associated user.
     * @param \Application\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        $user->addLog($this);
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
        $book_category->addLog($this);
    }

    /**
     * Returns associated book.
     * @return \Application\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Sets associated book.
     * @param \Application\Entity\Book $book
     */
    public function setBook($book)
    {
        $this->book = $book;
        $book->addLog($this);
    }

    /**
     * Returns associated rental.
     * @return \Application\Entity\Rental
     */
    public function getRental()
    {
        return $this->rental;
    }

    /**
     * Sets associated rental.
     * @param \Application\Entity\Rental $rental
     */
    public function setRental($rental)
    {
        $this->rental = $rental;
        $rental->addLog($this);
    }

    /**
     * Returns associated renter.
     * @return \Application\Entity\Renter
     */
    public function getRenter()
    {
        return $this->renter;
    }

    /**
     * Sets associated renter.
     * @param \Application\Entity\Renter $renter
     */
    public function setRenter($renter)
    {
        $this->renter = $renter;
        $renter->addLog($this);
    }

}