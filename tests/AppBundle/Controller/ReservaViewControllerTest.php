<?php
/**
 * Created by PhpStorm.
 * User: Joaquin
 * Date: 28/4/2018
 * Time: 11:19
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservaViewControllerTest extends WebTestCase
{
    public function testReservationActionTest()
    {
        $client = static:: createClient();
        $crawler = $client->request('GET', '/admin/reservations');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('RESERVATIONS REPORT', $crawler->filter('.tittle')->html());
    }
}
