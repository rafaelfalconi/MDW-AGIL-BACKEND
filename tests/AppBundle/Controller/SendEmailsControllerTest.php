<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SendEmailsControllerTest extends WebTestCase
{
    public function testSendEmailsTest()
    {
        $homelEmail = 'hotel@email.com';

        $customerEmail = 'customer@email.com';

        $client = static:: createClient();

        $client->enableProfiler();

        $crawler = $client->request('POST', 'path/to/action');

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Reserva registrada', $message->getSubject());
        $this->assertSame('hotel@email.com', key($message->getFrom()));
        $this->assertArrayHasKey('customer@email.com', $message->getTo());
        $this->assertSame('Reserva hecha', $crawler->filter('h3')->first()->text());
    }
}