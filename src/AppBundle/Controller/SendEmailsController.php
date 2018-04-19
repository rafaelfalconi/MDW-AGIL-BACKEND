<?php

namespace AppBundle\Controller;

class SendEmailsController
{
    public function sendEmails($reservationId, $reservationPrice, $hotelEmail, $managerEmail, $customerEmail, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Reserva registrada'))
            ->setFrom($hotelEmail)
            ->setTo($managerEmail, $customerEmail)
            ->setBody(
                $this->renderView(
                    'emails/reservation-confirmation.html.twig',
                    array('reservationId' => $reservationId, 'reservationPrice' => $reservationPrice)
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->render(
            'emails/reservation-confirmation.html.twig',
            array('reservationId' => $reservationId, 'reservationPrice' => $reservationPrice)
        );
    }
}