<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informacion
 *
 * @ORM\Table(name="Informacion", indexes={@ORM\Index(name="fk_Informacion_Usuario1_idx", columns={"Usuario_Id"})})
 * @ORM\Entity
 */
class Informacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="Telefono", type="string", length=45, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="Direccion", type="string", length=45, nullable=true)
     */
    private $direccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

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

