<?php
/**
 * Created by PhpStorm.
 * User: rafaelfalconi
 * Date: 23/4/18
 * Time: 19:47
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Habitacion;
use AppBundle\Entity\Hotel;

class HabitacionControllerTest extends WebTestCase
{
    const RUTA_API1 = 'api/v1/habitaciones?fecha=06/24/208&hora=1';
    const RUTA_API2 = 'api/v1/habitaciones';

    public function testGetHabitaciones()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::RUTA_API1);
        $respose= $client->getResponse();
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isNotFound());
        self::assertJson($respose->getContent());
    }
    public function testGetHabitaciones2()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::RUTA_API2);
        $respose= $client->getResponse();
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        self::assertTrue($respose->isNotFound());
        self::assertJson($respose->getContent());
    }

}