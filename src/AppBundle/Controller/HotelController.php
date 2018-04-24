<?php
/**
 * Created by PhpStorm.
 * User: Moons
 * Date: 19/4/2018
 * Time: 17:52
 */

namespace AppBundle\Controller;

use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Hotel;

/**
 * @Rest\Route("api/v1/hotels")
 */
class HotelController extends FOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Hotel')->findAll();
        if ($restresult === null) {
            return new View("there are no hotel exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

}