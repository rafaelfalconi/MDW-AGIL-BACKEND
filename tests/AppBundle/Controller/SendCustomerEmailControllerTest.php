<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SendCustomerEmailControllerTest extends WebTestCase
{
    public function testSendCustomerEmail()
    {
        $hotelEmail = 'hotel@email.com';

        $customerEmail = 'customer@email.com';

        $client = static:: createClient();

        $client->enableProfiler();

        $crawler = $client->request('POST', 'path/to/above/action');

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Pago reserva', $message->getSubject());
        $this->assertSame('hotel@email.com', key($message->getFrom()));
        $this->assertSame('customer@email.com', key($message->getTo()));
        $this->assertSame('Pago de la reserva', $crawler->filter('h3')->first()->text());
    }
}
