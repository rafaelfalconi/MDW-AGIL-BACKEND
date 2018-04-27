<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ReservaViewController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/confirm", name="confirm")
     */
    public function confirmAction()
    {
        return $this->render('@App/reserva/reservation-confirm.html.twig');
    }

    /**
     * @Route("/layout", name="layout")
     */
    public function layoutAction()
    {
        return $this->render('layout/layout.html.twig');
    }

    /**
     * @Route("/admin/reservations", name="reservations")
     */
    public function reservationsAction()
    {
        return $this->render('@App/admin/reservation-report.html.twig');
    }
}
