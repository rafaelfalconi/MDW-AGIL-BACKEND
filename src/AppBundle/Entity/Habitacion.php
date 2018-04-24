<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habitacion
 *
 * @ORM\Table(name="Habitacion", indexes={@ORM\Index(name="fk_Habitacion_Hotel1_idx", columns={"Hotel_Id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HabitacionRepository")
 */
class Habitacion
{
    /**
     * @var float
     *
     * @ORM\Column(name="Precio", type="float", precision=10, scale=0, nullable=true)
     */
    private $precio;

    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Hotel
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Hotel_Id", referencedColumnName="Id")
     * })
     */
    private $hotel;

    /**
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param float $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param Hotel $hotel
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;
    }


}

