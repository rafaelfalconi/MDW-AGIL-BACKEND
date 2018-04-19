<?php
/**
 * Created by PhpStorm.
 * User: Moons
 * Date: 19/4/2018
 * Time: 17:54
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends  WebTestCase
{
    const RUTA_API1='/reservation';
    public function testGetRerservation200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API1);
        $respose= $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

    }

    const RUTA_API2='/reservation/1';
    public function testGetRerservationById200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::RUTA_API1);
        $respose= $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());

    }

}