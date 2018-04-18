<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habitacion
 *
 * @ORM\Table(name="Habitacion", indexes={@ORM\Index(name="fk_Habitacion_Hotel_idx", columns={"Hotel_Id"})})
 * @ORM\Entity
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
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Hotel
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Hotel_Id", referencedColumnName="Id")
     * })
     */
    private $hotel;


}

