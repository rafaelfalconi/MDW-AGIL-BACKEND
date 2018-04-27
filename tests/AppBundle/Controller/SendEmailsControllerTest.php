<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\SendEmailsController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SendEmailsControllerTest extends WebTestCase
{
    public function testReservationConfirmationTest()
    {
        $client = static:: createClient();
        $client->enableProfiler();

        $email = new SendEmailsController($client->getContainer());
        $email->reservationPaymentInfo(1,1,
            'buking@joaquinzamora.net','joaquin_z619@hotmail.com');
    }
}