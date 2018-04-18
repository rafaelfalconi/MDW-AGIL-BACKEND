<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserva
 *
 * @ORM\Table(name="Reserva", indexes={@ORM\Index(name="fk_Reserva_Usuario1_idx", columns={"Usuario_Id"}), @ORM\Index(name="fk_Reserva_Habitacion1_idx", columns={"Habitacion_Id"})})
 * @ORM\Entity
 */
class Reserva
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="Entrada", type="integer", nullable=false)
     */
    private $entrada;

    /**
     * @var string
     *
     * @ORM\Column(name="Salida", type="string", length=45, nullable=false)
     */
    private $salida;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=45, nullable=false)
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Habitacion
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Habitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Habitacion_Id", referencedColumnName="Id")
     * })
     */
    private $habitacion;

    /**
     * @var \AppBundle\Entity\Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Usuario_Id", referencedColumnName="Id")
     * })
     */
    private $usuario;


}

