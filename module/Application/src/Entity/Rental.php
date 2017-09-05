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
 * @ORM\Table(name="rental")
 */
class Rental
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="rent_date")
     */
    protected $rent_date;

    /**
     * @ORM\Column(name="predicted_return_date")
     */
    protected $predicted_return_date;

    /**
     * @ORM\Column(name="return_date")
     */
    protected $return_date;

    /**
     * @ORM\Column(name="predicted_price")
     */
    protected $predicted_price;

    /**
     * @ORM\Column(name="payment_price")
     */
    protected $payment_price;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\UserLog", mappedBy="logs")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_rental")
     */
    protected $logs;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Renter", inversedBy="rentals")
     * @ORM\JoinColumn(name="id_renter", referencedColumnName="id")
     */
    protected $renter;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Book", inversedBy="rentals")
     * @ORM\JoinColumn(name="id_book", referencedColumnName="id")
     */
    protected $book;

    /**
     * Constructor.
     */
    public function __construct()
    {
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
    public function getRentDate()
    {
        return $this->rent_date;
    }

    /**
     * @param mixed $rent_date
     */
    public function setRentDate($rent_date)
    {
        $this->rent_date = $rent_date;
    }

    /**
     * @return mixed
     */
    public function getPredictedReturnDate()
    {
        return $this->predicted_return_date;
    }

    /**
     * @param mixed $predicted_return_date
     */
    public function setPredictedReturnDate($predicted_return_date)
    {
        $this->predicted_return_date = $predicted_return_date;
    }

    /**
     * @return mixed
     */
    public function getReturnDate()
    {
        return $this->return_date;
    }

    /**
     * @param mixed $return_date
     */
    public function setReturnDate($return_date)
    {
        $this->return_date = $return_date;
    }

    /**
     * @return mixed
     */
    public function getPredictedPrice()
    {
        return $this->predicted_price;
    }

    /**
     * @param mixed $predicted_price
     */
    public function setPredictedPrice($predicted_price)
    {
        $this->predicted_price = $predicted_price;
    }

    /**
     * @return mixed
     */
    public function getPaymentPrice()
    {
        return $this->payment_price;
    }

    /**
     * @param mixed $payment_price
     */
    public function setPaymentPrice($payment_price)
    {
        $this->payment_price = $payment_price;
    }

    /**
     * Returns logs for this rental.
     * @return ArrayCollection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Adds a new log to this rental.
     * @param $log
     */
    public function addLog($log)
    {
        $this->logs[] = $log;
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
        $renter->addRental($this);
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
        $book->addRental($this);
    }
}