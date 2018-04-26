<?php
/**
 * Created by PhpStorm.
 * User: Moons
 * Date: 25/4/2018
 * Time: 7:54
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Usuario;
use FOS\RestBundle\Tests\Functional\WebTestCase;

class ReservaTest extends WebTestCase
{
    public function testCreate()
    {
        $reserva = new Reserva();
        $reserva->setEstado(0);
        $reserva->setCodigo(0425);
        $reserva->setEntrada(2018);
        $reserva->setFecha(2018 - 04 - 19);
        $reserva->setSalida(2018 - 04 - 25);
        $reserva->setHabitacion(1);
        $reserva->setUsuario(1);
        echo $reserva->getEntrada();
        $this->assertEquals('2018', $reserva->getEntrada());
    }

    public function testCreateReservaHabitacionHotelUsuario()
    {
        $usuario= new Usuario();
        $usuario->setId(1);
        $usuario->setEmail('isragoo.prez@gmail.com');
        $usuario->setClave('123456');

        $hotel= new Hotel();
        $hotel->setId(1);
        $hotel->setDireccion('Vallecas');
        $hotel->setNombre('Hotel1');
        $hotel->setPin('0112');
        $hotel->setTelefono('604384578');

        $habitacion= new Habitacion();
        $habitacion->setId(1);
        $habitacion->setHotel($hotel);
        $habitacion->setPrecio(30.50);

        $reserva = new Reserva();
        $reserva->setId(1);
        $reserva->setEstado(0);
        $reserva->setCodigo(0425);
        $reserva->setEntrada(2018);
        $reserva->setFecha(2018 - 04 - 19);
        $reserva->setSalida(2018 - 04 - 25);
        $reserva->setHabitacion($habitacion);
        $reserva->setUsuario($usuario);

        $this->assertEquals('0112', $reserva->getHabitacion()->getHotel()->getPin());
    }
}