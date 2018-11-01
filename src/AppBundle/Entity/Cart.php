<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity
 */
class Cart
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Row", mappedBy="cart")
     */
    private $rows;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rows = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add row
     *
     * @param \AppBundle\Entity\Row $row
     *
     * @return Cart
     */
    public function addRow(\AppBundle\Entity\Row $row)
    {
        $this->rows[] = $row;

        return $this;
    }

    /**
     * Remove row
     *
     * @param \AppBundle\Entity\Row $row
     */
    public function removeRow(\AppBundle\Entity\Row $row)
    {
        $this->rows->removeElement($row);
    }

    /**
     * Get rows
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRows()
    {
        return $this->rows;
    }
}

