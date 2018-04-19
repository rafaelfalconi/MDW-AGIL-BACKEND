<?php

namespace AppBundle\Controller\SendCustomerEmailController;

class SendCustomerEmailController
{
    public function sendCustomerEmail($reservationPrice, $reservationId,
                                      $hotelEmail, $customerEmail, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Pago reserva'))
            ->setFrom($hotelEmail)
            ->setTo($customerEmail)
            ->setBody(
                $this->renderView(
                    'emails/reservation-payment.html.twig',
                    array('reservationPrice' => $reservationPrice, 'reservationId' => $reservationId)
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->render(
            'emails/reservation-payment.html.twig',
            array('reservationPrice' => $reservationPrice, 'reservationId' => $reservationId));
    }
}