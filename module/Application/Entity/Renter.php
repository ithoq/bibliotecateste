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
 * @ORM\Table(name="renter")
 */
class Renter
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
     * @ORM\Column(name="cpf")
     */
    protected $cpf;

    /**
     * @ORM\Column(name="email")
     */
    protected $email;

    /**
     * @ORM\Column(name="date_of_birth")
     */
    protected $date_of_birth;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Rental", mappedBy="rentals")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_renter")
     */
    protected $rentals;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\UserLog", mappedBy="logs")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_renter")
     */
    protected $logs;

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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param mixed $date_of_birth
     */
    public function setDateOfBirth($date_of_birth)
    {
        $this->date_of_birth = $date_of_birth;
    }

    /**
     * Returns logs for this renter.
     * @return ArrayCollection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Adds a new log to this renter.
     * @param $log
     */
    public function addLog($log)
    {
        $this->logs[] = $log;
    }

    /**
     * Returns rentals for this renter.
     * @return ArrayCollection
     */
    public function getRentals()
    {
        return $this->rentals;
    }

    /**
     * Adds a new rental to this renter.
     * @param $rental
     */
    public function addRental($rental)
    {
        $this->rentals[] = $rental;
    }

}