<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indent
 *
 * @ORM\Table(name="indent")
 * @ORM\Entity
 */
class Indent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=false, unique=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50, nullable=false, unique=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="number_delivery", type="string", length=10, nullable=false, unique=false)
     */
    private $numberDelivery;

    /**
     * @var string
     *
     * @ORM\Column(name="street_delivery", type="string", length=255, nullable=false, unique=false)
     */
    private $streetDelivery;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=5, nullable=false, unique=false)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="town_delivery", type="string", length=255, nullable=false, unique=false)
     */
    private $townDelivery;

    /**
     * @var \AppBundle\Entity\Cart
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cart_id", referencedColumnName="id", unique=true)
     * })
     */
    private $cart;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Indent
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Indent
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set numberDelivery
     *
     * @param string $numberDelivery
     *
     * @return Indent
     */
    public function setNumberDelivery($numberDelivery)
    {
        $this->numberDelivery = $numberDelivery;

        return $this;
    }

    /**
     * Get numberDelivery
     *
     * @return string
     */
    public function getNumberDelivery()
    {
        return $this->numberDelivery;
    }

    /**
     * Set streetDelivery
     *
     * @param string $streetDelivery
     *
     * @return Indent
     */
    public function setStreetDelivery($streetDelivery)
    {
        $this->streetDelivery = $streetDelivery;

        return $this;
    }

    /**
     * Get streetDelivery
     *
     * @return string
     */
    public function getStreetDelivery()
    {
        return $this->streetDelivery;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Indent
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set townDelivery
     *
     * @param string $townDelivery
     *
     * @return Indent
     */
    public function setTownDelivery($townDelivery)
    {
        $this->townDelivery = $townDelivery;

        return $this;
    }

    /**
     * Get townDelivery
     *
     * @return string
     */
    public function getTownDelivery()
    {
        return $this->townDelivery;
    }

    /**
     * Set cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return Indent
     */
    public function setCart(\AppBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \AppBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }
}

