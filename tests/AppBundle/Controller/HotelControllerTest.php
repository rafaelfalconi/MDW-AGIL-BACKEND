<?php
/**
 * Created by PhpStorm.
 * User: Joaquin
 * Date: 27/4/2018
 * Time: 16:06
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HotelControllerTest extends WebTestCase
{
    const RUTA_API = 'api/v1/hotels';

    public function testGetHotels200()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::RUTA_API);
        $respose = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isSuccessful());
        self::assertJson($respose->getContent());
    }
}
