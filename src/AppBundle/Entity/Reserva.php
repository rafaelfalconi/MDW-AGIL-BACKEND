<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserva
 *
 * @ORM\Table(name="Reserva", indexes={@ORM\Index(name="fk_Reserva_Habitacion1_idx", columns={"Habitacion_Id"}), @ORM\Index(name="fk_Reserva_Usuario1_idx", columns={"Usuario_Id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservaRepository")
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
     * @ORM\Column(name="Codigo", type="string", length=45, nullable=false)
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Habitacion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Habitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Habitacion_Id", referencedColumnName="Id")
     * })
     */
    private $habitacion;

    /**
     * @var \AppBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Usuario_Id", referencedColumnName="Id")
     * })
     */
    private $usuario;

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return bool
     */
    public function isEstado()
    {
        return $this->estado;
    }

    /**
     * @param bool $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return int
     */
    public function getEntrada()
    {
        return $this->entrada;
    }

    /**
     * @param int $entrada
     */
    public function setEntrada($entrada)
    {
        $this->entrada = $entrada;
    }

    /**
     * @return string
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * @param string $salida
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
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
     * @return Habitacion
     */
    public function getHabitacion()
    {
        return $this->habitacion;
    }

    /**
     * @param Habitacion $habitacion
     */
    public function setHabitacion($habitacion)
    {
        $this->habitacion = $habitacion;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }


}

