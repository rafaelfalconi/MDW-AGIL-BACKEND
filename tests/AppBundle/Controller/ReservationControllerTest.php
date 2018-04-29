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

    public function testGetRerservationByHotel200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API0.'/hotel/1');
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());
    }


    public function testGetRerservationById200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API1);
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

    }


    public function testPost()
    {

        $data = array(
            'fecha' => '04/27/2999',
            'entrada' => 16,
            'salida' => '20',
            'habitacion' => 1,
            'usuario' => 1,
            'maxdisponible' => 22,
        );
        $client = static::createClient();
        $client->request('POST', self::RUTA_API1, $data);
        $response = $client->getResponse();
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());
        //Decode Json
        $json = $response->getContent();
        $arrReserva = json_decode($json, true);
        //delete reserva test
        $client = static::createClient();
        $client->request('DELETE', 'api/v1/reservas/' . $arrReserva['id']);
        $response = $client->getResponse();
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());
    }



    public function testCreateReservas()
    {
        $data = array(
            'fecha' => '04/27/2900',
            'entrada' => 12,
            'salida' => '16',
            'habitacion' => 1,
            'usuario' => 1,
            'maxdisponible' => 22,
            'codigo' => '0425',
            'estado' => 0
        );
        //Create new Rerva
        $client = static::createClient();
        $client->request('POST', self::RUTA_API1, $data);
        $response = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($response->isOk());
        $this->assertJson($response->getContent());
        //Decode Json
        $json = $response->getContent();
        $arrReserva = json_decode($json, true);

        //Buscar Reserva const
        $RUTA_API3 = 'api/v1/reservas/code/' . $arrReserva['codigo'] . '/hotel/' . $arrReserva['habitacion']['hotel']['pin'];

        $client = static::createClient();
        $crawler = $client->request('GET', $RUTA_API3);
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

        //actualizar reserva estado  RUTA_API4 = 'api/v1/reservas/1/update';
        $RUTA_API4 = 'api/v1/reservas/' . $arrReserva['id'] . '/update';
        $client = static::createClient();
        $crawler = $client->request('PUT', $RUTA_API4);
        $respose = $client->getResponse();
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());

        //delete reserva test
        $client = static::createClient();
        $client->request('DELETE', 'api/v1/reservas/' . $arrReserva['id']);
        $response = $client->getResponse();
        self::assertTrue($response->isSuccessful());
        self::assertJson($response->getContent());
    }
}