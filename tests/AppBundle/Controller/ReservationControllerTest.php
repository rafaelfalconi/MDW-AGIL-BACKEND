<?php
/**
 * Created by PhpStorm.
 * User: Moons
 * Date: 19/4/2018
 * Time: 17:54
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Hotel;

class ReservationControllerTest extends WebTestCase
{


    const RUTA_API0 = 'api/v1/reservas';

    public function testCreateReservas()
    {
        $usuario = new Usuario();
        $usuario->setId(1);
        $usuario->setEmail('isragoo.prez@gmail.com');
        $usuario->setClave('123456');

        $hotel = new Hotel();
        $hotel->setId(1);
        $hotel->setDireccion('Vallecas');
        $hotel->setNombre('Hotel1');
        $hotel->setPin('0112');
        $hotel->setTelefono('604384578');

        $habitacion = new Habitacion();
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

        $p_data = array('reserva' => $reserva);
        $client = static::createClient();
        $client->request('POST', self::RUTA_API0, $p_data);
        $response = $client->getResponse();
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
//        $this->assertTrue($response->isOk());
//        self::assertJson($response->getContent());
    }



    const RUTA_API1 = 'api/v1/reservas';

    public function testGetRerservation200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API1);
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

    }


    const RUTA_API2 = 'api/v1/reservas/1';

    public function testGetRerservationById200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API1);
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

    }

    const RUTA_API3 = 'api/v1/reservas/code/0425';

    public function testGetRerservationByCodigo200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API3);
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

    }

    const RUTA_API4 = 'api/v1/reservas/1/update';

    public function testUpdateRerservationById204()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', self::RUTA_API4);
        $respose = $client->getResponse();
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());

    }

    public function testPost()
    {

        $data = array(
            'fecha' => '04/27/2999',
            'entrada' => 20,
            'salida' => '24',
            'habitacion' => 1,
            'usuario' => 1,
        );
        $client = static::createClient();
        $client->request('POST', self::RUTA_API1, $data);
        $response = $client->getResponse();
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());

        //delete reserva test
        $client = static::createClient();
        $client->request('DELETE', 'api/v1/reservas/' . $response->getContent());
        $response = $client->getResponse();
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());
    }
}